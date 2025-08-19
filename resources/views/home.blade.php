@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-b from-pink-50 to-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-6">
            ГОВОРИМ ЦВЕТАМИ
        </h1>
        <p class="text-xl md:text-2xl text-gray-700 mb-8 max-w-4xl mx-auto leading-relaxed">
            и каждый наш букет — это наше искреннее послание, созданное для того, чтобы принести вам радость, уют и особенные воспоминания.
        </p>
        <div class="flex justify-center">
            <a href="#catalog" class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-4 rounded-lg text-lg font-medium transition-colors">
                Найти букет
            </a>
        </div>
    </div>
</section>

<!-- Quick Info -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Быстрая доставка</h3>
                <p class="text-gray-600">Доставляем свежие букеты по всему городу в день заказа</p>
            </div>
            
            <div class="p-6">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Свежие цветы</h3>
                <p class="text-gray-600">Работаем только со свежими цветами от проверенных поставщиков</p>
            </div>
            
            <div class="p-6">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Доступные цены</h3>
                <p class="text-gray-600">Цены на букеты начинаются от <b>2 000 ₽</b></p>
            </div>
        </div>
    </div>
</section>

<!-- Популярные букеты (пока заглушка) -->
<section id="catalog" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
            Букеты, которые заказывают чаще всего!
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Карточка букета (пока заглушка) -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-64 bg-gradient-to-br from-pink-200 to-pink-300 flex items-center justify-center">
                    <span class="text-gray-600">Фото букета</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">Букет "Нежность"</h3>
                    <p class="text-gray-600 mb-4">Романтичный букет из розовых роз и пионов</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-pink-500">2 500 ₽</span>
                        <button class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg transition-colors">
                            Заказать
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Еще 2 карточки-заглушки -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-64 bg-gradient-to-br from-yellow-200 to-orange-300 flex items-center justify-center">
                    <span class="text-gray-600">Фото букета</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">Букет "Солнечный"</h3>
                    <p class="text-gray-600 mb-4">Яркий букет из подсолнухов и хризантем</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-pink-500">1 800 ₽</span>
                        <button class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg transition-colors">
                            Заказать
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-64 bg-gradient-to-br from-purple-200 to-blue-300 flex items-center justify-center">
                    <span class="text-gray-600">Фото букета</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">Букет "Мечта"</h3>
                    <p class="text-gray-600 mb-4">Изысканный букет из орхидей и лилий</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-pink-500">3 200 ₽</span>
                        <button class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg transition-colors">
                            Заказать
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="/products" class="border border-pink-500 text-pink-500 hover:bg-pink-500 hover:text-white px-8 py-3 rounded-lg transition-colors inline-block">
                Смотреть все букеты
            </a>
        </div>
    </div>
</section>

<!-- Call to Action для кастомного букета -->
<section class="py-16 bg-gradient-to-r from-pink-500 to-purple-600">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Не нашли идеальный букет?
        </h2>
        <p class="text-xl text-pink-100 mb-8 max-w-2xl mx-auto">
            Создайте уникальный букет вместе с нашим флористом. Расскажите о ваших пожеланиях, и мы воплотим их в жизнь!
        </p>
        <a href="/custom-bouquet" class="bg-white text-pink-600 px-8 py-4 rounded-lg text-lg font-medium hover:bg-gray-100 transition-colors inline-block shadow-lg">
            Собрать свой букет
        </a>
    </div>
</section>

@endsection
