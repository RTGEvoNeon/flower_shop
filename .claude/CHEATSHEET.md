# Шпаргалка по проекту Mindale

## Быстрый старт

### Запуск проекта
```bash
# Все сервисы сразу
composer dev

# Или по отдельности
php artisan serve          # Laravel сервер
npm run dev                # Vite dev server
php artisan queue:listen   # Очередь
```

### Очистка кеша
```bash
php artisan view:clear config:clear route:clear
```

## Создание нового функционала

### 1. Модель + миграция + контроллер
```bash
php artisan make:model Product -mc
php artisan make:request StoreProductRequest
php artisan make:request UpdateProductRequest
```

### 2. В миграции
```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->boolean('is_available')->default(true);
    $table->timestamps();

    // SEO поля
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();

    // Индексы
    $table->index('slug');
});
```

### 3. В модели
```php
protected $fillable = ['name', 'slug', 'description', 'price'];

protected $casts = [
    'price' => 'decimal:2',
    'is_available' => 'boolean',
];

// Scope
public function scopeAvailable(Builder $query): Builder
{
    return $query->where('is_available', true);
}
```

### 4. В контроллере
```php
public function index()
{
    $products = Product::available()->withImages()->paginate(12);
    return view('products.index', compact('products'));
}

public function store(StoreProductRequest $request): RedirectResponse
{
    $product = Product::create($request->validated());
    return redirect()->route('products.show', $product)
        ->with('success', 'Товар создан');
}
```

### 5. Роуты
```php
Route::resource('products', ProductController::class);
```

## SEO Шаблон для новой страницы

```blade
@php
    $title = 'Заголовок страницы | Mindale — доставка цветов в Брянске';
    $description = 'Описание страницы с ключевыми словами. Брянск.';
    $keywords = 'ключевые, слова, через, запятую, Брянск';
    $ogTitle = 'Заголовок для соцсетей';
    $ogDescription = 'Описание для соцсетей';
    $ogImage = asset('images/page-og.jpg');
@endphp

@push('seo')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "{{ $title }}",
  "description": "{{ $description }}",
  "url": "{{ url()->current() }}"
}
</script>
@endpush

@section('content')
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-6">Заголовок с ключевыми словами</h1>
        <!-- Контент -->
    </div>
</section>
@endsection
```

## Tailwind классы проекта

### Цвета
```
bg-pink-500       # Основной розовый
bg-pink-600       # Темнее розовый (hover)
bg-purple-600     # Дополнительный
bg-gray-50        # Светлый фон
text-gray-900     # Основной текст
text-gray-600     # Вторичный текст
```

### Типичные паттерны
```html
<!-- Кнопка -->
<button class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-lg transition-colors">
    Кнопка
</button>

<!-- Карточка -->
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <!-- Контент -->
</div>

<!-- Секция -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Контент -->
    </div>
</section>
```

## Git коммиты

### Формат
```
[тип] краткое описание

Детальное описание если нужно
```

### Типы
- `[feat]` - новая функция
- `[fix]` - исправление бага
- `[refactor]` - рефакторинг
- `[style]` - стили, форматирование
- `[docs]` - документация
- `[test]` - тесты

### Примеры
```bash
git commit -m "[feat] добавлена фильтрация букетов по типу цветов"
git commit -m "[fix] исправлена ошибка загрузки изображений"
git commit -m "[refactor] оптимизированы запросы к БД в ProductController"
```

## Частые задачи

### Добавить изображение с правильными атрибутами
```html
<img src="{{ $product->main_image }}"
     alt="Букет {{ $product->name }} - купить с доставкой в Брянске"
     title="{{ $product->name }}"
     loading="lazy"
     width="400"
     height="300"
     class="w-full h-full object-cover">
```

### Проверить N+1 проблему
```bash
# Включить query log в .env
DB_QUERY_LOG=true

# Проверить в Laravel Telescope (если установлен)
# Или использовать eager loading:
Product::with(['images', 'category'])->get();
```

### Создать slug из названия
```php
use Illuminate\Support\Str;

$slug = Str::slug($name); // "Розы красные" -> "rozy-krasnye"
```

### Валидация форм
```php
// В Request классе
public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'email' => 'required|email|unique:users,email',
        'image' => 'nullable|image|mimes:jpg,png,webp|max:2048',
    ];
}

public function messages(): array
{
    return [
        'name.required' => 'Название обязательно для заполнения',
        'price.min' => 'Цена не может быть отрицательной',
    ];
}
```

## Полезные ссылки

- Laravel Docs: https://laravel.com/docs
- Tailwind Docs: https://tailwindcss.com/docs
- PSR-12: https://www.php-fig.org/psr/psr-12/
- Schema.org: https://schema.org/

## Контакты проекта

- **Телефон**: +7 (953) 292-92-46
- **Город**: Брянск
- **Время работы**: 9:00-21:00
- **Основные ключевые запросы**: "доставка цветов Брянск", "купить букет Брянск"
