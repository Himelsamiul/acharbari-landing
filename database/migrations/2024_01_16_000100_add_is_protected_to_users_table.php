<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // delete-locked account: protected user shudhu platform owner (khorak,
        // admin@khorak.shop) delete korte parbe — onno super admin/admin na.
        // flag per-user, tai shudhu flagged account e niyom; baki sob aager motoi.
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_protected')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_protected');
        });
    }
};
