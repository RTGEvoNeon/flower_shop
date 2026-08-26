<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created_with_key_name_and_sort_order(): void
    {
        $category = Category::create([
            'key' => 'test-category',
            'name' => 'Тестовая категория',
            'sort_order' => 10,
        ]);

        $this->assertDatabaseHas('categories', [
            'key' => 'test-category',
            'name' => 'Тестовая категория',
            'sort_order' => 10,
        ]);
        $this->assertSame('Тестовая категория', $category->name);
    }

    public function test_category_key_must_be_unique(): void
    {
        Category::factory()->create(['key' => 'duplicate-key-test']);

        $this->expectException(QueryException::class);

        Category::factory()->create(['key' => 'duplicate-key-test']);
    }
}
