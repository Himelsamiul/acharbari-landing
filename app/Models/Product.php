<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'slug', 'name', 'name_en', 'category', 'category_en', 'category_key',
        'price', 'old_price', 'discount_bn', 'discount_en', 'image',
        'rating', 'reviews_count', 'stock_badge', 'stock_badge_en',
        'description', 'description_en', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'price' => 'float',
        'old_price' => 'float',
        'rating' => 'float',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
