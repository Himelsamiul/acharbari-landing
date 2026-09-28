<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Prottek variant er nijer VAT + discount badge — na thakle product
     * level er ta fallback hishebe cholbe.
     */
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('vat_percent', 5, 2)->nullable()->after('old_price');
            $table->string('discount_bn', 30)->nullable()->after('vat_percent');
            $table->string('discount_en', 30)->nullable()->after('discount_bn');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['vat_percent', 'discount_bn', 'discount_en']);
        });
    }
};
