<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminManagerController extends Controller
{
    /** List all admin logins (?edit=<id> hole edit card o khule). First admin kokhono dekhabe na. */
    public function index(Request $request)
    {
        // first admin (sobar puran, seed kora) — list e dekhabe na, secret thakuk
        $firstId = (int) User::min('id');
        $admins = User::where('id', '!=', $firstId)->orderBy('name')->get();

        $editUser = null;
        if ($request->filled('edit') && (int) $request->query('edit') !== (int) auth()->id()) {
            $editUser = User::where('id', '!=', $firstId)->find($request->query('edit'));
        }

        return view('admin.admins', [
            'admins' => $admins,
            'currentId' => auth()->id(),
            'editUser' => $editUser,
            'allPerms' => User::PERMISSIONS,
            'rolePresets' => User::ROLE_PRESETS,
        ]);
    }

    /** Create a new admin login with checkbox permissions. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:120|unique:users,email',
            'password' => 'required|string|min:6|max:100',
            'permissions' => 'nullable|array',
            'permissions.*' => Rule::in(array_keys(User::PERMISSIONS)),
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // hashed automatically by the model cast
            'permissions' => $data['permissions'] ?? [],
        ]);

        return back()->with('success', 'অ্যাডমিন "' . $data['name'] . '" তৈরি হয়েছে — এখন এই ইমেইল ও পাসওয়ার্ড দিয়ে লগইন করতে পারবে।');
    }

    /** Edit an admin's permissions and/or reset their password. */
    public function update(Request $request, User $user)
    {
        // nijer permission nijei badle jabe na — lockout hoye jabe
        if ($user->id === auth()->id()) {
            return back()->withErrors(['admin' => 'নিজের পারমিশন আপনি নিজে এডিট করতে পারবেন না — অন্য একজন অ্যাডমিন করে দিবে।']);
        }

        $data = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => Rule::in(array_keys(User::PERMISSIONS)),
            'password' => 'nullable|string|min:6|max:100',
        ]);

        $user->permissions = $data['permissions'] ?? [];

        if (!empty($data['password'])) {
            $user->password = $data['password']; // model cast e hash hoy
        }

        $user->save();

        $msg = 'অ্যাডমিন "' . $user->name . '" এর পারমিশন আপডেট হয়েছে।';
        if (!empty($data['password'])) $msg = 'অ্যাডমিন "' . $user->name . '" এর পাসওয়ার্ড ও পারমিশন আপডেট হয়েছে।';

        return redirect()->route('admin.admins.index')->with('success', $msg);
    }

    /**
     * Remove an admin login. Nijer account-o delete kora jay — tobe onno
     * admin thakte hobe (delete er por logout hoye jabe). Last admin kokhono na.
     */
    public function destroy(User $user)
    {
        if (User::count() <= 1) {
            return back()->withErrors(['admin' => 'শেষ অ্যাডমিন মুছে ফেলা যাবে না — age notun ekjon admin banaan।']);
        }

        $isSelf = $user->id === auth()->id();
        $name = $user->name;
        $user->delete();

        if ($isSelf) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('admin.login')->with('success', 'আপনার অ্যাকাউন্ট "' . $name . '" মুছে ফেলা হয়েছে — লগআউট করা হলো।');
        }

        return back()->with('success', 'অ্যাডমিন "' . $name . '" মুছে ফেলা হয়েছে।');
    }
}
