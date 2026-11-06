<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Team hierarchy — which account created this one. A client admin only
     * ever sees and manages the accounts they (or their team) created.
     * Accounts provisioned by the platform owner stay NULL, so the owner's id
     * never sits on a client's row. nullOnDelete keeps a team if its creator goes.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('is_protected')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
