<?php

namespace App\Http\Controllers\Admin;

/**
 * Section Design System — central registry.
 *
 * Sections + variant metadata for the admin Design Studio. Variant FILES are
 * auto-discovered (resources/views/sections/{section}/design-N.blade.php);
 * the metadata below only adds names/descriptions/badges. To add a new design:
 * drop design-N.blade.php in the section folder and (optionally) add metadata.
 */
class SectionDesignLibrary
{
    /** Section order on the landing page + Bengali labels for the admin. */
    public static function sections(): array
    {
        return [
            'navbar' => ['bn' => 'নেভিগেশন বার', 'en' => 'Navbar', 'icon' => 'fa-compass'],
            'hero' => ['bn' => 'হিরো', 'en' => 'Hero', 'icon' => 'fa-rocket'],
            'trust' => ['bn' => 'ট্রাস্ট মার্কি', 'en' => 'Trust Marquee', 'icon' => 'fa-shield-halved'],
            'products' => ['bn' => 'প্রোডাক্ট সেকশন', 'en' => 'Products', 'icon' => 'fa-jar'],
            'promises' => ['bn' => 'আমাদের গ্যারান্টি', 'en' => 'Promises', 'icon' => 'fa-medal'],
            'how-it-works' => ['bn' => 'কীভাবে অর্ডার হয়', 'en' => 'How It Works', 'icon' => 'fa-list-ol'],
            'why-us' => ['bn' => 'কেন আমরা', 'en' => 'Why Us', 'icon' => 'fa-star'],
            'faq' => ['bn' => 'প্রশ্ন-উত্তর', 'en' => 'FAQ', 'icon' => 'fa-circle-question'],
            'checkout' => ['bn' => 'চেকআউট ফর্ম', 'en' => 'Checkout', 'icon' => 'fa-cart-shopping'],
            'reviews' => ['bn' => 'কাস্টমার রিভিউ', 'en' => 'Reviews', 'icon' => 'fa-comments'],
            'bottom-cta' => ['bn' => 'নিচের CTA', 'en' => 'Bottom CTA', 'icon' => 'fa-bullhorn'],
            'footer' => ['bn' => 'ফুটার', 'en' => 'Footer', 'icon' => 'fa-feather'],
        ];
    }

    /** Sections the admin can hide from the landing page. checkout = order form (#order-form) — order buttons depend on it, so it always shows. */
    public static function hideable(): array
    {
        return ['hero', 'trust', 'products', 'promises', 'how-it-works', 'why-us', 'faq', 'reviews', 'bottom-cta'];
    }

    /** Per-design metadata (merged over auto-discovered files). */
    public static function designs(): array
    {
        return [
            'navbar' => [
                1 => ['name' => 'ক্লাসিক পিল নেভ', 'desc' => 'বর্তমান ডিজাইন — ভাসমান পিল মেনু', 'recommended' => true, 'features' => ['পিল মেনু', 'মোবাইল ড্রয়ার', 'ভাষা টগল']],
                2 => ['name' => 'সেন্টারড ব্র্যান্ড', 'desc' => 'মাঝখানে লোগো, দুই পাশে মেনু', 'features' => ['সেন্টার লোগো', 'সাব-নেভ', 'মোবাইল ড্রয়ার']],
                3 => ['name' => 'ফ্লোটিং গ্লাস', 'desc' => 'ভাসমান গ্লাস বার, মিনিমাল', 'features' => ['গ্লাস ইফেক্ট', 'স্টিকি', 'মোবাইল ড্রয়ার']],
                4 => ['name' => 'অ্যানাউন্সমেন্ট বার', 'desc' => 'ওপরে নোটিশ বার + ক্লিন নেভ', 'features' => ['নোটিশ বার', 'আন্ডারলাইন হোভার']],
                5 => ['name' => 'মিনিমাল গ্লাস পিল', 'desc' => 'ভাসমান গ্লাস পিল বার — পাতলা ও আধুনিক', 'features' => ['গ্লাস পিল', 'পিল মেনু', 'গ্রেডিয়েন্ট CTA']],
            ],
            'hero' => [
                1 => ['name' => 'ক্লাসিক স্লাইডার', 'desc' => 'বর্তমান ডিজাইন — টেক্সট স্লাইডার + ইমেজ স্লাইডার', 'recommended' => true, 'features' => ['স্লাইডার', 'স্ট্যাটস', 'ট্রাস্ট ব্যাজ']],
                2 => ['name' => 'গ্লাস ফুল-স্ক্রিন', 'desc' => 'ডার্ক ইমেজ ব্যাকগ্রাউন্ডে গ্লাস প্যানেল', 'features' => ['গ্লাস ইফেক্ট', 'ইমেজ স্লাইডার', 'স্ট্যাটস']],
                3 => ['name' => 'এডিটরিয়াল স্প্লিট', 'desc' => 'বাঁয়ে কপি, ডানে ফ্রেমড ইমেজ স্লাইডার', 'features' => ['স্প্লিট', 'ইমেজ স্লাইডার', 'স্ট্যাটস']],
                4 => ['name' => 'সেন্টারড এডিটরিয়াল', 'desc' => 'মাঝবসানো টেক্সট + পুরো প্রস্থের ইমেজ স্ট্রিপ', 'features' => ['সেন্টার লেআউট', 'ইমেজ স্ট্রিপ', 'স্ট্যাটস']],
                5 => ['name' => 'এডিটোরিয়াল স্প্লিট', 'desc' => 'বাঁয়ে কপি-স্ট্যাটস, ডানে বড় ছবি — স্লাইডার নেই, সবচেয়ে দ্রুত', 'features' => ['স্প্লিট', 'স্ট্যাটস', 'স্লাইডার-ফ্রি']],
            ],
            'trust' => [
                1 => ['name' => 'চলমান মার্কি', 'desc' => 'বর্তমান ডিজাইন — একটানা চলমান বার্তা', 'recommended' => true, 'features' => ['অ্যানিমেটেড']],
                2 => ['name' => 'স্ট্যাটিক কার্ড', 'desc' => 'থেমে থাকা ট্রাস্ট কার্ড স্ট্রিপ', 'features' => ['গ্রিড কার্ড', 'আইকন']],
                3 => ['name' => 'ডার্ক স্ট্যাটাস বার', 'desc' => 'গাঢ় ব্যাকগ্রাউন্ডে ডট-আইকন স্ট্যাটস', 'features' => ['ডার্ক বার', 'কমপ্যাক্ট']],
                4 => ['name' => 'চেক পিল ব্যাজ', 'desc' => 'সবুজ চেক-মার্ক পিল ব্যাজ', 'features' => ['স্ট্যাটিক', 'পিল স্টাইল']],
                5 => ['name' => 'চেকলিস্ট স্ট্রিপ', 'desc' => 'সাদা স্ট্রিপে ৬টা চেক-আইটেমের গ্রিড', 'features' => ['স্ট্যাটিক', 'গ্রিড', 'চেক আইকন']],
            ],
            'products' => [
                1 => ['name' => 'ডিসকভারি গ্রিড', 'desc' => 'বর্তমান ডিজাইন — ফিল্টার + গ্রিড + সি-মোর', 'recommended' => true, 'features' => ['ফিল্টার', 'কুইক ভিউ', 'সি-মোর']],
                2 => ['name' => 'ক্যারোসেল শোকেস', 'desc' => 'এক সারিতে স্ক্রলযোগ্য বড় কার্ড', 'features' => ['স্ক্রল ক্যারোসেল', 'ফিল্টার', 'কুইক ভিউ']],
                3 => ['name' => 'বেন্টো শোকেস', 'desc' => 'ফিচার্ড বড় কার্ড + বেন্টো গ্রিড', 'features' => ['ফিচার্ড কার্ড', 'ফিল্টার', 'কুইক ভিউ']],
                4 => ['name' => 'সেরিন স্কিন', 'desc' => 'ডিফল্ট গ্রিডের ওপর হালকা সবুজ আভার প্রিমিয়াম স্কিন', 'features' => ['ফিল্টার', 'কুইক ভিউ', 'সফট স্কিন']],
            ],
            'promises' => [
                1 => ['name' => 'বেন্টো কার্ড', 'desc' => 'বর্তমান ডিজাইন — নিয়ন বেন্টো গ্রিড', 'recommended' => true, 'features' => ['গ্লো কার্ড', 'ট্যাগ']],
                2 => ['name' => 'হরাইজন্টাল স্ট্রিপ', 'desc' => 'পাশে পাশে কমপ্যাক্ট ফিচার স্ট্রিপ', 'features' => ['কমপ্যাক্ট', 'নম্বর']],
                3 => ['name' => 'নম্বরড লিস্ট', 'desc' => 'বড় নম্বরসহ মিনিমাল তালিকা', 'features' => ['মিনিমাল', 'লিস্ট']],
                4 => ['name' => 'গ্রেডিয়েন্ট কার্ড', 'desc' => 'চার রঙের গ্রেডিয়েন্ট আইকন কার্ড', 'features' => ['গ্রেডিয়েন্ট', 'আইকন']],
                5 => ['name' => 'নম্বরড লেজার', 'desc' => 'বড় নম্বরসহ সারি আকারে গ্যারান্টি লিস্ট', 'features' => ['নম্বর', 'সারি', 'হোভার স্লাইড']],
            ],
            'how-it-works' => [
                1 => ['name' => 'ক্লাসিক স্টেপস', 'desc' => 'বর্তমান ডিজাইন — ৩ কলাম ধাপ', 'recommended' => true, 'features' => ['৩ কলাম']],
                2 => ['name' => 'টাইমলাইন', 'desc' => 'মাঝ বরাবর লাইনসহ টাইমলাইন', 'features' => ['টাইমলাইন', 'কার্ড']],
                3 => ['name' => 'বড় নম্বর', 'desc' => 'বিশাল নম্বরযুক্ত এডিটরিয়াল ধাপ', 'features' => ['ডার্ক', 'বড় নম্বর']],
                4 => ['name' => 'জিগজ্যাগ ফ্লো', 'desc' => 'অ্যারো-কানেক্টেড কার্ড ফ্লো', 'features' => ['অ্যারো ফ্লো', 'কার্ড']],
                5 => ['name' => 'ভার্টিক্যাল টাইমলাইন', 'desc' => 'মাঝে লাইন, ধাপে ধাপে গোল নম্বর কার্ড', 'features' => ['টাইমলাইন', 'কার্ড', 'নম্বর ডট']],
            ],
            'why-us' => [
                1 => ['name' => 'বেন্টো গ্রিড', 'desc' => 'বর্তমান ডিজাইন — বড় কার্ড + সেল', 'recommended' => true, 'features' => ['বেন্টো', 'বড় কার্ড']],
                2 => ['name' => 'ফিচার গ্রিড', 'desc' => 'সমান চার-কলাম ফিচার গ্রিড', 'features' => ['গ্রিড', 'ফিচার ব্যানার']],
                3 => ['name' => 'স্প্লিট এডিটরিয়াল', 'desc' => 'বাঁয়ে বড় ভিজ্যুয়াল, ডানে সুবিধা তালিকা', 'features' => ['স্প্লিট', 'চেকলিস্ট']],
                4 => ['name' => 'ডার্ক স্প্লিট', 'desc' => 'ডার্ক প্যানেলে নম্বরড সুবিধা', 'features' => ['ডার্ক', 'নম্বরড লিস্ট']],
                5 => ['name' => 'গ্যারান্টি ব্যান্ড', 'desc' => 'সবুজ ব্যান্ড + নম্বরযুক্ত ফিচার গ্রিড', 'features' => ['ব্যান্ড', 'গ্রিড', 'নম্বর']],
            ],
            'faq' => [
                1 => ['name' => 'অ্যাকর্ডিয়ন', 'desc' => 'বর্তমান ডিজাইন — এক-কলাম details', 'recommended' => true, 'features' => ['অ্যাকর্ডিয়ন']],
                2 => ['name' => 'দুই-কলাম', 'desc' => 'দুই কলামে ভাগ করা প্রশ্ন-উত্তর', 'features' => ['দুই কলাম', 'ইন্ট্রো প্যানেল']],
                3 => ['name' => 'মিনিমাল লিস্ট', 'desc' => 'বর্ডারহীন হালকা তালিকা', 'features' => ['মিনিমাল']],
                4 => ['name' => 'ওপেন Q/A কার্ড', 'desc' => 'সব উত্তর একসাথে খোলা কার্ড', 'features' => ['দুই কলাম', 'সব খোলা']],
                5 => ['name' => 'সাইড টাইটেল একর্ডিয়ন', 'desc' => 'বাঁয়ে টাইটেল, ডানে একর্ডিয়ন লিস্ট', 'features' => ['স্টিকি টাইটেল', 'একর্ডিয়ন']],
            ],
            'checkout' => [
                1 => ['name' => 'কার্ট + ফর্ম', 'desc' => 'বর্তমান ডিজাইন — বাঁয়ে কার্ট, ডানে ফর্ম', 'recommended' => true, 'features' => ['কার্ট', 'কুপন', 'COD']],
                2 => ['name' => 'প্রিমিয়াম স্কিন', 'desc' => 'একই চেকআউট, প্রিমিয়াম ডার্ক হেডার স্কিন', 'features' => ['কার্ট', 'কুপন', 'COD', 'ডার্ক হেডার']],
                3 => ['name' => 'মিনিমাল লাইট', 'desc' => 'সাদা মিনিমাল স্কিন, সফট শ্যাডো', 'features' => ['কার্ট', 'কুপন', 'COD', 'লাইট লুক']],
                4 => ['name' => 'ডার্ক প্রিমিয়াম স্কিন', 'desc' => 'গাঢ় সবুজ হেডারসহ প্রিমিয়াম স্কিন', 'features' => ['কার্ট', 'কুপন', 'COD', 'ডার্ক হেডার']],
            ],
            'reviews' => [
                1 => ['name' => 'সুইপার স্লাইডার', 'desc' => 'বর্তমান ডিজাইন — swiper কার্ড', 'recommended' => true, 'features' => ['সুইপার', 'রেটিং বার']],
                2 => ['name' => 'মডার্ন গ্রিড', 'desc' => 'রেটিং সামারি + স্ক্রল ছাড়া গ্রিড', 'features' => ['গ্রিড', 'রেটিং বার']],
                3 => ['name' => 'ডার্ক ওয়াল', 'desc' => 'গাঢ় ব্যাকগ্রাউন্ডে ম্যাসনরি ওয়াল', 'features' => ['ম্যাসনরি', 'ডার্ক']],
                4 => ['name' => 'সফট লাইট কার্ড', 'desc' => 'হালকা ব্যাকগ্রাউন্ডে ২-কলাম কোট কার্ড', 'features' => ['গ্রিড', 'লাইট', 'কোট মার্ক']],
            ],
            'bottom-cta' => [
                1 => ['name' => 'ক্লাসিক CTA', 'desc' => 'বর্তমান ডিজাইন — গাঢ় গ্রেডিয়েন্ট CTA', 'recommended' => true, 'features' => ['গ্রেডিয়েন্ট', 'লিংক']],
                2 => ['name' => 'মিনিমাল সেন্টার', 'desc' => 'হালকা ব্যাকগ্রাউন্ডে মাঝবসানো CTA', 'features' => ['মিনিমাল', 'লিংক']],
                3 => ['name' => 'কার্ড CTA', 'desc' => 'ভাসমান কার্ডের ভেতরে CTA', 'features' => ['কার্ড', 'ডার্ক ব্যাকগ্রাউন্ড']],
                4 => ['name' => 'গ্রেডিয়েন্ট বর্ডার', 'desc' => 'গ্লাস কার্ড + রেইনবো বর্ডার', 'features' => ['গ্লাস', 'গ্রেডিয়েন্ট বর্ডার']],
                5 => ['name' => 'টিকেট সিটিএ', 'desc' => 'ছিদ্রসহ টিকেট কার্ডে CTA', 'features' => ['টিকেট', 'কন্টাক্ট চিপ', 'গ্রেডিয়েন্ট বাটন']],
            ],
            'footer' => [
                1 => ['name' => 'ক্লাসিক ফুটার', 'desc' => 'বর্তমান ডিজাইন — গাঢ় মাল্টি-কলাম', 'recommended' => true, 'features' => ['মাল্টি-কলাম', 'সোশ্যাল', 'পেমেন্ট লোগো']],
                2 => ['name' => 'কমপ্যাক্ট ফুটার', 'desc' => 'এক সারিতে হালকা কমপ্যাক্ট ফুটার', 'features' => ['কমপ্যাক্ট', 'এক সারি']],
                3 => ['name' => 'প্রিমিয়াম ডার্ক', 'desc' => 'গ্লো-টপ ডার্ক মাল্টি-কলাম', 'features' => ['ডার্ক', 'গ্লো', 'পেমেন্ট লোগো']],
                4 => ['name' => 'লাইট মিনিমাল', 'desc' => 'বিশাল ওয়ার্ডমার্কসহ হালকা ফুটার', 'features' => ['লাইট', 'ওয়ার্ডমার্ক', 'সোশ্যাল']],
                5 => ['name' => 'ডার্ক সেন্টারড', 'desc' => 'মাঝবসানো কমপ্যাক্ট ডার্ক ফুটার', 'features' => ['ডার্ক', 'সেন্টারড', 'সোশ্যাল']],
            ],
        ];
    }

    /** Discovered design numbers per section (filesystem scan of design-N files). */
    public static function discovered(string $section): array
    {
        static $cache = [];

        if (empty($cache)) {
            foreach (array_keys(self::sections()) as $sec) {
                $dir = resource_path('views/sections/' . $sec);
                $files = is_dir($dir) ? glob($dir . '/design-*.blade.php') ?: [] : [];
                $cache[$sec] = [];
                foreach ($files as $file) {
                    if (preg_match('/design-(\d+)\.blade\.php$/', $file, $m)) {
                        $cache[$sec][] = (int) $m[1];
                    }
                }
                sort($cache[$sec]);
                if (!in_array(1, $cache[$sec], true)) {
                    array_unshift($cache[$sec], 1);
                }
            }
        }

        return $cache[$section];
    }

    /** Full render info for the admin studio: sections × designs with metadata. */
    public static function catalog(): array
    {
        $catalog = [];
        foreach (self::sections() as $section => $labels) {
            $designs = [];
            foreach (self::discovered($section) as $n) {
                $meta = self::designs()[$section][$n] ?? [];
                $designs[] = [
                    'n' => $n,
                    'name' => $meta['name'] ?? ('ডিজাইন ' . $n),
                    'desc' => $meta['desc'] ?? ('ভ্যারিয়েন্ট ' . $n),
                    'recommended' => $meta['recommended'] ?? false,
                    'features' => $meta['features'] ?? [],
                ];
            }
            $catalog[] = [
                'section' => $section,
                'bn' => $labels['bn'],
                'en' => $labels['en'],
                'icon' => $labels['icon'] ?? 'fa-object-group',
                'designs' => $designs,
            ];
        }

        return $catalog;
    }
}
