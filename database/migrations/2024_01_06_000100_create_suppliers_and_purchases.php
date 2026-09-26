<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('address')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->date('purchased_at');
            $table->string('note')->nullable();
            $table->timestamps();
        });

        // supplier picked from the dropdown on the product form
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->after('barcode')
                ->constrained()->nullOnDelete();
        });

        // active/inactive toggles for taxonomy
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('key');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('supplier_id');
        });
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('suppliers');
    }
};
