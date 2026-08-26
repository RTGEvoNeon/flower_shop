<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\Seo;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
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
            ->whereHas('products', function (Builder $query): Builder {
                /** @var Builder<Product> $query */
                return $query->available();
            })
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
        $query = Product::available()->withImages()->with('categories');

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

        $firstCategory = $product->categories->first();
        $categoryKeyword = $firstCategory instanceof Category ? $firstCategory->name : 'букет';

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
