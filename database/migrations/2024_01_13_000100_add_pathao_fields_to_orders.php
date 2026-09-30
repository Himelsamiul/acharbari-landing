<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Pathao Courier delivery er consignment + status order er sathe rakhar jonno. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('pathao_consignment_id', 60)->nullable()->after('payment_txn_id');
            $table->string('pathao_status', 60)->nullable()->after('pathao_consignment_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['pathao_consignment_id', 'pathao_status']);
        });
    }
};
