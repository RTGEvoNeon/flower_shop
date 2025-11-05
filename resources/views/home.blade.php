@extends('layouts.app')

@php
    $title = 'Доставка цветов в Брянске | Mindale — купить свежие букеты с доставкой';
    $description = 'Доставка цветов в Брянске — Mindale. Свежие букеты роз, пионов, хризантем с доставкой по городу. Заказать цветы на день рождения, 8 марта, свадьбу. Цены от 2000₽. Звоните: +7 (953) 292-92-46';
    $keywords = 'доставка цветов Брянск, купить цветы Брянск, заказать букет Брянск, доставка цветов Брянск недорого, цветы с доставкой Брянск, букеты Брянск, розы Брянск, пионы Брянск';
    $ogTitle = 'Доставка цветов в Брянске | Mindale';
    $ogDescription = 'Свежие цветы и букеты с доставкой по Брянску. Розы, пионы, хризантемы на любой повод. От 2000₽';
    $ogImage = asset('images/og-default.jpg');
    $jsonOptions = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT;
    $jsonData = [
        "@context" => "https://schema.org",
        "@type" => "LocalBusiness",
        "name" => "Mindale",
        "description" => "Доставка свежих цветов и букетов по Брянску",
        "url" => url('/'),
        "telephone" => "+79532929246",
        "priceRange" => "₽₽",
        "address" => [
            "@type" => "PostalAddress",
            "addressLocality" => "Брянск",
            "addressCountry" => "RU",
        ],
        "geo" => [
            "@type" => "GeoCoordinates",
            "latitude" => "53.243562",
            "longitude" => "34.363407",
        ],
        "openingHours" => "Mo-Su 09:00-21:00",
        "image" => $ogImage,
        "acceptsReservations" => false,
        "areaServed" => [
            "@type" => "City",
            "name" => "Брянск"
        ]
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($jsonData, $jsonOptions) !!}
</script>




@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-b from-pink-50 to-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl md:text-7xl font-bold text-gray-900 mb-6">
            Доставка свежих цветов в Брянске
        </h1>
        <p class="text-xl md:text-2xl text-gray-700 mb-8 max-w-4xl mx-auto leading-relaxed">
            и каждый наш букет — это наше искреннее послание, созданное для того, чтобы принести вам радость, уют и особенные воспоминания.
        </p>
        <div class="flex justify-center">
            <a href="#catalog" class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-4 rounded-lg text-lg font-medium transition-colors">
                Найти букет
            </a>
        </div>
    </div>
</section>

<!-- Quick Info -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Быстрая доставка</h3>
                <p class="text-gray-600">Доставляем свежие букеты по всему городу в день заказа</p>
            </div>
            
            <div class="p-6">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Свежие цветы</h3>
                <p class="text-gray-600">Работаем только со свежими цветами от проверенных поставщиков</p>
            </div>
            
            <div class="p-6">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Доступные цены</h3>
                <p class="text-gray-600">Цены на букеты начинаются от <b>2 000 ₽</b></p>
            </div>
        </div>
    </div>
</section>

<!-- Популярные букеты -->
<section id="catalog" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
            Букеты, которые заказывают чаще всего!
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $featuredProducts = \App\Models\Product::available()
                    ->withImages()
                    ->inRandomOrder()
                    ->limit(6)
                    ->get();
            @endphp
            
            @forelse($featuredProducts as $product)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow" itemscope itemtype="https://schema.org/Product">
                    <div class="h-64 bg-gradient-to-br from-pink-200 to-pink-300 flex items-center justify-center overflow-hidden">
                        @if($product->main_image && $product->main_image !== '/images/placeholder.jpg')
                            <img src="{{ $product->main_image }}"
                                 alt="{{ $product->alt_text ?? 'Букет ' . $product->name . ' - купить с доставкой' }}"
                                 title="{{ $product->name }}"
                                 itemprop="image"
                                 loading="lazy"
                                 width="400"
                                 height="300"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <span class="text-gray-600">🌹</span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2" itemprop="name">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-4" itemprop="description">{{ Str::limit($product->description, 60) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-pink-500" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                <meta itemprop="price" content="{{ $product->price }}">
                                <meta itemprop="priceCurrency" content="RUB">
                                {{ number_format($product->price, 0) }} ₽
                            </span>
                            <a href="{{ route('products.show', $product->slug) }}"
                               itemprop="url"
                               class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg transition-colors">
                                Смотреть
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <!-- Fallback карточки если нет продуктов -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-64 bg-gradient-to-br from-pink-200 to-pink-300 flex items-center justify-center">
                        <span class="text-gray-600">🌹</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Скоро здесь будут букеты!</h3>
                        <p class="text-gray-600 mb-4">Мы работаем над наполнением каталога</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-pink-500">от 2 000 ₽</span>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" class="border border-pink-500 text-pink-500 hover:bg-pink-500 hover:text-white px-8 py-3 rounded-lg transition-colors inline-block">
                Смотреть все букеты
            </a>
        </div>
    </div>
</section>

<!-- Call to Action для кастомного букета -->
<section class="py-16 bg-gradient-to-r from-pink-500 to-purple-600">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Не нашли идеальный букет?
        </h2>
        <p class="text-xl text-pink-100 mb-8 max-w-2xl mx-auto">
            Создайте уникальный букет вместе с нашим флористом. Расскажите о ваших пожеланиях, и мы воплотим их в жизнь!
        </p>
        <a href="/custom-bouquet" class="bg-white text-pink-600 px-8 py-4 rounded-lg text-lg font-medium hover:bg-gray-100 transition-colors inline-block shadow-lg">
            Собрать свой букет
        </a>
    </div>
</section>

<!-- Карта -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Мы находимся в Брянске</h2>
        <div class="relative rounded-lg overflow-hidden shadow-lg" style="height: 600px;">
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A44c15fbbc06a1918b30ef4008bef6dfc6e94b209ee5468ed2444ae0f343d7c39&amp;width=100%25&amp;height=600&amp;lang=ru_RU&amp;scroll=true"></script>
        </div>
    </div>
</section>

<!-- Популярные категории -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">Популярные категории</h2>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
            Выберите букет по типу цветов, поводу или стилю оформления
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Розы -->
            <a href="{{ route('category.roses') }}" class="group block bg-gradient-to-br from-red-50 to-pink-50 rounded-lg p-6 hover:shadow-lg transition-all">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-red-200 transition-colors">
                        <span class="text-2xl">🌹</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-pink-600 transition-colors">Розы</h3>
                </div>
                <p class="text-gray-600">Классические букеты из свежих роз для особенных моментов</p>
            </a>

            <!-- День рождения -->
            <a href="{{ route('category.birthday') }}" class="group block bg-gradient-to-br from-yellow-50 to-orange-50 rounded-lg p-6 hover:shadow-lg transition-all">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-yellow-200 transition-colors">
                        <span class="text-2xl">🎂</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors">День рождения</h3>
                </div>
                <p class="text-gray-600">Яркие композиции для самого важного праздника</p>
            </a>

            <!-- 8 марта -->
            <a href="{{ route('category.march8') }}" class="group block bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-6 hover:shadow-lg transition-all">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-purple-200 transition-colors">
                        <span class="text-2xl">🌷</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors">8 марта</h3>
                </div>
                <p class="text-gray-600">Весенние букеты для самых прекрасных женщин</p>
            </a>

            <!-- Недорогие букеты -->
            <a href="{{ route('category.affordable') }}" class="group block bg-gradient-to-br from-green-50 to-teal-50 rounded-lg p-6 hover:shadow-lg transition-all">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-green-200 transition-colors">
                        <span class="text-2xl">💐</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">Недорогие букеты</h3>
                </div>
                <p class="text-gray-600">Доступные цены без компромиссов по качеству</p>
            </a>

            <!-- Пионы -->
            <a href="{{ route('category.peonies') }}" class="group block bg-gradient-to-br from-pink-50 to-rose-50 rounded-lg p-6 hover:shadow-lg transition-all">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-pink-200 transition-colors">
                        <span class="text-2xl">🌺</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-rose-600 transition-colors">Пионы</h3>
                </div>
                <p class="text-gray-600">Роскошные пионы — символ романтики и нежности</p>
            </a>

            <!-- Свадебные -->
            <a href="{{ route('category.wedding') }}" class="group block bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-6 hover:shadow-lg transition-all">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                        <span class="text-2xl">👰</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Свадебные букеты</h3>
                </div>
                <p class="text-gray-600">Создадим букет мечты для вашего особенного дня</p>
            </a>
        </div>

        <!-- Дополнительные категории в виде ссылок -->
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('category.chrysanthemums') }}" class="px-4 py-2 bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-600 rounded-full transition-colors text-sm font-medium">
                Хризантемы
            </a>
            <a href="{{ route('category.kraft') }}" class="px-4 py-2 bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-600 rounded-full transition-colors text-sm font-medium">
                Букеты в крафте
            </a>
            <a href="{{ route('category.compositions') }}" class="px-4 py-2 bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-600 rounded-full transition-colors text-sm font-medium">
                Композиции из цветов
            </a>
        </div>
    </div>
</section>

<!-- SEO текстовый блок -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Доставка цветов в Брянске</h2>
        <div class="prose prose-lg max-w-none text-gray-700 space-y-4">
            <p>
                <strong>Mindale</strong> — это современный сервис доставки цветов в Брянске, который работает для того,
                чтобы ваши близкие получали самые свежие и красивые букеты. Мы предлагаем широкий выбор композиций
                из <a href="{{ route('category.roses') }}" class="text-pink-500 hover:text-pink-600 font-medium">роз</a>,
                <a href="{{ route('category.peonies') }}" class="text-pink-500 hover:text-pink-600 font-medium">пионов</a>,
                <a href="{{ route('category.chrysanthemums') }}" class="text-pink-500 hover:text-pink-600 font-medium">хризантем</a>
                и других цветов на любой повод.
            </p>
            <h3 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Почему выбирают Mindale?</h3>
            <ul class="list-disc list-inside space-y-2">
                <li><strong>Свежие цветы</strong> — работаем только с проверенными поставщиками</li>
                <li><strong>Быстрая доставка</strong> — доставляем букеты по Брянску в день заказа</li>
                <li><strong>Доступные цены</strong> — <a href="{{ route('category.affordable') }}" class="text-pink-500 hover:text-pink-600 font-medium">недорогие букеты</a> от 2000 рублей</li>
                <li><strong>Индивидуальный подход</strong> — поможем подобрать букет под любой повод</li>
            </ul>
            <h3 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Цветы на любой повод</h3>
            <p>
                Мы создаем букеты для самых разных событий:
                <a href="{{ route('category.birthday') }}" class="text-pink-500 hover:text-pink-600 font-medium">день рождения</a>,
                <a href="{{ route('category.march8') }}" class="text-pink-500 hover:text-pink-600 font-medium">8 марта</a>,
                <a href="{{ route('category.wedding') }}" class="text-pink-500 hover:text-pink-600 font-medium">свадьба</a>,
                годовщина, День святого Валентина или просто так, чтобы порадовать близкого человека.
                Каждый букет создается с любовью и вниманием к деталям нашими опытными флористами.
            </p>
            <p>
                Закажите доставку цветов в Брянске прямо сейчас по телефону <a href="tel:+79532929246" class="text-pink-500 font-semibold">+7 (953) 292-92-46</a>
                или через форму на сайте. Мы работаем ежедневно с 9:00 до 21:00.
            </p>
        </div>
    </div>
</section>

@endsection
