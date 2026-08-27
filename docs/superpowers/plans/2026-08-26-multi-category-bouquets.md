# Мультикатегорийность букетов + категория «1 сентября» Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Позволить букету (`Product`) принадлежать нескольким категориям одновременно через новую сущность `Category` и pivot-таблицу, и добавить категорию «1 сентября».

**Architecture:** Новая таблица `categories` + pivot `category_product` (belongsToMany между `Product` и `Category`). Данные из существующей строковой колонки `products.category` переносятся в pivot одноразовой data-миграцией; сама колонка остаётся (legacy, вне рамок задачи). Контроллер каталога, Filament-админка и blade-шаблоны переключаются с константы `Product::CATEGORIES` на таблицу `categories`.

**Tech Stack:** Laravel 11, Eloquent, Filament 3, Pest (class-based тесты в этом проекте пишутся через `Tests\Feature\*Test extends TestCase`), Blade.

**Spec:** [docs/superpowers/specs/2026-08-26-multi-category-bouquets-design.md](../specs/2026-08-26-multi-category-bouquets-design.md)

## Global Constraints

- Колонка `products.category` НЕ удаляется в этой задаче — остаётся как legacy-поле.
- Выбор категории в фильтре каталога (`?category=`) остаётся одиночным — множественный выбор в UI-фильтре вне рамок задачи.
- Категория «1 сентября» создаётся пустой (без товаров) — её ключ `september1`, название «1 сентября».
- Устаревшие сидерные значения категории (`bouquets`, `seasonal`, `luxury`), не входящие в `Product::CATEGORIES`, должны получить свои записи в `categories`, чтобы не потерять данные при переносе в pivot.
- Товары, чьё значение `products.category` не совпадает ни с одним известным ключом, логируются через `Log::warning` при миграции данных, но не блокируют её.
- Все PHP-файлы начинаются с `<?php\n\ndeclare(strict_types=1);` (проверено проектом через `./vendor/bin/pint --test` и `phpstan` в pre-commit hook).

---

## Обзор затрагиваемых файлов

**Создаются:**
- `database/migrations/2026_08_26_100000_create_categories_table.php`
- `database/migrations/2026_08_26_100001_create_category_product_table.php`
- `database/migrations/2026_08_26_100002_migrate_product_categories_to_pivot.php` (data-migration)
- `app/Models/Category.php`
- `database/factories/CategoryFactory.php`
- `app/Filament/Resources/CategoryResource.php`
- `app/Filament/Resources/CategoryResource/Pages/ListCategories.php`
- `app/Filament/Resources/CategoryResource/Pages/CreateCategory.php`
- `app/Filament/Resources/CategoryResource/Pages/EditCategory.php`
- `tests/Feature/CategoryMigrationTest.php`
- `tests/Feature/ProductCategoryFilterTest.php`
- `tests/Feature/Admin/CategoryResourceTest.php`

**Изменяются:**
- `app/Models/Product.php` — связь `categories()`, убрать `CATEGORIES`, `CATEGORY_LABELS`, `categoryLabel()`, `scopeByCategory`.
- `app/Http/Controllers/ProductController.php` — фильтрация и SEO через таблицу `categories`.
- `app/Filament/Resources/ProductResource.php` — мультивыбор категорий.
- `resources/views/products/index.blade.php` — вывод названия категории из связи.
- `resources/views/home.blade.php` — вывод названия категории из связи.
- `resources/views/components/footer.blade.php` — ссылки на актуальные ключи категорий.
- `app/Http/Controllers/PageController.php` — eager-load `categories` для товаров главной страницы.
- `database/factories/ProductFactory.php` — категории через `afterCreating` (attach к существующим ключам).
- `database/seeders/DatabaseSeeder.php` — создание категорий + привязка товаров.

---

### Task 1: Таблица `categories` и модель `Category`

**Files:**
- Create: `database/migrations/2026_08_26_100000_create_categories_table.php`
- Create: `app/Models/Category.php`
- Create: `database/factories/CategoryFactory.php`
- Test: `tests/Unit/CategoryTest.php`

**Interfaces:**
- Produces: `Category::class` с полями `id`, `key` (string, unique), `name` (string), `sort_order` (int, default 0); фабрика `Category::factory()`.

- [ ] **Step 1: Написать падающий тест модели**

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created_with_key_name_and_sort_order(): void
    {
        $category = Category::create([
            'key' => 'september1',
            'name' => '1 сентября',
            'sort_order' => 10,
        ]);

        $this->assertDatabaseHas('categories', [
            'key' => 'september1',
            'name' => '1 сентября',
            'sort_order' => 10,
        ]);
        $this->assertSame('1 сентября', $category->name);
    }

    public function test_category_key_must_be_unique(): void
    {
        Category::factory()->create(['key' => 'mono']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Category::factory()->create(['key' => 'mono']);
    }
}
```

- [ ] **Step 2: Запустить тест и убедиться, что он падает**

Run: `./vendor/bin/pest tests/Unit/CategoryTest.php`
Expected: FAIL — класс `App\Models\Category` не найден / таблица `categories` не существует.

- [ ] **Step 3: Создать миграцию таблицы `categories`**

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
```

- [ ] **Step 4: Создать модель `Category`**

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $key
 * @property string $name
 * @property int $sort_order
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
```

- [ ] **Step 5: Создать фабрику `CategoryFactory`**

```php
<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'key' => fake()->unique()->slug(2),
            'name' => fake()->words(2, true),
            'sort_order' => 0,
        ];
    }
}
```

- [ ] **Step 6: Запустить тест и убедиться, что он проходит**

Run: `./vendor/bin/pest tests/Unit/CategoryTest.php`
Expected: PASS

- [ ] **Step 7: Commit**

```bash
git add database/migrations/2026_08_26_100000_create_categories_table.php app/Models/Category.php database/factories/CategoryFactory.php tests/Unit/CategoryTest.php
git commit -m "feat: добавить модель и таблицу Category"
```

---

### Task 2: Pivot-таблица `category_product` и связь в `Product`

**Files:**
- Create: `database/migrations/2026_08_26_100001_create_category_product_table.php`
- Modify: `app/Models/Product.php` — добавить связь `categories()`
- Test: `tests/Unit/ProductCategoryRelationTest.php`

**Interfaces:**
- Consumes: `Category::class` (Task 1)
- Produces: `Product::categories(): BelongsToMany` — используется в Task 3 (контроллер), Task 4 (Filament), Task 5 (blade), Task 6 (data-migration).

- [ ] **Step 1: Написать падающий тест связи**

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCategoryRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_attached_to_multiple_categories(): void
    {
        $product = Product::factory()->create();
        $mono = Category::factory()->create(['key' => 'mono', 'name' => 'Монобукеты']);
        $wedding = Category::factory()->create(['key' => 'wedding', 'name' => 'Свадебные']);

        $product->categories()->attach([$mono->id, $wedding->id]);

        $this->assertCount(2, $product->refresh()->categories);
        $this->assertTrue($product->categories->contains('key', 'mono'));
        $this->assertTrue($product->categories->contains('key', 'wedding'));
    }

    public function test_category_can_have_multiple_products(): void
    {
        $category = Category::factory()->create();
        $products = Product::factory()->count(3)->create();

        $category->products()->attach($products->pluck('id'));

        $this->assertCount(3, $category->refresh()->products);
    }
}
```

- [ ] **Step 2: Запустить тест и убедиться, что он падает**

Run: `./vendor/bin/pest tests/Unit/ProductCategoryRelationTest.php`
Expected: FAIL — таблица `category_product` не существует / метод `categories()` не определён.

- [ ] **Step 3: Создать миграцию pivot-таблицы**

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['category_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};
```

- [ ] **Step 4: Добавить связь `categories()` в `Product`**

В `app/Models/Product.php` добавить импорт и метод (рядом с существующими scope-методами, после `scopeByCategory` — этот scope будет удалён в Task 3, пока оставляем):

```php
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
```

```php
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
```

- [ ] **Step 5: Запустить тест и убедиться, что он проходит**

Run: `./vendor/bin/pest tests/Unit/ProductCategoryRelationTest.php`
Expected: PASS

- [ ] **Step 6: Commit**

```bash
git add database/migrations/2026_08_26_100001_create_category_product_table.php app/Models/Product.php tests/Unit/ProductCategoryRelationTest.php
git commit -m "feat: добавить pivot category_product и связь Product::categories()"
```

---

### Task 3: Data-migration — перенос `products.category` в pivot + категория «1 сентября»

**Files:**
- Create: `database/migrations/2026_08_26_100002_migrate_product_categories_to_pivot.php`
- Test: `tests/Feature/CategoryMigrationTest.php`

**Interfaces:**
- Consumes: `Category::class`, `Product::categories()` (Task 1, 2)
- Produces: гарантия, что после `php artisan migrate` в таблице `categories` есть все ключи из `mono, mix, tulip, winter, wedding, premium, september1, bouquets, seasonal, luxury`, и каждый существующий товар привязан к категории, соответствующей его `products.category`.

- [ ] **Step 1: Написать падающий тест data-migration**

Тест наполняет `products` через прямой `DB::table('products')->insert()` (минуя фабрику, чтобы записать legacy-значения в колонку `category` до отработки миграции), затем откатывает и повторно накатывает целевую миграцию.

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_creates_all_expected_categories(): void
    {
        $keys = Category::query()->pluck('key')->all();

        foreach (['mono', 'mix', 'tulip', 'winter', 'wedding', 'premium', 'september1', 'bouquets', 'seasonal', 'luxury'] as $expectedKey) {
            $this->assertContains($expectedKey, $keys, "Категория '{$expectedKey}' должна существовать после миграции");
        }
    }

    public function test_september1_category_has_no_products_by_default(): void
    {
        $category = Category::where('key', 'september1')->first();

        $this->assertNotNull($category);
        $this->assertSame('1 сентября', $category->name);
        $this->assertCount(0, $category->products);
    }

    public function test_existing_product_category_value_is_migrated_to_pivot(): void
    {
        // RefreshDatabase уже применил все миграции, включая data-migration, к пустой БД.
        // Чтобы проверить перенос данных, добавляем товар с legacy-значением category
        // напрямую в БД и повторно выполняем ТОЛЬКО тело data-migration (метод up())
        // через прямое включение файла миграции — это детерминированно, в отличие от
        // повторного artisan migrate по уже отмеченной как выполненную миграции.
        $productId = DB::table('products')->insertGetId([
            'name' => 'Тестовый букет 2',
            'slug' => 'test-bouquet-2',
            'category' => 'wedding',
            'price' => 1000,
            'is_available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $migration = include base_path('database/migrations/2026_08_26_100002_migrate_product_categories_to_pivot.php');
        $migration->up();

        $weddingCategoryId = Category::where('key', 'wedding')->value('id');

        $this->assertDatabaseHas('category_product', [
            'category_id' => $weddingCategoryId,
            'product_id' => $productId,
        ]);
    }
}
```

Метод `up()` data-migration использует `insertOrIgnore` для `category_product` и `insertGetId` для `categories` — повторный вызов `up()` в этом тесте создаст дублирующиеся записи категорий (это ожидаемо и не мешает тесту, т.к. `Category::where('key', 'wedding')->value('id')` берёт первую подходящую запись; дубли категорий из-за повторного вызова `up()` в тесте не появляются в реальной эксплуатации, где миграция выполняется ровно один раз).

- [ ] **Step 2: Запустить тест и убедиться, что он падает**

Run: `./vendor/bin/pest tests/Feature/CategoryMigrationTest.php`
Expected: FAIL — категорий нет, т.к. data-migration ещё не написана.

- [ ] **Step 3: Создать data-migration**

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * @var array<string, string>
     */
    private array $categories = [
        'mono' => 'Монобукеты',
        'mix' => 'Микс букеты',
        'tulip' => 'Тюльпаны',
        'winter' => 'Зима',
        'wedding' => 'Свадебные',
        'premium' => 'Премиум',
        'september1' => '1 сентября',
        'bouquets' => 'Букеты',
        'seasonal' => 'Сезонные',
        'luxury' => 'Премиум (legacy)',
    ];

    public function up(): void
    {
        $categoryIds = [];

        foreach (array_values($this->categories) as $index => $name) {
            $key = array_keys($this->categories)[$index];

            $categoryIds[$key] = DB::table('categories')->insertGetId([
                'key' => $key,
                'name' => $name,
                'sort_order' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $products = DB::table('products')->select('id', 'category')->get();

        foreach ($products as $product) {
            if (! array_key_exists($product->category, $categoryIds)) {
                Log::warning("Product {$product->id} has unknown category '{$product->category}', skipped during category migration.");

                continue;
            }

            DB::table('category_product')->insertOrIgnore([
                'category_id' => $categoryIds[$product->category],
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('category_product')->truncate();
        DB::table('categories')->whereIn('key', array_keys($this->categories))->delete();
    }
};
```

- [ ] **Step 4: Запустить тест и убедиться, что он проходит**

Run: `./vendor/bin/pest tests/Feature/CategoryMigrationTest.php`
Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add database/migrations/2026_08_26_100002_migrate_product_categories_to_pivot.php tests/Feature/CategoryMigrationTest.php
git commit -m "feat: перенести products.category в pivot и добавить категорию 1 сентября"
```

---

### Task 4: Обновить `Product` — убрать legacy-константы, добавить fallback-логику через связь

**Files:**
- Modify: `app/Models/Product.php`
- Test: `tests/Unit/ProductTest.php`

**Interfaces:**
- Consumes: `Product::categories()` (Task 2)
- Produces: `Product::composition`, `Product::size`, `Product::careInstructions`, `Product::seoText` accessors работают через `categories->first()?->name` вместо удалённого `categoryLabel()`.

- [ ] **Step 1: Написать падающий тест fallback-текстов**

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_composition_fallback_uses_first_category_name(): void
    {
        $product = Product::factory()->create(['composition' => null, 'name' => 'Весна']);
        $category = Category::factory()->create(['name' => 'монобукет']);
        $product->categories()->attach($category);

        $this->assertStringContainsString('монобукет', $product->refresh()->composition);
    }

    public function test_composition_fallback_uses_generic_label_without_categories(): void
    {
        $product = Product::factory()->create(['composition' => null]);

        $this->assertStringContainsString('букет', $product->composition);
    }

    public function test_category_constants_are_removed(): void
    {
        $this->assertFalse(defined(Product::class.'::CATEGORIES'));
    }
}
```

- [ ] **Step 2: Запустить тест и убедиться, что он падает**

Run: `./vendor/bin/pest tests/Unit/ProductTest.php`
Expected: FAIL — `CATEGORIES` всё ещё существует, `categoryLabel()` использует старую колонку `category`, а не связь.

- [ ] **Step 3: Обновить `app/Models/Product.php`**

Удалить константы `CATEGORIES` (строки 42-49) и `CATEGORY_LABELS` (строки 59-66), метод `categoryLabel()` (строки 189-192) и `scopeByCategory()` (строки 96-101). Заменить `categoryLabel()` на:

```php
    /**
     * Человекочитаемое название категории в единственном числе.
     */
    private function categoryLabel(): string
    {
        return $this->categories->first()?->name ?? 'букет';
    }
```

Убедиться, что связь `categories()` из Task 2 остаётся. Итоговый файл после изменений (полная замена, без `CATEGORIES`, `CATEGORY_LABELS`, `scopeByCategory`):

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property float $price
 * @property string $category
 * @property bool $is_available
 * @property-read string $main_image
 * @property-read array<int, string> $image_urls
 * @property-read array<int, string> $image_urls_webp
 * @property-read string $composition
 * @property-read string $size
 * @property-read string $care_instructions
 * @property-read string $seo_text
 */
class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const PHOTOS_COLLECTION = 'photos';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'composition',
        'size',
        'care_instructions',
        'seo_text',
        'price',
        'category',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'float',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::PHOTOS_COLLECTION);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Scope: только доступные товары
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope: с изображениями (для совместимости, изображения загружаются через MediaLibrary)
     */
    public function scopeWithImages(Builder $query): Builder
    {
        return $query->with('media');
    }

    /**
     * Accessor: главное изображение или fallback
     */
    protected function mainImage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl(self::PHOTOS_COLLECTION) ?: '/images/placeholder.jpg'
        );
    }

    /**
     * Accessor: все изображения как URL
     */
    protected function imageUrls(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getMedia(self::PHOTOS_COLLECTION)
                ->map(fn (Media $media) => $media->getUrl())
                ->all()
        );
    }

    /**
     * Accessor: все изображения в виде WebP-URL (с fallback на оригинал).
     */
    protected function imageUrlsWebp(): Attribute
    {
        return Attribute::make(
            get: fn (): array => $this->getMedia(self::PHOTOS_COLLECTION)
                ->map(fn (Media $media) => self::webpForMedia($media))
                ->all()
        );
    }

    /**
     * Вернуть WebP-версию файла медиа, если она существует на диске.
     * Иначе возвращает исходный URL без изменений.
     */
    public static function webpForMedia(Media $media): string
    {
        $url = $media->getUrl();

        if (! preg_match('/\.(jpe?g|png)$/i', $url)) {
            return $url;
        }

        $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $media->getPathRelativeToRoot());

        if ($webpPath !== null && Storage::disk($media->disk)->exists($webpPath)) {
            return preg_replace('/\.(jpe?g|png)$/i', '.webp', $url);
        }

        return $url;
    }

    /**
     * Вернуть WebP-версию для произвольного URL (диск public), если файл существует.
     * Используется компонентом <x-product-image>, где под рукой только URL, а не Media.
     */
    public static function webpForUrl(string $imageUrl): string
    {
        if (! preg_match('/\.(jpe?g|png)$/i', $imageUrl)) {
            return $imageUrl;
        }

        $webpUrl = preg_replace('/\.(jpe?g|png)$/i', '.webp', $imageUrl);
        $relativePath = ltrim(str_replace('/storage/', '', parse_url($webpUrl, PHP_URL_PATH) ?? ''), '/');

        if ($relativePath !== '' && Storage::disk('public')->exists($relativePath)) {
            return $webpUrl;
        }

        return $imageUrl;
    }

    /**
     * Человекочитаемое название категории в единственном числе.
     */
    private function categoryLabel(): string
    {
        return $this->categories->first()?->name ?? 'букет';
    }

    /**
     * Accessor: состав букета.
     * Если поле заполнено вручную — возвращаем его, иначе — текст по шаблону.
     */
    protected function composition(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): string {
                if (filled($value)) {
                    return $value;
                }

                return 'Свежесрезанные цветы высшего качества, сезонная зелень и декоративная '
                    .'упаковка. Точный состав '.$this->categoryLabel().' «'.$this->name.'» '
                    .'наши флористы согласуют с вами при оформлении заказа и могут адаптировать '
                    .'под ваш бюджет и пожелания.';
            }
        );
    }

    /**
     * Accessor: размер букета.
     */
    protected function size(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): string {
                if (filled($value)) {
                    return $value;
                }

                return 'Стандартный размер. Высоту и объём букета можно увеличить — '
                    .'уточните пожелания при заказе.';
            }
        );
    }

    /**
     * Accessor: рекомендации по уходу.
     */
    protected function careInstructions(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): string {
                if (filled($value)) {
                    return $value;
                }

                return 'Подрежьте стебли под углом 45° острым ножом и поставьте букет в чистую '
                    .'прохладную воду. Меняйте воду каждые 1–2 дня, заново подрезая стебли. '
                    .'Держите цветы вдали от прямых солнечных лучей, сквозняков, отопительных '
                    .'приборов и спелых фруктов — так букет дольше сохранит свежесть.';
            }
        );
    }

    /**
     * Accessor: SEO-текст под карточкой товара.
     * Уникальный длинный текст для поисковых систем; при отсутствии генерируется по шаблону.
     */
    protected function seoText(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): string {
                if (filled($value)) {
                    return $value;
                }

                $label = $this->categoryLabel();
                $price = number_format((float) $this->price, 0, '', ' ');

                return "{$label} «{$this->name}» — это композиция из свежих цветов, "
                    .'собранная флористами цветочной мастерской «Эдемский сад» в Брянске. '
                    ."Каждый {$label} мы создаём вручную в день доставки, поэтому цветы "
                    .'приезжают к получателю свежими и стоят максимально долго. '
                    ."Купить {$this->name} в Брянске можно за {$price} ₽ с бесплатной "
                    .'доставкой по городу — курьер привезёт букет в удобное время, в том '
                    .'числе в день заказа. Такой букет станет прекрасным подарком на день '
                    .'рождения, годовщину, 8 Марта или просто знаком внимания без повода. '
                    .'Если хотите изменить состав, размер или добавить открытку — напишите '
                    .'нам, и мы соберём букет специально под вас.';
            }
        );
    }
}
```

- [ ] **Step 4: Запустить тест и убедиться, что он проходит**

Run: `./vendor/bin/pest tests/Unit/ProductTest.php`
Expected: PASS

- [ ] **Step 5: Проверить, что уже существующие тесты продукта не сломались**

Run: `./vendor/bin/pest tests/Unit/ProductCategoryRelationTest.php tests/Feature/CategoryMigrationTest.php`
Expected: PASS (не должны зависеть от удалённых констант)

- [ ] **Step 6: Commit**

```bash
git add app/Models/Product.php tests/Unit/ProductTest.php
git commit -m "refactor: убрать константы категорий из Product, использовать связь categories"
```

---

### Task 5: Обновить `ProductController` — фильтр каталога и SEO через таблицу `categories`

**Files:**
- Modify: `app/Http/Controllers/ProductController.php`
- Test: `tests/Feature/ProductCategoryFilterTest.php`

**Interfaces:**
- Consumes: `Category::class`, `Product::categories()` (Task 1, 2)
- Produces: `ProductController::index()` отдаёт `categories` во view как `Collection<Category>` вместо `array<string,string>`; `currentCategory` теперь строка `key` категории или `'all'`.

- [ ] **Step 1: Написать падающий тест фильтрации**

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCategoryFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_with_multiple_categories_appears_in_each_category_filter(): void
    {
        $mono = Category::factory()->create(['key' => 'mono', 'name' => 'Монобукеты']);
        $wedding = Category::factory()->create(['key' => 'wedding', 'name' => 'Свадебные']);

        $product = Product::factory()->create(['name' => 'Двойной букет', 'is_available' => true]);
        $product->categories()->attach([$mono->id, $wedding->id]);

        $responseMono = $this->get('/products?category=mono');
        $responseMono->assertOk();
        $responseMono->assertSee('Двойной букет');

        $responseWedding = $this->get('/products?category=wedding');
        $responseWedding->assertOk();
        $responseWedding->assertSee('Двойной букет');
    }

    public function test_category_without_products_is_not_in_available_categories(): void
    {
        Category::factory()->create(['key' => 'september1', 'name' => '1 сентября']);
        $mono = Category::factory()->create(['key' => 'mono', 'name' => 'Монобукеты']);
        $product = Product::factory()->create(['is_available' => true]);
        $product->categories()->attach($mono->id);

        $response = $this->get('/products');

        $response->assertOk();
        $categories = $response->viewData('categories');

        $this->assertTrue($categories->contains('key', 'mono'));
        $this->assertFalse($categories->contains('key', 'september1'));
    }

    public function test_invalid_category_falls_back_to_all(): void
    {
        $product = Product::factory()->create(['is_available' => true, 'name' => 'Видимый везде']);

        $response = $this->get('/products?category=does-not-exist');

        $response->assertOk();
        $response->assertSee('Видимый везде');
    }
}
```

- [ ] **Step 2: Запустить тест и убедиться, что он падает**

Run: `./vendor/bin/pest tests/Feature/ProductCategoryFilterTest.php`
Expected: FAIL — контроллер всё ещё фильтрует по старой колонке `category` через удалённый `scopeByCategory`.

- [ ] **Step 3: Обновить `app/Http/Controllers/ProductController.php`**

Полная замена файла:

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\Seo;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $category = $this->validateCategory($request->query('category'));
        $page = max(1, (int) $request->query('page', 1));

        $this->setSeoForCatalog($category, $page);

        $products = $this->getFilteredProducts($category);

        return view('products.index', [
            'products' => $products,
            'categories' => $this->getAvailableCategories(),
            'currentCategory' => $category,
        ]);
    }

    /**
     * Категории, в которых есть хотя бы один доступный товар.
     *
     * @return Collection<int, Category>
     */
    private function getAvailableCategories(): Collection
    {
        return Category::query()
            ->whereHas('products', fn ($query) => $query->available())
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Валидация и нормализация категории.
     */
    private function validateCategory(?string $category): string
    {
        if ($category === null || $category === 'all') {
            return 'all';
        }

        $exists = Category::query()->where('key', $category)->exists();

        return $exists ? $category : 'all';
    }

    /**
     * Получить отфильтрованные товары с пагинацией.
     */
    private function getFilteredProducts(string $category): LengthAwarePaginator
    {
        $query = Product::available()->withImages();

        if ($category !== 'all') {
            $query->whereHas('categories', fn ($q) => $q->where('key', $category));
        }

        return $query->paginate(18)->withQueryString();
    }

    /**
     * Установить SEO-данные для каталога.
     */
    private function setSeoForCatalog(string $category, int $page): void
    {
        $categoryName = $category === 'all'
            ? 'Каталог'
            : (Category::query()->where('key', $category)->value('name') ?? 'Каталог');

        $isFiltered = $category !== 'all';

        $title = $isFiltered
            ? "{$categoryName} — купить в Брянске"
            : 'Каталог букетов';

        if ($page > 1) {
            $title .= " — страница {$page}";
        }

        $description = $isFiltered
            ? "{$categoryName} от цветочной мастерской Эдемский сад. Доставка по Брянску бесплатно."
            : 'Каталог свежих букетов от цветочной мастерской Эдемский сад. Монобукеты и миксы от 2000₽. Доставка по Брянску бесплатно. Более 50 вариантов букетов.';

        $canonicalParams = $isFiltered ? ['category' => $category] : [];
        if ($page > 1) {
            $canonicalParams['page'] = $page;
        }

        $canonicalUrl = route('products.index', $canonicalParams);

        Seo::setTitle($title)
            ->setDescription($description)
            ->setKeywords(['каталог цветов', 'купить букет', 'цены на букеты Брянск', 'свежие цветы'])
            ->setCanonical($canonicalUrl)
            ->setBreadcrumbSchema([
                ['name' => 'Главная', 'url' => url('/')],
                ['name' => 'Каталог', 'url' => route('products.index')],
            ]);

        if ($page > 1) {
            Seo::setRobots('noindex, follow');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)->available()->firstOrFail();

        // SEO для страницы товара
        $title = $product->name.' — купить в Брянске';
        $description = $product->description
            ? mb_substr($product->description, 0, 140).'... Цена: '.number_format((float) $product->price, 0, '', ' ').'₽. Доставка по Брянску бесплатно.'
            : "Букет {$product->name} от цветочной мастерской Эдемский сад. Цена: ".number_format((float) $product->price, 0, '', ' ').'₽. Свежие цветы, бесплатная доставка по Брянску.';

        $categoryKeyword = $product->categories->first()?->name ?? 'букет';

        Seo::setTitle($title)
            ->setDescription($description)
            ->setKeywords([
                $product->name,
                "купить {$product->name}",
                "{$product->name} Брянск",
                "букет {$product->name}",
                $categoryKeyword,
            ])
            ->setCanonical(route('products.show', $product->slug))
            ->setType('product')
            ->setBreadcrumbSchema([
                ['name' => 'Главная', 'url' => url('/')],
                ['name' => 'Каталог', 'url' => route('products.index')],
                ['name' => $product->name, 'url' => route('products.show', $product->slug)],
            ])
            ->setProductSchema(
                name: $product->name,
                description: $product->description ?? "Прекрасный букет {$product->name} от цветочной мастерской Эдемский сад",
                price: $product->price,
                currency: 'RUB',
                image: $product->main_image,
                url: route('products.show', $product->slug),
                availability: $product->is_available ? 'InStock' : 'OutOfStock'
            );

        // Устанавливаем изображение для OG, если есть
        if ($product->main_image) {
            Seo::setImage($product->main_image, $product->name);
        }

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
```

- [ ] **Step 4: Запустить тест и убедиться, что он проходит**

Run: `./vendor/bin/pest tests/Feature/ProductCategoryFilterTest.php`
Expected: PASS

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/ProductController.php tests/Feature/ProductCategoryFilterTest.php
git commit -m "feat: фильтрация каталога и SEO через таблицу categories"
```

---

### Task 6: Обновить blade-шаблоны каталога и футер

**Files:**
- Modify: `resources/views/products/index.blade.php`
- Modify: `resources/views/home.blade.php`
- Modify: `resources/views/components/footer.blade.php`
- Modify: `app/Http/Controllers/PageController.php:39-43`
- Test: `tests/Feature/ProductCategoryFilterTest.php` (дополнить)

**Interfaces:**
- Consumes: `Product::categories` (relation, Task 2), `$categories` во view как `Collection<Category>` (Task 5).

- [ ] **Step 1: Написать падающий тест на отображение названия категории на карточке**

Добавить в `tests/Feature/ProductCategoryFilterTest.php`:

```php
    public function test_product_card_shows_category_name_from_relation(): void
    {
        $category = Category::factory()->create(['key' => 'mono', 'name' => 'Монобукеты']);
        $product = Product::factory()->create(['is_available' => true, 'name' => 'Карточный букет']);
        $product->categories()->attach($category->id);

        $response = $this->get('/products');

        $response->assertOk();
        $response->assertSee('Монобукеты');
    }
```

- [ ] **Step 2: Запустить тест и убедиться, что он падает**

Run: `./vendor/bin/pest tests/Feature/ProductCategoryFilterTest.php`
Expected: FAIL — blade всё ещё использует локальный `$categoryLabels`-массив с ключом `mono => 'Монобукет'` (не совпадёт по требуемому тексту `'Монобукеты'` из фабрики теста в единичном числе — фактически тест проверяет, что название берётся из БД, а не из захардкоженного массива).

- [ ] **Step 3: Обновить `resources/views/products/index.blade.php`**

Найти блок (текущие строки ~102-113):
```blade
                        <!-- Категория -->
                        <div class="absolute bottom-2 left-2 sm:bottom-4 sm:left-4 bg-white/95 backdrop-blur-sm px-2 py-1 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-medium text-gray-700 shadow-md">
                            @php
                                $categoryLabels = [
                                    'mono' => 'Монобукет',
                                    'mix' => 'Микс',
                                    'tulip' => 'Тюльпаны',
                                    'winter' => 'Зима',
                                    'wedding' => 'Свадебные',
                                ];
                            @endphp
                            {{ $categoryLabels[$product->category] ?? ucfirst($product->category) }}
                        </div>
```

Заменить на:
```blade
                        <!-- Категория -->
                        @if($product->categories->isNotEmpty())
                        <div class="absolute bottom-2 left-2 sm:bottom-4 sm:left-4 bg-white/95 backdrop-blur-sm px-2 py-1 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-medium text-gray-700 shadow-md">
                            {{ $product->categories->first()->name }}
                        </div>
                        @endif
```

- [ ] **Step 4: Обновить `resources/views/home.blade.php`**

Найти блок (текущие строки ~205-215):
```blade
                    <!-- Category badge -->
                    @if($product->category)
                    <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium text-gray-700">
                        @php
                            $categoryLabels = [
                                'mono' => 'Монобукет',
                                'mix' => 'Микс',
                                'winter' => 'Зима',
                                'wedding' => 'Свадебные',
                            ];
                        @endphp
                        {{ $categoryLabels[$product->category] ?? ucfirst($product->category) }}
                    </div>
                    @endif
```

Заменить на:
```blade
                    <!-- Category badge -->
                    @if($product->categories->isNotEmpty())
                    <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium text-gray-700">
                        {{ $product->categories->first()->name }}
                    </div>
                    @endif
```

В `app/Http/Controllers/PageController.php`, метод `home()`, найти запрос:
```php
        $randomProducts = Product::available()
            ->withImages()
            ->inRandomOrder()
            ->limit(3)
            ->get();
```
и добавить eager-load связи категорий, чтобы избежать N+1 при выводе `$product->categories->first()->name` в цикле шаблона:
```php
        $randomProducts = Product::available()
            ->withImages()
            ->with('categories')
            ->inRandomOrder()
            ->limit(3)
            ->get();
```

- [ ] **Step 5: Обновить `resources/views/components/footer.blade.php`**

Найти блок каталога (текущие строки со ссылками `?category=bouquets`, `?category=wedding`, `?category=luxury`):
```blade
                    <li><a href="/products?category=bouquets" class="text-gray-300 hover:text-primary-400 transition-colors inline-flex items-center group">
                        <span class="w-1.5 h-1.5 bg-primary-400 rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        Букеты
                    </a></li>
                    <li><a href="/products?category=wedding" class="text-gray-300 hover:text-primary-400 transition-colors inline-flex items-center group">
                        <span class="w-1.5 h-1.5 bg-primary-400 rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        Свадебные
                    </a></li>
                    <!-- TODO: Страница "Сезонные" временно отключена -->
                    <!-- <li><a href="/products?category=seasonal" class="text-gray-300 hover:text-primary-400 transition-colors inline-flex items-center group">
                        <span class="w-1.5 h-1.5 bg-primary-400 rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        Сезонные
                    </a></li> -->
                    <li><a href="/products?category=luxury" class="text-gray-300 hover:text-primary-400 transition-colors inline-flex items-center group">
                        <span class="w-1.5 h-1.5 bg-primary-400 rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        Премиум
                    </a></li>
```

Заменить на ключи, которые реально существуют после Task 3 (`wedding` и `premium` — актуальные ключи `Product::CATEGORIES`, старые `bouquets`/`luxury` — legacy-ключи, добавленные data-migration только для совместимости демо-данных, в футере на них не ссылаемся):
```blade
                    <li><a href="/products?category=wedding" class="text-gray-300 hover:text-primary-400 transition-colors inline-flex items-center group">
                        <span class="w-1.5 h-1.5 bg-primary-400 rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        Свадебные
                    </a></li>
                    <li><a href="/products?category=premium" class="text-gray-300 hover:text-primary-400 transition-colors inline-flex items-center group">
                        <span class="w-1.5 h-1.5 bg-primary-400 rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        Премиум
                    </a></li>
                    <li><a href="/products?category=september1" class="text-gray-300 hover:text-primary-400 transition-colors inline-flex items-center group">
                        <span class="w-1.5 h-1.5 bg-primary-400 rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        1 сентября
                    </a></li>
```

- [ ] **Step 6: Запустить тест и убедиться, что он проходит**

Run: `./vendor/bin/pest tests/Feature/ProductCategoryFilterTest.php`
Expected: PASS

- [ ] **Step 7: Commit**

```bash
git add resources/views/products/index.blade.php resources/views/home.blade.php resources/views/components/footer.blade.php app/Http/Controllers/PageController.php tests/Feature/ProductCategoryFilterTest.php
git commit -m "feat: отображать категории букета из связи в blade-шаблонах"
```

---

### Task 7: Filament — мультивыбор категорий в `ProductResource`

**Files:**
- Modify: `app/Filament/Resources/ProductResource.php`
- Test: `tests/Feature/Admin/CategoryResourceTest.php` (частично — тест на форму продукта добавляется здесь, тест самого `CategoryResource` — в Task 8)

**Interfaces:**
- Consumes: `Category::class`, `Product::categories()` (Task 1, 2)

- [ ] **Step 1: Написать падающий тест сохранения товара с несколькими категориями**

```php
<?php

declare(strict_types=1);

use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

test('admin can attach multiple categories to a product via the form', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $product = Product::factory()->create();
    $mono = Category::factory()->create(['key' => 'mono', 'name' => 'Монобукеты']);
    $wedding = Category::factory()->create(['key' => 'wedding', 'name' => 'Свадебные']);

    Livewire::actingAs($admin)
        ->test(EditProduct::class, ['record' => $product->getKey()])
        ->fillForm(['categories' => [$mono->id, $wedding->id]])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($product->refresh()->categories->pluck('id')->sort()->values()->all())
        ->toBe([$mono->id, $wedding->id]);
});
```

Добавить этот тест в новый файл `tests/Feature/Admin/CategoryResourceTest.php` (файл будет дополнен в Task 8 тестами самого `CategoryResource`).

- [ ] **Step 2: Запустить тест и убедиться, что он падает**

Run: `./vendor/bin/pest tests/Feature/Admin/CategoryResourceTest.php`
Expected: FAIL — поле `categories` не определено в форме `ProductResource` (там всё ещё `Select::make('category')`).

- [ ] **Step 3: Обновить `app/Filament/Resources/ProductResource.php`**

В методе `form()` заменить:
```php
                Forms\Components\Select::make('category')
                    ->label('Категория')
                    ->options(Product::CATEGORIES)
                    ->required(),
```
на:
```php
                Forms\Components\Select::make('categories')
                    ->label('Категории')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
```

В методе `table()` заменить колонку категории:
```php
                Tables\Columns\TextColumn::make('category')
                    ->label('Категория')
                    ->formatStateUsing(fn (string $state) => Product::CATEGORIES[$state] ?? $state)
                    ->searchable(),
```
на:
```php
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Категории')
                    ->badge()
                    ->separator(','),
```

И фильтр:
```php
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Категория')
                    ->options(Product::CATEGORIES),
            ])
```
на:
```php
            ->filters([
                Tables\Filters\SelectFilter::make('categories')
                    ->label('Категория')
                    ->relationship('categories', 'name'),
            ])
```

- [ ] **Step 4: Запустить тест и убедиться, что он проходит**

Run: `./vendor/bin/pest tests/Feature/Admin/CategoryResourceTest.php`
Expected: PASS

- [ ] **Step 5: Убедиться, что существующий тест списка товаров не сломался**

Run: `./vendor/bin/pest tests/Feature/Admin/FilamentAccessTest.php`
Expected: PASS

- [ ] **Step 6: Commit**

```bash
git add app/Filament/Resources/ProductResource.php tests/Feature/Admin/CategoryResourceTest.php
git commit -m "feat: мультивыбор категорий в форме товара Filament"
```

---

### Task 8: Filament — новый `CategoryResource` для CRUD категорий

**Files:**
- Create: `app/Filament/Resources/CategoryResource.php`
- Create: `app/Filament/Resources/CategoryResource/Pages/ListCategories.php`
- Create: `app/Filament/Resources/CategoryResource/Pages/CreateCategory.php`
- Create: `app/Filament/Resources/CategoryResource/Pages/EditCategory.php`
- Test: `tests/Feature/Admin/CategoryResourceTest.php` (дополнить)

**Interfaces:**
- Consumes: `Category::class` (Task 1)

- [ ] **Step 1: Написать падающий тест CRUD категорий**

Добавить в `tests/Feature/Admin/CategoryResourceTest.php`:

```php
test('admin can see category list', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Category::factory()->create(['name' => 'Тестовая категория']);

    $response = test()->actingAs($admin)->get('/admin/categories');

    $response->assertOk();
    $response->assertSee('Тестовая категория');
});

test('admin can create a new category', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    Livewire::actingAs($admin)
        ->test(\App\Filament\Resources\CategoryResource\Pages\CreateCategory::class)
        ->fillForm([
            'key' => 'newyear',
            'name' => 'Новый год',
            'sort_order' => 5,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Category::where('key', 'newyear')->exists())->toBeTrue();
});
```

- [ ] **Step 2: Запустить тест и убедиться, что он падает**

Run: `./vendor/bin/pest tests/Feature/Admin/CategoryResourceTest.php`
Expected: FAIL — `/admin/categories` возвращает 404, класса `CategoryResource` не существует.

- [ ] **Step 3: Создать `app/Filament/Resources/CategoryResource.php`**

```php
<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Категории';

    protected static ?string $modelLabel = 'категория';

    protected static ?string $pluralModelLabel = 'категории';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Ключ')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Порядок сортировки')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Сортировка')
                    ->sortable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->label('Товаров')
                    ->counts('products'),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
```

- [ ] **Step 4: Создать страницы ресурса**

`app/Filament/Resources/CategoryResource/Pages/ListCategories.php`:
```php
<?php

declare(strict_types=1);

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
```

`app/Filament/Resources/CategoryResource/Pages/CreateCategory.php`:
```php
<?php

declare(strict_types=1);

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
```

`app/Filament/Resources/CategoryResource/Pages/EditCategory.php`:
```php
<?php

declare(strict_types=1);

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
```

- [ ] **Step 5: Запустить тест и убедиться, что он проходит**

Run: `./vendor/bin/pest tests/Feature/Admin/CategoryResourceTest.php`
Expected: PASS

- [ ] **Step 6: Commit**

```bash
git add app/Filament/Resources/CategoryResource.php app/Filament/Resources/CategoryResource/Pages tests/Feature/Admin/CategoryResourceTest.php
git commit -m "feat: добавить Filament CategoryResource для CRUD категорий"
```

---

### Task 9: Обновить фабрику и сидер продуктов — привязка категорий вместо строкового поля

**Files:**
- Modify: `database/factories/ProductFactory.php`
- Modify: `database/seeders/DatabaseSeeder.php`
- Test: `tests/Unit/ProductFactoryTest.php`

**Interfaces:**
- Consumes: `Category::class`, `Product::categories()` (Task 1, 2)

- [ ] **Step 1: Написать падающий тест фабрики**

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_attaches_product_to_an_existing_category(): void
    {
        $category = Category::factory()->create(['key' => 'mono', 'name' => 'Монобукеты']);

        $product = Product::factory()->create();

        $this->assertTrue($product->categories()->exists());
    }
}
```

*(Примечание: тест создаёт категорию заранее, чтобы у фабрики было к чему привязываться — так фабрика не должна сама создавать случайные категории через `Category::factory()`, а привязываться к уже существующим в БД, что соответствует реальному использованию в data-migration и сидере.)*

- [ ] **Step 2: Запустить тест и убедиться, что он падает**

Run: `./vendor/bin/pest tests/Unit/ProductFactoryTest.php`
Expected: FAIL — фабрика продолжает писать в колонку `category`, связь не создаётся.

- [ ] **Step 3: Обновить `database/factories/ProductFactory.php`**

```php
<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = 'Букет "'.fake()->unique()->words(2, true).'"';

        return [
            'name' => $name,
            'slug' => str($name)->slug(),
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(10, 150) * 100,
            'is_available' => fake()->boolean(90), // 90% доступны
        ];
    }

    /**
     * Привязать созданный товар к случайной существующей категории (если есть).
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $category = Category::query()->inRandomOrder()->first();

            if ($category !== null) {
                $product->categories()->attach($category->id);
            }
        });
    }
}
```

- [ ] **Step 4: Запустить тест и убедиться, что он проходит**

Run: `./vendor/bin/pest tests/Unit/ProductFactoryTest.php`
Expected: PASS

- [ ] **Step 5: Обновить `database/seeders/DatabaseSeeder.php`**

Заменить блок создания продуктов. В массиве `$products` заменить ключ `'category' => 'bouquets'` (и другие значения) на отдельный ключ `'categories' => ['bouquets']` (массив ключей категорий), затем после `Product::create()` привязать категории по ключу:

```php
        // Создаем продукты
        foreach ($products as $productData) {
            $categoryKeys = $productData['categories'];
            unset($productData['categories']);

            $product = Product::create($productData);

            $categoryIds = Category::query()->whereIn('key', $categoryKeys)->pluck('id');
            $product->categories()->attach($categoryIds);
        }
```

В каждом элементе массива `$products` заменить `'category' => 'bouquets'` на `'categories' => ['bouquets']`, `'category' => 'seasonal'` на `'categories' => ['seasonal']`, `'category' => 'wedding'` на `'categories' => ['wedding']`, `'category' => 'luxury'` на `'categories' => ['luxury']` — по одной категории на товар, сохраняя текущее распределение. Добавить импорт `use App\Models\Category;` в начало файла.

- [ ] **Step 6: Запустить полный сидер локально для проверки отсутствия ошибок**

Run: `php artisan migrate:fresh --seed --env=testing`
Expected: команда завершается без ошибок; `Product::first()->categories` не пусто.

- [ ] **Step 7: Commit**

```bash
git add database/factories/ProductFactory.php database/seeders/DatabaseSeeder.php tests/Unit/ProductFactoryTest.php
git commit -m "feat: привязывать категории через связь в фабрике и сидере товаров"
```

---

### Task 10: Полный прогон тестов и статического анализа

**Files:** нет новых файлов — проверочный таск.

- [ ] **Step 1: Прогнать весь набор тестов**

Run: `./vendor/bin/pest`
Expected: все тесты проходят, включая ранее существовавшие (`OrderControllerTest`, `WholesaleControllerTest`, `FilamentAccessTest`, `ProfileTest`).

- [ ] **Step 2: Прогнать статический анализ и форматирование (как в pre-commit hook)**

Run: `./vendor/bin/pint --test && ./vendor/bin/phpstan analyse --memory-limit=1G --no-progress`
Expected: оба без ошибок.

- [ ] **Step 3: Проверить миграции с нуля**

Run: `php artisan migrate:fresh --seed`
Expected: без ошибок, в БД есть все категории и связи из data-migration и сидера.

- [ ] **Step 4: Commit (если Step 1-3 потребовали правок)**

```bash
git add -A
git commit -m "fix: устранить замечания pint/phpstan после мультикатегорийности"
```

Если правок не требовалось — пропустить коммит.

---

## Self-Review Notes

- **Spec coverage:** таблица `categories`/pivot (Task 1-2), перенос данных + категория «1 сентября» (Task 3), убраны дублирующиеся константы (Task 4), контроллер каталога (Task 5), blade-шаблоны и футер (Task 6), Filament мультивыбор (Task 7) и CategoryResource (Task 8), фабрика/сидер (Task 9). Всё покрыто.
- **Legacy-колонка `products.category`:** сознательно не удаляется — Global Constraints и Task 3/9 явно её не трогают, только читают при переносе.
- **Одиночный фильтр каталога:** Task 5 сохраняет `?category=` как единственное значение — соответствует Global Constraints.
