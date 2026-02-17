@extends('layouts.app')

<x-seo.meta />

@section('content')
<div class="min-h-screen bg-gradient-to-b from-sage-50 to-white py-8 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="mb-8 text-sm text-gray-600">
            <a href="/" class="hover:text-sage-600">Главная</a>
            <span class="mx-2">/</span>
            <a href="/opt" class="hover:text-sage-600">Оптовые продажи</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Левая колонка: Слайдер изображений -->
            <div class="space-y-4">
                <!-- Главный слайдер -->
                <div class="relative aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-sage-200 to-sage-300 shadow-xl">
                    @php
                        $images = $product->image_urls;
                        $hasImages = count($images) > 0 && $product->main_image !== '/images/placeholder.jpg';
                    @endphp

                    @if($hasImages)
                        <!-- Контейнер слайдов -->
                        <div id="slider-container" class="relative w-full h-full">
                            @foreach($images as $index => $image)
                                <div class="slider-slide {{ $index === 0 ? 'active' : '' }} absolute inset-0 transition-opacity duration-500"
                                     data-slide="{{ $index }}"
                                     style="opacity: {{ $index === 0 ? '1' : '0' }};">
                                    <img src="{{ $image }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>

                        <!-- Стрелки навигации (только если больше 1 изображения) -->
                        @if(count($images) > 1)
                            <button id="prev-btn" 
                                    class="absolute left-4 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-white p-3 rounded-full shadow-lg transition-all hover:scale-110"
                                    aria-label="Предыдущее изображение">
                                <svg class="w-6 h-6 text-sage-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button id="next-btn" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-white p-3 rounded-full shadow-lg transition-all hover:scale-110"
                                    aria-label="Следующее изображение">
                                <svg class="w-6 h-6 text-sage-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>

                            <!-- Индикаторы -->
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 flex gap-2">
                                @foreach($images as $index => $image)
                                    <button class="slider-indicator w-2 h-2 rounded-full transition-all {{ $index === 0 ? 'bg-white w-8' : 'bg-white/50 hover:bg-white/75' }}"
                                            data-slide="{{ $index }}"
                                            aria-label="Перейти к изображению {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-9xl opacity-40">🌷</span>
                        </div>
                    @endif
                </div>

                <!-- Миниатюры (если есть несколько изображений) -->
                @if($hasImages && count($images) > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($images as $index => $image)
                            <button class="thumbnail aspect-square rounded-xl overflow-hidden bg-sage-100 hover:ring-2 hover:ring-sage-400 transition-all {{ $index === 0 ? 'ring-2 ring-sage-600' : '' }}"
                                    data-slide="{{ $index }}">
                                <img src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Правая колонка: Информация и форма заказа -->
            <div class="space-y-6">
                <!-- Заголовок -->
                <div>
                    <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        {{ $product->name }}
                    </h1>
                </div>

                <!-- Минимальный заказ -->
                <div class="bg-gold-50 border border-gold-200 rounded-2xl p-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-gold-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium text-gold-800">
                        Минимальный заказ: <span class="font-bold">{{ number_format($product->min_quantity, 0, '', ' ') }} шт</span>
                    </p>
                </div>

                <!-- Таблица цен -->
                <div class="bg-white rounded-2xl shadow-lg border border-sage-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-sage-600 to-sage-500 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">Ценовые уровни</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($product->getTierInfo() as $tier)
                                <div class="flex items-center justify-between py-3 px-4 rounded-xl bg-sage-50 hover:bg-sage-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-sage-600 text-white flex items-center justify-center font-bold">
                                            {{ $loop->iteration }}
                                        </div>
                                        <span class="font-medium text-gray-700">{{ $tier['label'] }}</span>
                                    </div>
                                    <span class="text-2xl font-bold text-sage-700">{{ number_format($tier['price'], 0) }} ₽/шт</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Калькулятор и форма заказа -->
                <div class="bg-white rounded-2xl shadow-xl border border-sage-200 p-6" id="order-form">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Оформить заказ</h3>
                    
                    <form id="wholesale-order-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_slug" value="{{ $product->slug }}">

                        <!-- Калькулятор количества -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Количество (шт)
                            </label>
                            <input type="number" 
                                   id="quantity" 
                                   name="quantity" 
                                   min="{{ $product->min_quantity }}" 
                                   step="100"
                                   value="{{ $product->min_quantity }}"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-sage-500 focus:ring-2 focus:ring-sage-200 transition-all"
                                   required>
                            <p class="mt-1 text-xs text-gray-500">Минимум: {{ number_format($product->min_quantity, 0, '', ' ') }} шт</p>
                        </div>

                        <!-- Расчет стоимости -->
                        <div class="bg-sage-50 rounded-xl p-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Цена за штуку:</span>
                                <span id="price-per-unit" class="font-bold text-sage-700">-</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold">
                                <span>Итого:</span>
                                <span id="total-price" class="text-sage-700">-</span>
                            </div>
                        </div>

                        <!-- Контактные данные -->
                        <div class="space-y-4 pt-4 border-t border-gray-200">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Ваше имя *
                                </label>
                                <input type="text" 
                                       id="customer_name" 
                                       name="customer_name" 
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-sage-500 focus:ring-2 focus:ring-sage-200"
                                       required>
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Телефон *
                                </label>
                                <input type="tel" 
                                       id="customer_phone" 
                                       name="customer_phone"
                                       placeholder="+7 999 123-45-67" 
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-sage-500 focus:ring-2 focus:ring-sage-200"
                                       required>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Комментарий
                                </label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="3"
                                          placeholder="Дополнительные пожелания к заказу"
                                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-sage-500 focus:ring-2 focus:ring-sage-200"></textarea>
                            </div>
                        </div>

                        <!-- Кнопка отправки -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-sage-600 to-sage-500 text-white py-4 rounded-xl font-bold text-lg hover:shadow-xl transition-all transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed"
                                id="submit-btn">
                            Отправить заказ
                        </button>
                    </form>

                    <!-- Сообщение об успехе -->
                    <div id="success-message" class="hidden mt-6 p-6 bg-green-50 border-2 border-green-200 rounded-xl">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-bold text-green-900 mb-1">Заказ успешно отправлен!</h4>
                                <p class="text-green-700">Мы свяжемся с вами в ближайшее время для подтверждения заказа.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Сообщение об ошибке -->
                    <div id="error-message" class="hidden mt-6 p-6 bg-red-50 border-2 border-red-200 rounded-xl">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-bold text-red-900 mb-1">Ошибка</h4>
                                <p id="error-text" class="text-red-700"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== Слайдер изображений ==========
    const slides = document.querySelectorAll('.slider-slide');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const indicators = document.querySelectorAll('.slider-indicator');
    const thumbnails = document.querySelectorAll('.thumbnail');
    let currentSlide = 0;

    function showSlide(index) {
        // Убеждаемся, что индекс в пределах
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        
        currentSlide = index;

        // Скрываем все слайды
        slides.forEach((slide, i) => {
            slide.style.opacity = i === currentSlide ? '1' : '0';
            slide.style.zIndex = i === currentSlide ? '1' : '0';
        });

        // Обновляем индикаторы
        indicators.forEach((indicator, i) => {
            if (i === currentSlide) {
                indicator.classList.add('bg-white', 'w-8');
                indicator.classList.remove('bg-white/50', 'w-2');
            } else {
                indicator.classList.remove('bg-white', 'w-8');
                indicator.classList.add('bg-white/50', 'w-2');
            }
        });

        // Обновляем миниатюры
        thumbnails.forEach((thumbnail, i) => {
            if (i === currentSlide) {
                thumbnail.classList.add('ring-2', 'ring-sage-600');
            } else {
                thumbnail.classList.remove('ring-2', 'ring-sage-600');
            }
        });
    }

    // Навигация стрелками
    if (prevBtn) {
        prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
    }
    if (nextBtn) {
        nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));
    }

    // Навигация по индикаторам
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => showSlide(index));
    });

    // Навигация по миниатюрам
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', () => showSlide(index));
    });

    // Клавиатурная навигация
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') showSlide(currentSlide - 1);
        if (e.key === 'ArrowRight') showSlide(currentSlide + 1);
    });

    // ========== Калькулятор цен ==========
    const quantityInput = document.getElementById('quantity');
    const pricePerUnitEl = document.getElementById('price-per-unit');
    const totalPriceEl = document.getElementById('total-price');
    const form = document.getElementById('wholesale-order-form');
    const submitBtn = document.getElementById('submit-btn');
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');
    const errorText = document.getElementById('error-text');

    const tiers = @json($product->getTierInfo());

    function calculatePrice() {
        const quantity = parseInt(quantityInput.value) || 0;
        let pricePerUnit = 0;

        // Определяем ценовой уровень
        if (quantity >= 10000) {
            pricePerUnit = tiers[2].price;
        } else if (quantity >= 5000) {
            pricePerUnit = tiers[1].price;
        } else {
            pricePerUnit = tiers[0].price;
        }

        const total = pricePerUnit * quantity;

        pricePerUnitEl.textContent = new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: 'RUB',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(pricePerUnit);

        totalPriceEl.textContent = new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: 'RUB',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(total);
    }

    // Пересчет при изменении количества
    quantityInput.addEventListener('input', calculatePrice);
    calculatePrice(); // Первоначальный расчет

    // ========== Маска для телефона ==========
    function initPhoneMask() {
        const phoneInput = document.getElementById('customer_phone');
        if (!phoneInput) return;

        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            // Если первая цифра 8, заменяем на 7
            if (value.startsWith('8')) {
                value = '7' + value.slice(1);
            }

            // Если первая цифра не 7, добавляем 7
            if (value.length > 0 && !value.startsWith('7')) {
                value = '7' + value;
            }

            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = '+7';

                if (value.length > 1) {
                    formattedValue += ' (' + value.substring(1, 4);
                }
                if (value.length >= 5) {
                    formattedValue += ') ' + value.substring(4, 7);
                }
                if (value.length >= 8) {
                    formattedValue += '-' + value.substring(7, 9);
                }
                if (value.length >= 10) {
                    formattedValue += '-' + value.substring(9, 11);
                }
            }

            e.target.value = formattedValue;
        });

        // Устанавливаем начальное значение при фокусе
        phoneInput.addEventListener('focus', function(e) {
            if (e.target.value === '') {
                e.target.value = '+7 (';
            }
        });

        // Очищаем при потере фокуса, если введено только +7 (
        phoneInput.addEventListener('blur', function(e) {
            if (e.target.value === '+7 (' || e.target.value === '+7') {
                e.target.value = '';
            }
        });
    }

    initPhoneMask();

    // Отправка формы
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Отправка...';
        successMessage.classList.add('hidden');
        errorMessage.classList.add('hidden');

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('{{ route('wholesale.order.submit') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                successMessage.classList.remove('hidden');
                form.reset();
                calculatePrice();
                
                // Прокрутка к сообщению
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                throw new Error(result.message || 'Произошла ошибка при отправке заказа');
            }
        } catch (error) {
            errorText.textContent = error.message;
            errorMessage.classList.remove('hidden');
            errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Отправить заказ';
        }
    });
});
</script>

@endsection
