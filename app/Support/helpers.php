<?php

if (!function_exists('ab_img')) {
    /** Prefer an existing .webp sibling of the image (falls back to the original). */
    function ab_img(string $path): string
    {
        $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);

        return ($webp !== $path && is_file(public_path($webp))) ? $webp : $path;
    }
}

if (!function_exists('asset_v')) {
    /** Asset URL with automatic cache-busting version (file modification time). */
    function asset_v(string $path): string
    {
        $full = public_path($path);

        return asset($path) . (is_file($full) ? '?v=' . filemtime($full) : '');
    }
}

if (!function_exists('ab_contact')) {
    /** Contact info from admin settings with sensible defaults. */
    function ab_contact(string $key): string
    {
        $defaults = [
            'phone' => '01707373692',
            'whatsapp' => '8801707373692',
            'messenger' => 'AcharBari',
            'facebook' => 'https://facebook.com/',
        ];

        $value = trim((string) \App\Models\Setting::get('contact_' . $key, ''));

        return $value !== '' ? $value : ($defaults[$key] ?? '');
    }
}

if (!function_exists('bn_num')) {
    function bn_num($num): string
    {
        return strtr(number_format((float) $num), [
            '0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪',
            '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯',
        ]);
    }
}

if (!function_exists('buildQuickView')) {
    function buildQuickView($products): array
    {
        return $products->mapWithKeys(function ($p) {
            return [$p->id => [
                'title' => $p->name,
                'title_en' => $p->name_en,
                'category' => $p->category,
                'category_en' => $p->category_en,
                'price' => '৳' . bn_num($p->price),
                'price_en' => '৳' . number_format($p->price),
                'oldPrice' => '৳' . bn_num($p->old_price),
                'oldPrice_en' => '৳' . number_format($p->old_price),
                'discount' => $p->discount_bn,
                'discount_en' => $p->discount_en,
                'img' => asset($p->image),
                'alt' => $p->image_alt ?: $p->name,
                'desc' => $p->description,
                'desc_en' => $p->description_en,
                'vat_percent' => (float) $p->vat_percent,
                'stock' => (int) $p->stock,
            ]];
        })->all();
    }
}
