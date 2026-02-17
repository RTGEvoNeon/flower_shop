<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\WholesaleProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Str;

class WholesaleProductsImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row): ?WholesaleProduct
    {
        $id = $row['id'] ?? null;
        $name = $row['name'] ?? null;

        // Пропускаем пустые строки
        if (empty($name)) {
            return null;
        }

        // Если указан ID, пытаемся обновить существующий товар
        if (!empty($id)) {
            $product = WholesaleProduct::find($id);

            if ($product) {
                // Обновляем существующий товар
                $product->update([
                    'name' => $name,
                    'price_tier_1' => $row['price_tier_1'] ?? 0,
                    'price_tier_2' => $row['price_tier_2'] ?? 0,
                    'price_tier_3' => $row['price_tier_3'] ?? 0,
                    'min_quantity' => $row['min_quantity'] ?? 1000,
                    'is_available' => isset($row['is_available']) ? (bool)$row['is_available'] : true,
                ]);

                return null; // Возвращаем null, так как товар уже обновлен
            }
        }

        // Создаем новый товар (если ID не указан или товар не найден)
        // Генерируем уникальный slug из названия
        $slug = $row['slug'] ?? Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        // Проверяем уникальность slug
        while (WholesaleProduct::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $productData = [
            'name' => $name,
            'slug' => $slug,
            'price_tier_1' => $row['price_tier_1'] ?? 0,
            'price_tier_2' => $row['price_tier_2'] ?? 0,
            'price_tier_3' => $row['price_tier_3'] ?? 0,
            'min_quantity' => $row['min_quantity'] ?? 1000,
            'is_available' => isset($row['is_available']) ? (bool)$row['is_available'] : true,
        ];

        // Если указан ID при создании нового товара, добавляем его
        if (!empty($id)) {
            $productData['id'] = $id;
        }

        return new WholesaleProduct($productData);
    }
}
