<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCategoryRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_attached_to_multiple_categories(): void
    {
        $product = Product::factory()->create();
        $mono = Category::factory()->create(['key' => 'mono', 'name' => 'Монобукеты']);
        $wedding = Category::factory()->create(['key' => 'wedding', 'name' => 'Свадебные']);

        $product->categories()->attach([$mono->id, $wedding->id]);

        $this->assertCount(2, $product->refresh()->categories);
        $this->assertTrue($product->categories->contains('key', 'mono'));
        $this->assertTrue($product->categories->contains('key', 'wedding'));
    }

    public function test_category_can_have_multiple_products(): void
    {
        $category = Category::factory()->create();
        $products = Product::factory()->count(3)->create();

        $category->products()->attach($products->pluck('id'));

        $this->assertCount(3, $category->refresh()->products);
    }
}
