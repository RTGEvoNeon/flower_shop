<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#e96d3f">

    @stack('seo')

    <!-- Favicons -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg?v=3">
    <link rel="alternate icon" type="image/x-icon" href="/favicon.ico?v=3">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Эдемский сад">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Commissioner:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Schema.org JSON-LD -->
    @stack('schema')

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=104582209', 'ym');

        ym(104582209, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});
    </script>
    <!-- /Yandex.Metrika counter -->
</head>
<body class="min-h-screen bg-accent-50 text-gray-900 grain-texture">
    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-accent-50/80 backdrop-blur-xl border-b border-accent-200/50">
        <nav class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="group flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden">
                            <img src="/images/logo.jpg" alt="Эдемский сад" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-display text-2xl font-semibold text-gray-900 tracking-tight">Эдемский сад</span>
                            <span class="text-xs text-accent-600 tracking-wider uppercase">Цветочная мастерская</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="/" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Главная</a>
                    <a href="/products" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Каталог</a>
                    <!-- <a href="/custom-bouquet" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Свой букет</a>
                    <a href="/seasonal" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Сезонные</a>
                    <a href="/care" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Уход</a> -->
                    <a href="/delivery" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">Доставка</a>
                    <a href="/about" class="px-4 py-2 text-gray-700 hover:text-primary-600 transition-colors rounded-lg hover:bg-white/50">О нас</a>
                </div>

                <!-- Mobile menu -->
                <div class="flex items-center lg:hidden">
                    <!-- Mobile menu button -->
                    <button id="mobile-menu-button" type="button" class="relative p-2.5 text-gray-700 hover:text-primary-600 rounded-xl hover:bg-white/70 transition-all duration-300" aria-label="Открыть меню">
                        <svg id="menu-icon" class="w-6 h-6 transition-all duration-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="4" y1="6" x2="20" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line x1="4" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line x1="4" y1="18" x2="20" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <svg id="close-icon" class="w-6 h-6 absolute inset-0 m-2.5 transition-all duration-300 opacity-0 scale-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line x1="6" y1="18" x2="18" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>

        </nav>
    </header>

    <!-- Mobile menu overlay backdrop -->
    <div id="mobile-menu-backdrop" class="lg:hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300"></div>

    <!-- Mobile menu panel (right side) -->
    <div id="mobile-menu" class="lg:hidden fixed right-0 top-0 bottom-0 w-80 max-w-[85vw] z-50">
        <div class="mobile-menu-content h-full bg-gradient-to-b from-white via-accent-50/95 to-accent-100/95 backdrop-blur-xl shadow-2xl transition-transform duration-500 ease-out flex flex-col">
            <!-- Header меню -->
            <div class="flex items-center justify-between px-6 py-6 border-b border-accent-200/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                        <img src="/images/logo.jpg" alt="Эдемский сад" class="w-full h-full object-cover">
                    </div>
                    <span class="font-display text-xl font-semibold text-gray-900">Эдемский сад</span>
                </div>
                <button id="mobile-menu-close" class="p-2 text-gray-600 hover:text-primary-600 rounded-lg hover:bg-white/50 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="/" class="mobile-menu-link block relative px-5 py-4 text-gray-700 font-medium rounded-2xl transition-all duration-300 hover:text-primary-600 hover:bg-white/80 hover:shadow-md hover:translate-x-2 group overflow-hidden">
                    <span class="relative z-10 flex items-center gap-3">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Главная
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-50 to-gold-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="/products" class="mobile-menu-link block relative px-5 py-4 text-gray-700 font-medium rounded-2xl transition-all duration-300 hover:text-primary-600 hover:bg-white/80 hover:shadow-md hover:translate-x-2 group overflow-hidden">
                    <span class="relative z-10 flex items-center gap-3">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Каталог
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-50 to-gold-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="/about" class="mobile-menu-link block relative px-5 py-4 text-gray-700 font-medium rounded-2xl transition-all duration-300 hover:text-primary-600 hover:bg-white/80 hover:shadow-md hover:translate-x-2 group overflow-hidden">
                    <span class="relative z-10 flex items-center gap-3">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        О нас
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-50 to-gold-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="/delivery" class="mobile-menu-link block relative px-5 py-4 text-gray-700 font-medium rounded-2xl transition-all duration-300 hover:text-primary-600 hover:bg-white/80 hover:shadow-md hover:translate-x-2 group overflow-hidden">
                    <span class="relative z-10 flex items-center gap-3">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                        Доставка
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-50 to-gold-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
            </nav>

            <!-- Footer меню (опционально) -->
            <div class="px-6 py-4 border-t border-accent-200/50 bg-gradient-to-b from-transparent to-accent-100/50">
                <p class="text-sm text-gray-600 text-center">Эдемский сад — Цветочная мастерская</p>
            </div>
        </div>
    </div>

    <style>
        /* Анимация для иконок меню */
        #mobile-menu-button.menu-open #menu-icon {
            opacity: 0;
            transform: rotate(-90deg) scale(0);
        }

        #mobile-menu-button.menu-open #close-icon {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        /* Плавное появление меню справа */
        #mobile-menu {
            pointer-events: none;
            visibility: hidden;
        }

        #mobile-menu .mobile-menu-content {
            transform: translateX(100%);
        }

        #mobile-menu.menu-open {
            pointer-events: auto;
            visibility: visible;
        }

        #mobile-menu.menu-open .mobile-menu-content {
            transform: translateX(0) !important;
        }

        /* Backdrop затемнение */
        #mobile-menu-backdrop.menu-open {
            opacity: 1;
            pointer-events: auto;
        }

        /* Анимация ссылок - только когда меню НЕ открыто */
        #mobile-menu:not(.menu-open) .mobile-menu-link {
            opacity: 0;
            transform: translateX(20px);
        }

        /* Анимация появления ссылок когда меню открывается */
        #mobile-menu.menu-open .mobile-menu-link {
            opacity: 1;
            transform: translateX(0);
            animation: slideInFromRight 0.4s ease-out forwards;
        }

        #mobile-menu.menu-open .mobile-menu-link:nth-child(1) {
            animation-delay: 0.15s;
        }

        #mobile-menu.menu-open .mobile-menu-link:nth-child(2) {
            animation-delay: 0.2s;
        }

        #mobile-menu.menu-open .mobile-menu-link:nth-child(3) {
            animation-delay: 0.25s;
        }

        #mobile-menu.menu-open .mobile-menu-link:nth-child(4) {
            animation-delay: 0.3s;
        }

        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Эффект ripple при клике */
        .mobile-menu-link::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(233, 109, 63, 0.3), transparent);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .mobile-menu-link:active::before {
            width: 300px;
            height: 300px;
        }

        /* Скрыть скроллбар но оставить функциональность */
        #mobile-menu nav::-webkit-scrollbar {
            width: 4px;
        }

        #mobile-menu nav::-webkit-scrollbar-track {
            background: transparent;
        }

        #mobile-menu nav::-webkit-scrollbar-thumb {
            background: rgba(233, 109, 63, 0.3);
            border-radius: 2px;
        }

        #mobile-menu nav::-webkit-scrollbar-thumb:hover {
            background: rgba(233, 109, 63, 0.5);
        }
    </style>

    <!-- Main Content -->
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Yandex.Metrika noscript -->
    <noscript><div><img src="https://mc.yandex.ru/watch/104582209" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika noscript -->
</body>
</html>
