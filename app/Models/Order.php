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

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    /**
     * Delivery status er flow timeline — je status kokhon holo, chronologically.
     * Purano order er history na thakle current status + order time diye fallback.
     */
    public function statusTimeline(): array
    {
        $labels = self::statusLabels();
        $rows = $this->statusHistories()->orderBy('created_at')->get();

        if ($rows->isEmpty()) {
            $rows = collect();
            $rows->push((object) ['status' => 'pending', 'created_at' => $this->created_at]);
            if ($this->status !== 'pending') {
                $rows->push((object) ['status' => $this->status, 'created_at' => $this->updated_at ?: $this->created_at]);
            }
        }

        return $rows->map(fn ($r) => [
            'status' => $r->status,
            'label' => $labels[$r->status] ?? $r->status,
            'time' => $r->created_at ? \Illuminate\Support\Carbon::parse($r->created_at)->format('d M Y, h:i A') : '',
        ])->all();
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
