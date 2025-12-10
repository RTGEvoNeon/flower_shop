<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'path',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Связь с продуктом
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope: только активные изображения
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: главное изображение
     */
    public function scopePrimary(Builder $query): Builder
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope: сортировка по порядку
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Accessor: полный URL изображения
     */
    protected function fullUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url($this->path)
        );
    }

    /**
     * Удаление файла при удалении записи
     */
    protected static function booted(): void
    {
        static::deleting(function (ProductImage $image) {
            if ($image->path && Storage::exists($image->path)) {
                Storage::delete($image->path);
            }
        });
    }
}
