<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'iTulip — Цветочная мастерская' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Commissioner:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-accent-50 text-gray-900 grain-texture">
    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-accent-50/80 backdrop-blur-xl border-b border-accent-200/50">
        <nav class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="group flex items-center gap-3">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-primary-400 to-gold-500 rounded-full blur-md opacity-50 group-hover:opacity-75 transition-opacity"></div>
                            <div class="relative w-12 h-12 bg-gradient-to-br from-primary-500 to-gold-600 rounded-full flex items-center justify-center text-white text-2xl shadow-lg">
                                🌷
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-display text-2xl font-semibold text-gray-900 tracking-tight">iTulip</span>
                            <span class="text-xs text-accent-600 tracking-wider uppercase">Цветочная мастерская</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <!-- TODO: Добавить страницы -->
                    <a href="/" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Главная</a>
                    <a href="/products" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Каталог</a>
                    <!-- <a href="/custom-bouquet" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Свой букет</a>
                    <a href="/seasonal" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Сезонные</a>
                    <a href="/care" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Уход</a> -->
                    <a href="/delivery" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Доставка</a>
                </div>

                <!-- Mobile menu -->
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button class="lg:hidden p-2 text-gray-700 hover:text-primary-600 rounded-lg hover:bg-white/50 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')
</body>
</html>
