<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? 'Mindale - Доставка букетов цветов' }}</title>
    <meta name="description" content="{{ $description ?? 'Доставка свежих букетов цветов в день заказа. Широкий выбор композиций от 2000₽. Быстрая доставка, свежие цветы, доступные цены.' }}">
    <meta name="keywords" content="{{ $keywords ?? 'букеты, цветы, доставка цветов, купить букет, цветы с доставкой' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $ogTitle ?? $title ?? 'Mindale - Доставка букетов цветов' }}">
    <meta property="og:description" content="{{ $ogDescription ?? $description ?? 'Доставка свежих букетов цветов в день заказа' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/og-default.jpg') }}">
    <meta property="og:site_name" content="Mindale">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $ogTitle ?? $title ?? 'Mindale - Доставка букетов цветов' }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? $description ?? 'Доставка свежих букетов цветов' }}">
    <meta name="twitter:image" content="{{ $ogImage ?? asset('images/og-default.jpg') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional SEO Tags -->
    @stack('seo')
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=104177625', 'ym');

        ym(104177625, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/104177625" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>
<body class="min-h-screen bg-white text-gray-900 font-inter">
    <!-- Header Navigation -->
    <header class="border-b border-gray-100">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="text-3xl font-bold text-gray-900">
                        <span class="text-pink-500">Mindale</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-gray-900 transition-colors">Главная</a>
                    <!-- <a href="/products" class="text-gray-700 hover:text-gray-900 transition-colors">Каталог</a> -->
                    <a href="/custom-bouquet" class="text-gray-700 hover:text-gray-900 transition-colors">Собери свой букет</a>
                    <!-- <a href="/seasonal" class="text-gray-700 hover:text-gray-900 transition-colors">Сейчас сезон</a>
                    <a href="/care" class="text-gray-700 hover:text-gray-900 transition-colors">Уход</a>
                    <a href="/delivery" class="text-gray-700 hover:text-gray-900 transition-colors">Доставка</a> -->
                </div>

                <div class="text-gray-700 hover:text-gray-900 transition-colors">
                    <a href="tel:+79532929246"><b>8 (953) 292-92-46</b></a>
                </div>
                
                <!-- Cart & Mobile menu -->
                <div class="flex items-center space-x-4">
                    <!-- Cart -->
                    <!-- <a href="/cart" class="relative p-2 text-gray-700 hover:text-gray-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6.5M7 13l-1.5-6.5m0 0h13M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a> -->
                    
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
