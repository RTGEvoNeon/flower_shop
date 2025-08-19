<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'quantity' => fake()->numberBetween(1, 5),
            'price' => fake()->randomFloat(2, 1000, 15000),
        ];
    }

    /**
     * Состояние: для конкретного заказа
     */
    public function forOrder(Order $order): static
    {
        return $this->state(fn (array $attributes) => [
            'order_id' => $order->id,
        ]);
    }

    /**
     * Состояние: для конкретного продукта
     */
    public function forProduct(Product $product): static
    {
        return $this->state(fn (array $attributes) => [
            'product_id' => $product->id,
            'price' => $product->price, // Используем актуальную цену продукта
        ]);
    }

    /**
     * Состояние: большое количество
     */
    public function bulkQuantity(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => fake()->numberBetween(10, 50),
        ]);
    }

    /**
     * Состояние: единичный товар
     */
    public function singleItem(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 1,
        ]);
    }
}
