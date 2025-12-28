<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Базовый URL в Punycode для международного домена
     * эдемский-сад.рф = xn----8sbkccshgr4ce9k.xn--p1ai
     */
    private const BASE_URL = 'https://xn----8sbkccshgr4ce9k.xn--p1ai';

    /**
     * Генерирует URL в Punycode формате
     */
    private function punycodeUrl(string $path = ''): string
    {
        return self::BASE_URL . $path;
    }

    public function index()
    {
        // Получаем все активные товары
        $products = Product::all();

        // Статические страницы сайта
        $staticPages = [
            [
                'url' => $this->punycodeUrl('/'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'url' => $this->punycodeUrl('/products'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
            [
                'url' => $this->punycodeUrl('/delivery'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'url' => $this->punycodeUrl('/about'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'url' => $this->punycodeUrl('/contacts'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'url' => $this->punycodeUrl('/privacy'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'yearly',
                'priority' => '0.3'
            ]
        ];

        // Генерируем XML
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Добавляем статические страницы
        foreach ($staticPages as $page) {
            $sitemap .= "  <url>\n";
            $sitemap .= "    <loc>{$page['url']}</loc>\n";
            $sitemap .= "    <lastmod>{$page['lastmod']}</lastmod>\n";
            $sitemap .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $sitemap .= "    <priority>{$page['priority']}</priority>\n";
            $sitemap .= "  </url>\n";
        }

        // Добавляем товары
        foreach ($products as $product) {
            $sitemap .= "  <url>\n";
            $sitemap .= "    <loc>" . $this->punycodeUrl('/product/' . $product->slug) . "</loc>\n";
            $sitemap .= "    <lastmod>" . $product->updated_at->toAtomString() . "</lastmod>\n";
            $sitemap .= "    <changefreq>weekly</changefreq>\n";
            $sitemap .= "    <priority>0.8</priority>\n";
            $sitemap .= "  </url>\n";
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
}
