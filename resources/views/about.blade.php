@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-accent-50 via-white to-primary-50">
    <!-- Background Gradient Mesh -->
    <div class="absolute inset-0 gradient-mesh opacity-40"></div>

    <!-- Decorative Elements -->
    <div class="absolute top-10 right-20 w-80 h-80 bg-primary-200/20 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-32 left-10 w-96 h-96 bg-gold-200/25 rounded-full blur-3xl animate-float" style="animation-delay: -4s;"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-24 lg:py-32">
        <div class="text-center space-y-8 animate-fade-in-up">
            <div class="inline-block">
                <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/90 backdrop-blur-sm border border-primary-200 shadow-sm">
                    <span class="text-2xl">🌿</span>
                    <span class="text-sm font-medium text-accent-700">Семейная история</span>
                </span>
            </div>

            <h1 class="font-display text-5xl lg:text-7xl xl:text-8xl font-bold text-gray-900 leading-[0.95]">
                О нас —<br/>
                <span class="relative inline-block">
                    <span class="relative z-10 bg-gradient-to-r from-primary-600 via-sage-500 to-gold-600 bg-clip-text text-transparent">семейное дело</span>
                    <svg class="absolute -bottom-2 left-0 w-full h-5 text-primary-300/40" viewBox="0 0 300 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 9C50 3 100 1 150 2C200 3 250 5 298 9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                </span>
            </h1>

            <p class="text-xl lg:text-2xl text-gray-700 leading-relaxed max-w-3xl mx-auto text-balance">
                Каждый букет мы создаём с той же любовью и заботой, с какой украшаем дом для своих родных
            </p>
        </div>
    </div>
</section>

<!-- Наша история -->
<section class="py-20 lg:py-28 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Левая колонка - Текст -->
            <div class="space-y-8 animate-fade-in-up">
                <div class="inline-block">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-50 text-primary-700 font-medium text-sm border border-primary-100">
                        📖 Наша история
                    </span>
                </div>

                <h2 class="font-display text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    Семья, которая создаёт счастье
                </h2>

                <div class="space-y-6 text-lg text-gray-700 leading-relaxed">
                    <p>
                        <span class="font-semibold text-primary-600">«Эдемский сад»</span> — это не просто цветочная мастерская. Это наша семейная история, наполненная любовью к цветам и желанием делиться красотой с людьми.
                    </p>

                    <p>
                        Всё началось с простой мечты — создавать букеты, которые несут настоящие эмоции. Мы верим, что цветы — это язык, на котором можно сказать то, что сложно выразить словами.
                    </p>

                    <p>
                        Сегодня в нашей мастерской работает вся семья: мама подбирает самые свежие цветы, папа заботится о доставке, а мы с сестрой создаём композиции, вкладывая в каждый букет частичку души.
                    </p>

                    <p class="text-primary-600 font-medium italic">
                        Для нас каждый заказ — это возможность стать частью вашего особенного момента, разделить вашу радость и помочь выразить самые искренние чувства.
                    </p>
                </div>
            </div>

            <!-- Правая колонка - Изображение с декором -->
            <div class="relative animate-fade-in-up stagger-2">
                <!-- Декоративная рамка -->
                <div class="absolute -top-6 -left-6 w-full h-full border-2 border-sage-300/40 rounded-[2.5rem] -rotate-2"></div>
                <div class="absolute -bottom-6 -right-6 w-full h-full border-2 border-primary-300/40 rounded-[2.5rem] rotate-2"></div>

                <div class="relative rounded-[2rem] overflow-hidden shadow-2xl">
                    <div class="aspect-[4/5] bg-gradient-to-br from-primary-100 via-sage-100 to-gold-100">
                        <img
                            src="{{ asset('images/about.jpg') }}"
                            alt="Наша семейная мастерская - Эдемский сад"
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>

                <!-- Плавающий badge -->
                <div class="absolute -bottom-8 -left-8 bg-white rounded-2xl shadow-2xl p-6 backdrop-blur-sm border border-accent-200 animate-float max-w-xs">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-gold-500 rounded-xl flex items-center justify-center text-white font-bold text-3xl flex-shrink-0">
                            ❤️
                        </div>
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Наш принцип</div>
                            <div class="font-display text-lg font-bold text-gray-900 leading-tight">Как для своей семьи</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Наши ценности -->
<section class="py-20 lg:py-28 bg-gradient-to-b from-white via-accent-50 to-white relative overflow-hidden">
    <!-- Decorative background -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-40 left-10 w-72 h-72 bg-primary-400 rounded-full blur-3xl"></div>
        <div class="absolute bottom-40 right-10 w-96 h-96 bg-sage-400 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16 space-y-4">
            <div class="inline-block">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sage-100 text-sage-700 font-medium text-sm">
                    💚 Наши ценности
                </span>
            </div>
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-gray-900">
                Что для нас важно
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Принципы, которыми мы руководствуемся в работе каждый день
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Ценность 1 -->
            <div class="group relative animate-fade-in-up stagger-1">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-100 to-gold-100 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative p-8 rounded-3xl border border-accent-200/50 bg-white/80 backdrop-blur-sm hover:border-primary-300 transition-all hover:shadow-xl space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">
                        <span class="text-3xl">👨‍👩‍👧‍👦</span>
                    </div>
                    <h3 class="font-display text-2xl font-semibold text-gray-900">Семейный подход</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Мы относимся к каждому заказу так, будто создаём букет для самых близких людей. Ваша радость — наша награда.
                    </p>
                </div>
            </div>

            <!-- Ценность 2 -->
            <div class="group relative animate-fade-in-up stagger-2">
                <div class="absolute inset-0 bg-gradient-to-br from-sage-100 to-primary-100 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative p-8 rounded-3xl border border-accent-200/50 bg-white/80 backdrop-blur-sm hover:border-sage-300 transition-all hover:shadow-xl space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-sage-500 to-sage-600 rounded-2xl flex items-center justify-center shadow-lg shadow-sage-500/20 group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🌱</span>
                    </div>
                    <h3 class="font-display text-2xl font-semibold text-gray-900">Свежесть и качество</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Только свежие цветы от проверенных поставщиков. Мы лично отбираем каждый бутон для ваших букетов.
                    </p>
                </div>
            </div>

            <!-- Ценность 3 -->
            <div class="group relative animate-fade-in-up stagger-3">
                <div class="absolute inset-0 bg-gradient-to-br from-gold-100 to-sage-100 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative p-8 rounded-3xl border border-accent-200/50 bg-white/80 backdrop-blur-sm hover:border-gold-300 transition-all hover:shadow-xl space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-600 rounded-2xl flex items-center justify-center shadow-lg shadow-gold-500/20 group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🎨</span>
                    </div>
                    <h3 class="font-display text-2xl font-semibold text-gray-900">Творческий подход</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Каждый букет — это произведение искусства, созданное с вниманием к деталям и вашим пожеланиям.
                    </p>
                </div>
            </div>

            <!-- Ценность 4 -->
            <div class="group relative animate-fade-in-up stagger-4">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-100 to-sage-100 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative p-8 rounded-3xl border border-accent-200/50 bg-white/80 backdrop-blur-sm hover:border-primary-300 transition-all hover:shadow-xl space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-sage-500 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🤝</span>
                    </div>
                    <h3 class="font-display text-2xl font-semibold text-gray-900">Честность</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Никаких скрытых платежей, никаких обманов. Мы ценим доверие наших клиентов превыше всего.
                    </p>
                </div>
            </div>

            <!-- Ценность 5 -->
            <div class="group relative animate-fade-in-up stagger-5">
                <div class="absolute inset-0 bg-gradient-to-br from-sage-100 to-gold-100 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative p-8 rounded-3xl border border-accent-200/50 bg-white/80 backdrop-blur-sm hover:border-sage-300 transition-all hover:shadow-xl space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-sage-500 to-gold-500 rounded-2xl flex items-center justify-center shadow-lg shadow-sage-500/20 group-hover:scale-110 transition-transform">
                        <span class="text-3xl">⚡</span>
                    </div>
                    <h3 class="font-display text-2xl font-semibold text-gray-900">Оперативность</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Мы понимаем ценность времени. Быстрая сборка и доставка в день заказа по Брянску.
                    </p>
                </div>
            </div>

            <!-- Ценность 6 -->
            <div class="group relative animate-fade-in-up stagger-6">
                <div class="absolute inset-0 bg-gradient-to-br from-gold-100 to-primary-100 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative p-8 rounded-3xl border border-accent-200/50 bg-white/80 backdrop-blur-sm hover:border-gold-300 transition-all hover:shadow-xl space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-primary-500 rounded-2xl flex items-center justify-center shadow-lg shadow-gold-500/20 group-hover:scale-110 transition-transform">
                        <span class="text-3xl">💝</span>
                    </div>
                    <h3 class="font-display text-2xl font-semibold text-gray-900">Душа в каждом букете</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Мы не просто продаём цветы — мы помогаем выразить чувства и создать особенные моменты.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Почему выбирают нас -->
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Левая колонка - Изображение -->
            <div class="relative animate-fade-in-up order-2 lg:order-1">
                <div class="absolute -top-8 -right-8 w-full h-full bg-gradient-to-br from-primary-200/30 to-gold-200/30 rounded-[2.5rem] rotate-3"></div>

                <div class="relative rounded-[2rem] overflow-hidden shadow-2xl">
                    <div class="aspect-[4/3] bg-gradient-to-br from-sage-100 via-primary-100 to-accent-100 flex items-center justify-center">
                        <div class="text-center space-y-6 p-8">
                            <div class="flex justify-center gap-4">
                                <div class="text-6xl animate-float">🌹</div>
                                <div class="text-6xl animate-float" style="animation-delay: -2s;">🌺</div>
                                <div class="text-6xl animate-float" style="animation-delay: -4s;">🌸</div>
                            </div>
                            <p class="font-display text-3xl font-bold text-gray-800">500+</p>
                            <p class="text-xl text-gray-600">Счастливых клиентов</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая колонка - Текст -->
            <div class="space-y-8 animate-fade-in-up stagger-2 order-1 lg:order-2">
                <div class="inline-block">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gold-50 text-gold-700 font-medium text-sm border border-gold-100">
                        ⭐ Наши преимущества
                    </span>
                </div>

                <h2 class="font-display text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    Почему нам доверяют
                </h2>

                <div class="space-y-6">
                    <!-- Преимущество 1 -->
                    <div class="flex items-start gap-4 p-6 rounded-2xl bg-gradient-to-r from-primary-50 to-transparent border-l-4 border-primary-500 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <span class="text-2xl">👪</span>
                        </div>
                        <div>
                            <h3 class="font-display text-xl font-semibold text-gray-900 mb-2">Семейная ответственность</h3>
                            <p class="text-gray-600 leading-relaxed">Наша репутация — это репутация всей семьи. Мы дорожим каждым клиентом и каждым отзывом.</p>
                        </div>
                    </div>

                    <!-- Преимущество 2 -->
                    <div class="flex items-start gap-4 p-6 rounded-2xl bg-gradient-to-r from-sage-50 to-transparent border-l-4 border-sage-500 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-sage-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <span class="text-2xl">🏠</span>
                        </div>
                        <div>
                            <h3 class="font-display text-xl font-semibold text-gray-900 mb-2">Местное производство</h3>
                            <p class="text-gray-600 leading-relaxed">Мы живём и работаем в Брянске. Знаем город и можем гарантировать быструю доставку.</p>
                        </div>
                    </div>

                    <!-- Преимущество 3 -->
                    <div class="flex items-start gap-4 p-6 rounded-2xl bg-gradient-to-r from-gold-50 to-transparent border-l-4 border-gold-500 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-gold-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <span class="text-2xl">💬</span>
                        </div>
                        <div>
                            <h3 class="font-display text-xl font-semibold text-gray-900 mb-2">Личный контакт</h3>
                            <p class="text-gray-600 leading-relaxed">Вы всегда общаетесь с членами нашей семьи, а не с безликими операторами колл-центра.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="relative py-24 lg:py-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-500 to-gold-600"></div>
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96">
            <svg viewBox="0 0 200 200" class="w-full h-full">
                <circle cx="100" cy="100" r="80" fill="none" stroke="white" stroke-width="0.5"/>
                <circle cx="100" cy="100" r="60" fill="none" stroke="white" stroke-width="0.5"/>
                <circle cx="100" cy="100" r="40" fill="none" stroke="white" stroke-width="0.5"/>
            </svg>
        </div>
        <div class="absolute bottom-0 left-0 w-80 h-80">
            <svg viewBox="0 0 200 200" class="w-full h-full">
                <circle cx="100" cy="100" r="70" fill="none" stroke="white" stroke-width="0.5"/>
                <circle cx="100" cy="100" r="50" fill="none" stroke="white" stroke-width="0.5"/>
            </svg>
        </div>
    </div>

    <div class="relative max-w-5xl mx-auto px-6 lg:px-8 text-center">
        <div class="space-y-8">
            <div class="inline-block">
                <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/20 backdrop-blur-sm text-white font-medium text-sm border border-white/30">
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    Мы будем рады видеть вас
                </span>
            </div>

            <h2 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight text-balance">
                Станьте частью нашей<br/>большой семьи
            </h2>

            <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed text-balance">
                Позвольте нам сделать ваши особенные моменты ещё ярче. Мы создадим для вас букет с душой и любовью!
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-6">
                <a href="/products" class="group inline-flex items-center gap-3 px-8 py-4 bg-white text-primary-700 rounded-full font-semibold shadow-xl hover:shadow-2xl hover:scale-105 transition-all">
                    <span>Посмотреть букеты</span>
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>

                <a href="/delivery" class="inline-flex items-center gap-3 px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-full font-semibold border-2 border-white/30 hover:bg-white/20 hover:border-white/50 transition-all">
                    <span>Условия доставки</span>
                </a>
            </div>

            <!-- Статистика -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto pt-12">
                <div class="text-white/95">
                    <div class="font-display text-4xl lg:text-5xl font-bold mb-2">500+</div>
                    <div class="text-sm text-white/70">Счастливых клиентов</div>
                </div>
                <div class="text-white/95">
                    <div class="font-display text-4xl lg:text-5xl font-bold mb-2">1000+</div>
                    <div class="text-sm text-white/70">Букетов создано</div>
                </div>
                <div class="text-white/95">
                    <div class="font-display text-4xl lg:text-5xl font-bold mb-2">4.9</div>
                    <div class="text-sm text-white/70">Средняя оценка</div>
                </div>
                <div class="text-white/95">
                    <div class="font-display text-4xl lg:text-5xl font-bold mb-2">100%</div>
                    <div class="text-sm text-white/70">С любовью</div>
                </div>
            </div>

            <!-- Контакты -->
            <div class="pt-8 space-y-4">
                <p class="text-white/90 font-medium text-lg">Свяжитесь с нами прямо сейчас:</p>
                <div class="flex flex-wrap justify-center gap-6 text-lg">
                    <a href="tel:+79532929246" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm text-white rounded-full border border-white/30 hover:bg-white/20 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>+7 (953) 292-92-46</span>
                    </a>
                    <a href="https://t.me/FlowersMindale" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm text-white rounded-full border border-white/30 hover:bg-white/20 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c-.18 1.897-.962 6.502-1.359 8.627-.168.9-.5 1.201-.82 1.23-.697.064-1.226-.461-1.901-.903-1.056-.692-1.653-1.123-2.678-1.799-1.185-.781-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.139-5.062 3.345-.479.329-.913.489-1.302.481-.428-.008-1.252-.241-1.865-.44-.752-.244-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.831-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635.099-.002.321.023.465.141.121.099.155.232.171.325.016.093.036.306.02.472z"/>
                        </svg>
                        <span>Написать в Telegram</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
