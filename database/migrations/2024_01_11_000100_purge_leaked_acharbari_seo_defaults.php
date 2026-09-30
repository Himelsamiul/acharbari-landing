<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

/**
 * Purano SeoController ar seo-meta.blade.php te AcharBari-er title/desc/keywords
 * hardcoded default chhilo. Onno kono business (jemon amrongbd.com) er admin SEO
 * form save korle oi lekha oi site er DB te store hoye jeto — tarpor title tag,
 * og:title, og:description shob jaygay AcharBari dekhato.
 *
 * Ei migration non-AcharBari site theke oi leaked defaults delete kore, jate notun
 * dynamic brand-based default (ab_seo_default_*) kaj korte pare. AcharBari nijer
 * site (khorak.shop) er value gulo intended — oguli untouched thake.
 *
 * Deploy pipeline (setup.php -> migrate --force) dhore dui server-ei auto cholbe.
 */
return new class extends Migration
{
    public function up(): void
    {
        $brand = trim(
            \App\Models\Setting::get('brand_bn1', 'আচার') . \App\Models\Setting::get('brand_bn2', 'বাড়ি')
        );

        // AcharBari nijer site — oi lekha thik-i ache, kichu korar dorkar nei
        if ($brand === '' || $brand === 'আচারবাড়ি') {
            return;
        }

        $leaked = [
            // key => leaked default er chena phrase (value-r bhitore thakle leaked)
            'seo_title' => ['ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ'],
            'seo_desc' => ['ঘরে তৈরি খাঁটি দেশি আচার, মধু, ঘি ও চাটনি'],
            // puro default keyword list-ta te brand naam chhilo — contains-match e enough
            'seo_keywords' => ['আচারবাড়ি'],
        ];

        foreach ($leaked as $key => $patterns) {
            $value = (string) \App\Models\Setting::get($key, '');
            if ($value !== '' && collect($patterns)->contains(fn ($p) => str_contains($value, $p))) {
                \App\Models\Setting::query()->where('key', $key)->delete();
            }
        }

        Cache::forget('site_settings');
    }

    public function down(): void
    {
        // Delete-only cleanup — restore lagbe na, dynamic default nijei boshe ache
    }
};
