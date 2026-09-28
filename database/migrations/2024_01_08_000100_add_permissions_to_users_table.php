<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Role-based admin: prottek user er sidebar-section permission list (JSON).
     * Existing admin ra full access peye jabe — keu lockout hobe na.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('permissions')->nullable()->after('password');
        });

        // purano admin ra: full permission (ager moto choluk)
        DB::table('users')->update(['permissions' => json_encode(array_keys(User::PERMISSIONS))]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('permissions');
        });
    }
};
