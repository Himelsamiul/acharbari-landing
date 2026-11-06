<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Admin & team management — /admin/admin-management, inside the one admin panel.
 *
 * Super admin (platform owner): sees and manages every staff account.
 * Client admin with team.* grants: sees everyone in their own team (its head
 * and every account under it), but manages only the accounts they — and their
 * team — created, handing out at most the permissions they hold. Anything they
 * can't manage — the platform owner included — 404s, so a client admin can't
 * even confirm an account outside their team exists.
 */
class AdminManagerController extends Controller
{
    public function index(Request $request)
    {
        $me = $request->user();

        $admins = $me->isSuperAdmin()
            ? User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])->orderBy('name')->get()
            : User::where('role', User::ROLE_ADMIN)->whereIn('id', $me->visibleTeamIds())->orderBy('name')->get();

        return view('admin.team.index', [
            'admins' => $admins,
            'me' => $me,
            'presets' => $this->presetsFor($me),
        ]);
    }

    public function store(Request $request)
    {
        $me = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:120|unique:users,email',
            'password' => 'required|string|min:6|max:100',
            'preset' => 'nullable|string|max:30',
        ], [
            'email.unique' => 'এই ইমেইলটি ব্যবহার করা যাবে না — অন্য ইমেইল দিন।',
        ]);

        $permissions = $this->presetMap($data['preset'] ?? null);
        if (! $me->isSuperAdmin()) {
            $permissions = User::capPermissions($permissions, $me->grantableMap());
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // hashed by the model cast
            'role' => User::ROLE_ADMIN,
            'permissions' => $permissions,
            'is_active' => true,
            // delete-lock: only the platform owner may set it
            'is_protected' => $request->boolean('is_protected') && $me->isPlatformOwner(),
            // owner-provisioned client accounts stay NULL — the owner's id never sits on a client row
            'created_by' => $me->isSuperAdmin() ? null : $me->id,
        ]);

        return back()->with('success', 'অ্যাকাউন্ট "'.$data['name'].'" তৈরি হয়েছে — এই ইমেইল ও পাসওয়ার্ড দিয়ে /admin/login থেকে লগইন করতে পারবে।');
    }

    public function edit(Request $request, User $user)
    {
        $me = $request->user();
        $this->authorizeTarget($me, $user);

        // the matrix only offers what may be handed to this account
        $grantable = $this->grantableFor($me, $user);
        $modules = [];
        $checked = [];
        foreach (config('permissions.modules', []) as $module => $info) {
            $allowed = $grantable[$module] ?? [];
            if ($allowed === []) {
                continue;
            }

            $info['features'] = array_intersect_key($info['features'], array_flip($allowed));
            if (! empty($info['groups'])) {
                $info['groups'] = array_filter(array_map(
                    fn ($features) => array_values(array_intersect($features, $allowed)),
                    $info['groups']
                ));
            }

            $modules[$module] = $info;
            $checked[$module] = array_values(array_filter(
                array_keys($info['features']),
                fn ($feature) => $user->hasPermission("$module.$feature")
            ));
        }

        return view('admin.team.edit', [
            'user' => $user,
            'me' => $me,
            'modules' => $modules,
            'checked' => $checked,
            'presets' => $this->presetsFor($me, $grantable),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $me = $request->user();
        $this->authorizeTarget($me, $user);

        $data = $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:120|unique:users,email,'.$user->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'array',
        ], [
            'email.unique' => 'এই ইমেইলটি ব্যবহার করা যাবে না — অন্য ইমেইল দিন।',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        // the matrix form posts matrix=1 (an all-unchecked matrix sends no
        // permissions key at all); the profile-only form leaves grants as they are
        if ($request->has('permissions') || $request->boolean('matrix')) {
            if ($user->isAdmin()) {
                $permissions = $this->normalizePermissions($data['permissions'] ?? []);
                // a team member never ends up above the account that created
                // them — not even when the platform owner is the one editing
                if (! $me->isSuperAdmin() || $user->creator?->isAdmin()) {
                    $permissions = User::capPermissions($permissions, $this->grantableFor($me, $user));
                }
                $user->permissions = $permissions;
            } else {
                $user->permissions = null; // super admins hold everything
            }
        }

        $user->save();
        $user->trimTeamPermissions();

        return redirect()->route('admin.admins.index')
            ->with('success', 'অ্যাকাউন্ট "'.$user->name.'" এর তথ্য ও অনুমতি আপডেট হয়েছে।');
    }

    public function toggle(Request $request, User $user)
    {
        $me = $request->user();
        $this->authorizeTarget($me, $user);

        if ($user->id === $me->id) {
            return back()->withErrors(['admin' => 'আপনি নিজের অ্যাকাউন্ট নিষ্ক্রিয় করতে পারবেন না।']);
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('success', '"'.$user->name.'" এখন '.($user->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়').'।');
    }

    /** Delete-lock — the platform owner's tool alone; to everyone else it doesn't exist. */
    public function toggleProtect(Request $request, User $user)
    {
        abort_unless($request->user()->isPlatformOwner() && ! $user->isCustomer(), 404);

        $user->is_protected = ! $user->is_protected;
        $user->save();

        return back()->with('success', '"'.$user->name.'" এখন '.($user->is_protected ? 'ডিলিট-লকড — শুধু আপনি মুছতে পারবেন' : 'সাধারণ (ডিলিট-লক সরানো হয়েছে)').'।');
    }

    public function updatePassword(Request $request, User $user)
    {
        $me = $request->user();
        $this->authorizeTarget($me, $user);

        $data = $request->validate([
            'password' => 'required|string|min:6|max:100',
        ]);

        $user->password = $data['password']; // hashed by the model cast
        $user->save();

        return back()->with('success', '"'.$user->name.'" এর নতুন পাসওয়ার্ড সেট হয়েছে।');
    }

    public function destroy(Request $request, User $user)
    {
        $me = $request->user();
        $this->authorizeTarget($me, $user);

        if ($user->id === $me->id) {
            return back()->withErrors(['admin' => 'আপনি নিজের অ্যাকাউন্ট মুছতে পারবেন না।']);
        }

        // delete-locked: only the platform owner may remove it
        if ($user->is_protected && ! $me->isPlatformOwner()) {
            return back()->withErrors(['admin' => 'এই অ্যাকাউন্টটি লক করা আছে — মুছে ফেলা যাবে না।']);
        }

        $remaining = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])
            ->where('id', '!=', $user->id)
            ->count();

        if ($remaining < 1) {
            return back()->withErrors(['admin' => 'শেষ অ্যাডমিন মুছে ফেলা যাবে না।']);
        }

        // the removed account's own team moves up to its creator, so nobody
        // silently drops out of their manager's view
        User::where('created_by', $user->id)->update(['created_by' => $user->created_by]);

        $name = $user->name;
        $user->delete();

        return back()->with('success', 'অ্যাকাউন্ট "'.$name.'" মুছে ফেলা হয়েছে।');
    }

    /* ================= Helpers ================= */

    /**
     * Outside your team (or a customer) is "not found", never "forbidden" — a
     * client admin can't probe which other accounts exist.
     */
    private function authorizeTarget(User $me, User $target): void
    {
        abort_unless($me->canManageUser($target), 404);
    }

    /**
     * module => features that may be handed to $target: what $me holds, and
     * never more than the admin who created $target holds.
     */
    private function grantableFor(User $me, User $target): array
    {
        $grantable = $me->grantableMap();

        $creator = $target->creator;
        if ($creator?->isAdmin()) {
            $fromCreator = $creator->grantableMap();
            foreach ($grantable as $module => $features) {
                $grantable[$module] = array_values(array_intersect($features, $fromCreator[$module] ?? []));
            }
        }

        return $grantable;
    }

    /** Whitelist + normalize a submitted permission matrix (module → feature list). */
    private function normalizePermissions(?array $incoming): array
    {
        $clean = [];
        $modules = config('permissions.modules', []);

        foreach ($incoming ?? [] as $module => $features) {
            if (! isset($modules[$module]) || ! is_array($features)) {
                continue;
            }

            $valid = array_values(array_intersect(array_keys($modules[$module]['features']), $features));

            if (in_array('*', $features, true) || (count($valid) === count($modules[$module]['features']) && $valid !== [])) {
                $clean[$module] = ['*']; // select-all = whole module (future features included)
            } elseif ($valid !== []) {
                $clean[$module] = $valid;
            }
        }

        return $clean;
    }

    /** Permissions for a preset key from config/permissions.php (validated). */
    private function presetMap(?string $preset): array
    {
        if (! $preset) {
            return [];
        }

        $map = config("permissions.presets.$preset.map");
        if (! $map) {
            return [];
        }

        if ($map === '*') {
            return array_fill_keys(array_keys(config('permissions.modules', [])), ['*']);
        }

        $modules = config('permissions.modules', []);
        $clean = [];
        foreach ($map as $module => $features) {
            if (! isset($modules[$module])) {
                continue;
            }
            if ($features === '*') {
                $clean[$module] = ['*'];
            } else {
                $valid = array_values(array_intersect(array_keys($modules[$module]['features']), (array) $features));
                if ($valid !== []) {
                    $clean[$module] = $valid;
                }
            }
        }

        return $clean;
    }

    /**
     * Preset packages the user may offer — capped to their own grants for
     * client admins, or to an explicit grantable map (e.g. a member's creator).
     */
    private function presetsFor(User $me, ?array $grantable = null): array
    {
        $presets = config('permissions.presets', []);
        if ($me->isSuperAdmin() && $grantable === null) {
            return $presets;
        }

        $grantable ??= $me->grantableMap();
        $offered = [];
        foreach ($presets as $key => $preset) {
            $capped = User::capPermissions($this->presetMap($key), $grantable);
            if ($capped !== []) {
                $offered[$key] = ['label' => $preset['label'], 'map' => $capped];
            }
        }

        return $offered;
    }
}
