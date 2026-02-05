<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\Seo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Доступные категории для фильтрации.
     */
    private const CATEGORIES = [
        'all' => 'Все букеты',
        'mono' => 'Монобукеты',
        'mix' => 'Микс букеты',
        'tulip' => 'Тюльпаны',
        'winter' => 'Зима',
        'wedding' => 'Свадебные',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $category = $this->validateCategory($request->query('category'));

        $this->setSeoForCatalog($category);

        $products = $this->getFilteredProducts($category);

        return view('products.index', [
            'products' => $products,
            'categories' => self::CATEGORIES,
            'currentCategory' => $category,
        ]);
    }

    /**
     * Валидация и нормализация категории.
     */
    private function validateCategory(?string $category): string
    {
        if ($category === null || $category === 'all' || !array_key_exists($category, self::CATEGORIES)) {
            return 'all';
        }

        return $category;
    }

    /**
     * Получить отфильтрованные товары с пагинацией.
     */
    private function getFilteredProducts(string $category): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Product::available()->withImages();

        if ($category !== 'all') {
            $query->byCategory($category);
        }

        return $query->paginate(18)->withQueryString();
    }

    /**
     * Установить SEO-данные для каталога.
     */
    private function setSeoForCatalog(string $category): void
    {
        $categoryName = self::CATEGORIES[$category] ?? 'Каталог';
        $isFiltered = $category !== 'all';

        $title = $isFiltered
            ? "{$categoryName} — купить в Брянске"
            : 'Каталог букетов';

        $description = $isFiltered
            ? "{$categoryName} от цветочной мастерской Эдемский сад. Доставка по Брянску бесплатно."
            : 'Каталог свежих букетов от цветочной мастерской Эдемский сад. Монобукеты и миксы от 2000₽. Доставка по Брянску бесплатно. Более 50 вариантов букетов.';

        $canonicalUrl = $isFiltered
            ? route('products.index', ['category' => $category])
            : route('products.index');

        Seo::setTitle($title)
            ->setDescription($description)
            ->setKeywords(['каталог цветов', 'купить букет', 'цены на букеты Брянск', 'свежие цветы'])
            ->setCanonical($canonicalUrl)
            ->setBreadcrumbSchema([
                ['name' => 'Главная', 'url' => url('/')],
                ['name' => 'Каталог', 'url' => route('products.index')],
            ]);
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
        $product = Product::where('slug', $slug)->firstOrFail();

        // SEO для страницы товара
        $title = $product->name . ' — купить в Брянске';
        $description = $product->description
            ? mb_substr($product->description, 0, 140) . '... Цена: ' . number_format((float) $product->price, 0, '', ' ') . '₽. Доставка по Брянску бесплатно.'
            : "Букет {$product->name} от цветочной мастерской Эдемский сад. Цена: " . number_format((float) $product->price, 0, '', ' ') . "₽. Свежие цветы, бесплатная доставка по Брянску.";

        $categoryKeywords = [
            'mono' => 'монобукет',
            'mix' => 'букет микс',
            'tulip' => 'тюльпаны',
            'winter' => 'зимний букет',
            'wedding' => 'свадебный букет',
        ];

        Seo::setTitle($title)
            ->setDescription($description)
            ->setKeywords([
                $product->name,
                "купить {$product->name}",
                "{$product->name} Брянск",
                "букет {$product->name}",
                $categoryKeywords[$product->category] ?? 'букет'
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
