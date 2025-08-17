<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ оформлен - iTulip</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            text-align: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 300;
            text-decoration: none;
            color: white;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 3rem 20px;
        }

        .success-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            text-align: center;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
        }

        .success-icon i {
            font-size: 3rem;
            color: white;
        }

        .success-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .success-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .order-details {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: left;
        }

        .detail-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 500;
            color: #495057;
        }

        .detail-value {
            color: #2c3e50;
        }

        .order-items {
            margin-top: 1.5rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            margin-bottom: 0.5rem;
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

        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid #667eea;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
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
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            color: white;
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

        .contact-info {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
            text-align: center;
        }

        .contact-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .contact-text {
            color: #6c757d;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .success-card {
                padding: 2rem;
            }
            
            .success-title {
                font-size: 2rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .detail-row {
                flex-direction: column;
                gap: 0.3rem;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-card {
            animation: fadeInUp 0.6s ease;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">🌷 iTulip</a>
        </div>
    </header>

    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <h1 class="success-title">Заказ успешно оформлен!</h1>
            <p class="success-subtitle">
                Спасибо за ваш заказ! Мы получили вашу заявку и свяжемся с вами в ближайшее время для подтверждения деталей доставки.
            </p>

            <div class="order-details">
                <div class="detail-title">
                    <i class="fas fa-receipt"></i>
                    Детали заказа #{{ $order->id }}
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Заказчик:</span>
                    <span class="detail-value">{{ $order->customer_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Телефон:</span>
                    <span class="detail-value">{{ $order->customer_phone }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $order->customer_email }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Адрес доставки:</span>
                    <span class="detail-value">{{ $order->delivery_address }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Дата доставки:</span>
                    <span class="detail-value">{{ $order->delivery_date->format('d.m.Y') }}</span>
                </div>
                
                @if($order->notes)
                <div class="detail-row">
                    <span class="detail-label">Комментарий:</span>
                    <span class="detail-value">{{ $order->notes }}</span>
                </div>
                @endif

                <div class="order-items">
                    <div class="detail-title" style="margin-bottom: 1rem;">
                        <i class="fas fa-list"></i>
                        Товары в заказе
                    </div>
                    
                    @foreach($order->orderItems as $item)
                        <div class="order-item">
                            <div class="item-info">
                                <div class="item-name">{{ $item->product->name }}</div>
                                <div class="item-quantity">{{ $item->quantity }} шт. × {{ number_format($item->price, 0) }} ₽</div>
                            </div>
                            <div class="item-price">{{ number_format($item->price * $item->quantity, 0) }} ₽</div>
                        </div>
                    @endforeach
                    
                    <div class="total-amount">
                        Итого: {{ number_format($order->total_amount, 0) }} ₽
                    </div>
                </div>
            </div>

            <div class="contact-info">
                <div class="contact-title">Что дальше?</div>
                <div class="contact-text">
                    Наш менеджер свяжется с вами в течение 30 минут для подтверждения заказа и уточнения деталей доставки. 
                    Если у вас есть вопросы, вы можете связаться с нами по телефону +7 (999) 123-45-67.
                </div>
            </div>

            <div class="action-buttons">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Вернуться в каталог
                </a>
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fas fa-print"></i>
                    Распечатать заказ
                </button>
            </div>
        </div>
    </div>

    <script>
        // Автоматическое сохранение информации о заказе в localStorage для отслеживания
        const orderInfo = {
            id: {{ $order->id }},
            date: '{{ $order->created_at->format('d.m.Y H:i') }}',
            total: {{ $order->total_amount }}
        };
        
        localStorage.setItem('lastOrder', JSON.stringify(orderInfo));

        // Эффект конфетти при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            // Простая анимация успеха
            setTimeout(() => {
                document.querySelector('.success-icon').style.transform = 'scale(1.1)';
                setTimeout(() => {
                    document.querySelector('.success-icon').style.transform = 'scale(1)';
                }, 200);
            }, 300);
        });
    </script>
</body>
</html>
