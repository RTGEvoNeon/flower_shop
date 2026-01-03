<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Статические страницы
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/delivery', [PageController::class, 'delivery'])->name('delivery');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');
Route::get('/-privacy', [PageController::class, 'privacy'])->name('privacy');

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
