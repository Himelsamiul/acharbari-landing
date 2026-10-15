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
        // showcase demo admin context: genre defaults + nijer sandbox age,
        // tarpor global store — real store er data demo panel e leak o hoy,
        // demo er change real store e jay o na
        $sandbox = \App\Support\AdminGenre::settings();
        if ($sandbox !== null && array_key_exists($key, $sandbox)) {
            return $sandbox[$key];
        }

        $all = self::allCached();

        return $all[$key] ?? $default;
    }

    /** Setting ROW ta ase kina (khali string holeo true — admin intentionally clear korse). */
    public static function has(string $key): bool
    {
        $sandbox = \App\Support\AdminGenre::settings();
        if ($sandbox !== null && array_key_exists($key, $sandbox)) {
            return true;
        }

        return array_key_exists($key, self::allCached());
    }

    /** Store a setting. */
    public static function set(string $key, $value): void
    {
        if (\App\Support\AdminGenre::active() !== null) {
            \App\Support\AdminGenre::put($key, $value);

            return; // sandbox e gelo — global cache/session er dorkar nei
        }

        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    /** Store many settings at once + clear cache. */
    public static function setMany(array $pairs): void
    {
        if (\App\Support\AdminGenre::active() !== null) {
            \App\Support\AdminGenre::putMany($pairs);

            return;
        }

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

    /** Full settings map for the current context (View composer er $settings). */
    public static function allForContext(): array
    {
        $all = self::allCached();
        $sandbox = \App\Support\AdminGenre::settings();
        if ($sandbox !== null) {
            $all = array_merge($all, $sandbox);
        }

        return $all;
    }
}
