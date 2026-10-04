<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Feature-granular permission split: theme/payment/tracking/content each
     * used to expose a single `edit` feature; they are now many granular keys
     * (config/permissions.php). A stored `module => ['edit']` meant FULL control
     * of that module, so it becomes `['*']` ("all current + future features") —
     * otherwise every migrated admin would silently lose access overnight.
     *
     * Fully additive + idempotent, safe on the live MySQL via setup.php:
     *  - only array grants actually containing `edit` are rewritten;
     *  - `['*']`, `'*'` and feature lists without `edit` are left untouched;
     *  - re-running finds nothing left to change.
     * No down(): the original granular list cannot be reconstructed — keeping
     * the widened access on rollback is the safe direction.
     */
    private const SPLIT_MODULES = ['theme', 'payment', 'tracking', 'content'];

    public function up(): void
    {
        $admins = DB::table('users')
            ->where('role', 'admin')
            ->whereNotNull('permissions')
            ->get(['id', 'permissions']);

        foreach ($admins as $admin) {
            $permissions = json_decode((string) $admin->permissions, true);
            if (! is_array($permissions)) {
                continue;
            }

            $changed = false;
            foreach (self::SPLIT_MODULES as $module) {
                $granted = $permissions[$module] ?? null;
                if (is_array($granted) && in_array('edit', $granted, true)) {
                    $permissions[$module] = ['*'];
                    $changed = true;
                }
            }

            if ($changed) {
                DB::table('users')->where('id', $admin->id)->update([
                    'permissions' => json_encode($permissions),
                ]);
            }
        }
    }

    public function down(): void
    {
        // no-op — data migration, intentionally irreversible (see docblock)
    }
};
