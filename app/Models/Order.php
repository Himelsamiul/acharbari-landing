<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code', 'customer_name', 'phone', 'address', 'area', 'district',
        'payment_method', 'payment_status', 'payment_txn_id', 'subtotal', 'discount', 'coupon_code',
        'vat_total', 'shipping_cost', 'total', 'status',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'discount' => 'float',
        'vat_total' => 'float',
        'shipping_cost' => 'float',
        'total' => 'float',
    ];

    public function notifications()
    {
        return $this->hasMany(CustomerNotification::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function statuses(): array
    {
        return ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    }

    public static function statusLabels(): array
    {
        return [
            'pending' => 'পেন্ডিং',
            'processing' => 'প্রসেসিং',
            'shipped' => 'শিপড',
            'delivered' => 'ডেলিভার্ড',
            'cancelled' => 'বাতিল',
        ];
    }
}
