<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_status', 20)->nullable()->after('payment_method'); // null = COD, else pending|paid|failed
            $table->string('payment_txn_id', 100)->nullable()->after('payment_status'); // gateway transaction id
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_txn_id']);
        });
    }
};
