<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Route-level permission check: middleware('perm:orders').
 * Sidebar te link dekhleo URL hate likhe dhukte parbe na — 403.
 */
class EnsureHasPermission
{
    public function handle(Request $request, Closure $next, string $perm): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasPerm($perm)) {
            abort(403, 'এই পেজে ঢোকার অনুমতি আপনার নেই।');
        }

        return $next($request);
    }
}
