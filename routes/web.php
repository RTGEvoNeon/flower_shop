<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\CustomBouquetController;
use App\Http\Controllers\CategoryPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

// Маршрут для отображения изображений продуктов (fallback если nginx не обработал)
Route::get('/storage/products/{product_id}/{filename}', function ($product_id, $filename) {
    $path = storage_path("products/{$product_id}/{$filename}");
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->file($path);
})->where(['product_id' => '[0-9]+', 'filename' => '[^/]+\.(jpg|jpeg|png|gif|webp)'])->name('product.image');

// Custom bouquet
Route::get('/custom-bouquet', [CustomBouquetController::class, 'show'])->name('custom-bouquet.show');
Route::post('/custom-bouquet/submit', [CustomBouquetController::class, 'submit'])->name('custom-bouquet.submit');

// Категорийные SEO-страницы
// Высокий приоритет (высокая частотность)
Route::get('/rozy', [CategoryPageController::class, 'roses'])->name('category.roses');
Route::get('/bukety-na-den-rozhdeniya', [CategoryPageController::class, 'birthday'])->name('category.birthday');
Route::get('/bukety-na-8-marta', [CategoryPageController::class, 'march8'])->name('category.march8');
Route::get('/bukety-nedorogo', [CategoryPageController::class, 'affordable'])->name('category.affordable');

// Средний приоритет (средняя частотность)
Route::get('/hrizantemy', [CategoryPageController::class, 'chrysanthemums'])->name('category.chrysanthemums');
Route::get('/piony', [CategoryPageController::class, 'peonies'])->name('category.peonies');
Route::get('/bukety-v-krafte', [CategoryPageController::class, 'kraft'])->name('category.kraft');
Route::get('/svadebnyy-buket', [CategoryPageController::class, 'wedding'])->name('category.wedding');
Route::get('/kompozicii-iz-cvetov', [CategoryPageController::class, 'compositions'])->name('category.compositions');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/order', [CartController::class, 'placeOrder'])->name('order.place');
Route::get('/order/success/{id}', [CartController::class, 'orderSuccess'])->name('order.success');

// Страницы
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

// Админка - импорт товаров
Route::get('/admin/import', [ImportController::class, 'index'])->name('admin.import');
Route::post('/admin/import', [ImportController::class, 'import'])->name('admin.import.store');
Route::get('/admin/import/template', [ImportController::class, 'downloadTemplate'])->name('admin.import.template');
