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

if (!function_exists('ab_t')) {
    /** Admin-editable bilingual landing text. Empty stored value falls back to the default, so the landing never renders blank. */
    function ab_t(string $key, string $bnDefault, string $enDefault = ''): array
    {
        $bn = trim((string) \App\Models\Setting::get($key . '_bn', ''));
        $en = trim((string) \App\Models\Setting::get($key . '_en', ''));

        return [
            'bn' => $bn !== '' ? $bn : $bnDefault,
            'en' => $en !== '' ? $en : ($enDefault !== '' ? $enDefault : $bnDefault),
        ];
    }
}

if (!function_exists('ab_img_setting')) {
    /** Admin-uploaded image URL for a content slot; falls back to the bundled default (webp preferred). */
    function ab_img_setting(string $key, string $defaultPath): string
    {
        $v = trim((string) \App\Models\Setting::get($key, ''));

        return $v !== '' ? asset($v) : asset(ab_img($defaultPath));
    }
}

if (!function_exists('ab_charge')) {
    /** Numeric setting (delivery charges etc.) with default. */
    function ab_charge(string $key, int $default): int
    {
        $v = (int) \App\Models\Setting::get($key, $default);

        return $v > 0 ? $v : $default;
    }
}

if (!function_exists('ab_json')) {
    /** JSON-list setting (FAQ items, reviews, marquee) with default. */
    function ab_json(string $key, array $default): array
    {
        $arr = json_decode((string) \App\Models\Setting::get($key, ''), true);

        return is_array($arr) && count($arr) ? $arr : $default;
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

if (!function_exists('ab_districts_all')) {
    /** All 64 districts of Bangladesh (English + Bangla names). */
    function ab_districts_all(): array
    {
        return [
            ['en' => 'Dhaka', 'bn' => 'ঢাকা'],
            ['en' => 'Faridpur', 'bn' => 'ফরিদপুর'],
            ['en' => 'Gazipur', 'bn' => 'গাজীপুর'],
            ['en' => 'Gopalganj', 'bn' => 'গোপালগঞ্জ'],
            ['en' => 'Kishoreganj', 'bn' => 'কিশোরগঞ্জ'],
            ['en' => 'Madaripur', 'bn' => 'মাদারীপুর'],
            ['en' => 'Manikganj', 'bn' => 'মানিকগঞ্জ'],
            ['en' => 'Munshiganj', 'bn' => 'মুন্সিগঞ্জ'],
            ['en' => 'Narayanganj', 'bn' => 'নারায়ণগঞ্জ'],
            ['en' => 'Narsingdi', 'bn' => 'নরসিংদী'],
            ['en' => 'Rajbari', 'bn' => 'রাজবাড়ী'],
            ['en' => 'Shariatpur', 'bn' => 'শরীয়তপুর'],
            ['en' => 'Tangail', 'bn' => 'টাঙ্গাইল'],
            ['en' => 'Bogura', 'bn' => 'বগুড়া'],
            ['en' => 'Chapainawabganj', 'bn' => 'চাঁপাইনবাবগঞ্জ'],
            ['en' => 'Joypurhat', 'bn' => 'জয়পুরহাট'],
            ['en' => 'Naogaon', 'bn' => 'নওগাঁ'],
            ['en' => 'Natore', 'bn' => 'নাটোর'],
            ['en' => 'Pabna', 'bn' => 'পাবনা'],
            ['en' => 'Rajshahi', 'bn' => 'রাজশাহী'],
            ['en' => 'Sirajganj', 'bn' => 'সিরাজগঞ্জ'],
            ['en' => 'Dinajpur', 'bn' => 'দিনাজপুর'],
            ['en' => 'Gaibandha', 'bn' => 'গাইবান্ধা'],
            ['en' => 'Kurigram', 'bn' => 'কুড়িগ্রাম'],
            ['en' => 'Lalmonirhat', 'bn' => 'লালমনিরহাট'],
            ['en' => 'Nilphamari', 'bn' => 'নীলফামারী'],
            ['en' => 'Panchagarh', 'bn' => 'পঞ্চগড়'],
            ['en' => 'Rangpur', 'bn' => 'রংপুর'],
            ['en' => 'Thakurgaon', 'bn' => 'ঠাকুরগাঁও'],
            ['en' => 'Barguna', 'bn' => 'বরগুনা'],
            ['en' => 'Barishal', 'bn' => 'বরিশাল'],
            ['en' => 'Bhola', 'bn' => 'ভোলা'],
            ['en' => 'Jhalokati', 'bn' => 'ঝালকাঠি'],
            ['en' => 'Patuakhali', 'bn' => 'পটুয়াখালী'],
            ['en' => 'Pirojpur', 'bn' => 'পিরোজপুর'],
            ['en' => 'Bandarban', 'bn' => 'বান্দরবান'],
            ['en' => 'Brahmanbaria', 'bn' => 'ব্রাহ্মণবাড়িয়া'],
            ['en' => 'Chandpur', 'bn' => 'চাঁদপুর'],
            ['en' => 'Chattogram', 'bn' => 'চট্টগ্রাম'],
            ['en' => 'Cumilla', 'bn' => 'কুমিল্লা'],
            ['en' => "Cox's Bazar", 'bn' => 'কক্সবাজার'],
            ['en' => 'Feni', 'bn' => 'ফেনী'],
            ['en' => 'Khagrachhari', 'bn' => 'খাগড়াছড়ি'],
            ['en' => 'Lakshmipur', 'bn' => 'লক্ষ্মীপুর'],
            ['en' => 'Noakhali', 'bn' => 'নোয়াখালী'],
            ['en' => 'Rangamati', 'bn' => 'রাঙ্গামাটি'],
            ['en' => 'Bagerhat', 'bn' => 'বাগেরহাট'],
            ['en' => 'Chuadanga', 'bn' => 'চুয়াডাঙ্গা'],
            ['en' => 'Jashore', 'bn' => 'যশোর'],
            ['en' => 'Jhenaidah', 'bn' => 'ঝিনাইদহ'],
            ['en' => 'Khulna', 'bn' => 'খুলনা'],
            ['en' => 'Kushtia', 'bn' => 'কুষ্টিয়া'],
            ['en' => 'Magura', 'bn' => 'মাগুরা'],
            ['en' => 'Meherpur', 'bn' => 'মেহেরপুর'],
            ['en' => 'Narail', 'bn' => 'নড়াইল'],
            ['en' => 'Satkhira', 'bn' => 'সাতক্ষীরা'],
            ['en' => 'Habiganj', 'bn' => 'হবিগঞ্জ'],
            ['en' => 'Moulvibazar', 'bn' => 'মৌলভীবাজার'],
            ['en' => 'Sunamganj', 'bn' => 'সুনামগঞ্জ'],
            ['en' => 'Sylhet', 'bn' => 'সিলেট'],
            ['en' => 'Jamalpur', 'bn' => 'জামালপুর'],
            ['en' => 'Mymensingh', 'bn' => 'ময়মনসিংহ'],
            ['en' => 'Netrokona', 'bn' => 'নেত্রকোনা'],
            ['en' => 'Sherpur', 'bn' => 'শেরপুর'],
        ];
    }
}

if (!function_exists('ab_districts')) {
    /**
     * Districts the admin delivers to, with charges: [['en','bn','charge'],…].
     * Falls back to the legacy inside/outside pricing (Dhaka ৳80, rest ৳150)
     * until the admin saves a district-wise configuration.
     */
    function ab_districts(): array
    {
        $saved = json_decode((string) \App\Models\Setting::get('delivery_districts', ''), true);

        if (is_array($saved) && count($saved)) {
            return array_values(array_filter($saved, fn ($d) => isset($d['en'], $d['charge'])));
        }

        return array_map(
            fn ($d) => ['en' => $d['en'], 'bn' => $d['bn'], 'charge' => $d['en'] === 'Dhaka' ? 80 : 150],
            ab_districts_all()
        );
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
