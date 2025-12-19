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
                    <button id="mobile-menu-button" class="lg:hidden relative p-2.5 text-gray-700 hover:text-primary-600 rounded-xl hover:bg-white/70 transition-all duration-300 group">
                        <div class="relative w-6 h-6">
                            <svg id="menu-icon" class="w-6 h-6 absolute inset-0 transition-all duration-300 ease-in-out transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg id="close-icon" class="w-6 h-6 absolute inset-0 transition-all duration-300 ease-in-out transform opacity-0 rotate-90 scale-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>

        </nav>
    </header>

    <!-- Mobile menu overlay backdrop -->
    <div id="mobile-menu-backdrop" class="lg:hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300"></div>

    <!-- Mobile menu panel (right side) -->
    <div id="mobile-menu" class="lg:hidden fixed right-0 top-0 bottom-0 w-80 max-w-[85vw] z-50">
        <div class="mobile-menu-content h-full bg-gradient-to-b from-white via-accent-50/95 to-accent-100/95 backdrop-blur-xl shadow-2xl transform translate-x-full transition-transform duration-500 ease-out flex flex-col">
            <!-- Header меню -->
            <div class="flex items-center justify-between px-6 py-6 border-b border-accent-200/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-gold-600 rounded-full flex items-center justify-center text-white text-xl shadow-md">
                        🌷
                    </div>
                    <span class="font-display text-xl font-semibold text-gray-900">Меню</span>
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
                <p class="text-sm text-gray-600 text-center">iTulip — Цветочная мастерская</p>
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

        #mobile-menu.menu-open {
            pointer-events: auto;
            visibility: visible;
        }

        #mobile-menu.menu-open .mobile-menu-content {
            transform: translateX(0);
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

    <script>
        // Мобильное меню с плавной анимацией
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
            const mobileMenuClose = document.getElementById('mobile-menu-close');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            let isMenuOpen = false;

            function openMenu() {
                console.log('Opening menu');
                isMenuOpen = true;
                mobileMenuButton.classList.add('menu-open');
                mobileMenu.classList.add('menu-open');
                mobileMenuBackdrop.classList.add('menu-open');
                document.body.style.overflow = 'hidden';
            }

            function closeMenu() {
                console.log('Closing menu');
                isMenuOpen = false;
                mobileMenuButton.classList.remove('menu-open');
                mobileMenu.classList.remove('menu-open');
                mobileMenuBackdrop.classList.remove('menu-open');
                document.body.style.overflow = '';
            }

            // Открытие меню по кнопке
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    if (isMenuOpen) {
                        closeMenu();
                    } else {
                        openMenu();
                    }
                });
            }

            // Закрытие по кнопке X внутри меню
            if (mobileMenuClose) {
                mobileMenuClose.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Close button clicked');
                    closeMenu();
                });
            }

            // Закрытие меню при клике на ссылку
            const mobileMenuLinks = mobileMenu.querySelectorAll('.mobile-menu-link');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    closeMenu();
                });
            });

            // Закрытие меню при клике на backdrop
            if (mobileMenuBackdrop) {
                mobileMenuBackdrop.addEventListener('click', () => {
                    closeMenu();
                });
            }

            // Закрытие меню по клавише Escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && isMenuOpen) {
                    closeMenu();
                }
            });
        });
    </script>

    <!-- Main Content -->
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')
</body>
</html>
