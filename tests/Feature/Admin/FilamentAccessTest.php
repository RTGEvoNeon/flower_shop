<?php

declare(strict_types=1);

use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

test('guest is redirected away from admin panel', function () {
    $response = $this->get('/admin/products');

    $response->assertRedirect('/admin/login');
});

test('non-admin user cannot access admin panel', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $response = $this->actingAs($user)->get('/admin/products');

    $response->assertForbidden();
});

test('admin user can see product list', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $product = Product::factory()->create(['name' => 'Тестовый букет']);

    $response = $this->actingAs($admin)->get('/admin/products');

    $response->assertOk();
    $response->assertSee('Тестовый букет');
});

test('admin can toggle product availability from the list', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $product = Product::factory()->create(['is_available' => true]);

    Livewire::actingAs($admin)
        ->test(ListProducts::class)
        ->call('updateTableColumnState', 'is_available', $product->getKey(), false);

    expect($product->refresh()->is_available)->toBeFalse();
});
