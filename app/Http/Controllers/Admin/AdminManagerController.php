<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Super\SuperAdminController;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Legacy admin-management endpoints (/admin/admin-management).
 * The real panel now lives at /super/admins — these routes stay registered
 * (URIs + names unchanged) but are super-admin-only and forward there.
 */
class AdminManagerController extends Controller
{
    /** List page → the Super Admin panel. */
    public function index()
    {
        return redirect()->route('super.admins.index');
    }

    /** Delegate creation to the Super Admin panel logic. */
    public function store(Request $request)
    {
        return app(SuperAdminController::class)->store($request);
    }

    /** Delegate permission/password updates to the Super Admin panel logic. */
    public function update(Request $request, User $user)
    {
        return app(SuperAdminController::class)->update($request, $user);
    }

    /** Delegate deletion (guards included) to the Super Admin panel logic. */
    public function destroy(User $user)
    {
        return app(SuperAdminController::class)->destroy($user);
    }
}
