<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\WholesaleProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<WholesaleProduct>
 */
class WholesaleProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $varieties = ['Outlook', 'Presto', 'Replay', 'Royal Virgin', 'Strong Gold', 'Strong Love',
            'Supermodel', 'Tresor', 'Verandi', 'First Class', 'Dutch Delight', 'Columbus'];
        $variety = fake()->randomElement($varieties);

        $name = 'Тюльпаны '.$variety;

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 999),
            'price_tier_1' => fake()->numberBetween(45, 55),
            'price_tier_2' => fake()->numberBetween(40, 48),
            'price_tier_3' => fake()->numberBetween(35, 43),
            'min_quantity' => 1000,
            'is_available' => true,
        ];
    }
}
