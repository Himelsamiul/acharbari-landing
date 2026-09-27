<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'name_en', 'key', 'industry', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_key', 'key');
    }

    /** Only the active industry's rows — other genres never leak through. */
    public function scopeForIndustry($query, ?string $industry = null)
    {
        return $query->where('industry', $industry ?: (ab_industry() ?: 'organic'));
    }
}
