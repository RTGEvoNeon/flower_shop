<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_created_by_factory_has_no_categories_by_default(): void
    {
        // Фабрика не привязывает категории автоматически — это осознанное решение:
        // безусловный auto-attach в afterCreating() ломал бы инвариант "товар без
        // категорий" и точный подсчёт категорий во всех тестах, где Product::factory()
        // используется как нейтральная заготовка (Task 2, 4, 6).
        $product = Product::factory()->create();

        $this->assertFalse($product->categories()->exists());
    }

    public function test_product_created_by_factory_can_be_attached_to_an_existing_category(): void
    {
        // Категории для привязки уже существуют благодаря data-migration
        // (2026_08_26_100002), которая сеет baseline-набор при каждом
        // RefreshDatabase — создавать отдельную категорию не нужно и опасно
        // (конфликт unique(key) с уже засеянными ключами).
        $category = Category::query()->first();
        $product = Product::factory()->create();

        $product->categories()->attach($category->id);

        $this->assertTrue($product->categories()->exists());
    }
}
