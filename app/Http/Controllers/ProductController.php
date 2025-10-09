<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::available()
            ->withImages()
            ->paginate(12);
        return view('products.catalog', compact('products'));
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
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['activeImages' => function($query) {
                $query->ordered();
            }, 'primaryImage'])
            ->firstOrFail();

        // SEO данные для мета-тегов
        $seoData = [
            'title' => $product->name . ' - Купить букет цветов | Mindale',
            'description' => mb_substr(strip_tags($product->description), 0, 155) . ' Цена: ' . number_format($product->price, 0) . '₽. Быстрая доставка.',
            'keywords' => $product->name . ', купить ' . $product->name . ', букет ' . $product->category . ', доставка цветов',
            'ogType' => 'product',
            'ogTitle' => $product->name,
            'ogDescription' => mb_substr(strip_tags($product->description), 0, 155),
            'ogImage' => $product->main_image && $product->main_image !== '/images/placeholder.svg'
                ? url($product->main_image)
                : asset('images/og-default.jpg'),
            'canonical' => route('products.show', $product->slug),
        ];

        return view('products.show', array_merge(compact('product'), $seoData));
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
