<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Поддерживаем различные форматы заголовков
        $name = $row['name'] ?? $row['name_nazvanie'] ?? null;
        $slug = $row['slug'] ?? null;
        $description = $row['description'] ?? $row['description_opisanie'] ?? null;
        $category = $row['category'] ?? $row['category_kategoriia'] ?? 'bouquets';
        $amount = $row['amount'] ?? $row['amount_kolicestvo'] ?? null;
        $price = $row['price'] ?? $row['price_cena'] ?? 0;
        $isAvailable = $row['is_available'] ?? $row['is_available_10'] ?? true;
        $altText = $row['alt_text'] ?? $row['alt_text_dlia_seo'] ?? null;

        // Пропускаем строки без названия
        if (empty($name)) {
            return null;
        }

        // Генерируем slug из названия, если он не указан
        $slug = $slug ?? Str::slug($name);

        // Проверяем уникальность slug и добавляем суффикс если нужно
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return new Product([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'category' => $category,
            'amount' => $amount,
            'price' => $price,
            'is_available' => (bool) $isAvailable,
            'alt_text' => $altText,
        ]);
    }

    /**
     * Правила валидации
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'amount' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'alt_text' => 'nullable|string',
        ];
    }

    /**
     * Кастомные сообщения об ошибках
     */
    public function customValidationMessages()
    {
        return [
            'name.required' => 'Название товара обязательно для заполнения',
            'slug.unique' => 'Такой slug уже существует',
            'amount.integer' => 'Количество должно быть целым числом',
            'price.numeric' => 'Цена должна быть числом',
        ];
    }
}
