<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithCalculatedFormulas, WithEvents, WithHeadingRow
{
    use RegistersEventListeners;

    /**
     * Отложенные привязки категорий: slug товара => ключ категории.
     * Заполняется в model() и применяется после сохранения всех строк в afterImport(),
     * т.к. ToModel не даёт доступа к сохранённому instance для новых строк.
     *
     * @var array<string, string>
     */
    private array $pendingCategoryLinks = [];

    /**
     * @return Model|null
     */
    public function model(array $row)
    {
        $id = $row['id'] ?? null;
        $name = $row['name'] ?? null;
        $price = $this->roundedPriceToHundreds($row['price'] ?? null);
        $category = $row['category'] ?? null;

        // Пропускаем пустые строки
        if (empty($name) && empty($price) && empty($category)) {
            return null;
        }

        // Если указан ID, пытаемся обновить существующий товар
        if (! empty($id)) {
            $product = Product::find($id);

            if ($product) {
                // Обновляем существующий товар
                $product->update([
                    'name' => $name,
                    'description' => $row['description'] ?? null,
                    'composition' => $row['composition'] ?? null,
                    'size' => $row['size'] ?? null,
                    'care_instructions' => $row['care_instructions'] ?? null,
                    'seo_text' => $row['seo_text'] ?? null,
                    'price' => $price,
                    'category' => $category,
                    'is_available' => isset($row['is_available']) ? (bool) $row['is_available'] : true,
                ]);

                if (! empty($category)) {
                    $this->pendingCategoryLinks[$product->slug] = $category;
                }

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
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        $productData = [
            'name' => $name,
            'slug' => $slug,
            'description' => $row['description'] ?? null,
            'composition' => $row['composition'] ?? null,
            'size' => $row['size'] ?? null,
            'care_instructions' => $row['care_instructions'] ?? null,
            'seo_text' => $row['seo_text'] ?? null,
            'price' => $price,
            'category' => $category,
            'is_available' => isset($row['is_available']) ? (bool) $row['is_available'] : true,
        ];

        // Если указан ID при создании нового товара, добавляем его
        if (! empty($id)) {
            $productData['id'] = $id;
        }

        if (! empty($category)) {
            $this->pendingCategoryLinks[$slug] = $category;
        }

        return new Product($productData);
    }

    /**
     * После сохранения всех строк — привязываем реальные категории (таблица categories)
     * к импортированным/обновлённым товарам по значению legacy-колонки category.
     * sync (а не attach) гарантирует отсутствие дублей при повторном импорте и корректную
     * замену категории при повторном импорте той же строки с другим значением.
     */
    public function afterImport(): void
    {
        if ($this->pendingCategoryLinks === []) {
            return;
        }

        $categoryIds = Category::query()
            ->whereIn('key', array_unique(array_values($this->pendingCategoryLinks)))
            ->pluck('id', 'key');

        foreach ($this->pendingCategoryLinks as $slug => $categoryKey) {
            $categoryId = $categoryIds->get($categoryKey);

            if ($categoryId === null) {
                continue;
            }

            $product = Product::where('slug', $slug)->first();

            $product?->categories()->sync([$categoryId]);
        }

        $this->pendingCategoryLinks = [];
    }

    /**
     * Округление до ближайших 100 ₽ при импорте (как в миграции данных).
     */
    private function roundedPriceToHundreds(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return round((float) $value / 100.0) * 100.0;
    }
}
