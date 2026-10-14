<?php

namespace App\Support;

use App\Http\Controllers\Admin\IndustryPack;

/**
 * Genre demo context for the public showcase live-demo pages
 * (/showcase/{genre}). Fully request-derived — active only while the current
 * request's route IS the demo route, so nothing leaks into other requests
 * (including back-to-back requests inside the test suite).
 *
 * While active, the landing helpers (ab_t, ab_img_setting, ab_json, …)
 * resolve copy/images from the IndustryPack instead of the store's global
 * settings — the demo pages must never read or mutate the store's identity.
 */
class GenreDemo
{
    /** Active genre key for THIS request, or null outside a demo page. */
    public static function active(): ?string
    {
        $route = request()?->route();
        if (!$route || $route->getName() !== 'showcase.demo') {
            return null;
        }

        $genre = $route->parameter('genre');
        return is_string($genre) && IndustryPack::valid($genre) ? $genre : null;
    }

    /** The active genre's full pack, or null outside a demo page. */
    public static function pack(): ?array
    {
        $genre = self::active();

        return $genre !== null ? IndustryPack::all()[$genre] : null;
    }
}
