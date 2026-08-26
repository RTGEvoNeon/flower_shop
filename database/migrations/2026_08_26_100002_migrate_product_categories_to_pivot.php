<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * @var array<string, string>
     */
    private array $categories = [
        'mono' => 'Монобукеты',
        'mix' => 'Микс букеты',
        'tulip' => 'Тюльпаны',
        'winter' => 'Зима',
        'wedding' => 'Свадебные',
        'premium' => 'Премиум',
        'september1' => '1 сентября',
        'bouquets' => 'Букеты',
        'seasonal' => 'Сезонные',
        'luxury' => 'Премиум (legacy)',
    ];

    public function up(): void
    {
        $categoryIds = [];

        foreach (array_values($this->categories) as $index => $name) {
            $key = array_keys($this->categories)[$index];

            $existingId = DB::table('categories')->where('key', $key)->value('id');

            $categoryIds[$key] = $existingId ?? DB::table('categories')->insertGetId([
                'key' => $key,
                'name' => $name,
                'sort_order' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $products = DB::table('products')->select('id', 'category')->get();

        foreach ($products as $product) {
            if (! array_key_exists($product->category, $categoryIds)) {
                Log::warning("Product {$product->id} has unknown category '{$product->category}', skipped during category migration.");

                continue;
            }

            DB::table('category_product')->insertOrIgnore([
                'category_id' => $categoryIds[$product->category],
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('category_product')->truncate();
        DB::table('categories')->whereIn('key', array_keys($this->categories))->delete();
    }
};
