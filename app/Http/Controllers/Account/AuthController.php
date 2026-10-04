<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Storefront customer auth: register / login (email OR phone) / logout.
 * Passwordless reset lives in PasswordResetController.
 */
class AuthController extends Controller
{
    public function showRegister()
    {
        return view('account.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|min:10|max:20|unique:users,phone',
            'email' => 'nullable|email|max:120|unique:users,email',
            'password' => 'required|string|min:6|max:100|confirmed',
        ], [
            'phone.unique' => 'এই মোবাইল নম্বরে ইতোমধ্যে একটি অ্যাকাউন্ট আছে — লগইন করুন।',
            'email.unique' => 'এই ইমেইলে ইতোমধ্যে একটি অ্যাকাউন্ট আছে — লগইন করুন।',
            'password.confirmed' => 'পাসওয়ার্ড দুটি মিলছে না।',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'password' => $data['password'], // hashed by the model cast
            'role' => User::ROLE_CUSTOMER,
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('account'))->with('success', 'অ্যাকাউন্ট তৈরি হয়েছে — স্বাগতম, '.$user->name.'!');
    }

    public function showLogin()
    {
        return view('account.login');
    }

    /** Login accepts email OR phone + password. */
    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => 'required|string|max:120',
            'password' => 'required|string',
        ], [
            'login.required' => 'ইমেইল অথবা মোবাইল নম্বর দিন।',
        ]);

        $login = trim($data['login']);
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::attempt([$field => $login, 'password' => $data['password']], $request->boolean('remember'))) {
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::guard('web')->logout();

                return back()->withErrors(['login' => 'আপনার অ্যাকাউন্টটি নিষ্ক্রিয় করা হয়েছে।'])->onlyInput('login');
            }

            $request->session()->regenerate();

            // admins keep their own panel — customers land in their account area
            return redirect()->intended(
                $user->isCustomer() ? route('account') : route('admin.dashboard')
            );
        }

        return back()->withErrors([
            'login' => 'ভুল তথ্য — ইমেইল/মোবাইল নম্বর ও পাসওয়ার্ড মিলিয়ে আবার চেষ্টা করুন।',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('account_msg', 'আপনি সফলভাবে লগআউট করেছেন।');
    }
}
