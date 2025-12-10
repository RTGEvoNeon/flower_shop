<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('home');
});

// Каталог товаров
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

// Форма заказа кастомного букета
Route::get('/custom-bouquet', function () {
    return view('custom-bouquet');
})->name('custom-bouquet.show');

Route::post('/custom-bouquet/submit', function () {
    // TODO: Добавить отправку в Telegram
    return redirect('/custom-bouquet')->with('success', 'Спасибо! Мы скоро с вами свяжемся!');
})->name('custom-bouquet.submit');
