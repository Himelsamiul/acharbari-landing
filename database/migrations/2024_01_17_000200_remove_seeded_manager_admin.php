<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove the seeded sample "Store Manager" admin (manager@khorak.shop).
     * Its password was public in the seeder, and the seeder no longer creates
     * it. A delete-locked row is the owner's call and stays. Orders keep
     * existing — orders.user_id is nullOnDelete.
     */
    public function up(): void
    {
        $ids = DB::table('users')
            ->where('email', 'manager@khorak.shop')
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
        // sample admin is no longer seeded — nothing to restore
    }
};
