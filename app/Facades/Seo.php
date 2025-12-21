<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Services\SeoService setTitle(string $title, bool $appendSiteName = true)
 * @method static \App\Services\SeoService setDescription(string $description)
 * @method static \App\Services\SeoService setKeywords(string|array $keywords)
 * @method static \App\Services\SeoService setCanonical(?string $url = null)
 * @method static \App\Services\SeoService setImage(string $imageUrl, ?string $alt = null)
 * @method static \App\Services\SeoService setType(string $type)
 * @method static \App\Services\SeoService setRobots(string $robots)
 * @method static \App\Services\SeoService addSchema(array $schema)
 * @method static \App\Services\SeoService setProductSchema(string $name, string $description, float $price, string $currency = 'RUB', ?string $image = null, ?string $url = null, ?string $availability = 'InStock')
 * @method static \App\Services\SeoService setLocalBusinessSchema(array $options = [])
 * @method static \App\Services\SeoService setBreadcrumbSchema(array $breadcrumbs)
 * @method static string renderMetaTags()
 * @method static string renderSchema()
 * @method static array getData()
 *
 * @see \App\Services\SeoService
 */
class Seo extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'seo';
    }
}
