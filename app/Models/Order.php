<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'total_amount',
        'status',
        'delivery_date',
        'notes'
    ];

    protected $casts = [
        'delivery_date' => 'datetime',
        'total_amount' => 'decimal:2'
    ];

    // Получить товары в заказе
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Получить общую сумму заказа
    public function calculateTotal()
    {
        return $this->orderItems()->sum(\DB::raw('price * quantity'));
    }
}
