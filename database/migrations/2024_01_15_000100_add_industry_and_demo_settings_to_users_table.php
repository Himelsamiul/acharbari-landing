<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // showcase demo admins: kon genre er "admin panel" ei user dekhbe.
        // industry null = real admin/super admin/customer — global store.
        Schema::table('users', function (Blueprint $table) {
            $table->string('industry', 40)->nullable()->index();
            // sandbox: bound admin er nijer setting writes ekhane jay,
            // global `settings` table kono koronei touch hoy na
            $table->json('demo_settings')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['industry', 'demo_settings']);
        });
    }
};
