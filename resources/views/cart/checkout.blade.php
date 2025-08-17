<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - iTulip</title>
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

        .checkout-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2rem;
            text-align: center;
        }

        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        .checkout-form {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e1e8ed;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e1e8ed;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .order-summary {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            height: fit-content;
        }

        .summary-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item:last-of-type {
            border-bottom: 2px solid #667eea;
            margin-bottom: 1rem;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 0.3rem;
        }

        .item-quantity {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .item-price {
            font-weight: 600;
            color: #667eea;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 1.2rem 2rem;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .required {
            color: #e74c3c;
        }

        @media (max-width: 768px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
            
            .checkout-title {
                font-size: 2rem;
            }
            
            .checkout-form,
            .order-summary {
                padding: 1.5rem;
            }
        }

        .loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">🌷 iTulip</a>
            <a href="/cart" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Вернуться в корзину
            </a>
        </div>
    </header>

    <div class="container">
        <h1 class="checkout-title">Оформление заказа</h1>

        <div class="checkout-container">
            <form class="checkout-form" method="POST" action="{{ route('order.place') }}" id="checkoutForm">
                @csrf
                
                <div class="form-title">
                    <i class="fas fa-user"></i>
                    Контактная информация
                </div>

                <div class="form-group">
                    <label for="customer_name" class="form-label">Имя и фамилия <span class="required">*</span></label>
                    <input type="text" id="customer_name" name="customer_name" class="form-input" 
                           value="{{ old('customer_name') }}" required>
                    @error('customer_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="customer_phone" class="form-label">Телефон <span class="required">*</span></label>
                    <input type="tel" id="customer_phone" name="customer_phone" class="form-input" 
                           value="{{ old('customer_phone') }}" placeholder="+7 (999) 123-45-67" required>
                    @error('customer_phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="customer_email" class="form-label">Email <span class="required">*</span></label>
                    <input type="email" id="customer_email" name="customer_email" class="form-input" 
                           value="{{ old('customer_email') }}" placeholder="example@mail.ru" required>
                    @error('customer_email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-title" style="margin-top: 2rem;">
                    <i class="fas fa-truck"></i>
                    Доставка
                </div>

                <div class="form-group">
                    <label for="delivery_address" class="form-label">Адрес доставки <span class="required">*</span></label>
                    <input type="text" id="delivery_address" name="delivery_address" class="form-input" 
                           value="{{ old('delivery_address') }}" placeholder="ул. Примерная, д. 1, кв. 1" required>
                    @error('delivery_address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="delivery_date" class="form-label">Дата доставки <span class="required">*</span></label>
                    <input type="date" id="delivery_date" name="delivery_date" class="form-input" 
                           value="{{ old('delivery_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    @error('delivery_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Комментарий к заказу</label>
                    <textarea id="notes" name="notes" class="form-textarea" 
                              placeholder="Особые пожелания, время доставки и др.">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    <span id="submitText">Оформить заказ</span>
                    <div class="loading" id="loading"></div>
                </button>
            </form>

            <div class="order-summary">
                <div class="summary-title">
                    <i class="fas fa-receipt"></i>
                    Ваш заказ
                </div>

                @foreach($cartItems as $item)
                    <div class="order-item">
                        <div class="item-info">
                            <div class="item-name">{{ $item['product']->name }}</div>
                            <div class="item-quantity">{{ $item['quantity'] }} шт. × {{ number_format($item['product']->price, 0) }} ₽</div>
                        </div>
                        <div class="item-price">{{ number_format($item['subtotal'], 0) }} ₽</div>
                    </div>
                @endforeach

                <div class="order-item">
                    <div class="item-info">
                        <div class="item-name">Доставка</div>
                        <div class="item-quantity">Бесплатная доставка по городу</div>
                    </div>
                    <div class="item-price">0 ₽</div>
                </div>

                <div class="order-total">
                    <span>Итого к оплате:</span>
                    <span>{{ number_format($total, 0) }} ₽</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Установка минимальной даты доставки (завтра)
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const minDate = tomorrow.toISOString().split('T')[0];
            document.getElementById('delivery_date').setAttribute('min', minDate);

            // Маска для телефона
            const phoneInput = document.getElementById('customer_phone');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                let formattedValue = '';
                
                if (value.length > 0) {
                    if (value[0] === '8') {
                        value = '7' + value.slice(1);
                    }
                    if (value[0] === '7') {
                        formattedValue = '+7';
                        if (value.length > 1) {
                            formattedValue += ' (' + value.slice(1, 4);
                        }
                        if (value.length >= 4) {
                            formattedValue += ') ' + value.slice(4, 7);
                        }
                        if (value.length >= 7) {
                            formattedValue += '-' + value.slice(7, 9);
                        }
                        if (value.length >= 9) {
                            formattedValue += '-' + value.slice(9, 11);
                        }
                    }
                }
                
                e.target.value = formattedValue;
            });

            // Обработка отправки формы
            const form = document.getElementById('checkoutForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loading = document.getElementById('loading');

            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitText.textContent = 'Обрабатываем заказ...';
                loading.style.display = 'block';
            });
        });

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
            }, 3000);
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

        // Показываем сообщения об ошибках/успехе из Laravel
        @if(session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif

        @if(session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif
    </script>
</body>
</html>
