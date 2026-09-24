<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['key', 'value'];

    /** Get a setting with default (cached). */
    public static function get(string $key, $default = null)
    {
        $all = self::allCached();

        return $all[$key] ?? $default;
    }

    /** Store a setting. */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    /** Store many settings at once + clear cache. */
    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            self::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings');
    }

    public static function allCached(): array
    {
        return Cache::rememberForever('site_settings', function () {
            return self::query()->pluck('value', 'key')->all();
        });
    }
}
