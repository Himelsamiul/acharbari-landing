<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Route-level permission gate (alias: `perm`).
 *
 * Usage: ->middleware('perm:orders.view')
 * super_admin always passes; plain admins need the granted permission;
 * anyone else gets the Bengali 403 page.
 */
class CheckPermission
{
    public function handle(Request $request, Closure $next, string $action): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasPermission($action)) {
            abort(403, 'এই পেজ বা অ্যাকশনের অনুমতি আপনার নেই।');
        }

        return $next($request);
    }
}
