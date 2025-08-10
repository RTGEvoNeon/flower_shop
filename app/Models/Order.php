<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'total_amount',
        'category',
        'is_available',
    ];
    // Получить товары в заказе
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
