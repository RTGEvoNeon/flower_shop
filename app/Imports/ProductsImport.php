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
        // Генерируем slug из названия, если он не указан
        $slug = $row['slug'] ?? Str::slug($row['name']);
        
        return new Product([
            'name' => $row['name'],
            'slug' => $slug,
            'description' => $row['description'] ?? null,
            'category' => $row['category'] ?? 'bouquets',
            'amount' => $row['amount'] ?? null,
            'price' => $row['price'] ?? 0,
            'is_available' => (bool) ($row['is_available'] ?? true),
            'alt_text' => $row['alt_text'] ?? null,
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
