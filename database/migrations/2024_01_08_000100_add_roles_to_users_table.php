<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 3-role system: super_admin (platform owner) / admin (client) / customer.
     *
     * Fully additive + guarded so it can run on the live MySQL via setup.php:
     *  - `role` defaults to `customer` (least privilege — anything that forgets
     *    to set a role can never gain admin access), then ALL existing rows are
     *    backfilled to super_admin because today every user is a full admin.
     *  - `permissions` JSON holds the module.feature map (role=admin only).
     *  - `phone` unique-nullable lets customers log in without an email.
     *  - `email` becomes nullable (MySQL/SQLite unique indexes allow many NULLs,
     *     so existing admin rows are untouched).
     *  - `address` for the customer profile / checkout prefill.
     *  - `is_active` lets the super admin deactivate a client's admin login.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 20)->default('customer')->index()->after('name');
            });
        }

        if (! Schema::hasColumn('users', 'permissions')) {
            Schema::table('users', function (Blueprint $table) {
                $table->json('permissions')->nullable()->after('password');
            });
        }

        if (! Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone', 20)->nullable()->unique()->after('email');
            });
        }

        if (! Schema::hasColumn('users', 'address')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('address', 500)->nullable()->after('phone');
            });
        }

        if (! Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('remember_token');
            });
        }

        // email → nullable so customers can register with phone only
        $emailColumn = collect(Schema::getColumns('users'))->firstWhere('name', 'email');
        if ($emailColumn && ($emailColumn['nullable'] ?? false) === false) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('email')->nullable()->change();
            });
        }

        // every pre-existing user was a full admin — they become the platform owner.
        // MySQL applies the column's DDL default to all existing rows during the
        // ALTER, so whereNull() matches nothing; at this instant every row still
        // carries the fresh default, and users created later never hit this query.
        DB::table('users')->where('role', 'customer')->update(['role' => 'super_admin']);
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['role']);
                $table->dropColumn('role');
            });
        }

        foreach (['permissions', 'phone', 'address', 'is_active'] as $column) {
            if (Schema::hasColumn('users', $column)) {
                Schema::table('users', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }

        // email stays nullable on rollback — restoring NOT NULL would destroy
        // phone-only customer accounts (no destructive operations on live data)
    }
};
