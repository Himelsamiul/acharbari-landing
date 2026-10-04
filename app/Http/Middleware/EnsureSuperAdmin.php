<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Super-admin-only gate for the /super prefix and platform-owner routes
 * (admin user management, industry apply/clear).
 */
class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request); // guests are handled by the `auth` middleware
        }

        if (! $user->isSuperAdmin()) {
            abort(403, 'এই পেজটি শুধু সুপার অ্যাডমিনের জন্য।');
        }

        if (! $user->is_active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'আপনার অ্যাকাউন্টটি নিষ্ক্রিয় করা হয়েছে।']);
        }

        return $next($request);
    }
}
