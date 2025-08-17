<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageTypes = ['jpeg', 'png', 'webp'];
        $imageType = fake()->randomElement($imageTypes);
        $filename = fake()->uuid() . '.' . $imageType;
        $originalName = fake()->words(2, true) . '_bouquet.' . $imageType;
        
        // Генерируем реалистичные размеры изображений
        $width = fake()->numberBetween(400, 2000);
        $height = fake()->numberBetween(400, 2000);
        $fileSize = fake()->numberBetween(50000, 2000000); // 50KB - 2MB

        return [
            'product_id' => Product::factory(),
            'filename' => $filename,
            'original_name' => $originalName,
            'path' => 'products/' . fake()->dateTimeBetween('-1 year')->format('Y/m') . '/' . $filename,
            'url' => null, // Будет генерироваться автоматически
            'mime_type' => 'image/' . $imageType,
            'file_size' => $fileSize,
            'width' => $width,
            'height' => $height,
            'sort_order' => fake()->numberBetween(0, 10),
            'is_primary' => false, // По умолчанию не главное
            'is_active' => fake()->boolean(90), // 90% активных
            'alt_text' => fake()->sentence(3),
            'description' => fake()->boolean(60) ? fake()->sentence(8) : null, // 60% имеют описание
        ];
    }

    /**
     * Состояние: главное изображение
     */
    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
            'is_active' => true,
            'sort_order' => 0,
        ]);
    }

    /**
     * Состояние: высокое качество
     */
    public function highQuality(): static
    {
        return $this->state(fn (array $attributes) => [
            'width' => fake()->numberBetween(1200, 2000),
            'height' => fake()->numberBetween(1200, 2000),
            'file_size' => fake()->numberBetween(500000, 2000000),
            'mime_type' => 'image/png',
        ]);
    }

    /**
     * Состояние: маленькое изображение (thumbnail)
     */
    public function thumbnail(): static
    {
        return $this->state(fn (array $attributes) => [
            'width' => fake()->numberBetween(150, 300),
            'height' => fake()->numberBetween(150, 300),
            'file_size' => fake()->numberBetween(10000, 50000),
            'mime_type' => 'image/webp',
        ]);
    }

    /**
     * Состояние: неактивное изображение
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'is_primary' => false,
        ]);
    }

    /**
     * Состояние: изображение для конкретного продукта
     */
    public function forProduct(Product $product): static
    {
        return $this->state(fn (array $attributes) => [
            'product_id' => $product->id,
            'alt_text' => "Фото букета {$product->name}",
        ]);
    }

    /**
     * Состояние: набор изображений для продукта (1 главное + несколько дополнительных)
     */
    public function setForProduct(Product $product, int $count = 3): array
    {
        $images = [];
        
        // Создаем главное изображение
        $images[] = $this->forProduct($product)->primary()->create();
        
        // Создаем дополнительные изображения
        for ($i = 1; $i < $count; $i++) {
            $images[] = $this->forProduct($product)->state([
                'sort_order' => $i,
                'is_primary' => false,
            ])->create();
        }
        
        return $images;
    }
}
