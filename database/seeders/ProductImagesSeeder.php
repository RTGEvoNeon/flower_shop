<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "🖼️ Добавляем изображения к существующим продуктам...\n";

        // Получаем все существующие продукты
        $products = Product::all();

        if ($products->isEmpty()) {
            echo "❌ Продукты не найдены! Сначала создайте продукты.\n";
            return;
        }

        echo "📦 Найдено продуктов: {$products->count()}\n";

        foreach ($products as $product) {
            // Проверяем, есть ли уже изображения у продукта
            if ($product->images()->count() > 0) {
                echo "⏭️ У продукта '{$product->name}' уже есть изображения, пропускаем...\n";
                continue;
            }

            // Добавляем от 2 до 5 изображений к каждому продукту
            $imageCount = fake()->numberBetween(2, 5);
            
            echo "🎨 Добавляем {$imageCount} изображений к '{$product->name}'...\n";

            // Создаем изображения
            $images = [];
            for ($i = 0; $i < $imageCount; $i++) {
                $images[] = ProductImage::factory()
                    ->forProduct($product)
                    ->state([
                        'is_primary' => $i === 0, // Первое изображение главное
                        'sort_order' => $i,
                        'is_active' => true,
                    ])
                    ->create();
            }

            echo "✅ Добавлено {$imageCount} изображений\n";
        }

        echo "🎉 Готово! Изображения добавлены ко всем продуктам.\n";
    }
}
