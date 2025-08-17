<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Создаем демо-продукты
        $products = [
            [
                'name' => 'Букет "Нежность"',
                'description' => 'Романтичный букет из белых и розовых роз, дополненный эвкалиптом и гипсофилой. Идеален для признания в любви или извинений.',
                'price' => 2500,
                'category' => 'bouquets',
                'is_available' => true,
            ],
            [
                'name' => 'Букет "Весенняя радость"',
                'description' => 'Яркий весенний букет из тюльпанов разных цветов с добавлением зелени. Подарит хорошее настроение в любое время года.',
                'price' => 1800,
                'category' => 'seasonal',
                'is_available' => true,
            ],
            [
                'name' => 'Букет "Классика"',
                'description' => 'Элегантный букет из красных роз - символ страсти и любви. Классический выбор для особенного человека.',
                'price' => 3200,
                'category' => 'bouquets',
                'is_available' => true,
            ],
            [
                'name' => 'Свадебный букет "Мечта"',
                'description' => 'Изысканный свадебный букет из белых пионов и роз с кружевной лентой. Создан специально для самого важного дня.',
                'price' => 4500,
                'category' => 'wedding',
                'is_available' => true,
            ],
            [
                'name' => 'Букет "Солнечный день"',
                'description' => 'Яркий букет из подсолнухов и желтых хризантем. Принесет тепло и радость в любой дом.',
                'price' => 2200,
                'category' => 'seasonal',
                'is_available' => true,
            ],
            [
                'name' => 'Премиум букет "Роскошь"',
                'description' => 'Эксклюзивный букет из экзотических орхидей и редких роз. Для тех, кто ценит изысканность и качество.',
                'price' => 7500,
                'category' => 'luxury',
                'is_available' => true,
            ],
            [
                'name' => 'Букет "Лавандовые мечты"',
                'description' => 'Нежный букет из лаванды и белых роз. Обладает успокаивающим ароматом и создает атмосферу уюта.',
                'price' => 2800,
                'category' => 'bouquets',
                'is_available' => true,
            ],
            [
                'name' => 'Свадебный букет "Королевский"',
                'description' => 'Роскошный свадебный букет из белых роз и пионов с добавлением серебряной зелени и жемчуга.',
                'price' => 6200,
                'category' => 'wedding',
                'is_available' => true,
            ],
            [
                'name' => 'Букет "Осенняя палитра"',
                'description' => 'Теплый осенний букет из хризантем, астр и рудбекии в оранжево-красных тонах.',
                'price' => 2100,
                'category' => 'seasonal',
                'is_available' => true,
            ],
            [
                'name' => 'Премиум букет "Императорский"',
                'description' => 'Эксклюзивная композиция из редких сортов роз и экзотических цветов. Настоящее произведение искусства.',
                'price' => 12000,
                'category' => 'luxury',
                'is_available' => true,
            ],
            [
                'name' => 'Букет "Полевые цветы"',
                'description' => 'Естественный букет из полевых цветов: ромашки, васильки, маки. Для любителей простоты и натуральности.',
                'price' => 1500,
                'category' => 'bouquets',
                'is_available' => true,
            ],
            [
                'name' => 'Букет "Зимняя сказка"',
                'description' => 'Зимний букет из белых роз, серебряной брунии и хвойных веточек. Создает праздничное настроение.',
                'price' => 3500,
                'category' => 'seasonal',
                'is_available' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
