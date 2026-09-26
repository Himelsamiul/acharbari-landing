<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id', 'product_id', 'quantity', 'unit_cost', 'total',
        'purchased_at', 'note',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_cost' => 'float',
        'total' => 'float',
        'purchased_at' => 'date',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $purchase) {
            $purchase->total = $purchase->quantity * $purchase->unit_cost;
        });
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
