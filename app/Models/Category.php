<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string|null $label_singular
 * @property int $sort_order
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'label_singular',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
