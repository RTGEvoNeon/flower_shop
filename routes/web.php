<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// Маршрут для отображения изображений продуктов (fallback если nginx не обработал)
Route::get('/storage/products/{product_id}/{filename}', function ($product_id, $filename) {
    $path = storage_path("products/{$product_id}/{$filename}");
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->file($path);
})->where(['product_id' => '[0-9]+', 'filename' => '[^/]+\.(jpg|jpeg|png|gif|webp)'])->name('product.image');

// Custom bouquet
Route::get('/custom-bouquet', function () {
    return view('custom-bouquet');
});
Route::post('/custom-bouquet/submit', function () {
    // Пока просто редирект с сообщением
    return redirect('/custom-bouquet')->with('success', 'Спасибо! Мы скоро с вами свяжемся!');
});

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/order', [CartController::class, 'placeOrder'])->name('order.place');
Route::get('/order/success/{id}', [CartController::class, 'orderSuccess'])->name('order.success');
