<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SitemapUrl extends Model
{
    protected $fillable = ['loc', 'priority', 'changefreq', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'priority' => 'float'];

    public static function active(): array
    {
        return Cache::rememberForever('sitemap_urls', function () {
            return static::where('is_active', true)
                ->orderByDesc('priority')
                ->get(['loc', 'priority', 'changefreq'])
                ->map(fn ($u) => ['loc' => $u->loc, 'priority' => number_format($u->priority, 1, '.', ''), 'freq' => $u->changefreq])
                ->all();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('sitemap_urls'));
        static::deleted(fn () => Cache::forget('sitemap_urls'));
    }
}
