<?php

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
                'desc' => $p->description,
                'desc_en' => $p->description_en,
                'vat_percent' => (float) $p->vat_percent,
                'stock' => (int) $p->stock,
            ]];
        })->all();
    }
}
