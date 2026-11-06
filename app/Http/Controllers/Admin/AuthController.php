<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // ?email= prefills the login field — any well-formed address, with no
        // lookup, so the page never tells whether an account exists
        $email = trim((string) $request->query('email', ''));
        $prefill = strlen($email) <= 120 && filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';

        return view('admin.login', ['prefillEmail' => $prefill]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            /** @var User $user */
            $user = Auth::user();

            // the admin panel is not for storefront customers
            if ($user->isCustomer()) {
                Auth::guard('web')->logout();
                return back()->withErrors([
                    'email' => 'এই পেজটি শুধু অ্যাডমিনদের জন্য।',
                ])->onlyInput('email');
            }

            if (! $user->is_active) {
                Auth::guard('web')->logout();
                return back()->withErrors([
                    'email' => 'আপনার অ্যাকাউন্টটি নিষ্ক্রিয় করা হয়েছে — আপনার অ্যাডমিনের সাথে যোগাযোগ করুন।',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // everyone (platform owner included) lands on the store dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'ভুল ইমেইল বা পাসওয়ার্ড — আবার চেষ্টা করুন।',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
