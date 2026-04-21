<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['bouquets', 'wedding', 'seasonal', 'luxury'];

        return [
            'name' => 'Букет "'.fake()->words(2, true).'"',
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(10, 150) * 100,
            'category' => fake()->randomElement($categories),
            'is_available' => fake()->boolean(90), // 90% доступны
        ];
    }
}
