<?php

use Illuminate\Support\Str;
use App\Models\Product;
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
        Schema::table('products', function (Blueprint $table) {
            // Добавляем поля только если их нет
            if (!Schema::hasColumn('products', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (!Schema::hasColumn('products', 'amount')) {
                $table->integer('amount')->nullable()->after('category');
            }
            if (!Schema::hasColumn('products', 'alt_text')) {
                $table->text('alt_text')->nullable()->after('is_available');
            }
        });

        // Заполняем пустые slug'и на основе названий
        $products = Product::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($products as $product) {
            $slug = Str::slug($product->name);
            $counter = 1;
            $originalSlug = $slug;
            
            // Проверяем уникальность slug'а
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            Product::where('id', $product->id)->update(['slug' => $slug]);
        }

        // Делаем slug уникальным
        try {
            Schema::table('products', function (Blueprint $table) {
                $table->unique('slug', 'products_slug_unique');
            });
        } catch (\Exception $e) {
            // Индекс уже существует, игнорируем ошибку
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['slug', 'amount', 'alt_text']);
        });
    }
};
