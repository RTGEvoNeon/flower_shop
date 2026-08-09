<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 */
class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const PHOTOS_COLLECTION = 'photos';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::PHOTOS_COLLECTION);
    }

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'price',
        'category',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'float',
    ];

    /**
     * Scope: только доступные товары
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope: по категории
     */
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
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
}
