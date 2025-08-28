<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

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

            // Путь к папке с изображениями для этого продукта
            $productImagePath = storage_path("products/{$product->id}");
            
            if (!File::exists($productImagePath)) {
                echo "⚠️ Папка с изображениями для продукта {$product->id} не найдена, пропускаем...\n";
                continue;
            }

            // Получаем все JPG файлы из папки продукта
            $imageFiles = File::glob($productImagePath . '/*.jpg');
            
            if (empty($imageFiles)) {
                echo "⚠️ Изображения для продукта {$product->id} не найдены, пропускаем...\n";
                continue;
            }

            echo "🎨 Найдено " . count($imageFiles) . " изображений для '{$product->name}'...\n";

            // Создаем записи в БД для каждого найденного файла
            foreach ($imageFiles as $index => $filePath) {
                $filename = basename($filePath);
                $fileSize = File::size($filePath);
                
                // Получаем размеры изображения
                $imageInfo = getimagesize($filePath);
                $width = $imageInfo[0] ?? null;
                $height = $imageInfo[1] ?? null;
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'filename' => $filename,
                    'original_name' => $filename,
                    'path' => "{$product->id}/{$filename}",
                    'url' => null, // Будем использовать локальные файлы
                    'mime_type' => 'image/jpeg',
                    'file_size' => $fileSize,
                    'width' => $width,
                    'height' => $height,
                    'sort_order' => $index,
                    'is_primary' => $index === 0, // Первое изображение главное
                    'is_active' => true,
                    'alt_text' => $product->name . ' - фото ' . ($index + 1),
                    'description' => null,
                ]);
                
                echo "  ✅ Добавлено изображение: {$filename}\n";
            }

            echo "✅ Обработан продукт '{$product->name}' - " . count($imageFiles) . " изображений\n";
        }

        echo "🎉 Готово! Изображения добавлены ко всем продуктам.\n";
    }
}
