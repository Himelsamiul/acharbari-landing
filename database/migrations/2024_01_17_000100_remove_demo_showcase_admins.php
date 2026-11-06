<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Showcase/demo feature retired. Remove the per-genre demo-admin accounts
     * (demo.<genre>@khorak.shop, password public on the old showcase cards).
     * Their sandbox code is gone, so if left they would log in against the
     * REAL store — they must be deleted. Only the generated accounts match:
     * an admin row carrying the showcase genre tag (users.industry). A real
     * account with a look-alike address, a customer, or anything delete-locked
     * stays. Orders keep existing — orders.user_id is nullOnDelete.
     */
    public function up(): void
    {
        $ids = DB::table('users')
            ->where('email', 'like', 'demo.%@khorak.shop')
            ->where('role', 'admin')
            ->whereNotNull('industry')
            ->where('is_protected', false)
            ->pluck('id');

        if ($ids->isEmpty()) {
            return;
        }

        if (Schema::hasTable('sessions')) {
            DB::table('sessions')->whereIn('user_id', $ids)->delete();
        }
        DB::table('users')->whereIn('id', $ids)->delete();
    }

    public function down(): void
    {
        // demo admins are no longer generated — nothing to restore
    }
};
