@extends('layouts.app')

<x-seo.meta />

@section('content')
<style>
    /* Органичный дизайн для личного кабинета */
    .dashboard-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(250, 248, 243, 0.98) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(233, 109, 63, 0.15);
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.08),
            0 2px 8px rgba(233, 109, 63, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 
            0 16px 48px rgba(0, 0, 0, 0.12),
            0 4px 12px rgba(233, 109, 63, 0.15);
    }

    .organic-border {
        border-radius: 2.5rem 1rem 2.5rem 1rem;
    }

    .organic-border-alt {
        border-radius: 1rem 2.5rem 1rem 2.5rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .stagger-1 {
        animation-delay: 0.1s;
        opacity: 0;
    }

    .stagger-2 {
        animation-delay: 0.2s;
        opacity: 0;
    }

    .stagger-3 {
        animation-delay: 0.3s;
        opacity: 0;
    }

    .status-badge {
        position: relative;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-badge::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-pending::before {
        background: #f4b329;
        box-shadow: 0 0 8px rgba(244, 179, 41, 0.6);
    }

    .status-confirmed::before {
        background: #5f7560;
        box-shadow: 0 0 8px rgba(95, 117, 96, 0.6);
    }

    .status-in_progress::before {
        background: #e96d3f;
        box-shadow: 0 0 8px rgba(233, 109, 63, 0.6);
    }

    .status-delivered::before {
        background: #10b981;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
    }

    .status-cancelled::before {
        background: #6b7280;
        box-shadow: 0 0 8px rgba(107, 114, 128, 0.6);
    }
</style>

<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Декоративные элементы фона -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-200/20 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-gold-200/20 rounded-full blur-3xl -z-10"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-sage-200/10 rounded-full blur-3xl -z-10"></div>

    <div class="max-w-7xl mx-auto">
        <!-- Заголовок страницы -->
        <div class="mb-8 animate-fade-in-up">
            <h1 class="text-4xl sm:text-5xl font-display font-bold text-primary-800 mb-3">
                Личный кабинет
            </h1>
            <p class="text-lg text-sage-600">Добро пожаловать, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Уведомления -->
        @if (session('status') === 'profile-updated')
            <div class="mb-6 p-4 bg-green-50 border-2 border-green-200 rounded-xl text-green-800 animate-fade-in-up stagger-1" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Профиль успешно обновлен!
                </div>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="mb-6 p-4 bg-green-50 border-2 border-green-200 rounded-xl text-green-800 animate-fade-in-up stagger-1" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Пароль успешно изменен!
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Левая колонка: Заказы -->
            <div class="lg:col-span-2">
                <!-- Карточка профиля -->
                <div class="dashboard-card organic-border p-6 sm:p-8 animate-fade-in-up stagger-1">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-400 to-gold-400 flex items-center justify-center text-white text-2xl font-display font-bold shadow-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-display font-semibold text-gray-900">{{ auth()->user()->name }}</h2>
                            <p class="text-sm text-sage-600">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm">
                        @if(auth()->user()->phone)
                            <div class="flex items-center gap-2 text-sage-700">
                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ auth()->user()->phone }}
                            </div>
                        @endif
                        @if(auth()->user()->default_address)
                            <div class="flex items-start gap-2 text-sage-700">
                                <svg class="w-4 h-4 text-primary-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="flex-1">{{ auth()->user()->default_address }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Форма редактирования профиля -->
                <div class="dashboard-card organic-border-alt p-6 sm:p-8 animate-fade-in-up stagger-2">
                    <h3 class="text-xl font-display font-semibold text-primary-800 mb-4">Личные данные</h3>
                    
                    <form method="POST" action="{{ route('dashboard.profile.update') }}" class="space-y-5">
                        @csrf
                        @method('patch')

                        <div class="group">
                            <label for="name" class="block text-sm font-medium text-sage-700 mb-2 transition-colors group-focus-within:text-primary-600">
                                Имя
                            </label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', auth()->user()->name) }}"
                                required
                                autofocus
                                autocomplete="name"
                                class="block w-full px-4 py-3 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                                       focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                                       transition-all duration-300 ease-out
                                       hover:border-sage-300"
                            >
                            @error('name')
                                <p class="mt-2 text-sm text-primary-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="email" class="block text-sm font-medium text-sage-700 mb-2 transition-colors group-focus-within:text-primary-600">
                                Email
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                required
                                autocomplete="username"
                                class="block w-full px-4 py-3 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                                       focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                                       transition-all duration-300 ease-out
                                       hover:border-sage-300"
                            >
                            @error('email')
                                <p class="mt-2 text-sm text-primary-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="phone" class="block text-sm font-medium text-sage-700 mb-2 transition-colors group-focus-within:text-primary-600">
                                Телефон
                            </label>
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                value="{{ old('phone', auth()->user()->phone) }}"
                                autocomplete="tel"
                                class="block w-full px-4 py-3 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                                       focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                                       transition-all duration-300 ease-out
                                       hover:border-sage-300"
                                placeholder="+7 (999) 999-99-99"
                            >
                            @error('phone')
                                <p class="mt-2 text-sm text-primary-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="default_address" class="block text-sm font-medium text-sage-700 mb-2 transition-colors group-focus-within:text-primary-600">
                                Адрес доставки по умолчанию
                            </label>
                            <textarea
                                id="default_address"
                                name="default_address"
                                rows="3"
                                autocomplete="street-address"
                                class="block w-full px-4 py-3 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                                       focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                                       transition-all duration-300 ease-out
                                       hover:border-sage-300 resize-none"
                                placeholder="Введите адрес доставки"
                            >{{ old('default_address', auth()->user()->default_address) }}</textarea>
                            @error('default_address')
                                <p class="mt-2 text-sm text-primary-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full py-3 px-6 bg-primary-500 text-white font-semibold rounded-xl shadow-lg
                                   hover:bg-primary-600 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98]
                                   focus:outline-none focus:ring-4 focus:ring-primary-200
                                   transition-all duration-300 ease-out"
                        >
                            Сохранить изменения
                        </button>
                    </form>
                </div>

                <!-- Форма смены пароля -->
                <div class="dashboard-card organic-border p-6 sm:p-8 animate-fade-in-up stagger-3">
                    <h3 class="text-xl font-display font-semibold text-primary-800 mb-4">Смена пароля</h3>
                    
                    <form method="POST" action="{{ route('dashboard.password.update') }}" class="space-y-5">
                        @csrf
                        @method('put')

                        <div class="group">
                            <label for="current_password" class="block text-sm font-medium text-sage-700 mb-2">
                                Текущий пароль
                            </label>
                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                autocomplete="current-password"
                                class="block w-full px-4 py-3 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                                       focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                                       transition-all duration-300 ease-out
                                       hover:border-sage-300"
                            >
                            @error('current_password', 'updatePassword')
                                <p class="mt-2 text-sm text-primary-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="password" class="block text-sm font-medium text-sage-700 mb-2">
                                Новый пароль
                            </label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                class="block w-full px-4 py-3 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                                       focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                                       transition-all duration-300 ease-out
                                       hover:border-sage-300"
                            >
                            @error('password', 'updatePassword')
                                <p class="mt-2 text-sm text-primary-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="password_confirmation" class="block text-sm font-medium text-sage-700 mb-2">
                                Подтвердите пароль
                            </label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                class="block w-full px-4 py-3 bg-white/50 border-2 border-sage-200 rounded-xl text-gray-900 placeholder-sage-400
                                       focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white
                                       transition-all duration-300 ease-out
                                       hover:border-sage-300"
                            >
                            @error('password_confirmation', 'updatePassword')
                                <p class="mt-2 text-sm text-primary-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full py-3 px-6 bg-sage-600 text-white font-semibold rounded-xl shadow-lg
                                   hover:bg-sage-700 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98]
                                   focus:outline-none focus:ring-4 focus:ring-sage-200
                                   transition-all duration-300 ease-out"
                        >
                            Изменить пароль
                        </button>
                    </form>
                </div>
            </div>

            <!-- Правая колонка: Заказы -->
            <div class="lg:col-span-2">
                <div class="dashboard-card organic-border-alt p-6 sm:p-8 animate-fade-in-up stagger-2">
                    <h3 class="text-2xl font-display font-semibold text-primary-800 mb-6">Мои заказы</h3>

                    @if($orders->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-24 h-24 mx-auto text-sage-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <p class="text-lg text-sage-600 mb-2">У вас пока нет заказов</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium">
                                Перейти в каталог
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div class="border-2 border-sage-200 rounded-xl p-5 hover:border-primary-300 transition-all duration-300 hover:shadow-md">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h4 class="text-lg font-semibold text-gray-900">Заказ #{{ $order->id }}</h4>
                                                <span class="status-badge status-{{ $order->status }}">
                                                    @if($order->status === 'pending')
                                                        Ожидает подтверждения
                                                    @elseif($order->status === 'confirmed')
                                                        Подтвержден
                                                    @elseif($order->status === 'in_progress')
                                                        В работе
                                                    @elseif($order->status === 'delivered')
                                                        Доставлен
                                                    @else
                                                        Отменен
                                                    @endif
                                                </span>
                                            </div>
                                            <p class="text-sm text-sage-600 mb-1">
                                                Дата заказа: {{ $order->created_at->format('d.m.Y H:i') }}
                                            </p>
                                            @if($order->delivery_date)
                                                <p class="text-sm text-sage-600">
                                                    Дата доставки: {{ $order->delivery_date->format('d.m.Y H:i') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-display font-bold text-primary-600">
                                                {{ number_format($order->total_amount, 0, ',', ' ') }} ₽
                                            </p>
                                        </div>
                                    </div>

                                    @if($order->orderItems->isNotEmpty())
                                        <div class="mb-4 pt-4 border-t border-sage-200">
                                            <h5 class="text-sm font-semibold text-gray-700 mb-2">Товары:</h5>
                                            <div class="space-y-2">
                                                @foreach($order->orderItems as $item)
                                                    <div class="flex items-center justify-between text-sm">
                                                        <span class="text-gray-700">
                                                            @if($item->product)
                                                                {{ $item->product->name }}
                                                            @else
                                                                Товар #{{ $item->product_id }}
                                                            @endif
                                                            <span class="text-sage-600">× {{ $item->quantity }}</span>
                                                        </span>
                                                        <span class="text-gray-900 font-medium">
                                                            {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($order->delivery_address)
                                        <div class="pt-4 border-t border-sage-200">
                                            <p class="text-sm text-sage-600">
                                                <span class="font-medium">Адрес доставки:</span> {{ $order->delivery_address }}
                                            </p>
                                        </div>
                                    @endif

                                    @if($order->notes)
                                        <div class="mt-3 pt-3 border-t border-sage-100">
                                            <p class="text-sm text-gray-600 italic">{{ $order->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Анимация появления элементов
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.animate-fade-in-up');
        elements.forEach((el, index) => {
            setTimeout(() => {
                el.style.opacity = '0';
                el.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s forwards`;
            }, 100);
        });
    });
</script>
@endsection
