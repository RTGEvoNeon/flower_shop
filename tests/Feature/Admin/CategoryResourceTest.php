<?php

declare(strict_types=1);

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
