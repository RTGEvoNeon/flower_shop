@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden">
    <!-- Background Gradient Mesh -->
    <div class="absolute inset-0 gradient-mesh"></div>

    <!-- Decorative Elements -->
    <div class="absolute top-20 right-10 w-72 h-72 bg-primary-200/30 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-20 left-10 w-96 h-96 bg-gold-200/30 rounded-full blur-3xl animate-float" style="animation-delay: -3s;"></div>

    <div class="relative max-w-4xl mx-auto px-6 lg:px-8 py-20 lg:py-28">
        <div class="text-center space-y-6 animate-fade-in-up">
            <div class="inline-block">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 backdrop-blur-sm border border-accent-200 shadow-sm">
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-medium text-accent-700">Свяжитесь с нами</span>
                </span>
            </div>

            <h1 class="font-display text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-900 leading-[0.95]">
                Наши<br/>
                <span class="relative inline-block">
                    <span class="relative z-10 bg-gradient-to-r from-primary-600 via-primary-500 to-gold-600 bg-clip-text text-transparent">контакты</span>
                    <svg class="absolute -bottom-2 left-0 w-full h-4 text-primary-300/50" viewBox="0 0 300 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 9C50 3 100 1 150 2C200 3 250 5 298 9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                </span>
            </h1>

            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Мы всегда рады ответить на ваши вопросы и помочь с выбором букета
            </p>
        </div>
    </div>
</section>

<!-- Contact Cards Section -->
<section class="relative py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">

        <!-- Main Contact Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">

            <!-- Phone Card -->
            <div class="group animate-fade-in-up">
                <div class="relative h-full p-8 bg-gradient-to-br from-white to-primary-50 rounded-3xl border-2 border-accent-200/50 hover:border-primary-300 transition-all hover:shadow-xl hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-100 to-gold-100 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>

                        <h3 class="font-display text-2xl font-bold text-gray-900 mb-4">Телефон</h3>
                        <a href="tel:+79532929246" class="text-2xl font-semibold text-primary-600 hover:text-primary-700 transition-colors block mb-2">
                            +7 (953) 292-92-46
                        </a>
                        <p class="text-gray-600 leading-relaxed">
                            Звоните нам в любое время для консультации и оформления заказа
                        </p>
                    </div>
                </div>
            </div>

            <!-- Telegram Card -->
            <div class="group animate-fade-in-up stagger-1">
                <div class="relative h-full p-8 bg-gradient-to-br from-white to-sage-50 rounded-3xl border-2 border-accent-200/50 hover:border-sage-300 transition-all hover:shadow-xl hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-sage-100 to-primary-100 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-sage-500 to-sage-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-sage-500/20 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c-.18 1.897-.962 6.502-1.359 8.627-.168.9-.5 1.201-.82 1.23-.697.064-1.226-.461-1.901-.903-1.056-.692-1.653-1.123-2.678-1.799-1.185-.781-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.139-5.062 3.345-.479.329-.913.489-1.302.481-.428-.008-1.252-.241-1.865-.44-.752-.244-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.831-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635.099-.002.321.023.465.141.121.099.155.232.171.325.016.093.036.306.02.472z"/>
                            </svg>
                        </div>

                        <h3 class="font-display text-2xl font-bold text-gray-900 mb-4">Telegram</h3>
                        <a href="https://t.me/FlowersMindale" class="text-2xl font-semibold text-sage-600 hover:text-sage-700 transition-colors block mb-2">
                            @FlowersMindale
                        </a>
                        <p class="text-gray-600 leading-relaxed">
                            Напишите нам в Telegram для быстрой связи и оформления заказа
                        </p>
                    </div>
                </div>
            </div>

            <!-- Address Card -->
            <div class="group animate-fade-in-up stagger-2">
                <div class="relative h-full p-8 bg-gradient-to-br from-white to-gold-50 rounded-3xl border-2 border-accent-200/50 hover:border-gold-300 transition-all hover:shadow-xl hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-gold-100 to-primary-100 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-gold-500/20 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>

                        <h3 class="font-display text-2xl font-bold text-gray-900 mb-4">Адрес</h3>
                        <p class="text-xl font-semibold text-gold-600 mb-2">
                            г. Брянск,<br/>ул. Академика Сахарова, 5
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            Доставляем свежие букеты по всему городу
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Working Hours Card -->
        <div class="mb-16 animate-fade-in-up stagger-3">
            <div class="relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-500 to-gold-600 rounded-3xl"></div>
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-80 h-80 bg-white rounded-full blur-3xl"></div>
                </div>

                <div class="relative p-10 lg:p-12">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-display text-3xl font-bold text-white">Часы работы</h3>
                                    <p class="text-white/80">Выдача букетов</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="p-6 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl">
                                <div class="flex justify-between items-center">
                                    <span class="text-white font-semibold text-lg">Понедельник - Суббота</span>
                                    <span class="text-white/90 text-xl font-bold">8:00 - 00:00</span>
                                </div>
                            </div>
                            <div class="p-6 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl">
                                <div class="flex justify-between items-center">
                                    <span class="text-white font-semibold text-lg">Воскресенье</span>
                                    <span class="text-white/90 text-xl font-bold">Выходной</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative divider -->
        <div class="my-16 flex items-center justify-center">
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
            <div class="mx-4 text-accent-400 text-2xl">🌸</div>
            <div class="h-px w-32 bg-gradient-to-r from-transparent via-accent-300 to-transparent"></div>
        </div>

        <!-- Contact Form Section -->
        <div class="max-w-3xl mx-auto animate-fade-in-up stagger-4">
            <div class="text-center mb-12">
                <h2 class="font-display text-4xl font-bold text-gray-900 mb-4">Напишите нам</h2>
                <p class="text-xl text-gray-600">
                    Заполните форму ниже, и мы свяжемся с вами в ближайшее время
                </p>
            </div>

            <div class="p-8 lg:p-12 bg-gradient-to-br from-accent-50 to-primary-50 rounded-3xl border-2 border-accent-200/50">
                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
                            Ваше имя <span class="text-primary-600">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            class="w-full px-6 py-4 bg-white border-2 border-accent-200/50 rounded-2xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none text-gray-900 placeholder-gray-400"
                            placeholder="Введите ваше имя"
                        >
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">
                            Телефон <span class="text-primary-600">*</span>
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            required
                            class="w-full px-6 py-4 bg-white border-2 border-accent-200/50 rounded-2xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none text-gray-900 placeholder-gray-400"
                            placeholder="+7 (___) ___-__-__"
                        >
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                            Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full px-6 py-4 bg-white border-2 border-accent-200/50 rounded-2xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none text-gray-900 placeholder-gray-400"
                            placeholder="your@email.com"
                        >
                    </div>

                    <!-- Message Field -->
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-900 mb-2">
                            Сообщение <span class="text-primary-600">*</span>
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            required
                            class="w-full px-6 py-4 bg-white border-2 border-accent-200/50 rounded-2xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none text-gray-900 placeholder-gray-400 resize-none"
                            placeholder="Расскажите, чем мы можем вам помочь..."
                        ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full group relative overflow-hidden bg-gradient-to-r from-primary-600 to-primary-500 text-white px-8 py-5 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]"
                    >
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            <span>Отправить сообщение</span>
                            <svg class="w-6 h-6 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                    </button>
                </form>

                <p class="text-sm text-gray-600 text-center mt-6">
                    Нажимая кнопку, вы соглашаетесь с <a href="/privacy" class="text-primary-600 hover:text-primary-700 underline">политикой конфиденциальности</a>
                </p>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-20 max-w-3xl mx-auto animate-fade-in-up stagger-5">
            <div class="text-center mb-12">
                <h2 class="font-display text-4xl font-bold text-gray-900 mb-4">Частые вопросы</h2>
                <p class="text-xl text-gray-600">
                    Ответы на самые популярные вопросы наших клиентов
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="group p-6 bg-white border-2 border-accent-200/50 rounded-2xl hover:border-primary-300 transition-all">
                    <h3 class="font-display text-xl font-semibold text-gray-900 mb-3">
                        Как быстро вы доставляете букеты?
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        Мы доставляем свежие букеты по всему Брянску в день заказа. Время доставки обычно составляет 2-4 часа с момента оформления заказа.
                    </p>
                </div>

                <!-- FAQ Item 2 -->
                <div class="group p-6 bg-white border-2 border-accent-200/50 rounded-2xl hover:border-primary-300 transition-all">
                    <h3 class="font-display text-xl font-semibold text-gray-900 mb-3">
                        Можно ли заказать букет к определенному времени?
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        Да, конечно! При оформлении заказа укажите желаемое время доставки, и мы постараемся доставить букет точно в срок.
                    </p>
                </div>

                <!-- FAQ Item 3 -->
                <div class="group p-6 bg-white border-2 border-accent-200/50 rounded-2xl hover:border-primary-300 transition-all">
                    <h3 class="font-display text-xl font-semibold text-gray-900 mb-3">
                        Какие способы оплаты вы принимаете?
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        Мы принимаем оплату наличными при получении, а также банковскими картами и электронными платежами.
                    </p>
                </div>

                <!-- FAQ Item 4 -->
                <div class="group p-6 bg-white border-2 border-accent-200/50 rounded-2xl hover:border-primary-300 transition-all">
                    <h3 class="font-display text-xl font-semibold text-gray-900 mb-3">
                        Насколько свежие ваши цветы?
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        Мы работаем только со свежими цветами от проверенных поставщиков. Каждый букет собирается непосредственно перед доставкой, что гарантирует максимальную свежесть.
                    </p>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-16">
            <a href="/" class="group inline-flex items-center gap-3 px-8 py-4 border-2 border-primary-400 text-primary-700 rounded-full font-semibold hover:bg-primary-50 transition-all hover:scale-105 shadow-sm">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                <span>Вернуться на главную</span>
            </a>
        </div>

    </div>
</section>

@endsection
