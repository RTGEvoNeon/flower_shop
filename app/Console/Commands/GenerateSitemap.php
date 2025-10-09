<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Генерирует sitemap.xml для SEO';

    public function handle()
    {
        $this->info('Генерация sitemap.xml...');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        // Главная страница
        $sitemap .= $this->addUrl(url('/'), '1.0', 'daily');

        // Страница сборки букета
        $sitemap .= $this->addUrl(url('/custom-bouquet'), '0.8', 'weekly');

        // Страницы товаров
        Product::available()->chunk(100, function ($products) use (&$sitemap) {
            foreach ($products as $product) {
                $sitemap .= $this->addUrl(
                    route('products.show', $product->slug),
                    '0.9',
                    'weekly',
                    $product->updated_at
                );
            }
        });

        // Политики
        $sitemap .= $this->addUrl(url('/privacy'), '0.3', 'yearly');
        $sitemap .= $this->addUrl(url('/terms'), '0.3', 'yearly');

        $sitemap .= '</urlset>';

        // Сохранить в public/sitemap.xml
        File::put(public_path('sitemap.xml'), $sitemap);

        $this->info('✓ Sitemap успешно создан: public/sitemap.xml');

        return 0;
    }

    /**
     * Добавляет URL в sitemap
     */
    private function addUrl(string $loc, string $priority, string $changefreq, $lastmod = null): string
    {
        $url = '  <url>' . PHP_EOL;
        $url .= '    <loc>' . htmlspecialchars($loc) . '</loc>' . PHP_EOL;
        $url .= '    <priority>' . $priority . '</priority>' . PHP_EOL;
        $url .= '    <changefreq>' . $changefreq . '</changefreq>' . PHP_EOL;

        if ($lastmod) {
            $url .= '    <lastmod>' . $lastmod->format('Y-m-d') . '</lastmod>' . PHP_EOL;
        }

        $url .= '  </url>' . PHP_EOL;

        return $url;
    }
}
