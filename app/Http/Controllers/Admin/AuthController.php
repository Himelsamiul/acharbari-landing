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
            return redirect()->route(Auth::user()->isSuperAdmin() ? 'super.overview' : 'admin.dashboard');
        }

        // showcase credential modal theke ashle email prefilled thake —
        // shudhu known active admin email e prefill hoy (enumeration nei:
        // onno value dile ignore)
        $prefill = '';
        $email = trim((string) $request->query('email', ''));
        if ($email !== '' && User::where('email', $email)->where('role', User::ROLE_ADMIN)->where('is_active', true)->exists()) {
            $prefill = $email;
        }

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
                    'email' => 'আপনার অ্যাকাউন্টটি নিষ্ক্রিয় করা হয়েছে — সুপার অ্যাডমিনের সাথে যোগাযোগ করুন।',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // the platform owner lands in their own panel
            return redirect()->intended(
                $user->isSuperAdmin() ? route('super.overview') : route('admin.dashboard')
            );
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
