<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'image', // Оставляем для обратной совместимости
        'category',
        'is_available'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Связь с изображениями (все изображения)
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->ordered();
    }

    /**
     * Связь с активными изображениями
     */
    public function activeImages(): HasMany
    {
        return $this->hasMany(ProductImage::class)->active()->ordered();
    }

    /**
     * Связь с главным изображением
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->primary()->active();
    }

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
     * Scope: с изображениями
     */
    public function scopeWithImages(Builder $query): Builder
    {
        return $query->with(['activeImages', 'primaryImage']);
    }

    /**
     * Accessor: главное изображение или fallback
     */
    protected function mainImage(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Сначала проверяем новую систему
                if ($this->primaryImage) {
                    return $this->primaryImage->full_url;
                }
                
                // Если есть любое активное изображение
                if ($this->activeImages->isNotEmpty()) {
                    return $this->activeImages->first()->full_url;
                }
                
                // Fallback на старое поле image
                if ($this->image) {
                    return $this->image;
                }
                
                // Placeholder
                return '/images/placeholder.jpg';
            }
        );
    }

    /**
     * Accessor: все активные изображения как URL
     */
    protected function imageUrls(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->activeImages->pluck('full_url')->toArray()
        );
    }

    /**
     * Accessor: количество изображений
     */
    protected function imagesCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->activeImages->count()
        );
    }

    /**
     * Accessor: есть ли изображения
     */
    protected function hasImages(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->activeImages->isNotEmpty() || !empty($this->image)
        );
    }

    /**
     * Метод: добавить изображение
     */
    public function addImage(array $imageData): ProductImage
    {
        return $this->images()->create($imageData);
    }

    /**
     * Метод: установить главное изображение
     */
    public function setPrimaryImage(int $imageId): bool
    {
        $image = $this->images()->find($imageId);
        
        if (!$image) {
            return false;
        }

        // Убираем флаг primary у всех изображений продукта
        $this->images()->update(['is_primary' => false]);
        
        // Устанавливаем новое главное
        $image->update(['is_primary' => true]);
        
        return true;
    }

    /**
     * Метод: удалить изображение
     */
    public function removeImage(int $imageId): bool
    {
        $image = $this->images()->find($imageId);
        
        if (!$image) {
            return false;
        }

        return $image->delete();
    }

    /**
     * Метод: получить изображения по размеру
     */
    public function getImagesBySize(string $size = 'all'): \Illuminate\Database\Eloquent\Collection
    {
        $images = $this->activeImages;
        
        return match($size) {
            'small' => $images->filter(fn($img) => $img->width <= 300),
            'medium' => $images->filter(fn($img) => $img->width > 300 && $img->width <= 800),
            'large' => $images->filter(fn($img) => $img->width > 800),
            default => $images
        };
    }
}
