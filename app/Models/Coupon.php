<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Coupon extends Model
{
    protected $fillable = ['code', 'percent', 'is_active', 'expires_at'];

    protected $casts = [
        'percent' => 'integer',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /** Active, non-expired coupons keyed by uppercase code → percent (cached). */
    public static function activeMap(): array
    {
        return Cache::remember('active_coupons', 300, function () {
            return self::query()
                ->where('is_active', true)
                ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
                ->pluck('percent', 'code')
                ->mapWithKeys(fn ($percent, $code) => [strtoupper($code) => $percent])
                ->all();
        });
    }

    /** Look up a valid coupon by code (case-insensitive). */
    public static function valid(string $code): ?self
    {
        $map = self::activeMap();

        return isset($map[strtoupper($code)]) ? self::where('code', strtoupper($code))->first() : null;
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('active_coupons'));
        static::deleted(fn () => Cache::forget('active_coupons'));
    }
}
