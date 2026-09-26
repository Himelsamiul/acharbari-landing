<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Older databases created the orders table before vat_total existed in
     * the schema ("Unknown column 'vat_total'" on checkout), and before the
     * district-based delivery column was introduced. Guarded so fresh
     * databases that already have them are untouched.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('orders', 'vat_total')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('vat_total', 10, 2)->default(0)->after('subtotal');
            });
        }

        if (! Schema::hasColumn('orders', 'district')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('district')->nullable()->after('area');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'district')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('district');
            });
        }

        if (Schema::hasColumn('orders', 'vat_total')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('vat_total');
            });
        }
    }
};
