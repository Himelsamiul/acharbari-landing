<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ModuleController extends Controller
{
    /**
     * Draft modules — template pages ready for future development.
     * Each entry renders a "coming soon" screen inside the admin panel.
     */
    public static array $modules = [
        'customers' => [
            'name' => 'গ্রাহক ম্যানেজমেন্ট',
            'icon' => 'fa-solid fa-users',
            'color' => '#2563eb',
            'desc' => 'সব গ্রাহকের তালিকা, অর্ডার হিস্ট্রি, রিপিট কাস্টমার ও সেগমেন্ট।',
            'features' => ['গ্রাহক তালিকা ও সার্চ', 'অর্ডার হিস্ট্রি ভিউ', 'রিপিট কাস্টমার রেট', 'ইউনিক গ্রাহক স্ট্যাটিসটিক্স'],
        ],
        'suppliers' => [
            'name' => 'সাপ্লায়ার ম্যানেজমেন্ট',
            'icon' => 'fa-solid fa-truck-field',
            'color' => '#0d9488',
            'desc' => 'কাঁচামাল ও প্যাকেজিং সরবরাহকারী, পারচেজ হিস্ট্রি ও বাকির হিসাব।',
            'features' => ['সাপ্লায়ার তালিকা', 'পারচেজ হিস্ট্রি', 'বাকির হিসাব (ডু ট্র্যাকিং)', 'নতুন সাপ্লায়ার যোগ'],
        ],
        'coupons' => [
            'name' => 'কুপন ম্যানেজমেন্ট',
            'icon' => 'fa-solid fa-ticket',
            'color' => '#7c3aed',
            'desc' => 'ডিসকাউন্ট কুপন তৈরি, সক্রিয়/নিষ্ক্রিয় ও ব্যবহারের হিসাব।',
            'features' => ['কুপন তৈরি ও এডিট', 'সক্রিয়/বন্ধ টগল', 'ব্যবহারের কাউন্ট', 'মেয়াদ ম্যানেজমেন্ট'],
        ],
        'reviews' => [
            'name' => 'রিভিউ মডারেশন',
            'icon' => 'fa-solid fa-star',
            'color' => '#f59e0b',
            'desc' => 'কাস্টমার রিভিউ অ্যাপ্রুভ, ডিলিট ও ল্যান্ডিং পেজে দেখানো।',
            'features' => ['রিভিউ অ্যাপ্রুভ/ডিলিট', 'রেটিং সামারি', 'ল্যান্ডিং পেজ সিঙ্ক'],
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
            'features' => ['Pixel ID সেটআপ', 'অটো ইভেন্ট ফায়ার', 'কনভার্সন ট্র্যাকিং'],
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
            'desc' => 'কোড ছাড়াই সব মার্কেটিং ট্যাগ ও পিক্সেল ম্যানেজ করুন।',
            'features' => ['Container ID সেটআপ', 'ট্যাগ ম্যানেজমেন্ট', 'ওয়ার্কস্পেস সাপোর্ট'],
        ],
        'tiktok' => [
            'name' => 'TikTok Pixel',
            'icon' => 'fa-brands fa-tiktok',
            'color' => '#FE2C55',
            'desc' => 'টিকটক অ্যাড পারফরম্যান্স ও কনভার্সন ট্র্যাকিং।',
            'features' => ['Pixel Code সেটআপ', 'কনভার্সন ইভেন্ট', 'ক্যাম্পেইন অপটিমাইজেশন'],
        ],
        'seo' => [
            'name' => 'SEO Settings',
            'icon' => 'fa-solid fa-magnifying-glass-chart',
            'color' => '#dc2626',
            'desc' => 'Meta title (৫০-৮০), description (১৬০-৩০০) ও keywords — Google SERP প্রিভিউ সহ।',
            'features' => ['Meta Title + কাউন্টার', 'Meta Description', 'Keywords ম্যানেজার', 'Google SERP প্রিভিউ'],
        ],
        'sitemap' => [
            'name' => 'Sitemap জেনারেটর',
            'icon' => 'fa-solid fa-sitemap',
            'color' => '#059669',
            'desc' => 'সাইটের সব পেজ ও প্রোডাক্ট নিয়ে sitemap.xml জেনারেট ও ডাউনলোড।',
            'features' => ['অটো-জেনারেট', 'কপি ও ডাউনলোড', 'সার্চ কনসোলে জমা দেওয়ার গাইড'],
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
