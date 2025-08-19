<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

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
