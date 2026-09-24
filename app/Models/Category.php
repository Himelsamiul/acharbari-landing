<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'name_en', 'key'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_key', 'key');
    }
}
