@extends('layouts.app')

@section('content')
<!-- Hero Section для каталога -->
<section class="bg-gradient-to-r from-pink-100 to-purple-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            Каталог букетов
        </h1>
        <p class="text-xl text-gray-700 max-w-2xl mx-auto">
            Выберите идеальный букет для особенного момента
        </p>
    </div>
</section>

<!-- Фильтры -->
<section class="py-8 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4">
            <button class="filter-btn active px-6 py-3 border-2 border-pink-500 text-pink-500 rounded-full hover:bg-pink-500 hover:text-white transition-all" data-category="all">
                Все букеты
            </button>
            <button class="filter-btn px-6 py-3 border-2 border-pink-500 text-pink-500 rounded-full hover:bg-pink-500 hover:text-white transition-all" data-category="bouquets">
                Классические
            </button>
            <button class="filter-btn px-6 py-3 border-2 border-pink-500 text-pink-500 rounded-full hover:bg-pink-500 hover:text-white transition-all" data-category="wedding">
                Свадебные
            </button>
            <button class="filter-btn px-6 py-3 border-2 border-pink-500 text-pink-500 rounded-full hover:bg-pink-500 hover:text-white transition-all" data-category="seasonal">
                Сезонные
            </button>
            <button class="filter-btn px-6 py-3 border-2 border-pink-500 text-pink-500 rounded-full hover:bg-pink-500 hover:text-white transition-all" data-category="luxury">
                Премиум
            </button>
        </div>
    </div>
</section>

<!-- Каталог продуктов -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="products-grid">
            @forelse($products as $product)
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300" data-category="{{ $product->category }}">
                    <!-- Изображение -->
                    <div class="h-64 bg-gradient-to-br from-pink-200 to-purple-300 relative overflow-hidden">
                        @if($product->main_image)
                            <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-xl font-semibold text-gray-900 flex-1">{{ $product->name }}</h3>
                            <span class="bg-pink-100 text-pink-800 text-xs font-medium px-2.5 py-0.5 rounded-full ml-2">
                                {{ ucfirst($product->category) }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4 line-clamp-2">
                            {{ Str::limit($product->description, 100) }}
                        </p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-2xl font-bold text-pink-600">
                                {{ number_format($product->price, 0) }} ₽
                            </div>
                            
                            @if($product->images_count > 0)
                                <div class="text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $product->images_count }} фото
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex gap-3">
                            <a href="/product/{{ $product->id }}" class="flex-1 text-center px-4 py-2 border border-pink-500 text-pink-500 rounded-lg hover:bg-pink-50 transition-colors">
                                Подробнее
                            </a>
                            
                            @if($product->is_available)
                                <button 
                                    onclick="addToCart({{ $product->id }})" 
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
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.264-5.364-3.11L5 9.5m14 5.5v-2.172a8 8 0 00-11.172-7.328L7 5.5"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Букеты не найдены</h3>
                    <p class="text-gray-500">Попробуйте изменить фильтры или вернитесь позже</p>
                </div>
            @endforelse
        </div>
        
        @if($products->count() > 0)
            <!-- Пагинация -->
            <div class="mt-12 flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</section>

<script>
// Фильтрация продуктов
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // Обновляем активную кнопку
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active', 'bg-pink-500', 'text-white');
            b.classList.add('text-pink-500');
        });
        btn.classList.add('active', 'bg-pink-500', 'text-white');
        btn.classList.remove('text-pink-500');
        
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
            // Обновляем счетчик корзины в header
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

// CSS для анимаций
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
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
