<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCategoryFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_with_multiple_categories_appears_in_each_category_filter(): void
    {
        $mono = Category::factory()->create(['key' => 'mono-filter-test', 'name' => 'Монобукеты тест']);
        $wedding = Category::factory()->create(['key' => 'wedding-filter-test', 'name' => 'Свадебные тест']);

        $product = Product::factory()->create(['name' => 'Двойной букет', 'is_available' => true]);
        $product->categories()->attach([$mono->id, $wedding->id]);

        $responseMono = $this->get('/products?category=mono-filter-test');
        $responseMono->assertOk();
        $responseMono->assertSee('Двойной букет');

        $responseWedding = $this->get('/products?category=wedding-filter-test');
        $responseWedding->assertOk();
        $responseWedding->assertSee('Двойной букет');
    }

    public function test_category_without_products_is_not_in_available_categories(): void
    {
        // 'september1' уже создана data-migration (2026_08_26_100002) как пустая категория —
        // используем существующую запись вместо создания новой с тем же key.
        $mono = Category::factory()->create(['key' => 'mono-available-test', 'name' => 'Монобукеты тест']);
        $product = Product::factory()->create(['is_available' => true]);
        $product->categories()->attach($mono->id);

        $response = $this->get('/products');

        $response->assertOk();
        $categories = $response->viewData('categories');

        $this->assertTrue($categories->contains('key', 'mono-available-test'));
        $this->assertFalse($categories->contains('key', 'september1'));
    }

    public function test_invalid_category_falls_back_to_all(): void
    {
        $product = Product::factory()->create(['is_available' => true, 'name' => 'Видимый везде']);

        $response = $this->get('/products?category=does-not-exist');

        $response->assertOk();
        $response->assertSee('Видимый везде');
    }

    public function test_product_card_shows_category_name_from_relation(): void
    {
        // Ключ 'mono' конфликтует с baseline-сидом data-migration (2026_08_26_100002),
        // используем свободный тестовый ключ с суффиксом -test. Название категории
        // тоже должно быть уникальным на странице — обычное "Монобукеты" совпадает
        // с текстом статичного SEO-description каталога ("Монобукеты и миксы от
        // 2000₽"), из-за чего assertSee проходил бы даже без рендера бейджа карточки.
        $categoryName = 'УникальнаяТестКатегория137';
        $category = Category::factory()->create(['key' => 'mono-test', 'name' => $categoryName]);
        $product = Product::factory()->create(['is_available' => true, 'name' => 'Карточный букет']);
        $product->categories()->attach($category->id);

        $response = $this->get('/products');

        $response->assertOk();
        // Название должно встретиться и во вкладке фильтра (Task 5), и в бейдже
        // на карточке товара (Task 6) — ровно 2 раза.
        $occurrences = substr_count($response->getContent(), $categoryName);
        $this->assertSame(2, $occurrences, 'Название категории должно быть и во вкладке фильтра, и на карточке товара');
    }
}
