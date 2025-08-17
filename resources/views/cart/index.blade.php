<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - iTulip</title>
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

        .cart-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2rem;
            text-align: center;
        }

        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .cart-items {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #FFB6C1, #FFC0CB, #DDA0DD);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }

        .item-image i {
            font-size: 2rem;
            color: white;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .item-price {
            font-size: 1.1rem;
            color: #667eea;
            font-weight: 500;
        }

        .item-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 25px;
            padding: 0.3rem;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border: none;
            background: transparent;
            color: #667eea;
            cursor: pointer;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: #667eea;
            color: white;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 600;
            color: #2c3e50;
        }

        .remove-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 0.8rem 1rem;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remove-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .cart-summary {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            height: fit-content;
        }

        .summary-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            border-top: 2px solid #667eea;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .checkout-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-cart i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .continue-shopping {
            background: #667eea;
            color: white;
            padding: 1rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }

        .continue-shopping:hover {
            background: #5a67d8;
            transform: translateY(-2px);
            color: white;
        }

        @media (max-width: 768px) {
            .cart-container {
                grid-template-columns: 1fr;
            }
            
            .cart-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .item-image {
                margin-right: 0;
            }
            
            .cart-title {
                font-size: 2rem;
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
                Продолжить покупки
            </a>
        </div>
    </header>

    <div class="container">
        <h1 class="cart-title">Корзина покупок</h1>

        @if(count($cartItems) > 0)
            <div class="cart-container">
                <div class="cart-items">
                    @foreach($cartItems as $item)
                        <div class="cart-item" data-product-id="{{ $item['product']->id }}">
                            <div class="item-image">
                                @if($item['product']->image)
                                    <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px;">
                                @else
                                    <i class="fas fa-seedling"></i>
                                @endif
                            </div>
                            
                            <div class="item-details">
                                <div class="item-name">{{ $item['product']->name }}</div>
                                <div class="item-price">{{ number_format($item['product']->price, 0) }} ₽ за штуку</div>
                            </div>
                            
                            <div class="item-actions">
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] - 1 }})">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="quantity-input" value="{{ $item['quantity'] }}" 
                                           onchange="updateQuantity({{ $item['product']->id }}, this.value)">
                                    <button class="quantity-btn" onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] + 1 }})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                
                                <button class="remove-btn" onclick="removeFromCart({{ $item['product']->id }})">
                                    <i class="fas fa-trash"></i>
                                    Удалить
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <div class="summary-title">Итого</div>
                    
                    <div class="summary-row">
                        <span>Товары ({{ array_sum(array_column($cartItems, 'quantity')) }} шт.)</span>
                        <span>{{ number_format($total, 0) }} ₽</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Доставка</span>
                        <span>Бесплатно</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Общая сумма</span>
                        <span id="totalAmount">{{ number_format($total, 0) }} ₽</span>
                    </div>

                    <a href="{{ route('cart.checkout') }}" class="checkout-btn">
                        <i class="fas fa-credit-card"></i>
                        Оформить заказ
                    </a>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Корзина пуста</h3>
                <p>Добавьте понравившиеся букеты в корзину</p>
                <a href="/" class="continue-shopping">
                    <i class="fas fa-arrow-left"></i>
                    Перейти к каталогу
                </a>
            </div>
        @endif
    </div>

    <script>
        // Получаем CSRF токен
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function updateQuantity(productId, newQuantity) {
            if (newQuantity < 1) {
                removeFromCart(productId);
                return;
            }

            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Перезагружаем страницу для обновления итогов
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                showNotification('Произошла ошибка при обновлении корзины', 'error');
            });
        }

        function removeFromCart(productId) {
            if (confirm('Удалить товар из корзины?')) {
                fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    showNotification('Произошла ошибка при удалении товара', 'error');
                });
            }
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: ${type === 'success' ? '#28a745' : '#dc3545'};
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
