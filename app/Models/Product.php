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
        'id',
        'name',
        'slug',
        'description',
        'price',
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
                if ($this->primaryImage) {
                    return $this->primaryImage->full_url;
                }

                if ($this->activeImages->isNotEmpty()) {
                    return $this->activeImages->first()->full_url;
                }

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


}
