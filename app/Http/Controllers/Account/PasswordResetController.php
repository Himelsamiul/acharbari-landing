<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Password reset for accounts that have an email. Mail runs on the log
 * driver in dev — the reset link lands in storage/logs/laravel.log.
 * Phone-only accounts cannot self-reset (support-assisted).
 */
class PasswordResetController extends Controller
{
    public function request()
    {
        return view('account.forgot');
    }

    public function email(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'আপনার ইমেইল দিন।',
            'email.email' => 'সঠিক ইমেইল দিন।',
        ]);

        $user = User::where('email', $data['email'])->first();

        if ($user) {
            Password::broker()->sendResetLink(['email' => $data['email']]);
        }

        // same response either way — no account enumeration
        return back()->with('status', 'ইমেইল পাঠানো হয়েছে — ইনবক্সে রিসেট লিংক দেখুন (ডেভ মোডে লিংকটি storage/logs/laravel.log এ যায়)।');
    }

    public function form(string $token)
    {
        return view('account.reset', [
            'token' => $token,
            'email' => (string) request()->query('email', ''),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:100|confirmed',
        ], [
            'password.confirmed' => 'পাসওয়ার্ড দুটি মিলছে না।',
        ]);

        $status = Password::broker()->reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password, // hashed by the model cast
                    'remember_token' => Str::random(10),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'পাসওয়ার্ড বদলে গেছে — এখন লগইন করুন।');
        }

        return back()->withErrors(['email' => 'লিংকটি ভুল বা মেয়াদ শেষ — আবার রিসেট করুন।']);
    }
}
