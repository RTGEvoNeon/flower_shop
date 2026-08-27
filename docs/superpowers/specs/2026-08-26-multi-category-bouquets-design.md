# Мультикатегорийность букетов + категория «1 сентября»

Дата: 2026-08-26

## Проблема

Сейчас категория букета — это строковая колонка `products.category`
(одна на товар), список допустимых значений захардкожен в константе
`Product::CATEGORIES` (app/Models/Product.php) и продублирован ещё в
3-4 местах:

- `ProductController::$categoryKeywords` (app/Http/Controllers/ProductController.php, метод `show()`)
- `resources/views/products/index.blade.php` — свой `$categoryLabels`
- `resources/views/home.blade.php` — свой `$categoryLabels`
- `resources/views/components/footer.blade.php` — статичные ссылки
  `?category=bouquets|wedding|seasonal|luxury`

Значения из `DatabaseSeeder` и `ProductFactory`
(`bouquets`, `seasonal`, `luxury`) не совпадают с актуальными ключами
`Product::CATEGORIES` (`mono`, `mix`, `tulip`, `winter`, `wedding`,
`premium`) — это уже существующий баг, из-за которого часть демо-
товаров не видна в фильтре каталога.

Требуется:
1. Букет должен уметь принадлежать нескольким категориям одновременно.
2. Добавить новую категорию «1 сентября» (изначально пустую, букеты в
   неё добавляют вручную через админку).

## Архитектура

### Новые таблицы

**`categories`**
- `id`
- `key` (string, unique) — технический слаг, например `mono`, `september1`
- `name` (string) — человекочитаемое название, например «Монобукеты», «1 сентября»
- `sort_order` (unsigned integer, default 0) — порядок вкладок в каталоге
- `timestamps`

**`category_product`** (pivot)
- `category_id` (FK → categories.id, cascade on delete)
- `product_id` (FK → products.id, cascade on delete)
- уникальный составной индекс (`category_id`, `product_id`)

### Модели

**`App\Models\Category`** — новая модель.
```php
public function products(): BelongsToMany
{
    return $this->belongsToMany(Product::class);
}
```

**`App\Models\Product`** — добавляется связь:
```php
public function categories(): BelongsToMany
{
    return $this->belongsToMany(Category::class);
}
```

Убираются:
- константа `CATEGORIES` (значения переезжают в таблицу `categories`)
- константа `CATEGORY_LABELS` и метод `categoryLabel()` — вместо
  единственной категории берём название первой связанной категории
  (`$this->categories->first()?->name ?? 'букет'`) для текстов-заглушек
  (`composition`, `size`, `careInstructions`, `seoText`).
- scope `scopeByCategory` — заменяется фильтрацией через
  `whereHas('categories', fn ($q) => $q->where('key', $key))`.

Колонка `products.category` **не удаляется** в рамках этой задачи —
остаётся как legacy-поле до отдельной задачи на её вывод из
эксплуатации.

### Миграция данных

Отдельная data-migration (миграция с DB-операциями, выполняемая один
раз):
1. Создать записи в `categories` для всех ключей из текущего
   `Product::CATEGORIES` (`mono`, `mix`, `tulip`, `winter`, `wedding`,
   `premium`) + новую категорию `september1` → «1 сентября» (пустая).
2. Дополнительно завести категории для устаревших сидерных значений
   `bouquets` → «Букеты», `seasonal` → «Сезонные», `luxury` → «Премиум
   (legacy)» — чтобы существующие демо-товары с этими значениями не
   потерялись при переносе в pivot. (Если на проде таких товаров нет —
   миграция их просто не создаст, это безопасно.)
3. Для каждого товара: найти категорию по текущему значению
   `products.category` и создать связь в `category_product`. Товары со
   значением, не входящим ни в один известный ключ, логируются
   (`Log::warning`), но не блокируют миграцию.

### Контроллер каталога (`ProductController`)

- `CATEGORIES` — константа убирается, список категорий берётся из
  `Category::query()->orderBy('sort_order')->get()`.
- `validateCategory()` — проверяет `key` через запрос к таблице
  `categories` вместо `array_key_exists`.
- `getFilteredProducts()` — фильтр `?category=` работает так же, как
  сейчас (одна категория в query-параметре), но через
  `whereHas('categories', fn ($q) => $q->where('key', $category))`.
  Букет с несколькими категориями просто попадает в выдачу каждой из
  них по отдельности — поведение фильтра не меняется, меняется только
  как считается принадлежность.
- `getAvailableCategories()` — категории, у которых
  `whereHas('products', fn ($q) => $q->available())` не пусто.
- `show()` — `$categoryKeywords` заменяется на ключевые слова,
  собранные из `$product->categories->pluck('key')`, с fallback
  `'букет'`, если категорий нет.

### Filament-админка

- `ProductResource::form()` — `Select::make('category')` заменяется на
  `Select::make('categories')->relationship('categories', 'name')->multiple()->preload()->required()`.
- `ProductResource::table()` — колонка `category` заменяется на
  `TextColumn::make('categories.name')->listWithLineBreaks()` (или
  badge-список), `SelectFilter` — на фильтр по `categories` через
  `relationship`.
- Новый `CategoryResource` (Filament) — CRUD категорий: `key`, `name`,
  `sort_order`. Позволяет добавлять новые категории (в т.ч. будущие
  сезонные) без правки кода.

### Blade-шаблоны

`products/index.blade.php`, `home.blade.php` — убираются локальные
`$categoryLabels`-массивы, название категории карточки берётся как
`$product->categories->first()?->name`.

`footer.blade.php` — статичные ссылки `?category=bouquets|wedding|...`
заменяются на реально существующие ключи из таблицы `categories`
(итоговый список ссылок согласовать по факту доступных категорий,
чтобы не дублировать баг с несовпадающими ключами).

### Тестирование

- Feature-тест: букет с двумя категориями отображается в каталоге при
  фильтрации по каждой из них.
- Feature-тест: `getAvailableCategories()` не включает категорию без
  товаров (в частности, пустую «1 сентября» сразу после миграции).
- Filament-тест: сохранение товара с несколькими категориями через
  форму ресурса.
- Тест data-migration: значения `products.category` из существующих
  строк корректно переносятся в `category_product`.

## Вне рамок задачи

- Удаление legacy-колонки `products.category`.
- Множественный выбор категорий в UI-фильтре каталога (сейчас и после
  изменения — выбор одной категории за раз через `?category=`).
- Наполнение категории «1 сентября» товарами — делается вручную через
  админку после деплоя.
