@php
    $ogDefaultImage = asset('images/og-default.jpg');
@endphp

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? $product->name . ' - Купить букет | Mindale' }}</title>
    <meta name="description" content="{{ $description ?? mb_substr(strip_tags($product->description), 0, 155) }}">
    <meta name="keywords" content="{{ $keywords ?? $product->name . ', купить букет, доставка цветов' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ route('products.show', $product->slug) }}">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ mb_substr(strip_tags($product->description), 0, 155) }}">
    <meta property="og:image" content="{{ $product->main_image && $product->main_image !== '/images/placeholder.svg' ? url($product->main_image) : $ogDefaultImage }}">
    <meta property="og:site_name" content="Mindale">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->name }}">
    <meta name="twitter:description" content="{{ mb_substr(strip_tags($product->description), 0, 155) }}">
    <meta name="twitter:image" content="{{ $product->main_image && $product->main_image !== '/images/placeholder.svg' ? url($product->main_image) : $ogDefaultImage }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ route('products.show', $product->slug) }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/css/product-animations.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Product",
        "name": {{ json_encode($product->name) }},
        "description": {{ json_encode(strip_tags($product->description)) }},
        @if($product->main_image && $product->main_image !== '/images/placeholder.svg')
        "image": {{ json_encode(url($product->main_image)) }},
        @endif
        "sku": "{{ $product->id }}",
        "offers": {
            "@@type": "Offer",
            "url": {{ json_encode(route('products.show', $product->slug)) }},
            "priceCurrency": "RUB",
            "price": "{{ $product->price }}",
            "availability": "{{ $product->is_available ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
            "priceValidUntil": "{{ now()->addYear()->format('Y-m-d') }}"
        }
    }
    </script>

    <!-- Breadcrumbs Schema -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@@type": "ListItem",
                "position": 1,
                "name": "Главная",
                "item": {{ json_encode(url('/')) }}
            },
            {
                "@@type": "ListItem",
                "position": 2,
                "name": {{ json_encode($product->name) }}
            }
        ]
    }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 300;
            text-decoration: none;
            color: white;
        }

        .back-btn {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 0.8rem 1.5rem;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        /* Breadcrumbs */
        .breadcrumbs {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 20px 0;
            font-size: 0.9rem;
        }

        .breadcrumbs-list {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .breadcrumbs-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .breadcrumbs-list a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumbs-list a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .breadcrumbs-list .current {
            color: #6c757d;
        }

        .breadcrumbs-separator {
            color: #adb5bd;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 20px;
        }

        .product-detail {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 600px;
        }

        .product-gallery {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            position: relative;
        }

        .main-image-container {
            position: relative;
            background: linear-gradient(45deg, #FFB6C1, #FFC0CB, #DDA0DD);
            border-radius: 20px;
            overflow: hidden;
            aspect-ratio: 4/3;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .main-image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="30" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/><circle cx="20" cy="20" r="10" fill="rgba(255,255,255,0.05)"/><circle cx="80" cy="30" r="15" fill="rgba(255,255,255,0.05)"/></svg>');
            z-index: 1;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: relative;
            z-index: 2;
            transition: transform 0.3s ease;
            cursor: zoom-in;
        }

        .main-image:hover {
            transform: scale(1.05);
        }

        .product-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4rem;
            color: white;
            z-index: 2;
        }

        .image-counter {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            z-index: 3;
        }

        .gallery-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.9);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            color: #667eea;
            transition: all 0.3s ease;
            z-index: 3;
            opacity: 0;
        }

        .main-image-container:hover .gallery-nav {
            opacity: 1;
        }

        .gallery-nav:hover {
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transform: translateY(-50%) scale(1.1);
        }

        .gallery-nav.prev {
            left: 15px;
        }

        .gallery-nav.next {
            right: 15px;
        }

        .thumbnails-container {
            display: flex;
            gap: 0.8rem;
            overflow-x: auto;
            padding: 0.5rem 0;
            scrollbar-width: thin;
            scrollbar-color: #667eea #f1f1f1;
        }

        .thumbnails-container::-webkit-scrollbar {
            height: 6px;
        }

        .thumbnails-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .thumbnails-container::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 3px;
        }

        .thumbnail {
            min-width: 80px;
            height: 80px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid transparent;
            position: relative;
        }

        .thumbnail:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .thumbnail.active {
            border-color: #667eea;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #FFB6C1, #FFC0CB);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .zoom-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            cursor: zoom-out;
        }

        .zoom-image {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 10px;
        }

        .product-info {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-category-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-block;
            width: fit-content;
            margin-bottom: 1rem;
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .product-price {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
        }

        .product-description {
            color: #7f8c8d;
            line-height: 1.8;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .product-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 1rem;
            flex: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        .product-features {
            border-top: 1px solid #ecf0f1;
            padding-top: 2rem;
        }

        .features-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .features-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #7f8c8d;
        }

        .feature-icon {
            color: #667eea;
            width: 20px;
        }

        .cart-badge {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1rem;
            border-radius: 50%;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .cart-badge:hover {
            transform: scale(1.1);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .product-detail {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .product-gallery {
                order: 1;
            }
            
            .product-info {
                padding: 2rem;
                order: 2;
            }
            
            .product-title {
                font-size: 2rem;
            }
            
            .product-price {
                font-size: 2.5rem;
            }
            
            .features-list {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            /* Галерея на мобильных */
            .main-image-container {
                aspect-ratio: 1/1;
                margin-bottom: 1rem;
            }
            
            .gallery-nav {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .gallery-nav.prev {
                left: 10px;
            }
            
            .gallery-nav.next {
                right: 10px;
            }
            
            .thumbnails-container {
                gap: 0.5rem;
                padding: 0.3rem 0;
                justify-content: center;
            }
            
            .thumbnail {
                min-width: 60px;
                height: 60px;
                border-radius: 8px;
            }
            
            .image-counter {
                top: 10px;
                right: 10px;
                padding: 0.3rem 0.8rem;
                font-size: 0.8rem;
            }

            /* Zoom на мобильных */
            .zoom-image {
                max-width: 95%;
                max-height: 95%;
            }

            /* Улучшение UX для сенсорных экранов */
            .main-image-container:hover .gallery-nav {
                opacity: 1; /* Всегда показываем на мобильных */
            }
            
            .thumbnail:hover {
                transform: none; /* Убираем hover эффекты на мобильных */
            }
            
            .thumbnail:active {
                transform: scale(0.95);
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 1rem 10px;
            }
            
            .product-info {
                padding: 1.5rem;
            }
            
            .thumbnails-container {
                overflow-x: auto;
                justify-content: flex-start;
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .thumbnail {
                min-width: 50px;
                height: 50px;
                flex-shrink: 0;
            }
            
            .product-actions {
                flex-direction: column;
                gap: 0.8rem;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">🌷 iTulip</a>
            <a href="/" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Вернуться к каталогу
            </a>
        </div>
    </header>

    <!-- Breadcrumbs -->
    <nav class="breadcrumbs" aria-label="breadcrumb">
        <ol class="breadcrumbs-list" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="/">
                    <span itemprop="name">Главная</span>
                </a>
                <meta itemprop="position" content="1" />
                <span class="breadcrumbs-separator">/</span>
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name" class="current">{{ $product->name }}</span>
                <meta itemprop="position" content="2" />
            </li>
        </ol>
    </nav>

    <div class="container">
        <div class="product-detail">
            <div class="product-gallery">
                <div class="main-image-container">
                    <!-- Счетчик изображений -->
                    @if(count($product->image_urls) > 1)
                        <div class="image-counter">
                            <span id="current-image">1</span> / {{ count($product->image_urls) }}
                        </div>
                    @endif

                    <!-- Кнопки навигации -->
                    @if(count($product->image_urls) > 1)
                        <button class="gallery-nav prev" onclick="changeImage(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="gallery-nav next" onclick="changeImage(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    @endif

                    <!-- Главное изображение -->
                    @if($product->has_images)
                        <img src="{{ $product->main_image }}"
                             alt="{{ $product->alt_text ?? 'Букет цветов ' . $product->name . ' - купить с доставкой' }}"
                             title="{{ $product->name }}"
                             class="main-image"
                             id="main-image"
                             loading="eager"
                             width="800"
                             height="600"
                             onclick="openZoom(this.src)">
                    @else
                        <i class="fas fa-seedling product-placeholder"></i>
                    @endif
                </div>

                <!-- Миниатюры -->
                @if(count($product->image_urls) > 1)
                    <div class="thumbnails-container">
                        @foreach($product->image_urls as $index => $imageUrl)
                            @php
                                $altText = $product->alt_text ?? ($product->name . ' фото');
                                $thumbAlt = $altText . ' ' . ($index + 1);
                            @endphp
                            <div class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                 data-url="{{ $imageUrl }}"
                                 data-alt="{{ $altText }}"
                                 data-index="{{ $index }}"
                                 onclick="setMainImage(this.dataset.url, this.dataset.alt, this.dataset.index)">
                                <img src="{{ $imageUrl }}"
                                     alt="{{ $thumbAlt }}"
                                     loading="lazy"
                                     width="150"
                                     height="150">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <div class="product-info">
                <div class="product-category-badge">{{ ucfirst($product->category) }}</div>
                
                <h1 class="product-title">{{ $product->name }}</h1>
                
                <div class="product-price">{{ number_format($product->price, 0) }} ₽</div>
                
                <div class="product-description">
                    {{ $product->description ?: 'Красивый букет, созданный с любовью нашими флористами. Идеально подходит для особенных моментов и выражения ваших чувств.' }}
                </div>

                <div class="product-actions">
                    <button class="btn btn-primary" onclick="addToCart({{ $product->id }})">
                        <i class="fas fa-shopping-cart"></i>
                        Добавить в корзину
                    </button>
                    <button class="btn btn-secondary" onclick="buyNow({{ $product->id }})">
                        <i class="fas fa-bolt"></i>
                        Купить сейчас
                    </button>
                </div>

                <div class="product-features">
                    <div class="features-title">Особенности букета</div>
                    <div class="features-list">
                        <div class="feature-item">
                            <i class="fas fa-leaf feature-icon"></i>
                            <span>Свежие цветы</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-truck feature-icon"></i>
                            <span>Доставка по городу</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-gift feature-icon"></i>
                            <span>Красивая упаковка</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-heart feature-icon"></i>
                            <span>Сделано с любовью</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-badge" onclick="toggleCart()">
        <i class="fas fa-shopping-cart"></i>
        <div class="cart-count" id="cartCount">0</div>
    </div>

    <!-- Zoom overlay -->
    <div class="zoom-overlay" id="zoom-overlay" onclick="closeZoom()">
        <img src="" alt="Zoom" class="zoom-image" id="zoom-image">
    </div>

    <script>
        // Галерея изображений
        const images = @json($product->image_urls);
        const imageAlts = @json(array_fill(0, count($product->image_urls), $product->alt_text ?? $product->name));
        let currentImageIndex = 0;

        // Функция переключения изображения
        function setMainImage(src, alt, index) {
            const mainImage = document.getElementById('main-image');
            const currentCounter = document.getElementById('current-image');

            // Преобразуем index в число
            index = parseInt(index);

            // Обновляем главное изображение
            mainImage.src = src;
            mainImage.alt = alt;

            // Обновляем счетчик
            if (currentCounter) {
                currentCounter.textContent = index + 1;
            }

            // Обновляем активную миниатюру
            document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });

            currentImageIndex = index;
        }

        // Функция навигации (стрелки)
        function changeImage(direction) {
            if (images.length === 0) return;
            
            currentImageIndex += direction;
            
            // Циклическая навигация
            if (currentImageIndex >= images.length) {
                currentImageIndex = 0;
            } else if (currentImageIndex < 0) {
                currentImageIndex = images.length - 1;
            }
            
            setMainImage(images[currentImageIndex], imageAlts[currentImageIndex], currentImageIndex);
        }

        // Функция открытия zoom
        function openZoom(src) {
            const overlay = document.getElementById('zoom-overlay');
            const zoomImage = document.getElementById('zoom-image');
            
            zoomImage.src = src;
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // Функция закрытия zoom
        function closeZoom() {
            const overlay = document.getElementById('zoom-overlay');
            overlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Клавиатурная навигация
        document.addEventListener('keydown', function(e) {
            if (images.length === 0) return;
            
            switch(e.key) {
                case 'ArrowLeft':
                    changeImage(-1);
                    break;
                case 'ArrowRight':
                    changeImage(1);
                    break;
                case 'Escape':
                    closeZoom();
                    break;
            }
        });

        // Свайп для мобильных устройств
        let startX = null;
        const mainImageContainer = document.querySelector('.main-image-container');
        
        mainImageContainer.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
        });
        
        mainImageContainer.addEventListener('touchend', function(e) {
            if (!startX) return;
            
            const endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;
            
            if (Math.abs(diffX) > 50) { // Минимальное расстояние свайпа
                if (diffX > 0) {
                    changeImage(1); // Свайп влево - следующее изображение
                } else {
                    changeImage(-1); // Свайп вправо - предыдущее изображение
                }
            }
            
            startX = null;
        });

        // Корзина (временно в локальном хранилище)
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        function updateCartCount() {
            const cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cartCount').textContent = cartCount;
        }

        function addToCart(productId) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cartCount').textContent = data.cart_count || 0;
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

        function buyNow(productId) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/checkout';
                } else {
                    showNotification('Ошибка при добавлении товара', 'error');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                showNotification('Ошибка при добавлении товара', 'error');
            });
        }

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('hiding');
                setTimeout(() => notification.remove(), 300);
            }, 2500);
        }

        function toggleCart() {
            window.location.href = '/cart';
        }

        // Инициализация
        updateCartCount();
    </script>
</body>
</html>
