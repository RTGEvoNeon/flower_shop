<?php

declare(strict_types=1);

use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

test('admin can attach multiple categories to a product via the form', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $product = Product::factory()->create();
    $mono = Category::factory()->create(['key' => 'mono-test', 'name' => 'Монобукеты']);
    $wedding = Category::factory()->create(['key' => 'wedding-test', 'name' => 'Свадебные']);

    Livewire::actingAs($admin)
        ->test(EditProduct::class, ['record' => $product->getKey()])
        ->fillForm(['categories' => [$mono->id, $wedding->id]])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($product->refresh()->categories->pluck('id')->sort()->values()->all())
        ->toBe([$mono->id, $wedding->id]);
});

test('admin can see category list', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Category::factory()->create(['name' => 'Тестовая категория']);

    $response = test()->actingAs($admin)->get('/admin/categories');

    $response->assertOk();
    $response->assertSee('Тестовая категория');
});

test('admin can create a new category', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    Livewire::actingAs($admin)
        ->test(CreateCategory::class)
        ->fillForm([
            'key' => 'newyear',
            'name' => 'Новый год',
            'sort_order' => 5,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Category::where('key', 'newyear')->exists())->toBeTrue();
});
