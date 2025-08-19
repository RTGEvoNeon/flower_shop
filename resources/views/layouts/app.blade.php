<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'iTulip - Доставка цветов' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-gray-900 font-inter">
    <!-- Header Navigation -->
    <header class="border-b border-gray-100">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="text-xl font-semibold text-gray-900">
                        Букеты by <span class="text-pink-500">iTulip</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-gray-900 transition-colors">Главная</a>
                    <a href="/products" class="text-gray-700 hover:text-gray-900 transition-colors">Каталог</a>
                    <a href="/custom-bouquet" class="text-gray-700 hover:text-gray-900 transition-colors">Собери свой букет</a>
                    <a href="/seasonal" class="text-gray-700 hover:text-gray-900 transition-colors">Сейчас сезон</a>
                    <a href="/care" class="text-gray-700 hover:text-gray-900 transition-colors">Уход</a>
                    <a href="/delivery" class="text-gray-700 hover:text-gray-900 transition-colors">Доставка</a>
                </div>
                
                <!-- Cart & Mobile menu -->
                <div class="flex items-center space-x-4">
                    <!-- Cart -->
                    <a href="/cart" class="relative p-2 text-gray-700 hover:text-gray-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6.5M7 13l-1.5-6.5m0 0h13M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a>
                    
                    <!-- Mobile menu button -->
                    <button class="md:hidden p-2 text-gray-700">
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
