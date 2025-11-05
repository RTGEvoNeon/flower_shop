@extends('layouts.app')

@php
    // Основные мета-переменные
    $title = $pageData['title'] ?? '';
    $description = $pageData['description'] ?? '';
    $keywords = $pageData['keywords'] ?? '';
    $ogTitle = $pageData['title'] ?? '';
    $ogDescription = $pageData['description'] ?? '';
    $ogImage = $pageData['ogImage'] ?? '';

    // Подготовка JSON-LD через массив и json_encode (безопасно для Blade)
    $jsonLd = [
        "@context" => "https://schema.org",
        "@type" => "CollectionPage",
        "name" => $pageData['h1'] ?? $title,
        "description" => $pageData['description'] ?? $description,
        "url" => url()->current(),
        "breadcrumb" => [
            "@type" => "BreadcrumbList",
            "itemListElement" => [
                [
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => "Главная",
                    "item" => url('/')
                ],
                [
                    "@type" => "ListItem",
                    "position" => 2,
                    "name" => $pageData['breadcrumb'] ?? ''
                ]
            ]
        ],
        "publisher" => [
            "@type" => "LocalBusiness",
            "name" => "Mindale",
            "telephone" => "+79532929246",
            "address" => [
                "@type" => "PostalAddress",
                "addressLocality" => "Брянск",
                "addressCountry" => "RU"
            ]
        ]
    ];

    $jsonLdString = json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
@endphp

@push('seo')
<script type="application/ld+json">
{!! $jsonLdString !!}
</script>
@endpush

@section('content')
<!-- Breadcrumbs -->
<nav class="bg-gray-50 py-3 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <ol class="flex items-center space-x-2 text-sm text-gray-600" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="{{ url('/') }}" class="hover:text-pink-500 transition-colors" itemprop="item">
                    <span itemprop="name">Главная</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="text-gray-400">/</li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span class="text-gray-900 font-medium" itemprop="name">{{ $pageData['breadcrumb'] ?? '' }}</span>
                <meta itemprop="position" content="2" />
            </li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-pink-100 to-purple-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            {{ $pageData['headerTitle'] ?? '' }}
        </h1>
        <p class="text-xl text-gray-700 max-w-2xl mx-auto">
            {{ $pageData['headerSubtitle'] ?? '' }}
        </p>
    </div>
</section>

<!-- Каталог продуктов -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(isset($products) && $products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($products as $product)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300" itemscope itemtype="https://schema.org/Product">
                        <!-- Изображение -->
                        <div class="h-64 bg-gradient-to-br from-pink-200 to-purple-300 relative overflow-hidden">
                            @if(!empty($product->main_image) && $product->main_image !== '/images/placeholder.svg')
                                <img src="{{ $product->main_image }}"
                                     alt="{{ $product->alt_text ?? 'Букет ' . $product->name . ' - купить с доставкой' }}"
                                     title="{{ $product->name }}"
                                     itemprop="image"
                                     loading="lazy"
                                     width="400"
                                     height="300"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                            @endif

                            @if(!$product->is_available)
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <span class="text-white font-semibold">Нет в наличии</span>
                                </div>
                            @endif
                        </div>

                        <!-- Контент -->
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2" itemprop="name">{{ $product->name }}</h3>

                            <p class="text-gray-600 mb-4 line-clamp-2" itemprop="description">
                                {{ Str::limit($product->description, 100) }}
                            </p>

                            <div class="flex items-center justify-between mb-4">
                                <div class="text-2xl font-bold text-pink-600" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                    <meta itemprop="price" content="{{ $product->price }}">
                                    <meta itemprop="priceCurrency" content="RUB">
                                    <meta itemprop="availability" content="https://schema.org/{{ $product->is_available ? 'InStock' : 'OutOfStock' }}">
                                    {{ number_format($product->price, 0) }} ₽
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <a href="{{ route('products.show', $product->slug) }}"
                                   itemprop="url"
                                   class="flex-1 text-center px-4 py-2 border border-pink-500 text-pink-500 rounded-lg hover:bg-pink-50 transition-colors">
                                    Подробнее
                                </a>

                                @if($product->is_available)
                                    <button
                                        onclick="addToCart({{ (int) $product->id }})"
                                        class="flex-1 px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors"
                                    >
                                        В корзину
                                    </button>
                                @else
                                    <button disabled class="flex-1 px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">
                                        Недоступно
                                    </button>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Пагинация -->
            @if(method_exists($products, 'hasPages') && $products->hasPages())
                <div class="flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- Если товаров нет -->
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.264-5.364-3.11L5 9.5m14 5.5v-2.172a8 8 0 00-11.172-7.328L7 5.5"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Скоро здесь появятся букеты</h3>
                <p class="text-gray-500 mb-6">Мы работаем над наполнением этого раздела</p>
                <a href="{{ url('/') }}" class="inline-block bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-pink-600 transition-colors">
                    Вернуться на главную
                </a>
            </div>
        @endif
    </div>
</section>

<!-- SEO текстовый блок -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none">
            @php
                $intro = $pageData['seoText']['intro'] ?? '';
                $sections = $pageData['seoText']['sections'] ?? [];
            @endphp

            <p class="text-lg text-gray-700 leading-relaxed mb-8">
                {!! $intro !!}
            </p>

            @foreach($sections as $section)
                @php
                    $sectionTitle = $section['title'] ?? '';
                    $sectionContent = $section['content'] ?? '';
                @endphp

                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">{{ $sectionTitle }}</h2>
                <div class="text-gray-700 space-y-4">
                    {!! $sectionContent !!}
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA секция -->
<section class="py-16 bg-gradient-to-r from-pink-500 to-purple-600">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Не нашли то, что искали?
        </h2>
        <p class="text-xl text-pink-100 mb-8 max-w-2xl mx-auto">
            Свяжитесь с нами, и мы создадим букет специально для вас!
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+79532929246" class="bg-white text-pink-600 px-8 py-4 rounded-lg text-lg font-medium hover:bg-gray-100 transition-colors inline-block shadow-lg">
                Позвонить: +7 (953) 292-92-46
            </a>
            <a href="/custom-bouquet" class="bg-pink-700 text-white px-8 py-4 rounded-lg text-lg font-medium hover:bg-pink-800 transition-colors inline-block shadow-lg">
                Собрать свой букет
            </a>
        </div>
    </div>
</section>

<script>
// Добавление в корзину
function addToCart(productId) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cartBadge = document.querySelector('.cart-badge span');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count || 0;
            }
            showNotification('Товар добавлен в корзину!');
        } else {
            showNotification('Ошибка при добавлении товара', 'error');
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        showNotification('Ошибка при добавлении товара', 'error');
    });
}

// Уведомления
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// CSS для line-clamp
const style = document.createElement('style');
style.textContent = `
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
`;
document.head.appendChild(style);
</script>
@endsection
