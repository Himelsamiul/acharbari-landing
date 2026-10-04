<?php

/**
 * Permission registry — the single source of truth for the 3-role system.
 *
 * super_admin (platform owner) → everything, no grants needed.
 * admin (client/merchant)      → only the module.feature pairs granted via the
 *                                super-admin permission matrix (/super/admins).
 * customer (end buyer)         → storefront only, never the admin panel.
 *
 * The matrix UI, the `perm:` route middleware strings and the sidebar gating
 * all read this config. Modules in `always` are available to every admin and
 * are NOT grantable; everything in `modules` is grantable per-feature.
 *
 * `theme`, `payment`, `tracking` and `content` are split into granular feature
 * keys. A legacy stored grant of `module => ['edit']` meant full control and is
 * rewritten to `['*']` by the 2024_01_08_000300 migration.
 *
 * Optional per-module keys:
 *  - `groups`: feature => sub-heading mapping used only by the matrix UI when
 *    a module has many features (every feature must appear in exactly one
 *    group; features themselves stay in `features`).
 */

return [

    'always' => [
        'dashboard' => 'ড্যাশবোর্ড',
        'notifications' => 'নোটিফিকেশন',
    ],

    'modules' => [
        'orders' => [
            'label' => 'অর্ডার',
            'features' => [
                'view' => 'দেখা',
                'status_update' => 'স্ট্যাটাস পরিবর্তন',
                'delete' => 'মুছে ফেলা',
            ],
        ],
        'complaints' => [
            'label' => 'কমপ্লেইন',
            'features' => [
                'view' => 'দেখা',
                'resolve' => 'সমাধান/টগল',
                'delete' => 'মুছে ফেলা',
            ],
        ],
        'customers' => [
            'label' => 'গ্রাহক',
            'features' => [
                'view' => 'দেখা',
                'rename' => 'নাম পরিবর্তন',
                'delete' => 'মুছে ফেলা',
            ],
        ],
        'suppliers' => [
            'label' => 'সাপ্লায়ার',
            'features' => [
                'view' => 'দেখা',
                'create' => 'তৈরি',
                'edit' => 'এডিট',
                'delete' => 'মুছে ফেলা',
                'purchases' => 'কেনাকাটা হিস্ট্রি',
            ],
        ],
        'coupons' => [
            'label' => 'কুপন',
            'features' => [
                'view' => 'দেখা',
                'create' => 'তৈরি',
                'edit' => 'এডিট',
                'delete' => 'মুছে ফেলা',
            ],
        ],
        'reviews' => [
            'label' => 'রিভিউ',
            'features' => [
                'view' => 'দেখা',
                'edit' => 'এডিট',
            ],
        ],
        'products' => [
            'label' => 'প্রোডাক্ট',
            'features' => [
                'view' => 'দেখা',
                'create' => 'তৈরি',
                'edit' => 'এডিট',
                'delete' => 'মুছে ফেলা',
            ],
        ],
        'taxonomy' => [
            'label' => 'ক্যাটাগরি ও ব্র্যান্ড',
            'features' => [
                'view' => 'দেখা',
                'manage_categories' => 'ক্যাটাগরি ম্যানেজ',
                'manage_brands' => 'ব্র্যান্ড ম্যানেজ',
            ],
        ],
        'delivery' => [
            'label' => 'ডেলিভারি এরিয়া',
            'features' => [
                'view' => 'দেখা',
                'edit' => 'এডিট',
            ],
        ],
        // payment is per-gateway granular: master online toggle + bKash / Nagad
        // credentials are independently grantable (separate POST routes).
        'payment' => [
            'label' => 'পেমেন্ট গেটওয়ে',
            'features' => [
                'view' => 'দেখা',
                'online_toggle' => 'অনলাইন পেমেন্ট টগল',
                'bkash_edit' => 'বিকাশ কনফিগার',
                'nagad_edit' => 'নগদ কনফিগার',
            ],
        ],
        // one feature per tracking pixel (keys match SettingController::TRACKERS)
        'tracking' => [
            'label' => 'ট্র্যাকিং ও পিক্সেল',
            'features' => [
                'view' => 'দেখা',
                'fb' => 'Facebook Pixel',
                'ga' => 'Google Analytics 4',
                'gtm' => 'Google Tag Manager',
                'tiktok' => 'TikTok Pixel',
            ],
        ],
        // landing content splits along the page's own tabs (each tab is one form
        // that only saves its own keys, so per-tab grants are safe)
        'content' => [
            'label' => 'ল্যান্ডিং কনটেন্ট',
            'features' => [
                'view' => 'দেখা',
                'hero' => 'হিরো সেকশন',
                'sections' => 'সেকশন লেখা',
                'order_form' => 'অর্ডার ফর্ম লেখা',
                'footer' => 'নেভিগেশন ও ফুটার',
            ],
        ],
        'sections' => [
            'label' => 'সেকশন ডিজাইন',
            'features' => [
                'view' => 'দেখা',
                'edit' => 'এডিট',
            ],
        ],
        'brand_settings' => [
            'label' => 'লোগো ও ব্র্যান্ড',
            'features' => [
                'view' => 'দেখা',
                'edit' => 'এডিট',
            ],
        ],
        // theme is the reference implementation of feature-granular permissions:
        // every independently visible card/action on the theme page is its own
        // grantable key. `groups` (optional) only shapes the matrix UI layout.
        'theme' => [
            'label' => 'থিম কালার',
            'features' => [
                'view' => 'দেখা',
                'live_preview' => 'লাইভ প্রিভিউ',
                'ready_made' => 'রেডিমেড থিম',
                'custom_colors' => 'কাস্টম কালার',
                'saved_themes' => 'আমার সেভ করা থিম',
                'recent_themes' => 'সাম্প্রতিক থিম',
                'fonts' => 'ফন্ট',
                'style_tokens' => 'স্টাইল টোকেন',
                'festive' => 'উৎসব অটো-শিডিউল',
                'reset' => 'থিম রিসেট',
                'industry_preset' => 'ইন্ডাস্ট্রি প্রিসেট',
            ],
            'groups' => [
                'দেখা ও প্রিভিউ' => ['view', 'live_preview'],
                'সেভ ও প্রয়োগ' => ['ready_made', 'custom_colors', 'saved_themes', 'recent_themes', 'reset'],
                'ফন্ট ও স্টাইল' => ['fonts', 'style_tokens'],
                'শিডিউল ও প্রোভিশনিং' => ['festive', 'industry_preset'],
            ],
        ],
        'seo' => [
            'label' => 'SEO Settings',
            'features' => [
                'view' => 'দেখা',
                'edit' => 'এডিট',
            ],
        ],
        'robots' => [
            'label' => 'robots.txt',
            'features' => [
                'view' => 'দেখা',
                'edit' => 'এডিট',
            ],
        ],
        'redirects' => [
            'label' => '301 Redirects',
            'features' => [
                'view' => 'দেখা',
                'manage' => 'ম্যানেজ',
            ],
        ],
        'sitemap' => [
            'label' => 'Sitemap',
            'features' => [
                'view' => 'দেখা',
                'manage' => 'ম্যানেজ',
            ],
        ],
    ],

    /**
     * Sellable packages — preset buttons on the permission matrix that pre-fill
     * the checkboxes. `full` = every module.
     */
    'presets' => [
        'orders_only' => [
            'label' => 'শুধু অর্ডার',
            'map' => [
                'orders' => ['view', 'status_update'],
            ],
        ],
        'store_manager' => [
            'label' => 'স্টোর ম্যানেজার',
            'map' => [
                'orders' => '*',
                'complaints' => '*',
                'customers' => '*',
                'suppliers' => '*',
                'coupons' => '*',
                'reviews' => '*',
                'products' => '*',
                'taxonomy' => '*',
                'delivery' => '*',
                // day-to-day look tweaks yes; site-wide festival scheduling and
                // the whole-site industry re-skin stay super-admin territory
                'theme' => ['view', 'live_preview', 'ready_made', 'custom_colors', 'saved_themes', 'recent_themes', 'fonts', 'style_tokens', 'reset'],
            ],
        ],
        'full' => [
            'label' => 'সম্পূর্ণ',
            'map' => '*',
        ],
    ],
];
