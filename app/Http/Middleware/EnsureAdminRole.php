<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Role firewall for the /admin prefix (alias: `admin.role`).
 * Customers never get in (Bengali 403); deactivated admins are logged out.
 */
class EnsureAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request); // guests are handled by the `auth` middleware
        }

        if ($user->isCustomer()) {
            abort(403, 'এই পেজটি শুধু অ্যাডমিনদের জন্য। আপনি কাস্টমার অ্যাকাউন্টে লগইন করেছেন।');
        }

        if (! $user->is_active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'আপনার অ্যাকাউন্টটি নিষ্ক্রিয় করা হয়েছে — সুপার অ্যাডমিনের সাথে যোগাযোগ করুন।']);
        }

        return $next($request);
    }
}
