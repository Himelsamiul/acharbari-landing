<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name', 'company', 'phone', 'address', 'note', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /** Total money spent purchasing from this supplier. */
    public function totalPurchased(): float
    {
        return (float) $this->purchases()->sum('total');
    }
}
