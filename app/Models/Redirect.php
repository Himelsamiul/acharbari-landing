<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    protected $fillable = ['from_path', 'to_url', 'status_code', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    /** Active redirect map: [from_path => [to_url, code]] — cached. */
    public static function map(): array
    {
        return Cache::rememberForever('redirect_map', function () {
            return static::where('is_active', true)
                ->get(['from_path', 'to_url', 'status_code'])
                ->mapWithKeys(fn ($r) => [$r->from_path => ['to' => $r->to_url, 'code' => $r->status_code]])
                ->all();
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('redirect_map');
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::flushCache());
        static::deleted(fn () => self::flushCache());
    }
}
