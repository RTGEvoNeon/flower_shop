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
        'filename',
        'original_name',
        'path',
        'url',
        'mime_type',
        'file_size',
        'width',
        'height',
        'sort_order',
        'is_primary',
        'is_active',
        'alt_text',
        'description',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'file_size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
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
            get: fn () => $this->url ?: Storage::url($this->path)
        );
    }

    /**
     * Accessor: размер файла в читаемом формате
     */
    protected function humanFileSize(): Attribute
    {
        return Attribute::make(
            get: function () {
                $bytes = $this->file_size;
                $units = ['B', 'KB', 'MB', 'GB'];
                
                for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                    $bytes /= 1024;
                }
                
                return round($bytes, 2) . ' ' . $units[$i];
            }
        );
    }

    /**
     * Accessor: соотношение сторон
     */
    protected function aspectRatio(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->width && $this->height 
                ? round($this->width / $this->height, 2) 
                : null
        );
    }

    /**
     * Mutator: автоматически устанавливает is_primary
     */
    protected function isPrimary(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                // Если устанавливаем как главное, убираем флаг у других
                if ($value && $this->product_id) {
                    static::where('product_id', $this->product_id)
                        ->where('id', '!=', $this->id ?? 0)
                        ->update(['is_primary' => false]);
                }
                return $value;
            }
        );
    }

    /**
     * Проверка, является ли изображение картинкой
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Получить альтернативный текст или имя продукта
     */
    public function getAltTextAttribute($value): string
    {
        return $value ?: $this->product->name ?? 'Product image';
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
