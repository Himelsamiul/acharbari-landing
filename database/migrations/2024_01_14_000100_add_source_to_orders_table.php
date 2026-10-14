<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // order er itihas: 'store' = admin-er product order, 'landing' =
        // super admin-er showcase theke becha landing-page design order
        Schema::table('orders', function (Blueprint $table) {
            $table->string('source', 20)->default('store')->index();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
