<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_composition_fallback_uses_first_category_name(): void
    {
        $product = Product::factory()->create(['composition' => null, 'name' => 'Весна']);
        $category = Category::factory()->create(['name' => 'монобукет']);
        $product->categories()->attach($category);

        $this->assertStringContainsString('монобукет', $product->refresh()->composition);
    }

    public function test_composition_fallback_uses_generic_label_without_categories(): void
    {
        $product = Product::factory()->create(['composition' => null]);

        $this->assertStringContainsString('букет', $product->composition);
    }

    public function test_category_constants_are_removed(): void
    {
        $this->assertFalse(defined(Product::class.'::CATEGORIES'));
    }
}
