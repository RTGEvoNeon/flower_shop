<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌷 iTulip - Цветочная мастерская</title>
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
            padding: 2rem 0;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            font-weight: 300;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .filters {
            background: white;
            padding: 1.5rem;
            margin: 2rem auto;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.8rem 1.5rem;
            border: 2px solid #667eea;
            background: transparent;
            color: #667eea;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn:hover, .filter-btn.active {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }

        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .product-image {
            height: 250px;
            background: linear-gradient(45deg, #FFB6C1, #FFC0CB, #DDA0DD);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .product-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="30" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/><circle cx="20" cy="20" r="10" fill="rgba(255,255,255,0.05)"/><circle cx="80" cy="30" r="15" fill="rgba(255,255,255,0.05)"/></svg>');
        }

        .product-content {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .product-description {
            color: #7f8c8d;
            line-height: 1.6;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-category {
            background: #f8f9fa;
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 500;
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            flex: 1;
            justify-content: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
            padding: 0.6rem 1rem;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
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
            .header h1 {
                font-size: 2rem;
            }
            
            .products {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }
            
            .filters {
                padding: 1rem;
            }
            
            .filter-btn {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>🌷 iTulip</h1>
            <p>Цветочная мастерская для особенных моментов</p>
        </div>
    </header>

    <div class="container">
        <div class="filters">
            <button class="filter-btn active" data-category="all">Все букеты</button>
            <button class="filter-btn" data-category="bouquets">Классические</button>
            <button class="filter-btn" data-category="wedding">Свадебные</button>
            <button class="filter-btn" data-category="seasonal">Сезонные</button>
            <button class="filter-btn" data-category="luxury">Премиум</button>
        </div>

        <div class="products">
            @forelse($products as $product)
                <div class="product-card" data-category="{{ $product->category }}">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-seedling"></i>
                        @endif
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="product-meta">
                            <div class="product-price">{{ number_format($product->price, 0) }} ₽</div>
                            <div class="product-category">{{ ucfirst($product->category) }}</div>
                        </div>

                        <div class="product-actions">
                            <a href="/product/{{ $product->id }}" class="btn btn-secondary">
                                <i class="fas fa-eye"></i> Подробнее
                            </a>
                            <button class="btn btn-primary" onclick="addToCart({{ $product->id }})">
                                <i class="fas fa-shopping-cart"></i> В корзину
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-flower"></i>
                    <h3>Пока нет доступных букетов</h3>
                    <p>Мы работаем над пополнением ассортимента</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="cart-badge" onclick="toggleCart()">
        <i class="fas fa-shopping-cart"></i>
        <div class="cart-count" id="cartCount">0</div>
    </div>

    <script>
        // Фильтрация по категориям
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // Убираем активный класс у всех кнопок
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                // Добавляем активный класс к нажатой кнопке
                btn.classList.add('active');
                
                const category = btn.getAttribute('data-category');
                const products = document.querySelectorAll('.product-card');
                
                products.forEach(product => {
                    if (category === 'all' || product.getAttribute('data-category') === category) {
                        product.style.display = 'block';
                        product.style.animation = 'fadeIn 0.5s ease';
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
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
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        function toggleCart() {
            window.location.href = '/cart';
        }

        // Инициализация
        updateCartCount();

        // CSS анимации
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes slideDown {
                from { transform: translateX(-50%) translateY(-100%); }
                to { transform: translateX(-50%) translateY(0); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
