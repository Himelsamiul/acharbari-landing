<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /** আমার অ্যাকাউন্ট — sob admin er nijer account page. */
    public function index()
    {
        return view('admin.account', [
            'user' => auth()->user(),
        ]);
    }

    /** Nijer password change — current password verify korte hoy. */
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|max:100|confirmed',
        ], [
            'current_password.required' => 'বর্তমান পাসওয়ার্ড দিন।',
            'password.required' => 'নতুন পাসওয়াঁর্ড দিন।',
            'password.min' => 'নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'নতুন পাসওয়ার্ড আর কনফার্মেশন মিলছে না।',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'বর্তমান গুলো ভুল — আবার দেখুন।']);
        }

        $user->password = $data['password']; // model cast e hash hoy
        $user->save();

        return back()->with('success', 'পাসওয়ার্ড বদলে গেছে — parer bar theke notun password diye dhukben।');
    }
}
