@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-pink-50 via-purple-50 to-blue-50 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
            Собери свой букет
        </h1>
        <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed mb-4">
            Создайте букет сами! Мы говорим цветами, но именно ваш выбор делает их особенными.
        </p>
        <p class="text-lg text-gray-600">
            <strong>Расскажите нам</strong> о бюджете, цветовой гамме и настроении, а наш флорист соберёт букет, который скажет всё за вас.
        </p>
    </div>
</section>

<!-- Основная форма -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100">
            <h2 class="text-3xl font-semibold text-gray-900 mb-8 text-center">
                Расскажите свою историю цветами
            </h2>

            <form id="custom-bouquet-form" action="/custom-bouquet/submit" method="POST" class="space-y-8">
                @csrf
                
                <!-- Цветовая гамма -->
                <div>
                    <label class="block text-lg font-medium text-gray-900 mb-4">
                        В какой цветовой гамме вы видите свой букет?
                    </label>
                    <textarea 
                        name="color_scheme" 
                        rows="4" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Нежные пастельные, яркие акценты или что-то спокойное и природное? Напишите примерные оттенки, пожелания (например, монохромный букет...)"
                    ></textarea>
                </div>

                <!-- Настроение -->
                <div>
                    <label class="block text-lg font-medium text-gray-900 mb-4">
                        Какое настроение должен передать ваш букет?
                    </label>
                    <textarea 
                        name="mood" 
                        rows="4" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Романтика, лёгкость, уют или что-то яркое и энергичное?"
                    ></textarea>
                </div>

                <!-- Любимые цветы -->
                <div>
                    <label class="block text-lg font-medium text-gray-900 mb-4">
                        Есть ли у вас любимые цветы, которые вы хотели бы добавить?
                    </label>
                    <textarea 
                        name="favorite_flowers" 
                        rows="4" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Расскажите нам, какие цветы вам особенно дороги или близки — добавим их в ваш букет."
                    ></textarea>
                </div>

                <!-- Особые пожелания -->
                <div>
                    <label class="block text-lg font-medium text-gray-900 mb-4">
                        Что сделает этот букет идеальным для вас?
                    </label>
                    <textarea 
                        name="special_wishes" 
                        rows="4" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none"
                        placeholder="Может, вам важен определённый стиль, форма букета или интересные детали?"
                    ></textarea>
                </div>

                <!-- Бюджет -->
                <div>
                    <label class="block text-lg font-medium text-gray-900 mb-4">
                        В пределах какой суммы собрать ваш букет?
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-pink-500 cursor-pointer">
                            <input type="radio" name="budget" value="1000-2000" class="text-pink-500 focus:ring-pink-500">
                            <span class="ml-3 font-medium">1 000 - 2 000 ₽</span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-pink-500 cursor-pointer">
                            <input type="radio" name="budget" value="2000-3500" class="text-pink-500 focus:ring-pink-500">
                            <span class="ml-3 font-medium">2 000 - 3 500 ₽</span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-pink-500 cursor-pointer">
                            <input type="radio" name="budget" value="3500-5000" class="text-pink-500 focus:ring-pink-500">
                            <span class="ml-3 font-medium">3 500 - 5 000 ₽</span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:border-pink-500 cursor-pointer">
                            <input type="radio" name="budget" value="5000+" class="text-pink-500 focus:ring-pink-500">
                            <span class="ml-3 font-medium">от 5 000 ₽</span>
                        </label>
                    </div>
                    <input 
                        type="text" 
                        name="custom_budget" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="Или укажите свою сумму"
                    >
                    <p class="text-sm text-gray-600 mt-2">
                        Независимо от суммы, каждый букет будет создан с душой и вниманием.
                    </p>
                </div>

                <!-- Контактная информация -->
                <div class="border-t pt-8">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-6">
                        Контактная информация для связи
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Как к Вам можно обращаться? <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                placeholder="Ваше имя"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Номер телефона <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                name="phone" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                placeholder="+7 (999) 123-45-67"
                            >
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            Удобный вид связи
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:border-pink-500 cursor-pointer">
                                <input type="checkbox" name="contact_method[]" value="telegram" class="text-pink-500 focus:ring-pink-500">
                                <span class="ml-2">Telegram</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:border-pink-500 cursor-pointer">
                                <input type="checkbox" name="contact_method[]" value="whatsapp" class="text-pink-500 focus:ring-pink-500">
                                <span class="ml-2">WhatsApp</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:border-pink-500 cursor-pointer">
                                <input type="checkbox" name="contact_method[]" value="sms" class="text-pink-500 focus:ring-pink-500">
                                <span class="ml-2">СМС</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:border-pink-500 cursor-pointer">
                                <input type="checkbox" name="contact_method[]" value="call" class="text-pink-500 focus:ring-pink-500">
                                <span class="ml-2">Звонок</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Кнопка отправки -->
                <div class="text-center pt-8">
                    <button 
                        type="submit" 
                        class="bg-pink-500 hover:bg-pink-600 text-white px-12 py-4 rounded-lg text-lg font-medium transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                    >
                        Собрать мой букет
                    </button>
                    
                    <p class="text-sm text-gray-600 mt-6 max-w-2xl mx-auto leading-relaxed">
                        Скоро с вами свяжется менеджер для расчета стоимости доставки (в зависимости от километража) и уточнения деталей.<br>
                        <strong>Заказы принимаются с 9:00 до 21:00. Доставка круглосуточная.</strong>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Дополнительная информация -->
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Быстрый ответ</h3>
                <p class="text-gray-600">Свяжемся с вами в течение 30 минут для уточнения деталей</p>
            </div>
            
            <div class="p-6">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Индивидуальный подход</h3>
                <p class="text-gray-600">Каждый букет создается флористом персонально под ваши пожелания</p>
            </div>
            
            <div class="p-6">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">С любовью</h3>
                <p class="text-gray-600">Вкладываем душу в каждый букет, чтобы передать ваши чувства</p>
            </div>
        </div>
    </div>
</section>
@endsection
