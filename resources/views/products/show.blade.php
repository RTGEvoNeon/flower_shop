<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - iTulip</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .product-image-container {
            background: linear-gradient(45deg, #FFB6C1, #FFC0CB, #DDA0DD);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .product-image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="30" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/><circle cx="20" cy="20" r="10" fill="rgba(255,255,255,0.05)"/><circle cx="80" cy="30" r="15" fill="rgba(255,255,255,0.05)"/></svg>');
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            position: relative;
        }

        .product-placeholder {
            font-size: 8rem;
            color: white;
            z-index: 1;
            position: relative;
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
            }
            
            .product-info {
                padding: 2rem;
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

    <div class="container">
        <div class="product-detail">
            <div class="product-image-container">
                @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <i class="fas fa-seedling product-placeholder"></i>
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

    <script>
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
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: #28a745;
                color: white;
                padding: 1rem 2rem;
                border-radius: 25px;
                z-index: 1001;
                animation: slideDown 0.3s ease;
                box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 2500);
        }

        function toggleCart() {
            window.location.href = '/cart';
        }

        // Инициализация
        updateCartCount();

        // CSS анимации
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideDown {
                from { transform: translateX(-50%) translateY(-100%); opacity: 0; }
                to { transform: translateX(-50%) translateY(0); opacity: 1; }
            }
            
            @keyframes slideUp {
                from { transform: translateX(-50%) translateY(0); opacity: 1; }
                to { transform: translateX(-50%) translateY(-100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
