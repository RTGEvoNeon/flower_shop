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
        $name = 'Букет "'.fake()->unique()->words(2, true).'"';

        return [
            'name' => $name,
            'slug' => str($name)->slug(),
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(10, 150) * 100,
            'is_available' => fake()->boolean(90), // 90% доступны
        ];
    }
}
