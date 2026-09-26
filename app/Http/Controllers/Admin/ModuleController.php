<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ModuleController extends Controller
{
    /**
     * Draft modules — template pages ready for future development.
     */
    public static array $modules = [
        'coupons' => [
            'name' => 'কুপন ম্যানেজমেন্ট',
            'icon' => 'fa-solid fa-ticket',
            'color' => '#7c3aed',
            'desc' => 'ডিসকাউন্ট কুপন তৈরি, সক্রিয়/নিষ্ক্রিয় ও ব্যবহারের হিসাব।',
            'features' => ['কুপন তৈরি ও এডিট', 'সক্রিয়/বন্ধ টগল', 'ব্যবহারের কাউন্ট', 'মেয়াদ ম্যানেজমেন্ট'],
        ],
        'payments' => [
            'name' => 'পেমেন্ট গেটওয়ে',
            'icon' => 'fa-solid fa-credit-card',
            'color' => '#e2136e',
            'desc' => 'bKash, Nagad, Rocket, Upay ও SSLCommerz API সংযোগ।',
            'features' => ['bKash Merchant API', 'Nagad / Rocket / Upay', 'SSLCommerz ইন্টিগ্রেশন', 'Sandbox / Live মোড'],
        ],
        'fbpixel' => [
            'name' => 'Facebook Pixel',
            'icon' => 'fa-brands fa-facebook',
            'color' => '#1877F2',
            'desc' => 'ফেসবুক অ্যাড কনভার্সন ট্র্যাকিং — PageView, AddToCart, Purchase ইভেন্ট।',
            'features' => ['Pixel ID সেটআপ', 'অটো ইভেন্ট ফায়ার', 'noscript fallback', 'কনভার্সন ট্র্যাকিং'],
        ],
        'ganalytics' => [
            'name' => 'Google Analytics 4',
            'icon' => 'fa-solid fa-chart-line',
            'color' => '#F9AB00',
            'desc' => 'ওয়েবসাইট ট্রাফিক, সোর্স ও ইভেন্ট অ্যানালিটিক্স।',
            'features' => ['GA4 Measurement ID', 'ইভেন্ট ট্র্যাকিং', 'রিয়েলটাইম রিপোর্ট'],
        ],
        'tagmanager' => [
            'name' => 'Google Tag Manager',
            'icon' => 'fa-solid fa-tags',
            'color' => '#246FDB',
            'desc' => 'কোড ছাড়াই সব মার্কেটিং ট্যাগ ম্যানেজ করুন।',
            'features' => ['Container ID সেটআপ', 'ট্যাগ ম্যানেজমেন্ট', 'ওয়ার্কস্পেস সাপোর্ট'],
        ],
        'tiktok' => [
            'name' => 'TikTok Pixel',
            'icon' => 'fa-brands fa-tiktok',
            'color' => '#FE2C55',
            'desc' => 'টিকটক অ্যাড পারফরম্যান্স ট্র্যাকিং।',
            'features' => ['Pixel Code সেটআপ', 'কনভার্সন ইভেন্ট', 'ক্যাম্পেইন অপটিমাইজেশন'],
        ],
    ];

    public function show(string $module)
    {
        abort_unless(isset(self::$modules[$module]), 404);

        return view('admin.module', [
            'module' => $module,
            'info' => self::$modules[$module],
        ]);
    }
}
