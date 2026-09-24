<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'price', 'quantity', 'line_total',
    ];

    protected $casts = [
        'price' => 'float',
        'line_total' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
