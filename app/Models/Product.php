<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'slug', 'name', 'name_en', 'category', 'category_en', 'category_key',
        'brand', 'unit', 'stock', 'barcode',
        'price', 'old_price', 'discount_bn', 'discount_en', 'image', 'vat_percent', 'supplier_id',
        'rating', 'reviews_count', 'stock_badge', 'stock_badge_en',
        'description', 'description_en', 'sort_order', 'is_active', 'is_featured',
        'meta_title', 'meta_description', 'image_alt',
    ];

    protected $casts = [
        'price' => 'float',
        'old_price' => 'float',
        'rating' => 'float',
        'stock' => 'integer',
        'vat_percent' => 'float',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
