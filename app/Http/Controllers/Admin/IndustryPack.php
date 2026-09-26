<?php

namespace App\Http\Controllers\Admin;

/**
 * Industry Preset System — single source of truth.
 *
 * 10 Bangladesh-focused business genres. Each genre bundles:
 *  - a ThemeLibrary theme id
 *  - an image pack (public/assets/img/genres/<key>/…)
 *  - demo content (settings keys → bn/en text + JSON lists)
 *  - demo products (stable slugs `demo-<genre>-<n>`, synced on apply)
 *
 * `industry` setting empty/invalid → the site renders exactly like the
 * default AcharBari look (organic).
 */
class IndustryPack
{
    /** Image-slot map: setting key → genre file name. */
    public static function slots(): array
    {
        return [
            'hero_img1' => 'hero-1.svg',
            'hero_img2' => 'hero-2.svg',
            'hero_img3' => 'hero-3.svg',
            'hero_img4' => 'hero-4.svg',
        ];
    }

    public static function keys(): array
    {
        return array_keys(self::all());
    }

    public static function valid(?string $key): bool
    {
        return $key !== null && $key !== '' && array_key_exists($key, self::all());
    }

    /** Slot file for a setting key, e.g. hero_img1 → hero-1.svg */
    public static function slotFor(string $industry, string $key): ?string
    {
        if (!self::valid($industry)) return null;
        return self::slots()[$key] ?? null;
    }

    /** Every demo-product slug the industry system manages (never touches others). */
    public static function managedSlugs(): array
    {
        $slugs = [];
        foreach (self::all() as $key => $pack) {
            foreach ($pack['products'] as $i => $p) {
                $slugs[] = 'demo-' . $key . '-' . ($i + 1);
            }
        }
        return $slugs;
    }

    /** Full genre registry. */
    public static function all(): array
    {
        return [
            'organic' => [
                'name_bn' => 'খাঁটি খাবার ও অর্গানিক', 'name_en' => 'Organic & Pure Food',
                'icon' => 'fa-leaf', 'theme' => 'herbal',
                'swatch' => ['#059669', '#10b981', '#a3e635', '#064e3b'],
                'desc' => 'আচার-মধু-ঘি, দেশি খাবার ও অর্গানিক পণ্য',
                'content' => [
                    'hero_chip' => ['বাংলার ঘরে তৈরি স্বাদ — ক্যাশ অন ডেলিভারিতে', 'Village-made taste — Cash on Delivery'],
                    'hero_s1_main' => ['ঘরে তৈরি খাঁটি দেশি আচার —', 'Homemade authentic deshi pickles —'],
                    'hero_s1_grad' => ['স্বাদ ও ভালোবাসার বন্ধন', 'a bond of taste & love'],
                    'hero_lead' => ['মৌসুমি কাঁচা আম, জলপাই, তেঁতুল আর সরিষার তেলে তৈরি প্রতিটি জার — কোনো প্রিজারভেটিভ ছাড়াই সারা দেশে পৌঁছে যায়।', 'Seasonal mango, olive and tamarind in pure mustard oil — delivered nationwide, preservative free.'],
                    'prod_eyebrow' => ['জনপ্রিয় কালেকশন', 'Popular Collections'],
                    'prod_h2a' => ['এই মুহূর্তের ', "Today's "],
                    'prod_h2b' => ['সেরা আচার ডিল', 'Best Pickle Deals'],
                    'cta_h2a' => ['আজই অর্ডার করুন — ', 'Order today — on '],
                    'cta_h2b' => ['ক্যাশ অন ডেলিভারিতে', 'Cash on Delivery'],
                ],
            ],
            'restaurant' => [
                'name_bn' => 'রেস্টুরেন্ট ও ক্যাটারিং', 'name_en' => 'Restaurant & Catering',
                'icon' => 'fa-utensils', 'theme' => 'restaurant',
                'swatch' => ['#c2410c', '#ea580c', '#fbbf24', '#7c2d12'],
                'desc' => 'রেস্টুরেন্ট, হোম কিচেন, ক্যাটারিং ও ফুড ডেলিভারি',
                'content' => [
                    'hero_chip' => ['গরম গরম ঘরোয়া খাবার — এখন অর্ডারে', 'Hot homestyle food — order now'],
                    'hero_s1_main' => ['মায়ের হাতের রান্না,', 'Mom-cooked meals,'],
                    'hero_s1_grad' => ['এখন শুধু এক ক্লিক দূরে', 'just one click away'],
                    'hero_lead' => ['বিরিয়ানি, খিচুড়ি, ঐতিহ্যবাহী মেনু আর বিশেষ অনুষ্ঠানের ক্যাটারিং — তাজা উপকরণে রোজ রান্না, ঢাকায় দ্রুত ডেলিভারি।', 'Biriyani, khichuri, heritage menus and event catering — cooked fresh daily, delivered fast.'],
                    'prod_eyebrow' => ['আজকের মেনু', "Today's Menu"],
                    'prod_h2a' => ['সবচেয়ে জনপ্রিয় ', 'Most loved '],
                    'prod_h2b' => ['খাবার', 'Dishes'],
                    'cta_h2a' => ['ক্ষুধা লেগেছে? ', 'Hungry? '],
                    'cta_h2b' => ['এখনই অর্ডার করুন', 'Order right now'],
                ],
            ],
            'fashion' => [
                'name_bn' => 'ফ্যাশন ও পোশাক', 'name_en' => 'Fashion & Clothing',
                'icon' => 'fa-shirt', 'theme' => 'fashion',
                'swatch' => ['#1f2937', '#9d174d', '#d4a437', '#e5e7eb'],
                'desc' => 'পাঞ্জাবি, শাড়ি, থ্রি-পিস, কুর্তি ও অ্যাক্সেসরিজ',
                'content' => [
                    'hero_chip' => ['নতুন ঈদ-সিজন কালেকশন এসেছে', 'New festive collection is live'],
                    'hero_s1_main' => ['প্রিমিয়াম দেশি পোশাক —', 'Premium deshi clothing —'],
                    'hero_s1_grad' => ['প্রতিদিনের জন্য, উৎসবের জন্য', 'for every day & every festival'],
                    'hero_lead' => ['হাতে বাছাই করা কাপড়, নিখুঁত সেলাই আর আরামদায়ক ফিট — পাঞ্জাবি থেকে শাড়ি, সব এক ঠিকানায়। সারা দেশে ডেলিভারি।', 'Hand-picked fabrics, perfect stitching and comfortable fits — panjabi to saree, all in one place. Nationwide delivery.'],
                    'prod_eyebrow' => ['নতুন কালেকশন', 'New Collection'],
                    'prod_h2a' => ['এ সপ্তাহের ', "This week's "],
                    'prod_h2b' => ['বেস্টসেলার', 'Bestsellers'],
                    'cta_h2a' => ['আপনার স্টাইল এখন ', 'Your style is now '],
                    'cta_h2b' => ['এক ক্লিক দূরে', 'one click away'],
                ],
            ],
            'beauty' => [
                'name_bn' => 'বিউটি ও কসমেটিকস', 'name_en' => 'Beauty & Cosmetics',
                'icon' => 'fa-spray-can-sparkles', 'theme' => 'beauty',
                'swatch' => ['#db2777', '#c026d3', '#fbcfe8', '#500724'],
                'desc' => 'স্কিনকেয়ার, মেকআপ, হেয়ার কেয়ার ও পারফিউম',
                'content' => [
                    'hero_chip' => ['ত্বকের যত্নে খাঁটি উপকরণ', 'Gentle care, honest ingredients'],
                    'hero_s1_main' => ['নিজেকে ভালোবাসুন —', 'Love your skin —'],
                    'hero_s1_grad' => ['প্রতিদিনের গ্লো রুটিনে', 'a daily glow routine'],
                    'hero_lead' => ['স্কিনকেয়ার থেকে মেকআপ — সব প্রোডাক্ট ডার্মাটোলজিক্যালি পরীক্ষিত উপকরণে, যত্নে বাছাই করা। অথেনটিক ব্র্যান্ডের নিশ্চয়তা।', 'From skincare to makeup — dermatologically tested ingredients, carefully curated. 100% authentic brands.'],
                    'prod_eyebrow' => ['গ্লো এসেনশিয়ালস', 'Glow Essentials'],
                    'prod_h2a' => ['আপনার রুটিনের জন্য ', 'For your routine '],
                    'prod_h2b' => ['বেস্ট পিক', 'Best Picks'],
                    'cta_h2a' => ['গ্লো শুরু হোক ', 'Let the glow begin — '],
                    'cta_h2b' => ['আজ থেকেই', 'starting today'],
                ],
            ],
            'electronics' => [
                'name_bn' => 'ইলেকট্রনিক্স ও গ্যাজেট', 'name_en' => 'Electronics & Gadgets',
                'icon' => 'fa-headphones', 'theme' => 'electronics',
                'swatch' => ['#1d4ed8', '#06b6d4', '#7dd3fc', '#172554'],
                'desc' => 'মোবাইল অ্যাক্সেসরিজ, হেডফোন, স্মার্ট ডিভাইস',
                'content' => [
                    'hero_chip' => ['লেটেস্ট গ্যাজেট — অফিসিয়াল ওয়ারেন্টিতে', 'Latest gadgets — with official warranty'],
                    'hero_s1_main' => ['স্মার্ট লাইফের জন্য —', 'Gear up your smart life —'],
                    'hero_s1_grad' => ['দামে সেরা ডিল', 'best deals in town'],
                    'hero_lead' => ['হেডফোন, স্মার্টওয়াচ, পাওয়ার ব্যাংক ও অ্যাক্সেসরিজ — অফিসিয়াল ওয়ারেন্টি, ক্যাশ অন ডেলিভারিতে সারা দেশে।', 'Headphones, smartwatches, power banks and accessories — official warranty, nationwide COD.'],
                    'prod_eyebrow' => ['ট্রেন্ডিং গ্যাজেট', 'Trending Gadgets'],
                    'prod_h2a' => ['এই মাসের ', "This month's "],
                    'prod_h2b' => ['হট ডিল', 'Hot Deals'],
                    'cta_h2a' => ['আপগ্রেড করুন আজই — ', 'Upgrade today — '],
                    'cta_h2b' => ['সেরা দামে', 'at the best price'],
                ],
            ],
            'jewelry' => [
                'name_bn' => 'জুয়েলারি', 'name_en' => 'Jewelry',
                'icon' => 'fa-gem', 'theme' => 'jewelry',
                'swatch' => ['#a16207', '#d4a437', '#fcd34d', '#292524'],
                'desc' => 'সোনা-রুপা ও ফ্যাশন জুয়েলারি',
                'content' => [
                    'hero_chip' => ['হাতে গড়া এক্সক্লুসিভ ডিজাইন', 'Handcrafted exclusive designs'],
                    'hero_s1_main' => ['রুচিশীল জুয়েলারি —', 'Timeless jewelry —'],
                    'hero_s1_grad' => ['প্রতিটি মুহূর্তের সঙ্গী', 'for every moment'],
                    'hero_lead' => ['মিনিমাল নেকলেস থেকে ব্রাইডাল সেট — খাঁটি সিলভার ও গোল্ড-প্লেটেড কালেকশন, সীমিত এডিশনে।', 'From minimal necklaces to bridal sets — pure silver and gold-plated collections in limited editions.'],
                    'prod_eyebrow' => ['নতুন এডিশন', 'New Edition'],
                    'prod_h2a' => ['সবচেয়ে আলোচিত ', 'Most desired '],
                    'prod_h2b' => ['পিস', 'Pieces'],
                    'cta_h2a' => ['আপনার পছন্দের পিসটি ', 'Your favourite piece '],
                    'cta_h2b' => ['এখনই বুক করুন', 'book it now'],
                ],
            ],
            'furniture' => [
                'name_bn' => 'ফার্নিচার ও হোম ডেকর', 'name_en' => 'Furniture & Home Decor',
                'icon' => 'fa-couch', 'theme' => 'furniture',
                'swatch' => ['#8b5e34', '#b08968', '#a3b18a', '#4a3421'],
                'desc' => 'কাঠের ফার্নিচার, ইন্টেরিয়র ডেকর ও শোপিস',
                'content' => [
                    'hero_chip' => ['শিল্পকুমারদের হাতে গড়া ফার্নিচার', 'Crafted by master carpenters'],
                    'hero_s1_main' => ['ঘরকে বানান ঘরবাড়ি —', 'Make a house your home —'],
                    'hero_s1_grad' => ['কাঠের উষ্ণতায়', 'with the warmth of wood'],
                    'hero_lead' => ['সেগুন ও মহogany-র টেকসই ফার্নিচার, হ্যান্ডমেড ডেকর — ৫ বছরের ওয়ারেন্টিতে, ঢাকার বাইরেও ডেলিভারি।', 'Durable teak & mahogany furniture and handmade decor — 5-year warranty, delivered nationwide.'],
                    'prod_eyebrow' => ['হোম কালেকশন', 'Home Collection'],
                    'prod_h2a' => ['আপনার বসার ঘরের জন্য ', 'For your living room '],
                    'prod_h2b' => ['সেরা পিক', 'Top Picks'],
                    'cta_h2a' => ['স্বপ্নের ঘর সাজান ', 'Decorate your dream home — '],
                    'cta_h2b' => ['আজ থেকেই', 'starting today'],
                ],
            ],
            'healthcare' => [
                'name_bn' => 'হেলথকেয়ার ও ফার্মেসি', 'name_en' => 'Healthcare & Pharmacy',
                'icon' => 'fa-briefcase-medical', 'theme' => 'healthcare',
                'swatch' => ['#0284c7', '#0ea5e9', '#5eead4', '#075985'],
                'desc' => 'ফার্মেসি, ভিটামিন ও ব্যক্তিগত যত্ন',
                'content' => [
                    'hero_chip' => ['১০০% অথেনটিক প্রোডাক্ট — লাইসেন্সড ফার্মেসি', '100% authentic — licensed pharmacy'],
                    'hero_s1_main' => ['পরিবারের স্বাস্থ্যের দায়িত্ব —', 'Your family\u2019s everyday health —'],
                    'hero_s1_grad' => ['আমাদের দায়িত্ব', 'our responsibility'],
                    'hero_lead' => ['ভিটামিন, সাপ্লিমেন্ট, মাতৃ ও শিশু যত্নের পণ্য — সব অথেনটিক ব্র্যান্ড, ঠান্ডা-চেইন ম্যানেজমেন্টে সরবরাহ।', 'Vitamins, supplements, mother & baby care — authentic brands with proper cold-chain handling.'],
                    'prod_eyebrow' => ['স্বাস্থ্য এসেনশিয়ালস', 'Health Essentials'],
                    'prod_h2a' => ['পরিবারের জন্য ', 'For the family '],
                    'prod_h2b' => ['নির্ভরযোগ্য পিক', 'Reliable Picks'],
                    'cta_h2a' => ['স্বাস্থ্যের যত্ন — ', 'Care for your health — '],
                    'cta_h2b' => ['এখনই অর্ডার করুন', 'order now'],
                ],
            ],
            'education' => [
                'name_bn' => 'শিক্ষা ও কোচিং', 'name_en' => 'Education & Coaching',
                'icon' => 'fa-graduation-cap', 'theme' => 'education',
                'swatch' => ['#4f46e5', '#7c3aed', '#7dd3fc', '#3730a3'],
                'desc' => 'কোচিং সেন্টার, অনলাইন কোর্স ও স্কিল ট্রেনিং',
                'content' => [
                    'hero_chip' => ['নতুন ব্যাচে ভর্তি চলছে', 'Admission open for the new batch'],
                    'hero_s1_main' => ['সফলতার প্রস্তুতি —', 'Prepare for success —'],
                    'hero_s1_grad' => ['অভিজ্ঞ শিক্ষকদের সাথে', 'with expert mentors'],
                    'hero_lead' => ['এসএসসি-HSC, ভর্তি পরীক্ষা ও স্কিল কোর্স — লাইভ ক্লাস, নিয়মিত পরীক্ষা আর প্রতিটি শিক্ষার্থীর জন্য আলাদা ট্র্যাকিং।', 'SSC-HSC, admission tests and skill courses — live classes, weekly exams and individual progress tracking.'],
                    'prod_eyebrow' => ['কোর্স ও ব্যাচ', 'Courses & Batches'],
                    'prod_h2a' => ['জনপ্রিয় ', 'Popular '],
                    'prod_h2b' => ['কোর্সসমূহ', 'Courses'],
                    'cta_h2a' => ['সিট সীমিত — ', 'Seats are limited — '],
                    'cta_h2b' => ['আজই ভর্তি হোন', 'enroll today'],
                ],
            ],
            'travel' => [
                'name_bn' => 'ট্রাভেল ও ট্যুর এজেন্সি', 'name_en' => 'Travel & Tour Agency',
                'icon' => 'fa-plane', 'theme' => 'travel',
                'swatch' => ['#0e7490', '#f97316', '#5eead4', '#164e63'],
                'desc' => 'দেশ-বিদেশ ট্যুর, হানিমুন ও গ্রুপ প্যাকেজ',
                'content' => [
                    'hero_chip' => ['এই শীতের ছুটির প্যাকেজ এসেছে', 'Winter holiday packages are live'],
                    'hero_s1_main' => ['নতুন জায়গা, নতুন অভিজ্ঞতা —', 'New places, new memories —'],
                    'hero_s1_grad' => ['বাজেটে সেরা ট্যুর', 'the best tours on budget'],
                    'hero_lead' => ['সাজেক থেকে কক্সবাজার, মালয়েশিয়া থেকে দুবাই — হোটেল, গাড়ি আর গাইডসহ সম্পূর্ণ প্যাকেজ, EMI সুবিধাসহ।', 'Sajek to Cox\u2019s Bazar, Malaysia to Dubai — complete packages with hotels, transport and guides.'],
                    'prod_eyebrow' => ['জনপ্রিয় প্যাকেজ', 'Popular Packages'],
                    'prod_h2a' => ['এই মৌসুমের ', "This season's "],
                    'prod_h2b' => ['টপ ট্যুর', 'Top Tours'],
                    'cta_h2a' => ['ব্যাগ গুছিয়ে নিন — ', 'Pack your bags — '],
                    'cta_h2b' => ['বুকিং চলছে', 'booking open'],
                ],
            ],
        ];
    }

    /** Demo products for a genre (slug auto: demo-<genre>-<n>). */
    public static function products(string $key): array
    {
        $P = [
            'organic' => [
                ['আমের কুচি আচার (৫০০গ্রা)', 'Mango Kuchi Achar 500g', 'আচার', 'Pickles', 'pickle', 450, 600, '৯০ দিনের মৌসুমি কাঁচা আমে তৈরি'],
                ['সুন্দরবনের খাঁটি মধু (৫০০গ্রা)', 'Pure Sundarbans Honey 500g', 'মধু', 'Honey', 'pure', 750, 900, 'সরাসরি মৌজাকালি থেকে সংগৃহীত'],
                ['দেশি ঘি (৪০০গ্রা)', 'Desi Ghee 400g', 'ঘি', 'Ghee', 'pure', 950, 1100, 'গরুর দুধের সর থেকে প্রস্তুত'],
                ['জিরা আচার (৩০০গ্রা)', 'Cumin Achar 300g', 'আচার', 'Pickles', 'pickle', 320, 400, 'ঘরোয়া রেসিপিতে ঝাল-ঝরঝরে'],
                ['খেজুরের গুড় (১কেজি)', 'Date Palm Jaggery 1kg', 'গুড়', 'Jaggery', 'pure', 550, 650, 'শীতের তাজা খেজুর রসের গুড়'],
                ['চালকুমড়ার আচার (৩০০গ্রা)', 'Chal Kumra Achar 300g', 'আচার', 'Pickles', 'pickle', 300, 380, 'ঠাকুমাদের চেনা রেসিপিতে'],
            ],
            'restaurant' => [
                ['কাচ্চি বিরিয়ানি (১ প্লেট)', 'Kacchi Biriyani (plate)', 'মেইন', 'Main', 'main', 280, 350, 'মutton আর আটকে চালের প্রিমিয়াম কাচ্চি'],
                ['চিকেন খিচুড়ি (১ বক্স)', 'Chicken Khichuri (box)', 'মেইন', 'Main', 'main', 220, 260, 'ঘি-ভাজা মৌসুমি খিচুড়ি'],
                ['বিফ তেহারি (১ প্লেট)', 'Beef Tehari (plate)', 'মেইন', 'Main', 'main', 200, 250, 'ঢাকাইয়া স্পাইসি তেহারি'],
                ['ফিরনি (১ কাপ)', 'Firni (cup)', 'ডেজার্ট', 'Dessert', 'dessert', 80, 100, 'চাল-দুধে ঘন ঐতিহ্যবাহী ফিরনি'],
                ['লাচ্চি (৫০০মিলি)', 'Lacchi 500ml', 'ড্রিংকস', 'Drinks', 'drinks', 90, 120, 'মিষ্টি টক ব্যালেন্স লাচ্চি'],
                ['বুফে ক্যাটারিং (১০০ জন)', 'Buffet Catering (100 pax)', 'ক্যাটারিং', 'Catering', 'catering', 12000, 15000, 'অনুষ্ঠানের জন্য সম্পূর্ণ ম্যানেজমেন্ট'],
            ],
            'fashion' => [
                ['প্রিমিয়াম এমব্রয়ডারি পাঞ্জাবি', 'Premium Embroidered Panjabi', 'পাঞ্জাবি', 'Panjabi', 'men', 1290, 1690, 'সাটিন কটন, জামদানি নকশি'],
                ['হাফ সিল্ক জামদানি শাড়ি', 'Half Silk Jamdani Saree', 'শাড়ি', 'Saree', 'women', 2450, 2990, 'নকশিকাঁথা বর্ডারসহ'],
                ['কুর্তি — ব্লক প্রিন্ট', 'Block Print Kurti', 'কুর্তি', 'Kurti', 'women', 890, 1150, 'কটন, নিয়মিত পরার জন্য'],
                ['জেন্টস ক্যাজুয়াল টি-শার্ট', 'Men Casual Tee', 'টি-শার্ট', 'T-Shirt', 'men', 450, 590, '১০০% কমব্যাক কটন'],
                ['থ্রি-পিস সেট', 'Three Piece Set', 'থ্রি-পিস', 'Three Piece', 'women', 1850, 2400, 'আনস্টিচড ফেব্রিক সেট'],
                ['পাঞ্জাবি পেজডি সেট', 'Panjabi & Pajama Set', 'সেট', 'Set', 'men', 1590, 1990, 'ম্যাচিং পেজডিসহ কমপ্লিট'],
            ],
            'beauty' => [
                ['ভিটামিন সি ফেস সিরাম', 'Vitamin C Face Serum', 'স্কিনকেয়ার', 'Skincare', 'skincare', 690, 890, 'উজ্জ্বল ত্বকের জন্য দৈনিক সিরাম'],
                ['সানস্ক্রিন SPF ৫০', 'Sunscreen SPF 50', 'স্কিনকেয়ার', 'Skincare', 'skincare', 750, 950, 'UV-A/UV-B প্রোটেকশন'],
                ['ম্যাট লিকুইড লিপস্টিক', 'Matte Liquid Lipstick', 'মেকআপ', 'Makeup', 'makeup', 420, 550, '১২ ঘণ্টা স্থায়ী ফর্মুলা'],
                ['হেয়ার ফল অয়েল', 'Hair Fall Oil', 'হেয়ার কেয়ার', 'Hair Care', 'haircare', 480, 600, 'আমলা-ভৃঙ্গরাজ ব্লেন্ড'],
                ['ফেস ওয়াশ (১০০মিলি)', 'Face Wash 100ml', 'স্কিনকেয়ার', 'Skincare', 'skincare', 350, 450, 'সব ধরনের ত্বকের জন্য'],
                ['পারফিউম — ওড (৫০মিলি)', 'Oud Perfume 50ml', 'পারফিউম', 'Perfume', 'perfume', 1250, 1600, 'প্রিমিয়াম ওড ব্লেন্ড'],
            ],
            'electronics' => [
                ['ওয়্যারলেস ANC হেডফোন', 'Wireless ANC Headphone', 'অডিও', 'Audio', 'audio', 2450, 3200, 'অ্যাক্টিভ নয়েজ ক্যান্সেলিং'],
                ['স্মার্ট ওয়াচ (IP68)', 'Smart Watch IP68', 'ওয়্যারেবল', 'Wearable', 'wearable', 1890, 2500, 'হার্ট-রেট + স্লিপ ট্র্যাকিং'],
                ['২০০০০mAh পাওয়ার ব্যাংক', 'Power Bank 20000mAh', 'চার্জার', 'Chargers', 'chargers', 1450, 1800, 'PD 22.5W ফাস্ট চার্জ'],
                ['টাইপ-C গ্যালিং কেবল', 'Type-C Braided Cable', 'কেবল', 'Cables', 'cables', 290, 380, '১০০W, ব্রেইডেড ডিজাইন'],
                ['ব্লুটুথ স্পিকার', 'Bluetooth Speaker', 'অডিও', 'Audio', 'audio', 1650, 2100, '১২ ঘণ্টা প্লেব্যাক, IPX6'],
                ['ওয়্যারলেস ইয়ারবাডস', 'Wireless Earbuds', 'অডিও', 'Audio', 'audio', 1150, 1500, 'ENC কল ক্ল্যারিটি'],
            ],
            'jewelry' => [
                ['মিনিমাল গোল্ড-প্লেটেড নেকলেস', 'Minimal Gold-Plated Necklace', 'নেকলেস', 'Necklace', 'necklace', 1150, 1450, 'অ্যান্টি-টার্নিশ কোটিং'],
                ['সিলভার বালা জোড়া', 'Silver Bala Pair', 'বালা', 'Bangles', 'bangles', 1850, 2200, '৯২.৫ স্টার্লিং সিলভার'],
                ['পার্ল স্টাড আরিং', 'Pearl Stud Earrings', 'আরিং', 'Earrings', 'earrings', 690, 850, 'সামুদ্রিক পার্ল'],
                ['ব্রাইডাল চকর সেট', 'Bridal Choker Set', 'সেট', 'Set', 'set', 3450, 4200, 'বিয়ের জন্য এক্সক্লুসিভ'],
                ['হ্যান্ডমেড ব্রেসলেট', 'Handmade Bracelet', 'ব্রেসলেট', 'Bracelet', 'bracelet', 540, 690, 'বিডস ও চার্মসহ'],
                ['অক্সিডাইজড নেকলেস', 'Oxidised Necklace', 'নেকলেস', 'Necklace', 'necklace', 890, 1100, 'বোহেমিয়ান ডিজাইন'],
            ],
            'furniture' => [
                ['সেগুন ডাইনিং চেয়ার', 'Teak Dining Chair', 'চেয়ার', 'Chair', 'chair', 3450, 4200, 'সলিড সেগুন কাঠ'],
                ['৩ সিট সোফা (কটন)', '3-Seater Sofa (Cotton)', 'সোফা', 'Sofa', 'sofa', 16500, 19900, 'হার্ডওয়েড ফ্রেম + কটন আপহোলস্টারি'],
                ['স্টাডি টেবিল', 'Study Table', 'টেবিল', 'Table', 'table', 5200, 6400, 'ড্রয়ারসহ কমপ্যাক্ট ডিজাইন'],
                ['বুকশেলফ (৪ শেলফ)', 'Bookshelf (4 shelves)', 'শেলফ', 'Shelf', 'shelf', 7800, 9500, 'মেলামাইন ফিনিশ'],
                ['বেড সাইড টেবিল', 'Bedside Table', 'টেবিল', 'Table', 'table', 2900, 3600, 'ড্রয়ার + ওপেন শেলফ'],
                ['হ্যান্ডমেড ওয়াল শেলফ', 'Handmade Wall Shelf', 'ডেকর', 'Decor', 'decor', 1250, 1600, 'দেয়ালে ঝোলানো ডিজাইন'],
            ],
            'healthcare' => [
                ['ভিটামিন ডি৩ ট্যাবলেট', 'Vitamin D3 Tablets', 'ভিটামিন', 'Vitamins', 'vitamins', 320, 400, 'দৈনিক প্রয়োজনীয় ডোজ'],
                ['ডিজিটাল থার্মোমিটার', 'Digital Thermometer', 'ডিভাইস', 'Devices', 'devices', 450, 590, 'দ্রুত ও নিখুঁত রিডিং'],
                ['ব্লাড প্রেশার মনিটর', 'Blood Pressure Monitor', 'ডিভাইস', 'Devices', 'devices', 2450, 2990, 'অটো-ডিজিটাল, মেমরি স্টোর'],
                ['মাতৃ ও শিশু কেয়ার কিট', 'Mother & Baby Care Kit', 'কেয়ার', 'Care', 'care', 890, 1150, 'প্রয়োজনীয় সব আইটেম একসাথে'],
                ['সার্জিক্যাল মাস্ক (৫০পিস)', 'Surgical Mask (50 pcs)', 'সেফটি', 'Safety', 'safety', 250, 320, '৩-লেয়ার ফিল্টারেশন'],
                ['হ্যান্ড স্যানিটাইজার (৫০০মিলি)', 'Hand Sanitizer 500ml', 'সেফটি', 'Safety', 'safety', 180, 240, '৭০% অ্যালকোহল বেস'],
            ],
            'education' => [
                ['HSC বিজ্ঞান ব্যাচ (ভর্তি)', 'HSC Science Batch', 'কোর্স', 'Course', 'course', 6000, 7500, 'ফিজিক্স-কেমিস্ট্রি-ম্যাথ লাইভ ক্লাস'],
                ['ইংরেজি ভাষা কোর্স (৩ মাস)', 'English Language Course (3 months)', 'কোর্স', 'Course', 'course', 3500, 4500, 'স্পিকিং + রাইটিং মডিউল'],
                ['স্কিল ট্রেনিং — গ্রাফিক ডিজাইন', 'Skill Training — Graphic Design', 'স্কিল', 'Skill', 'skill', 5000, 6500, 'প্রজেক্ট-বেইজড হ্যান্ডস-অন ট্রেনিং'],
                ['BCS প্রিলি কোর্স', 'BCS Preliminary Course', 'কোর্স', 'Course', 'course', 5500, 7000, 'সম্পূর্ণ সিলেবাস + উইকলি মডেল টেস্ট'],
                ['প্রাইমারি কেয়ার (ক্লাস ১-৫)', 'Primary Care (Class 1-5)', 'কোর্স', 'Course', 'course', 2000, 2600, 'স্কুল সিলেবাস সাপোর্ট'],
                ['ভর্তি পরীক্ষা প্যাকেজ', 'Admission Test Package', 'কোর্স', 'Course', 'course', 4500, 5900, 'বিগত বছরের প্রশ্ন + গাইডলাইন'],
            ],
            'travel' => [
                ['কক্সবাজার ৩দিন ২রাত', 'Cox\u2019s Bazar 3D2N', 'দেশে', 'Domestic', 'domestic', 7500, 9500, 'হোটেল + বাস + গাইড'],
                ['সাজেক-বান্দরবান ৪দিন', 'Sajek-Bandarban 4 Days', 'দেশে', 'Domestic', 'domestic', 6500, 8500, 'পাহাড়ি ট্রেইল + লোকাল ফুড'],
                ['মালয়েশিয়া ৫দিন ৪রাত', 'Malaysia 5D4N', 'বিদেশ', 'International', 'international', 45000, 55000, 'এয়ারটিকেট + ভিসা সাপোর্ট'],
                ['দুবাই ৪দিন ৩রাত', 'Dubai 4D3N', 'বিদেশ', 'International', 'international', 55000, 68000, 'সিটি ট্যুরসহ প্যাকেজ'],
                ['হানিমুন স্পেশাল — নীলগিরি', 'Honeymoon Special — Nilgiri', 'হানিমুন', 'Honeymoon', 'honeymoon', 12500, 15000, 'প্রাইভেট কার + ডিলাক্স রিসর্ট'],
                ['কর্পোরেট গ্রুপ ট্যুর', 'Corporate Group Tour', 'গ্রুপ', 'Group', 'group', 9800, 12500, 'টিম-বিল্ডিং অ্যাক্টিভিটিসহ'],
            ],
        ];

        $list = $P[$key] ?? [];
        $out = [];
        foreach ($list as $i => $p) {
            $organicSlugs = ['mango-kuchi-achar', 'jalpai-achar', 'mixed-pickle-pack', 'tamarind-chutney', 'deshi-ghee', 'sundarban-honey'];
            $out[] = [
                'slug' => $key === 'organic' ? ($organicSlugs[$i] ?? ('demo-organic-' . ($i + 1))) : ('demo-' . $key . '-' . ($i + 1)),
                'name' => $p[0], 'name_en' => $p[1],
                'category' => $p[2], 'category_en' => $p[3], 'category_key' => $p[4],
                'price' => $p[5], 'old_price' => $p[6],
                'desc' => $p[7], 'desc_en' => $p[7],
                'image' => $key === 'organic'
                    ? ['assets/img/prod_mango.jpg', 'assets/img/prod_mix.jpg', 'assets/img/prod_honey.jpg', 'assets/img/prod_ghee.jpg', 'assets/img/spice_box.jpg', 'assets/img/prod_jalpai.jpg'][$i]
                    : 'assets/img/genres/' . $key . '/product-' . ($i + 1) . '.svg',
            ];
        }
        return $out;
    }

    /** Demo trust-marquee lines for a genre. */
    public static function marquee(string $key): array
    {
        $M = [
            'organic' => [['৯০ দিনের মৌসুমি আমে তৈরি আচার', 'Pickles from 90-day seasonal mango'], ['কেমিক্যাল-মুক্ত খাঁটি মধু', 'Pure chemical-free honey'], ['ভাঙা জারে ফ্রি রিপ্লেসমেন্ট', 'Free replacement on breakage'], ['সারা দেশে হোম ডেলিভারি', 'Nationwide home delivery']],
            'restaurant' => [['রোজ তাজা উপকরণে রান্না', 'Cooked fresh every day'], ['৩০ মিনিটে ডেলিভারি গ্যারান্টি*', '30-minute delivery guarantee*'], ['অনুষ্ঠানের ক্যাটারিং প্যাকেজ', 'Event catering packages'], ['সেরা শেফদের হাতে তৈরি', 'Crafted by top chefs']],
            'fashion' => [['নতুন কালেকশন প্রতি সপ্তাহে', 'New collection every week'], ['৭ দিনের সহজ রিটার্ন', 'Easy 7-day returns'], ['সাইজ না মিললে এক্সচেঞ্জ', 'Size exchange available'], ['সারা দেশে ক্যাশ অন ডেলিভারি', 'Nationwide Cash on Delivery']],
            'beauty' => [['ডার্মাটোলজিক্যালি টেস্টেড', 'Dermatologically tested'], ['১০০% অথেনটিক ব্র্যান্ড', '100% authentic brands'], ['ফ্রি স্কিন-কেয়ার কনসালটেশন', 'Free skincare consultation'], ['অর্ডারে গিফট স্যাম্পল', 'Free samples with orders']],
            'electronics' => [['অফিসিয়াল ওয়ারেন্টি সহকারে', 'With official warranty'], ['১০০% অরিজিনাল প্রোডাক্ট', '100% original products'], ['১৪ দিনের রিপ্লেসমেন্ট', '14-day replacement'], ['দ্রুত ডেলিভারি, সেফ প্যাকেজিং', 'Fast delivery, safe packaging']],
            'jewelry' => [['হাতে গড়া এক্সক্লুসিভ ডিজাইন', 'Handcrafted exclusive designs'], ['অ্যান্টি-টার্নিশ কোটিং', 'Anti-tarnish coating'], ['সীমিত এডিশন কালেকশন', 'Limited edition collections'], ['গিফট বক্সসহ ডেলিভারি', 'Delivered in gift boxes']],
            'furniture' => [['৫ বছরের ওয়ারেন্টি', '5-year warranty'], ['মাস্টার কারিগরদের হাতে তৈরি', 'Crafted by master carpenters'], ['ফ্রি অ্যাসেম্বলি সার্ভিস', 'Free assembly service'], ['সারা দেশে ডেলিভারি', 'Nationwide delivery']],
            'healthcare' => [['১০০% অথেনটিক প্রোডাক্ট', '100% authentic products'], ['লাইসেন্সড ফার্মেসি থেকে', 'From a licensed pharmacy'], ['ঠান্ডা-চেইন সরবরাহ', 'Cold-chain handling'], ['এক্সপার্ট পরামর্শ সেবা', 'Expert guidance available']],
            'education' => [['অভিজ্ঞ শিক্ষক প্যানেল', 'Experienced mentor panel'], ['ফ্রি ডেমো ক্লাস', 'Free demo class'], ['উইকলি প্রগ্রেস রিপোর্ট', 'Weekly progress reports'], ['অনলাইন + অফলাইন ব্যাচ', 'Online + offline batches']],
            'travel' => [['সার্ভিস চার্জ ওয়েভ অফার', 'Service fee waived'], ['ভেরিফায়েড হোটেল ও গাইড', 'Verified hotels & guides'], ['ইএমআই সুবিধা আছে', 'EMI facility available'], ['২৪/৭ ট্রাভেল সাপোর্ট', '24/7 travel support']],
        ];
        return $M[$key] ?? [];
    }

    /** Hero slider texts for slides 2 & 3, per genre: [s2main, s2grad, s3main, s3grad] each [bn, en]. */
    public static function heroSlides(string $key): array
    {
        $H = [
            'organic' => [
                [['ঠাকুমার রেসিপিতে, ঘরে তৈরি —', "Thakumar's recipe, made at home —"], ['১০০% প্রিজারভেটিভ মুক্ত', '100% preservative free']],
                [['আজই অর্ডার করুন ক্যাশ অন ডেলিভারিতে —', 'Order today on Cash on Delivery —'], ['৬৪ জেলায় হোম ডেলিভারি', 'home delivery in 64 districts']],
            ],
            'restaurant' => [
                [['ঘরে বসে রেস্টুরেন্টের স্বাদ —', 'Restaurant taste at home —'], ['রান্না হয় অর্ডার পাওয়ার পরে', 'cooked after you order']],
                [['অনুষ্ঠানে ক্যাটারিং?', 'Planning an event?'], ['আমরা সামলে নেব পুরো মেনু', 'we handle the whole menu']],
            ],
            'fashion' => [
                [['উৎসবের পোশাক এসেছে —', 'Festive wear has arrived —'], ['সীমিত স্টক, এক্সক্লুসিভ ডিজাইন', 'limited stock, exclusive designs']],
                [['সারা দেশে ডেলিভারি —', 'Delivered nationwide —'], ['৭ দিনের সহজ রিটার্ন', 'easy 7-day returns']],
            ],
            'beauty' => [
                [['স্কিনকেয়ার রুটিন শুরু হোক —', 'Start your skincare routine —'], ['খাঁটি উপকরণে যত্ন', 'care with honest ingredients']],
                [['নতুন লুক, নতুন আত্মবিশ্বাস —', 'New look, new confidence —'], ['মেকআপ এসেনশিয়ালস', 'makeup essentials']],
            ],
            'electronics' => [
                [['নতুন গ্যাজেট এসেছে —', 'New gadgets are here —'], ['অফিসিয়াল ওয়ারেন্টিতে', 'with official warranty']],
                [['স্মার্ট লাইফ আপগ্রেড —', 'Upgrade your smart life —'], ['সেরা দামে', 'at the best price']],
            ],
            'jewelry' => [
                [['ব্রাইডাল কালেকশন এসেছে —', 'The bridal collection is here —'], ['সীমিত এডিশনের পিস', 'limited-edition pieces']],
                [['উপহারে সেরা পছন্দ —', 'The perfect gift —'], ['গিফট বক্সসহ ডেলিভারি', 'delivered in a gift box']],
            ],
            'furniture' => [
                [['বাড়ির প্রতিটি কোণ সাজান —', 'Style every corner of your home —'], ['কাঠের টেকসই শক্তিতে', 'with durable solid wood']],
                [['৫ বছরের ওয়ারেন্টি —', '5-year warranty —'], ['ফ্রি অ্যাসেম্বলি সার্ভিস', 'free assembly service']],
            ],
            'healthcare' => [
                [['পরিবারের যত্নে খাঁটি পণ্য —', 'Authentic care for your family —'], ['লাইসেন্সড ফার্মেসি থেকে', 'from a licensed pharmacy']],
                [['ভিটামিন ও সাপ্লিমেন্ট —', 'Vitamins & supplements —'], ['নিয়মিত ব্যবহারে সুস্থতা', 'for everyday wellness']],
            ],
            'education' => [
                [['নতুন ব্যাচে ভর্তি চলছে —', 'New batch admission open —'], ['সীমিত সিট, আজই নিশ্চিত করুন', 'limited seats — secure today']],
                [['স্কিল শিখুন, ইনকাম শুরু করুন —', 'Learn a skill, start earning —'], ['প্রজেক্ট-বেইজড ট্রেনিং', 'project-based training']],
            ],
            'travel' => [
                [['পাহাড় থেকে সমুদ্র —', 'From hills to the sea —'], ['বাজেটে সেরা প্যাকেজ', 'the best value packages']],
                [['বিদেশ ঘুরতে যাচ্ছেন? —', 'Going abroad? —'], ['ভিসা সাপোর্টসহ ট্যুর', 'tours with visa support']],
            ],
        ];

        $rows = $H[$key] ?? [];
        return [
            'hero_s2_main' => $rows[0][0] ?? null,
            'hero_s2_grad' => $rows[0][1] ?? null,
            'hero_s3_main' => $rows[1][0] ?? null,
            'hero_s3_grad' => $rows[1][1] ?? null,
        ];
    }

    /** Demo reviews for a genre. */
    public static function reviews(string $key): array
    {
        $R = [
            'organic' => [['সুন্দরবনের মধু একদম আসল — পরিবারের সবাই পছন্দ করেছে!', 'Real Sundarbans honey — my whole family loved it!'], ['আচারের স্বাদ ঠিক ঠাকুমার হাতের মতো। ডেলিভারিও দ্রুত পেয়েছি।', 'The pickle tastes just like grandma\u2019s. Fast delivery too.'], ['প্যাকেজিং দেখে মুগ্ধ — এক ফোঁটাও লিক হয়নি।', 'Impressed by the packaging — not a single leak.']],
            'restaurant' => [['বিরিয়ানির স্বাদ একদম রেস্টুরেন্টের মতো — রোজ অর্ডার করি!', 'Biriyani tastes restaurant-grade — I order daily!'], ['অনুষ্ঠানে ক্যাটারিং নিয়েছিলাম, গেস্টরা প্রশংসা করেছে।', 'Booked catering for an event — guests kept praising the food.'], ['গরম খাবার একদম ঠিক সময়ে পৌঁছেছে। ধন্যবাদ!', 'Hot food arrived right on time. Thank you!']],
            'fashion' => [['পাঞ্জাবির কাপড় আর সেলাই দুটোই পারফেক্ট — দামের তুলনায় সেরা।', 'Fabric and stitching both perfect — best value for money.'], ['শাড়িটা ছবির চেয়েও সুন্দর! বান্ধবীকেও অর্ডার করিয়েছি।', 'The saree is even prettier than the photo! Ordered one for my friend too.'], ['মাপ অনুযায়ী ফিটিং একদম ঠিক এসেছে। আবার অর্ডার করব।', 'Fitting was exactly right. Will order again.']],
            'beauty' => [['সিরাম ব্যবহারে ত্বক অনেক উজ্জ্বল হয়েছে — অথেনটিক প্রোডাক্ট।', 'My skin got visibly brighter — authentic product.'], ['সানস্ক্রিন একদম হালকা, দাগ পড়ে না। রিপিট করব।', 'Lightweight sunscreen, no white cast. Will repurchase.'], ['অর্ডার করা প্রোডাক্টগুলো সিলড প্যাকে আসে — বিশ্বাসযোগ্য দোকান।', 'Everything came sealed — a trustworthy shop.']],
            'electronics' => [['হেডফোনের সাউন্ড কোয়ালিটি দামের তুলনায় অসাধারণ!', 'Sound quality is amazing for the price!'], ['পাওয়ার ব্যাংক এক চার্জে ৩ দিন চলে। ওয়ারেন্টিও আছে।', 'The power bank lasts 3 days per charge. Warranty included.'], ['অর্ডারের পরদিনই ডেলিভারি — সার্ভিস দুর্দান্ত।', 'Next-day delivery — excellent service.']],
            'jewelry' => [['নেকলেসের ফিনিশিং একদম প্রিমিয়াম — গিফট হিসেবে দিয়েছি, পছন্দ হয়েছে।', 'The necklace finish is premium — gifted it, they loved it.'], ['সিলভার বালা একদম আসলের মতো হালকা আর ঝকঝকে।', 'Silver balas feel light and shiny like real ones.'], ['এক্সক্লুসিভ ডিজাইন, বাজারে পাবেন না — দামও যুক্তিসঙ্গত।', 'Exclusive designs you won\u2019t find elsewhere — fair price too.']],
            'furniture' => [['কাঠের কোয়ালিটি দেখে মুগ্ধ — ৫ বছরের ওয়ারেন্টিও পেয়েছি।', 'Impressed by the wood quality — came with a 5-year warranty.'], ['স্টাডি টেবিলটা একদম স্মুথ ফিনিশে এসেছে, ছেলেটা খুশি।', 'The study table came with a smooth finish — my son loves it.'], ['বাইরের জেলায় এত যত্নে ডেলিভারি হয় ভাবিনি। ধন্যবাদ!', 'Didn\u2019t expect such careful delivery outside Dhaka. Thanks!']],
            'healthcare' => [['প্রোডাক্ট একদম অরিজিনাল — মেয়াদও ভালো এসেছে।', 'Products are genuine with long expiry dates.'], ['বাড়িতে বসে প্রেশার মনিটর পেয়ে গেছি — সার্ভিস দ্রুত।', 'Got the BP monitor at home — quick service.'], ['ভাইয়া/আপুরা কল করে বুঝিয়ে দেন কোনটা দরকার — আস্থার জায়গা।', 'They call and explain what you need — a place you can trust.']],
            'education' => [['লাইভ ক্লাসগুলো দারুণ — শিক্ষকরা বারবার বুঝিয়ে দেন।', 'The live classes are great — teachers explain patiently.'], ['উইকলি এক্সামের রিপোর্ট অভিভাবকের ফোনে আসে — দারুণ সিস্টেম।', 'Weekly exam reports go to guardians — brilliant system.'], ['গ্রাফিক ডিজাইন কোর্স শেষে ক্লায়েন্ট পাওয়া শুরু করেছি!', 'After the graphic design course I started getting clients!']],
            'travel' => [['সাজেক ট্যুরের গাইড আর হোটেল দুটোই সেরা — ঝামেলাহীন ট্রিপ।', 'Sajek tour guide and hotel were the best — hassle-free trip.'], ['প্যাকেজের দামে যা লেখা তাই-ই খরচ — কোনো লুকানো বিল নেই।', 'You pay exactly what the package says — no hidden bills.'], ['হানিমুন ট্রিপটা ভুলবার নয় — প্ল্যানিং ছিল পারফেক্ট।', 'An unforgettable honeymoon — perfectly planned.']],
        ];
        $sel = $R[$key] ?? $R['organic'];
        $out = [];
        foreach ($sel as $i => $r) {
            $out[] = [
                'img' => 'assets/img/genres/' . $key . '/avatar-' . ($i + 1) . '.svg',
                'name' => ['রফিকুল ইসলাম', 'শারমিন আক্তার', 'তানভীর হাসান'][$i % 3],
                'loc_bn' => 'ভেরিফাইড পারচেজ • ঢাকা',
                'loc_en' => 'Verified Purchase • Dhaka',
                'text_bn' => $r[0], 'text_en' => $r[1],
                'stars' => 5,
                'likes_bn' => 'Like (' . [24, 18, 31][$i % 3] . ')', 'likes_en' => 'Like (' . [24, 18, 31][$i % 3] . ')',
            ];
        }
        return $out;
    }
}
