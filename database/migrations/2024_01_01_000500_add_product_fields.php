<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('vat_percent', 5, 2)->default(0)->after('price');
            $table->boolean('is_featured')->default(false)->after('is_active');
        });

        Schema::create('order_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('customer_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_notifications');
        Schema::dropIfExists('order_notifications');
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['vat_percent', 'is_featured']);
        });
    }
};
