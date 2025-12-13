<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
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
                // Сначала проверяем файловую систему products/{id}/
                $filesystemImages = $this->getFilesystemImages();
                if (!empty($filesystemImages)) {
                    return $filesystemImages[0];
                }

                // Затем проверяем базу данных (legacy)
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
            get: function () {
                // Сначала проверяем файловую систему
                $filesystemImages = $this->getFilesystemImages();
                if (!empty($filesystemImages)) {
                    return $filesystemImages;
                }

                // Затем проверяем базу данных (legacy)
                return $this->activeImages->pluck('full_url')->toArray();
            }
        );
    }

    /**
     * Получить изображения из файловой системы products/{id}/
     */
    private function getFilesystemImages(): array
    {
        $directory = "products/{$this->id}";

        if (!Storage::disk('public')->exists($directory)) {
            return [];
        }

        $files = Storage::disk('public')->files($directory);
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $images = [];

        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($extension, $imageExtensions)) {
                $images[] = Storage::url($file);
            }
        }

        // Сортируем по имени файла
        sort($images);

        return $images;
    }


}
