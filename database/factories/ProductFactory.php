<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'name' => 'Букет "' . fake()->words(2, true) . '"',
            'description' => fake()->paragraph(3),
            'price' => fake()->randomFloat(2, 1000, 15000),
            'category' => fake()->randomElement($categories),
            'is_available' => fake()->boolean(90), // 90% доступны
        ];
    }
}
