<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    $randomProducts = \App\Models\Product::available()
        ->withImages()
        ->inRandomOrder()
        ->limit(3)
        ->get();
    return view('home', compact('randomProducts'));
});

// Страница доставки
Route::get('/delivery', function () {
    return view('delivery');
})->name('delivery');

// Страница политики конфиденциальности
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Страница о нас
Route::get('/about', function () {
    return view('about');
})->name('about');

// Страница контактов
Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

// Каталог товаров
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

// Оформление заказа
Route::post('/order/submit', [OrderController::class, 'submit'])->name('order.submit');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// TODO: Форма заказа кастомного букета (временно отключена)
// Route::get('/custom-bouquet', function () {
//     return view('custom-bouquet');
// })->name('custom-bouquet.show');
//
// Route::post('/custom-bouquet/submit', function () {
//     // TODO: Добавить отправку в Telegram
//     return redirect('/custom-bouquet')->with('success', 'Спасибо! Мы скоро с вами свяжемся!');
// })->name('custom-bouquet.submit');

// Импорт товаров из Excel
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/products/import', [ProductImportController::class, 'showForm'])->name('products.import');
    Route::post('/products/import', [ProductImportController::class, 'import'])->name('products.import.process');
    Route::get('/products/import/template', [ProductImportController::class, 'downloadTemplate'])->name('products.import.template');
});
