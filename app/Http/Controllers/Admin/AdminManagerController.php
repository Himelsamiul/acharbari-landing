<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminManagerController extends Controller
{
    /** List all admin logins. */
    public function index()
    {
        $admins = User::orderBy('name')->get();

        return view('admin.admins', [
            'admins' => $admins,
            'currentId' => auth()->id(),
        ]);
    }

    /** Create a new admin login. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:120|unique:users,email',
            'password' => 'required|string|min:6|max:100',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // hashed automatically by the model cast
        ]);

        return back()->with('success', 'অ্যাডমিন "' . $data['name'] . '" তৈরি হয়েছে — এখন এই ইমেইল ও পাসওয়ার্ড দিয়ে লগইন করতে পারবে।');
    }

    /** Remove an admin login (never your own, never the last one). */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['admin' => 'আপনি নিজের অ্যাকাউন্ট মুছতে পারবেন না।']);
        }

        if (User::count() <= 1) {
            return back()->withErrors(['admin' => 'শেষ অ্যাডমিন মুছে ফেলা যাবে না।']);
        }

        $user->delete();

        return back()->with('success', 'অ্যাডমিন "' . $user->name . '" মুছে ফেলা হয়েছে।');
    }
}
