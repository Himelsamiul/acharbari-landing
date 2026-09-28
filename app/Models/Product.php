<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'slug', 'name', 'name_en', 'category', 'category_en', 'category_key', 'industry',
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

    /** Only the active industry's rows — other genres never leak through. */
    public function scopeForIndustry($query, ?string $industry = null)
    {
        return $query->where('industry', $industry ?: (ab_industry() ?: 'organic'));
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order')->orderBy('id');
    }

    public function activeVariants()
    {
        return $this->variants()->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    /** Variant ase kina — order/price logic ekhane theke switch hoy. */
    public function hasVariants(): bool
    {
        return $this->activeVariants()->exists();
    }

    /** Order/cart e default variant — na thakle null (product er nijer price). */
    public function defaultVariant(): ?ProductVariant
    {
        return $this->activeVariants()->first();
    }

    /** Active variant der motal stock — landing e stock badge etai dekhabe. */
    public function variantStock(): int
    {
        return (int) $this->activeVariants()->sum('stock');
    }

    /** Active variant der moddhe sosto dam — listing e "৳30 theke" dekhate. */
    public function variantMinPrice(): ?float
    {
        return $this->activeVariants()->min('price');
    }

    public function variantMaxPrice(): ?float
    {
        return $this->activeVariants()->max('price');
    }
}
