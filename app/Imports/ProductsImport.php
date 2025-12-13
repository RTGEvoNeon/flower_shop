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
        // Отладка: смотрим какие ключи приходят
        \Log::info('Excel row keys:', array_keys($row));
        \Log::info('Excel row data:', $row);

        $name = $row['name'] ?? null;
        $price = $row['price'] ?? null;
        $category = $row['category'] ?? null;

        // Пропускаем пустые строки
        if (empty($name) && empty($price) && empty($category)) {
            return null;
        }

        // Генерируем уникальный slug из названия
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        // Проверяем уникальность slug
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return new Product([
            'name' => $name,
            'slug' => $slug,
            'description' => $row['description'] ?? null,
            'price' => $price,
            'category' => $category,
            'is_available' => isset($row['is_available']) ? (bool)$row['is_available'] : true,
        ]);
    }
}
