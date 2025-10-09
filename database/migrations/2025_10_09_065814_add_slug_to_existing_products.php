<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Генерируем slug для всех продуктов, у которых его нет
        Product::whereNull('slug')->orWhere('slug', '')->chunk(100, function ($products) {
            foreach ($products as $product) {
                $slug = Str::slug($product->name);

                // Проверяем уникальность slug
                $originalSlug = $slug;
                $counter = 1;

                while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $product->update(['slug' => $slug]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Опционально: можно очистить slug
        // Product::query()->update(['slug' => null]);
    }
};
