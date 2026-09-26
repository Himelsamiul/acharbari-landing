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

if (!function_exists('ab_online_payment')) {
    /** Whether the admin turned online payment (bKash / Nagad) on — COD stays available regardless. */
    function ab_online_payment(): bool
    {
        return \App\Models\Setting::get('online_payment_enabled', '') === '1';
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
    /**
     * Contact info from admin settings. Khali thakle '' return kore —
     * landing page tokhon oi contact element hide kore dey.
     */
    function ab_contact(string $key): string
    {
        return trim((string) \App\Models\Setting::get('contact_' . $key, ''));
    }
}

if (!function_exists('ab_reviews_default')) {
    /** The five starter reviews used by the landing page and the admin editor. */
    function ab_reviews_default(): array
    {
        return [
            ['name' => 'নুসরাত জাহান', 'img' => 'assets/img/rev1.jpg', 'stars' => 5, 'source' => 'normal', 'loc_bn' => 'ভেরিফাইড পারচেজ • ঢাকা', 'loc_en' => 'Verified Purchase • Dhaka', 'text_bn' => '"আমের কুচি আচারটা একদম ঠাকুমার বানানো আচারের মতোই লেগেছে! তেল বেশি না, ঝাল-নোনতা পারফেক্ট ব্যালেন্স। ঢাকায় একদিনের মধ্যেই ডেলিভারি পেয়েছি!"', 'text_en' => '"The mango kuchi achar tastes exactly like my grandmother used to make! Not too oily, perfectly spiced. Delivery arrived within a day in Dhaka!"', 'likes_bn' => 'Like (২৪)', 'likes_en' => 'Like (24)'],
            ['name' => 'ফারহানা ইয়াসমিন', 'img' => 'assets/img/rev2.jpg', 'stars' => 5, 'source' => 'normal', 'loc_bn' => 'ভেরিফাইড পারচেজ • চট্টগ্রাম', 'loc_en' => 'Verified Purchase • Chattogram', 'text_bn' => '"মিক্সড প্যাকের প্যাকেজিং দেখে মুগ্ধ! তিনটা আলাদা সিল করা জার, এক ফোঁটাও লিক হয়নি। জলপাই আচারটা বছরের পর বছর ধরে খাওয়া সেরা আচার!"', 'text_en' => '"The mixed pack packaging was amazing — three sealed jars, not a drop leaked. The olive pickle is the best I have had in years!"', 'likes_bn' => 'Like (১৮)', 'likes_en' => 'Like (18)'],
            ['name' => 'তানজিনা আক্তার', 'img' => 'assets/img/rev3.jpg', 'stars' => 5, 'source' => 'normal', 'loc_bn' => 'ভেরিফাইড পারচেজ • রাজশাহী', 'loc_en' => 'Verified Purchase • Rajshahi', 'text_bn' => '"অবশেষে খাঁটি কাঁচা মধু পেলাম! শীতে প্রাকৃতিকভাবে সেট হয়ে গেছে — খাঁটি হওয়ার সবচেয়ে বড় প্রমাণ। পুরো পরিবারের সবাই খুব পছন্দ করেছে।"', 'text_en' => '"Finally found pure raw Sundarban honey! It crystallised naturally in winter — proof that it is real. The whole family loves it."', 'likes_bn' => 'Like (৩১)', 'likes_en' => 'Like (31)'],
            ['name' => 'মেহেজাবীন চৌধুরী', 'img' => 'assets/img/rev4.jpg', 'stars' => 5, 'source' => 'normal', 'loc_bn' => 'ভেরিফাইড পারচেজ • সিলেট', 'loc_en' => 'Verified Purchase • Sylhet', 'text_bn' => '"ঘি খুলতেই পুরো রান্নাঘর ঘ্রাণে ভরে গেল! গরম ভাতে এক চামচ ঘি মানেই আসল স্বাদ। আপনার বোনের জন্য আরও ৩টা অর্ডার দিয়েছি।"', 'text_en' => '"The ghee aroma fills the whole kitchen! One spoon on hot rice and you are in heaven. Ordered 3 more jars for my sister."', 'likes_bn' => 'Like (১৫)', 'likes_en' => 'Like (15)'],
            ['name' => 'সাবরিনা ইসলাম', 'img' => 'assets/img/rev5.jpg', 'stars' => 5, 'source' => 'normal', 'loc_bn' => 'ভেরিফাইড পারচেজ • খুলনা', 'loc_en' => 'Verified Purchase • Khulna', 'text_bn' => '"প্রথমবার অনলাইনে আচার অর্ডার করলাম এবং অভিজ্ঞতা দারুণ! ডেলিভারি ম্যানের সামনে চেক করে টাকা দিলাম। রিকমেন্ডেড শপ।"', 'text_en' => '"First time ordering pickles online and the experience was great! Checked the parcel in front of the delivery man and then paid. Recommended shop."', 'likes_bn' => 'Like (২৯)', 'likes_en' => 'Like (29)'],
        ];
    }
}

if (!function_exists('ab_brand')) {
    /** Brand name assembled from admin brand settings ("Achar"+"Bari"). */
    function ab_brand(string $lang = 'bn'): string
    {
        if ($lang === 'en') {
            return trim(\App\Models\Setting::get('brand_en1', 'Achar') . \App\Models\Setting::get('brand_en2', 'Bari'));
        }

        return trim(\App\Models\Setting::get('brand_bn1', 'আচার') . \App\Models\Setting::get('brand_bn2', 'বাড়ি'));
    }
}

if (!function_exists('ab_social')) {
    /**
     * Footer/chat social icon link: accepts a full URL pasted by the admin as-is,
     * or builds one by prefixing a bare handle/number ("AcharBari" -> https://m.me/AcharBari).
     * Falls back to the same defaults as ab_contact when the setting is empty.
     */
    function ab_social(string $key, string $prefix): string
    {
        $value = trim((string) ab_contact($key));

        if ($value === '') {
            return '#';
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return $prefix . $value;
    }
}

if (!function_exists('ab_code39_png')) {
    /**
     * Scanable Code 39 barcode rendered as a PNG data URI (dompdf embeds it in PDFs).
     * Supports A-Z, 0-9, dash, dot, space, $, /, +, % — order codes & product barcodes fit.
     */
    function ab_code39_png(string $text, int $height = 40, int $unit = 2): string
    {
        $text = strtoupper(preg_replace('/[^A-Z0-9\-\. \$\/\+%]/', '', $text));

        if ($text === '' || ! function_exists('imagecreatetruecolor')) {
            return '';
        }

        $codes = [
            '0' => '000110100', '1' => '100100001', '2' => '001100001', '3' => '101100000',
            '4' => '000110001', '5' => '100110000', '6' => '001110000', '7' => '000100101',
            '8' => '100100100', '9' => '001100100', 'A' => '100001001', 'B' => '001001001',
            'C' => '101001000', 'D' => '000011001', 'E' => '100011000', 'F' => '001011000',
            'G' => '000001101', 'H' => '100001100', 'I' => '001001100', 'J' => '000011100',
            'K' => '100000011', 'L' => '001000011', 'M' => '101000010', 'N' => '000010011',
            'O' => '100010010', 'P' => '001010010', 'Q' => '000000111', 'R' => '100000110',
            'S' => '001000110', 'T' => '000010110', 'U' => '110000001', 'V' => '011000001',
            'W' => '111000000', 'X' => '010010001', 'Y' => '110010000', 'Z' => '011010000',
            '-' => '010000101', '.' => '110000100', ' ' => '011000100', '$' => '010101000',
            '/' => '010100010', '+' => '010001010', '%' => '010000010', '*' => '010010100',
        ];

        $elements = [];
        foreach (str_split('*' . $text . '*') as $index => $char) {
            if (! isset($codes[$char])) {
                continue;
            }
            if ($index > 0) {
                $elements[] = ['space', 1]; // narrow inter-character gap
            }
            foreach (str_split($codes[$char]) as $position => $bit) {
                $elements[] = [$position % 2 === 0 ? 'bar' : 'space', $bit === '1' ? 3 : 1];
            }
        }

        $totalWidth = 0;
        foreach ($elements as [$type, $narrow]) {
            $totalWidth += $narrow * $unit;
        }

        $image = imagecreatetruecolor($totalWidth, $height);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $white);

        $x = 0;
        foreach ($elements as [$type, $narrow]) {
            $width = $narrow * $unit;
            if ($type === 'bar') {
                imagefilledrectangle($image, $x, 0, $x + $width - 1, $height - 1, $black);
            }
            $x += $width;
        }

        ob_start();
        imagepng($image, null, 6);
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode((string) ob_get_clean());
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
