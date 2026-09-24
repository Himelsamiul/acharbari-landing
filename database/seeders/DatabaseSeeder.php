<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        foreach ([
            ['আচার', 'Pickles', 'pickle'],
            ['মধু ও ঘি', 'Honey & Ghee', 'pure'],
            ['চাটনি', 'Chutney', 'chaatni'],
        ] as [$name, $nameEn, $key]) {
            \App\Models\Category::updateOrCreate(['key' => $key], ['name' => $name, 'name_en' => $nameEn]);
        }

        // Brands
        \App\Models\Brand::updateOrCreate(['name' => 'আচারবাড়ি']);
        \App\Models\Brand::updateOrCreate(['name' => 'গ্রাম ভাণ্ডার']);

        // Site settings defaults
        \App\Models\Setting::setMany([
            'brand_bn1' => 'আচার', 'brand_bn2' => 'বাড়ি',
            'brand_en1' => 'Achar', 'brand_en2' => 'Bari',
            'logo_path' => '',
            'theme_id' => 'spice',
        ]);

        // Admin user
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@khorak.shop'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $products = [
            [
                'slug' => 'mango-kuchi-achar',
                'name' => 'খাঁটি আমের কুচি আচার (৫০০ গ্রাম) — খাঁটি সরিষার তেলে',
                'name_en' => 'Authentic Mango Kuchi Achar (500g) — in pure mustard oil',
                'category' => 'আচার', 'category_en' => 'Pickles', 'category_key' => 'pickle',
                'price' => 450, 'old_price' => 600,
                'discount_bn' => '-২৫% ছাড়', 'discount_en' => '-25% Off',
                'image' => 'assets/img/prod_mango.jpg',
                'rating' => 4.9, 'reviews_count' => 128,
                'stock_badge' => 'স্টকে আছে', 'stock_badge_en' => 'In Stock',
                'description' => 'মৌসুমি কাঁচা আম ও বিশুদ্ধ মসলায় ঘরে তৈরি খাঁটি কুচি আচার। খাঁটি সরিষার তেলে ভরা, কোনো প্রিজারভেটিভ বা কেমিক্যাল ছাড়াই ১২ মাস পর্যন্ত ভালো থাকে।',
                'description_en' => 'Homemade authentic kuchi achar made with seasonal raw mangoes and pure spices, packed in premium mustard oil.',
                'sort_order' => 1,
            ],
            [
                'slug' => 'jalpai-achar',
                'name' => 'হাতে তৈরি জলপাই আচার (৪০০ গ্রাম) — ঠাকুমার রেসিপিতে',
                'name_en' => 'Handmade Jalpai Olive Pickle (400g) — Thakumar recipe',
                'category' => 'আচার', 'category_en' => 'Pickles', 'category_key' => 'pickle',
                'price' => 380, 'old_price' => 450,
                'discount_bn' => '-১৫% ছাড়', 'discount_en' => '-15% Off',
                'image' => 'assets/img/prod_jalpai.jpg',
                'rating' => 4.8, 'reviews_count' => 95,
                'stock_badge' => 'স্টকে আছে', 'stock_badge_en' => 'In Stock',
                'description' => 'দেশি জলপাই ও ঐতিহ্যবাহী ঠাকুমার রেসিপিতে হাতে তৈরি। হালকা টক-মিষ্টি স্বাদে পুরো পরিবারের প্রিয়।',
                'description_en' => 'Handmade from deshi jalpai olives following a traditional family recipe.',
                'sort_order' => 2,
            ],
            [
                'slug' => 'mixed-pickle-pack',
                'name' => 'স্পেশাল মিক্সড আচার প্যাক (৩ প্রকার) — আম, জলপাই ও মরিচ',
                'name_en' => 'Special Mixed Pickle Pack (3 Varieties) — mango, olive & chili',
                'category' => 'আচার', 'category_en' => 'Pickles', 'category_key' => 'pickle',
                'price' => 650, 'old_price' => 900,
                'discount_bn' => '-২৮% ছাড়', 'discount_en' => '-28% Off',
                'image' => 'assets/img/prod_mix.jpg',
                'rating' => 5.0, 'reviews_count' => 140,
                'stock_badge' => 'হট ডিল', 'stock_badge_en' => 'Hot Deal',
                'description' => 'তিনটি আলাদা সিল করা জারে আমের কুচি, জলপাই ও হট মরিচ আচার। উপহার দেওয়ার জন্য পারফেক্ট কম্বো প্যাক।',
                'description_en' => 'Three separately sealed jars — mango kuchi, jalpai and hot chili achar. A perfect combo pack for gifting.',
                'sort_order' => 3,
            ],
            [
                'slug' => 'tamarind-chutney',
                'name' => 'তেঁতুল ঝোল টক-ঝাল চাটনি (৩৫০ গ্রাম) — খিচুড়ি ও নাস্তার সঙ্গী',
                'name_en' => 'Tetul Jhol Tangy Chutney (350g) — perfect with khichuri & snacks',
                'category' => 'চাটনি', 'category_en' => 'Chutney', 'category_key' => 'chaatni',
                'price' => 290, 'old_price' => 390,
                'discount_bn' => '-২৬% ছাড়', 'discount_en' => '-26% Off',
                'image' => 'assets/img/prod_chutney.jpg',
                'rating' => 4.9, 'reviews_count' => 64,
                'stock_badge' => 'নতুন আগমন', 'stock_badge_en' => 'New Arrival',
                'description' => 'দেশি তেঁতুলের ঘন ঝোল চাটনি — টক-ঝাল-মিষ্টির নিখুঁত ব্যালেন্স। খিচুড়ি, বিরিয়ানি কিংবা সিঙাড়া-পুরির সঙ্গে সবার প্রিয়।',
                'description_en' => 'Thick tamarind chutney with a perfect tangy-hot-sweet balance.',
                'sort_order' => 4,
            ],
            [
                'slug' => 'deshi-ghee',
                'name' => 'ঘরে ভাঙা খাঁটি দেশি ঘি (৫০০ মিলি) — গ্রামের গরুর দুধের সর',
                'name_en' => 'Pure Homemade Deshi Ghee (500ml) — from village cow milk',
                'category' => 'মধু ও ঘি', 'category_en' => 'Honey & Ghee', 'category_key' => 'pure',
                'price' => 1190, 'old_price' => 1400,
                'discount_bn' => '-১৫% ছাড়', 'discount_en' => '-15% Off',
                'image' => 'assets/img/prod_ghee.jpg',
                'rating' => 4.8, 'reviews_count' => 112,
                'stock_badge' => 'স্টকে আছে', 'stock_badge_en' => 'In Stock',
                'description' => 'গ্রামের গরুর দুধের সর থেকে ঐতিহ্যবাহী পদ্ধতিতে ঘরে ভাঙা খাঁটি দেশি ঘি। সেই চেনা ঘ্রাণ আর স্বাদ।',
                'description_en' => 'Pure deshi ghee churned at home from village cow milk cream using the traditional method.',
                'sort_order' => 5,
            ],
            [
                'slug' => 'sundarban-honey',
                'name' => 'সুন্দরবনের খাঁটি কাঁচা মধু (১ কেজি) — ল্যাব টেস্টেড, চিনি মুক্ত',
                'name_en' => 'Pure Raw Sundarban Honey (1kg) — lab-tested, no sugar added',
                'category' => 'মধু ও ঘি', 'category_en' => 'Honey & Ghee', 'category_key' => 'pure',
                'price' => 990, 'old_price' => 1250,
                'discount_bn' => '-২০% ছাড়', 'discount_en' => '-20% Off',
                'image' => 'assets/img/prod_honey.jpg',
                'rating' => 5.0, 'reviews_count' => 200,
                'stock_badge' => '১০০% খাঁটি', 'stock_badge_en' => '100% Pure',
                'description' => 'সুন্দরবনের খলিসা ও কেওড়া ফুলের ১০০% খাঁটি কাঁচা মধু। চিনি বা কেমিক্যাল মুক্ত ল্যাব-টেস্টেড মধু।',
                'description_en' => '100% pure raw honey from the khalsena and keora flowers of the Sundarbans. Lab-tested, no sugar added.',
                'sort_order' => 6,
            ],
        ];

        \App\Models\Product::upsert(
            array_map(function ($i, $p) {
                $p['brand'] = 'আচারবাড়ি';
                $p['unit'] = in_array($p['category_key'], ['pickle', 'chaatni']) ? 'gm' : 'ml';
                $p['stock'] = 60 + $i * 15;
                $p['barcode'] = 'ABP-' . str_pad((string)($i + 1), 4, '0', STR_PAD_LEFT);
                return $p;
            }, array_keys($products), $products),
            ['slug'],
            ['name', 'name_en', 'category', 'category_en', 'category_key', 'brand', 'unit', 'stock', 'barcode', 'price', 'old_price', 'discount_bn', 'discount_en', 'image', 'rating', 'reviews_count', 'stock_badge', 'stock_badge_en', 'description', 'description_en', 'sort_order']
        );
    }
}
