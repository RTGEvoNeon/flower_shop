<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wholesale_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price_tier_1', 8, 2); // Цена для 1000-4999 шт
            $table->decimal('price_tier_2', 8, 2); // Цена для 5000-9999 шт
            $table->decimal('price_tier_3', 8, 2); // Цена для 10000+ шт
            $table->integer('min_quantity')->default(1000);
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            // Индексы для быстрого поиска
            $table->index('slug');
            $table->index('is_available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wholesale_products');
    }
};
