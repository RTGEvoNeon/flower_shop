<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $id = $row['id'] ?? null;
        $name = $row['name'] ?? null;
        $price = $row['price'] ?? null;
        $category = $row['category'] ?? null;

        // Пропускаем пустые строки
        if (empty($name) && empty($price) && empty($category)) {
            return null;
        }

        // Если указан ID, пытаемся обновить существующий товар
        if (!empty($id)) {
            $product = Product::find($id);

            if ($product) {
                // Обновляем существующий товар
                $product->update([
                    'name' => $name,
                    'description' => $row['description'] ?? null,
                    'price' => $price,
                    'category' => $category,
                    'is_available' => isset($row['is_available']) ? (bool)$row['is_available'] : true,
                ]);

                return null; // Возвращаем null, так как товар уже обновлен
            }
        }

        // Создаем новый товар (если ID не указан или товар не найден)
        // Генерируем уникальный slug из названия
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        // Проверяем уникальность slug
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $productData = [
            'name' => $name,
            'slug' => $slug,
            'description' => $row['description'] ?? null,
            'price' => $price,
            'category' => $category,
            'is_available' => isset($row['is_available']) ? (bool)$row['is_available'] : true,
        ];

        // Если указан ID при создании нового товара, добавляем его
        if (!empty($id)) {
            $productData['id'] = $id;
        }

        return new Product($productData);
    }
}
