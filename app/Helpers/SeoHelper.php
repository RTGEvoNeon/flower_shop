<?php

namespace App\Helpers;

use App\Models\Product;

class SeoHelper
{
    /**
     * Генерирует JSON-LD разметку для продукта
     */
    public static function productSchema(Product $product): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => strip_tags($product->description),
            'image' => $product->main_image && $product->main_image !== '/images/placeholder.svg'
                ? url($product->main_image)
                : null,
            'sku' => $product->id,
            'offers' => [
                '@type' => 'Offer',
                'url' => route('products.show', $product->slug),
                'priceCurrency' => 'RUB',
                'price' => $product->price,
                'availability' => $product->is_available
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'priceValidUntil' => now()->addYear()->format('Y-m-d'),
            ],
        ];

        // Удаляем null значения
        $schema = array_filter($schema, fn($value) => $value !== null);
        $schema['offers'] = array_filter($schema['offers'], fn($value) => $value !== null);

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Генерирует JSON-LD разметку для организации (LocalBusiness)
     */
    public static function organizationSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => 'Mindale',
            'description' => 'Доставка свежих букетов цветов',
            'url' => url('/'),
            'telephone' => '+7-953-292-92-46',
            'priceRange' => '2000₽-10000₽',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Россия',
                'addressCountry' => 'RU',
            ],
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Генерирует breadcrumbs разметку
     */
    public static function breadcrumbsSchema(array $items): string
    {
        $itemListElement = [];
        $position = 1;

        foreach ($items as $name => $url) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $name,
                'item' => $url,
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemListElement,
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
