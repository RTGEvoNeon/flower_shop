<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_creates_all_expected_categories(): void
    {
        $keys = Category::query()->pluck('key')->all();

        foreach (['mono', 'mix', 'tulip', 'winter', 'wedding', 'premium', 'september1', 'bouquets', 'seasonal', 'luxury'] as $expectedKey) {
            $this->assertContains($expectedKey, $keys, "Категория '{$expectedKey}' должна существовать после миграции");
        }
    }

    public function test_september1_category_has_no_products_by_default(): void
    {
        $category = Category::where('key', 'september1')->first();

        $this->assertNotNull($category);
        $this->assertSame('1 сентября', $category->name);
        $this->assertCount(0, $category->products);
    }

    public function test_existing_product_category_value_is_migrated_to_pivot(): void
    {
        // RefreshDatabase уже применил все миграции, включая data-migration, к пустой БД.
        // Чтобы проверить перенос данных, добавляем товар с legacy-значением category
        // напрямую в БД и повторно выполняем ТОЛЬКО тело data-migration (метод up())
        // через прямое включение файла миграции — это детерминированно, в отличие от
        // повторного artisan migrate по уже отмеченной как выполненную миграции.
        $productId = DB::table('products')->insertGetId([
            'name' => 'Тестовый букет 2',
            'slug' => 'test-bouquet-2',
            'category' => 'wedding',
            'price' => 1000,
            'is_available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $migration = include base_path('database/migrations/2026_08_26_100002_migrate_product_categories_to_pivot.php');
        $migration->up();

        $weddingCategoryId = Category::where('key', 'wedding')->value('id');

        $this->assertDatabaseHas('category_product', [
            'category_id' => $weddingCategoryId,
            'product_id' => $productId,
        ]);
    }
}
