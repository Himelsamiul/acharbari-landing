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
            'navbar' => ['bn' => 'নেভিগেশন বার', 'en' => 'Navbar'],
            'hero' => ['bn' => 'হিরো', 'en' => 'Hero'],
            'trust' => ['bn' => 'ট্রাস্ট মার্কি', 'en' => 'Trust Marquee'],
            'products' => ['bn' => 'প্রোডাক্ট সেকশন', 'en' => 'Products'],
            'promises' => ['bn' => 'আমাদের গ্যারান্টি', 'en' => 'Promises'],
            'how-it-works' => ['bn' => 'কীভাবে অর্ডার হয়', 'en' => 'How It Works'],
            'why-us' => ['bn' => 'কেন আমরা', 'en' => 'Why Us'],
            'faq' => ['bn' => 'প্রশ্ন-উত্তর', 'en' => 'FAQ'],
            'checkout' => ['bn' => 'চেকআউট ফর্ম', 'en' => 'Checkout'],
            'reviews' => ['bn' => 'কাস্টমার রিভিউ', 'en' => 'Reviews'],
            'bottom-cta' => ['bn' => 'নিচের CTA', 'en' => 'Bottom CTA'],
            'footer' => ['bn' => 'ফুটার', 'en' => 'Footer'],
        ];
    }

    /** Per-design metadata (merged over auto-discovered files). */
    public static function designs(): array
    {
        return [
            'navbar' => [
                1 => ['name' => 'ক্লাসিক পিল নেভ', 'desc' => 'বর্তমান ডিজাইন — ভাসমান পিল মেনু', 'recommended' => true],
                2 => ['name' => 'সেন্টারড ব্র্যান্ড', 'desc' => 'মাঝখানে লোগো, দুই পাশে মেনু'],
            ],
            'hero' => [
                1 => ['name' => 'ক্লাসিক স্লাইডার', 'desc' => 'বর্তমান ডিজাইন — টেক্সট স্লাইডার + ইমেজ স্লাইডার', 'recommended' => true],
                2 => ['name' => 'ফুল-ভিজ্যুয়াল', 'desc' => 'পুরো প্রস্থের ইমেজ হিরো, ওপরে কনটেন্ট'],
            ],
            'trust' => [
                1 => ['name' => 'চলমান মার্কি', 'desc' => 'বর্তমান ডিজাইন — একটানা চলমান বার্তা', 'recommended' => true],
                2 => ['name' => 'স্ট্যাটিক কার্ড', 'desc' => 'থেমে থাকা ট্রাস্ট কার্ড স্ট্রিপ'],
                3 => ['name' => 'ডার্ক স্ট্যাটাস বার', 'desc' => 'গাঢ় ব্যাকগ্রাউন্ডে চার্জার-আইকন স্ট্যাটস'],
            ],
            'products' => [
                1 => ['name' => 'ডিসকভারি গ্রিড', 'desc' => 'বর্তমান ডিজাইন — ফিল্টার + গ্রিড + সি-মোর', 'recommended' => true],
                2 => ['name' => 'ক্যারোসেল শোকেস', 'desc' => 'এক সারিতে স্ক্রলযোগ্য বড় কার্ড'],
            ],
            'promises' => [
                1 => ['name' => 'বেন্টো কার্ড', 'desc' => 'বর্তমান ডিজাইন — নিয়ন বেন্টো গ্রিড', 'recommended' => true],
                2 => ['name' => 'হরাইজন্টাল স্ট্রিপ', 'desc' => 'পাশে পাশে কমপ্যাক্ট ফিচার স্ট্রিপ'],
                3 => ['name' => 'নম্বরড লিস্ট', 'desc' => 'বড় নম্বরসহ মিনিমাল তালিকা'],
            ],
            'how-it-works' => [
                1 => ['name' => 'ক্লাসিক স্টেপস', 'desc' => 'বর্তমান ডিজাইন — ৩ কলাম ধাপ', 'recommended' => true],
                2 => ['name' => 'টাইমলাইন', 'desc' => 'মাঝ বরাবর লাইনসহ টাইমলাইন'],
                3 => ['name' => 'বড় নম্বর', 'desc' => 'বিশাল নম্বরযুক্ত এডিটরিয়াল ধাপ'],
            ],
            'why-us' => [
                1 => ['name' => 'বেন্টো গ্রিড', 'desc' => 'বর্তমান ডিজাইন — বড় কার্ড + সেল', 'recommended' => true],
                2 => ['name' => 'ফিচার গ্রিড', 'desc' => 'সমান চার-কলাম ফিচার গ্রিড'],
                3 => ['name' => 'স্প্লিট এডিটরিয়াল', 'desc' => 'বাঁয়ে বড় ভিজ্যুয়াল, ডানে সুবিধা তালিকা'],
            ],
            'faq' => [
                1 => ['name' => 'অ্যাকর্ডিয়ন', 'desc' => 'বর্তমান ডিজাইন — এক-কলাম details', 'recommended' => true],
                2 => ['name' => 'দুই-কলাম', 'desc' => 'দুই কলামে ভাগ করা প্রশ্ন-উত্তর'],
                3 => ['name' => 'মিনিমাল লিস্ট', 'desc' => 'বর্ডারহীন হালকা তালিকা'],
            ],
            'checkout' => [
                1 => ['name' => 'কার্ট + ফর্ম', 'desc' => 'বর্তমান ডিজাইন — বাঁয়ে কার্ট, ডানে ফর্ম', 'recommended' => true],
            ],
            'reviews' => [
                1 => ['name' => 'সুইপার স্লাইডার', 'desc' => 'বর্তমান ডিজাইন — swiper কার্ড', 'recommended' => true],
                2 => ['name' => 'স্ট্যাটিক কার্ড', 'desc' => 'স্ক্রল ছাড়া গ্রিড রিভিউ'],
            ],
            'bottom-cta' => [
                1 => ['name' => 'ক্লাসিক CTA', 'desc' => 'বর্তমান ডিজাইন — গাঢ় গ্রেডিয়েন্ট CTA', 'recommended' => true],
                2 => ['name' => 'মিনিমাল সেন্টার', 'desc' => 'হালকা ব্যাকগ্রাউন্ডে মাঝবসানো CTA'],
                3 => ['name' => 'কার্ড CTA', 'desc' => 'ভাসমান কার্ডের ভেতরে CTA'],
            ],
            'footer' => [
                1 => ['name' => 'ক্লাসিক ফুটার', 'desc' => 'বর্তমান ডিজাইন — গাঢ় মাল্টি-কলাম', 'recommended' => true],
                2 => ['name' => 'কমপ্যাক্ট ফুটার', 'desc' => 'এক সারিতে হালকা কমপ্যাক্ট ফুটার'],
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
                ];
            }
            $catalog[] = [
                'section' => $section,
                'bn' => $labels['bn'],
                'en' => $labels['en'],
                'designs' => $designs,
            ];
        }

        return $catalog;
    }
}
