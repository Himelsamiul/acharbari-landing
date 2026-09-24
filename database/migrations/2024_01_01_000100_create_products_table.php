<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('name_en');
            $table->string('category');
            $table->string('category_en');
            $table->string('category_key', 20);
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->string('discount_bn')->nullable();
            $table->string('discount_en')->nullable();
            $table->string('image');
            $table->decimal('rating', 3, 1)->default(5);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->string('stock_badge')->nullable();
            $table->string('stock_badge_en')->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
