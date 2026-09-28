<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'size', 'price', 'old_price', 'vat_percent',
        'discount_bn', 'discount_en', 'stock', 'sku',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'price' => 'float',
        'old_price' => 'float',
        'vat_percent' => 'float',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /** Prottekta product er active variant gulo order e. */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
