<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, follow">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Commissioner:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex items-center justify-center relative overflow-hidden gradient-mesh grain-texture">
            <!-- Декоративные элементы -->
            <div class="absolute top-20 right-10 w-64 h-64 bg-primary-300/30 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 left-10 w-80 h-80 bg-sage-300/30 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/4 w-48 h-48 bg-gold-300/25 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>

            <!-- Контейнер формы -->
            <div class="w-full max-w-md mx-4 relative z-10">
                <!-- Логотип -->
                <div class="text-center mb-8 opacity-0 animate-fade-in-up">
                    <a href="/" class="inline-block group">
                        <div class="w-20 h-20 rounded-full overflow-hidden shadow-lg ring-2 ring-primary-200/50 transition-all duration-300 group-hover:scale-110 group-hover:ring-primary-400/70 group-hover:shadow-xl">
                            <x-application-logo class="w-full h-full object-cover" />
                        </div>
                    </a>
                </div>

                <!-- Карточка формы -->
                <div class="bg-white/70 backdrop-blur-2xl shadow-2xl rounded-3xl overflow-hidden border border-primary-200/60 opacity-0 animate-fade-in-up stagger-1">
                    <div class="px-8 py-10 sm:px-12 sm:py-12">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Декоративная линия снизу -->
                <div class="mt-6 text-center opacity-0 animate-fade-in-up stagger-2">
                    <div class="inline-block w-16 h-1 bg-gradient-to-r from-primary-400 via-gold-400 to-sage-400 rounded-full"></div>
                </div>
            </div>
        </div>
    </body>
</html>
