<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Customer-area gate for the storefront /account pages.
 * Admins are sent back to their own panel — never mixed into customer UI.
 */
class EnsureCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request); // guests are handled by the `auth` middleware
        }

        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
