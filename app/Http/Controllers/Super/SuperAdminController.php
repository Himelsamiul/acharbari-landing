<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Admin\IndustryPack;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Super Admin panel (/super) — platform-owner tooling:
 * client (admin) accounts, the permission matrix and industry provisioning.
 */
class SuperAdminController extends Controller
{
    /* ================= Overview ================= */

    public function overview()
    {
        $stats = [
            'orders_total' => Order::count(),
            'revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'pending' => Order::where('status', 'pending')->count(),
            'products' => Product::where('is_active', true)->count(),
            'categories' => Category::count(),
            'complaints' => Complaint::count(),
            'complaints_open' => Complaint::where('is_resolved', false)->count(),
            'customers' => User::where('role', User::ROLE_CUSTOMER)->count(),
            'admins' => User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])->count(),
        ];

        $recent = Order::latest()->take(10)->get();

        return view('super.overview', compact('stats', 'recent'));
    }

    /* ================= Admin (client) users ================= */

    public function index()
    {
        $admins = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])
            ->orderBy('name')
            ->get();

        return view('super.admins', [
            'admins' => $admins,
            'currentId' => auth()->id(),
            'presets' => config('permissions.presets', []),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:120|unique:users,email',
            'password' => 'required|string|min:6|max:100',
            'preset' => 'nullable|string|max:30',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // hashed automatically by the model cast
            'role' => User::ROLE_ADMIN,
            'permissions' => $this->presetMap($data['preset'] ?? null),
            'is_active' => true,
        ]);

        return back()->with('success', 'অ্যাডমিন "'.$data['name'].'" তৈরি হয়েছে — এখন এই ইমেইল ও পাসওয়ার্ড দিয়ে /admin/login থেকে লগইন করতে পারবে।');
    }

    public function edit(User $user)
    {
        if ($user->isCustomer()) {
            abort(404);
        }

        $permissions = $user->permissions ?? [];

        // presentation helper: '*' expands to the full feature list for the checkboxes
        $checked = [];
        foreach (config('permissions.modules', []) as $module => $info) {
            $granted = $permissions[$module] ?? [];
            $checked[$module] = $granted === '*' || (is_array($granted) && in_array('*', $granted, true))
                ? array_keys($info['features'])
                : array_values(array_intersect(array_keys($info['features']), is_array($granted) ? $granted : []));
        }

        return view('super.admin-edit', [
            'user' => $user,
            'modules' => config('permissions.modules', []),
            'presets' => config('permissions.presets', []),
            'checked' => $checked,
            'industry' => Setting::get('industry', ''),
            'industries' => IndustryPack::all(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        if ($user->isCustomer()) {
            abort(404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:120|unique:users,email,'.$user->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'array',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        // the permission matrix only applies to plain admins — super admins hold everything
        $user->permissions = $user->isAdmin() ? $this->normalizePermissions($data['permissions'] ?? []) : null;

        $user->save();

        return redirect()->route('super.admins.index')
            ->with('success', 'অ্যাডমিন "'.$user->name.'" এর তথ্য ও অনুমতি আপডেট হয়েছে।');
    }

    public function toggle(Request $request, User $user)
    {
        if ($user->isCustomer()) {
            abort(404);
        }

        if ($user->id === auth()->id()) {
            return back()->withErrors(['admin' => 'আপনি নিজের অ্যাকাউন্ট নিষ্ক্রিয় করতে পারবেন না।']);
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('success', '"'.$user->name.'" এখন '.($user->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়').'।');
    }

    public function updatePassword(Request $request, User $user)
    {
        if ($user->isCustomer()) {
            abort(404);
        }

        $data = $request->validate([
            'password' => 'required|string|min:6|max:100',
        ]);

        $user->password = $data['password']; // hashed by the model cast
        $user->save();

        return back()->with('success', '"'.$user->name.'" এর নতুন পাসওয়ার্ড সেট হয়েছে।');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['admin' => 'আপনি নিজের অ্যাকাউন্ট মুছতে পারবেন না।']);
        }

        $remaining = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])
            ->where('id', '!=', $user->id)
            ->count();

        if ($remaining < 1) {
            return back()->withErrors(['admin' => 'শেষ অ্যাডমিন মুছে ফেলা যাবে না।']);
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', 'অ্যাডমিন "'.$name.'" মুছে ফেলা হয়েছে।');
    }

    /* ================= Industry provisioning shortcut ================= */

    /** Apply an industry pack from the client-edit page (reuses the admin logic 1:1). */
    public function applyIndustry(Request $request, User $user)
    {
        if ($user->isCustomer()) {
            abort(404);
        }

        $response = app(SettingController::class)->applyIndustry($request);
        $data = json_decode((string) $response->getContent(), true) ?: [];

        if (($data['ok'] ?? false) !== true) {
            return back()->withErrors(['admin' => $data['message'] ?? 'ইন্ডাস্ট্রি প্রিসেট প্রয়োগ করা যায়নি।']);
        }

        return redirect()->route('super.admins.edit', $user)->with('success', $data['message'] ?? 'ইন্ডাস্ট্রি প্রিসেট প্রয়োগ হয়েছে।');
    }

    /* ================= Helpers ================= */

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
    private function presetMap(?string $preset): ?array
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
}
