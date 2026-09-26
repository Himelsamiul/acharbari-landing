<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /** Brand: logo + name (landing reflects instantly). */
    public function brand()
    {
        return view('admin.brand', [
            'settings' => Setting::allCached(),
        ]);
    }

    public function saveBrand(Request $request)
    {
        // logo removal (standalone action)
        if ($request->boolean('remove_logo')) {
            Setting::set('logo_path', '');
            return back()->with('success', 'লোগো ডিফল্টে ফিরে গেছে।');
        }

        // favicon removal (standalone action)
        if ($request->boolean('remove_favicon')) {
            Setting::set('favicon_path', '');
            return back()->with('success', 'ফেভিকন ডিফল্টে ফিরে গেছে।');
        }

        $data = $request->validate([
            'brand_bn1' => 'required|string|max:20',
            'brand_bn2' => 'nullable|string|max:20',
            'brand_en1' => 'required|string|max:20',
            'brand_en2' => 'nullable|string|max:20',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'favicon' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,ico|max:1024',
            'contact_phone' => 'nullable|string|max:20',
            'contact_whatsapp' => 'nullable|string|max:255',
            'contact_messenger' => 'nullable|string|max:60',
            'contact_facebook' => 'nullable|url|max:255',
        ]);

        $pairs = [
            'brand_bn1' => $data['brand_bn1'],
            'brand_bn2' => $data['brand_bn2'] ?? '',
            'brand_en1' => $data['brand_en1'],
            'brand_en2' => $data['brand_en2'] ?? '',
            'contact_phone' => $data['contact_phone'] ?? '',
            'contact_whatsapp' => $data['contact_whatsapp'] ?? '',
            'contact_messenger' => $data['contact_messenger'] ?? '',
            'contact_facebook' => $data['contact_facebook'] ?? '',
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('brand', 'public');
            $pairs['logo_path'] = 'storage/' . $path;
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('brand', 'public');
            $pairs['favicon_path'] = 'storage/' . $path;
        }

        Setting::setMany($pairs);

        return back()->with('success', 'ব্র্যান্ড সেটিংস সেভ হয়েছে — ল্যান্ডিং পেজে দেখুন।');
    }

    /** Theme: presets + custom colors (landing reads from DB). */
    public function theme()
    {
        return view('admin.theme', [
            'themeId' => Setting::get('theme_id', 'herbal'),
            'themeJson' => Setting::get('theme_json', json_encode(\App\Http\Controllers\Admin\ThemeLibrary::get('herbal'))),
        ]);
    }

    public function saveTheme(Request $request)
    {
        $data = $request->validate([
            'theme_id' => 'required|string|max:30',
            'theme_json' => 'required|json',
        ]);

        Setting::setMany([
            'theme_id' => $data['theme_id'],
            'theme_json' => $data['theme_json'],
        ]);

        return back()->with('success', 'থিম সেভ হয়েছে — ল্যান্ডিং পেজে দেখুন।');
    }

    public function saveCustomTheme(Request $request)
    {
        $data = $request->validate([
            'primary' => 'required|string|max:9',
            'dark' => 'required|string|max:9',
            'accent' => 'required|string|max:9',
        ]);

        $theme = \App\Http\Controllers\Admin\ThemeLibrary::custom($data['primary'], $data['dark'], $data['accent']);

        Setting::setMany([
            'theme_id' => 'custom',
            'theme_json' => json_encode($theme),
        ]);

        return response()->json($theme);
    }

    public function resetTheme()
    {
        Setting::setMany([
            'theme_id' => 'herbal',
            'theme_json' => json_encode(\App\Http\Controllers\Admin\ThemeLibrary::get('herbal')),
        ]);

        return back()->with('success', 'ডিফল্ট (হার্বাল গ্রিন) থিমে ফিরে গেছে।');
    }

    /** District-wise delivery: which districts get delivery and at what charge. */
    public function delivery()
    {
        return view('admin.delivery', [
            'districts' => ab_districts(),
            'allDistricts' => ab_districts_all(),
        ]);
    }

    public function saveDelivery(Request $request)
    {
        $data = $request->validate([
            'districts' => 'required|array|max:64',
            'districts.*.en' => 'required|string|max:60',
            'districts.*.charge' => 'required|integer|min:0|max:5000',
        ]);

        $all = collect(ab_districts_all())->keyBy('en');
        $configured = [];

        foreach ($data['districts'] as $row) {
            $district = $all[trim($row['en'])] ?? null;
            if (! $district) {
                continue; // ignore unknown district names coming from the client
            }

            $configured[] = [
                'en' => $district['en'],
                'bn' => $district['bn'],
                'charge' => (int) $row['charge'],
            ];
        }

        if (count($configured) === 0) {
            return back()->withErrors(['districts' => 'অন্তত একটি জেলায় ডেলিভারি চালু রাখুন।']);
        }

        Setting::setMany([
            'delivery_districts' => json_encode($configured, JSON_UNESCAPED_UNICODE),
        ]);

        return back()->with('success', 'ডেলিভারি এরিয়া সেভ হয়েছে — ' . count($configured) . ' টি জেলায় ডেলিভারি চালু আছে।');
    }

    /** Landing content: hero / sections / order form / footer (ab_t + ab_json keys). */
    public const CONTENT_TEXT_KEYS = [
        // hero
        'hero_chip', 'hero_s1_main', 'hero_s1_grad', 'hero_s2_main', 'hero_s2_grad', 'hero_s3_main', 'hero_s3_grad',
        'hero_lead', 'hero_cta1', 'hero_cta2',
        'hero_stat1', 'hero_stat2', 'hero_stat3', 'hero_stat4',
        'hero_stat1_n', 'hero_stat2_n', 'hero_stat3_n', 'hero_stat4_n',
        'hero_flash', 'hero_badge1_t', 'hero_badge1_s', 'hero_badge2_t', 'hero_badge2_s',
        // product section + filter pills
        'prod_eyebrow', 'prod_h2a', 'prod_h2b', 'prod_sub',
        'filter_all', 'filter_pickle', 'filter_pure', 'filter_chaatni',
        // promises
        'promise_eyebrow', 'promise_h2a', 'promise_h2b', 'promise_sub',
        'promise_c1_t', 'promise_c1_d', 'promise_c1_tag',
        'promise_c2_t', 'promise_c2_d', 'promise_c2_tag',
        'promise_c3_t', 'promise_c3_d', 'promise_c3_tag',
        'promise_c4_t', 'promise_c4_d', 'promise_c4_tag',
        // steps
        'steps_eyebrow', 'steps_h2a', 'steps_h2b', 'steps_sub',
        'step1_t', 'step1_d', 'step2_t', 'step2_d', 'step3_t', 'step3_d',
        // why us
        'why_eyebrow', 'why_h2a', 'why_h2b', 'why_sub', 'why_big_t', 'why_big_d', 'why_verified',
        'why_c1_t', 'why_c1_d', 'why_c2_t', 'why_c2_d', 'why_c3_t', 'why_c3_d', 'why_c4_t', 'why_c4_d',
        // faq headings (items via faq_json)
        'faq_eyebrow', 'faq_h2a', 'faq_h2b', 'faq_sub',
        // order form
        'order_head_a', 'order_head_b', 'order_head_c', 'order_head_sub',
        'cart_title', 'cart_coupon_ph', 'cart_coupon_note',
        'cart_col_mark', 'cart_col_product', 'cart_col_qty', 'cart_col_price',
        'cart_total_sub', 'cart_total_delivery', 'cart_total_grand', 'cart_empty',
        'advance_title', 'advance_payable', 'advance_due',
        'checkout_title', 'f_name_ph', 'f_phone_ph', 'f_address_ph', 'f_area',
        'area_inside', 'area_outside', 'area_pick', 'area_free',
        'pay_method', 'pay_cod', 'pay_cod_sub', 'pay_online', 'pay_online_note_a', 'pay_online_note_b',
        'confirm_order', 'trust_1', 'trust_2', 'trust_3',
        // reviews
        'reviews_eyebrow', 'reviews_h2a', 'reviews_h2b', 'reviews_sub',
        'rating_score', 'rating_total',
        // bottom CTA
        'cta_h2a', 'cta_h2b', 'cta_sub', 'cta_btn',
        // nav + footer
        'logo_pill', 'nav_home', 'nav_products', 'nav_why', 'nav_reviews', 'nav_faq', 'nav_order',
        'footer_tag', 'footer_col_links', 'footer_col_contact', 'footer_fb', 'footer_rights', 'footer_made',
    ];

    public function content()
    {
        return view('admin.content', [
            'settings' => Setting::allCached(),
        ]);
    }

    public function saveContent(Request $request)
    {
        $rules = [];
        foreach (self::CONTENT_TEXT_KEYS as $key) {
            $rules[$key . '_bn'] = 'nullable|string|max:3000';
            $rules[$key . '_en'] = 'nullable|string|max:3000';
        }
        $rules += [
            'marquee_json' => 'nullable|string|max:20000',
            'faq_json' => 'nullable|string|max:60000',
            'reviews_json' => 'nullable|string|max:60000',
            'rating_json' => 'nullable|string|max:10000',
            'delivery_inside' => 'nullable|integer|min:0|max:5000',
            'delivery_outside' => 'nullable|integer|min:0|max:5000',
        ];
        foreach (['hero_img1', 'hero_img2', 'hero_img3', 'hero_img4'] as $img) {
            $rules[$img] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
            $rules[$img . '_remove'] = 'nullable|boolean';
        }

        $data = $request->validate($rules);

        $pairs = [];
        foreach (self::CONTENT_TEXT_KEYS as $key) {
            // shudhu submit-howa key update hoy — onno tab er custom lekha haray na
            if (! array_key_exists($key . '_bn', $data) && ! array_key_exists($key . '_en', $data)) {
                continue;
            }
            $pairs[$key . '_bn'] = trim((string) ($data[$key . '_bn'] ?? ''));
            $pairs[$key . '_en'] = trim((string) ($data[$key . '_en'] ?? ''));
        }

        // repeater groups — empty/invalid JSON clears the override so blade defaults return
        foreach (['marquee' => 'marquee_items', 'faq' => 'faq_items', 'reviews' => 'reviews_items', 'rating' => 'rating_items'] as $field => $setting) {
            if (! array_key_exists($field . '_json', $data)) {
                continue; // onno tab er repeater untouched thakbe
            }
            $rows = json_decode((string) ($data[$field . '_json'] ?? ''), true);
            $pairs[$setting] = (is_array($rows) && count($rows))
                ? json_encode($rows, JSON_UNESCAPED_UNICODE)
                : '';
        }

        foreach (['delivery_inside' => 80, 'delivery_outside' => 150] as $charge => $default) {
            if (array_key_exists($charge, $data) && (int) $data[$charge] > 0) {
                $pairs[$charge] = (int) $data[$charge];
            }
        }

        // hero images follow the logo upload pattern (removal restores the bundled default)
        foreach (['hero_img1', 'hero_img2', 'hero_img3', 'hero_img4'] as $img) {
            if ($request->boolean($img . '_remove')) {
                $pairs[$img] = '';
            } elseif ($request->hasFile($img)) {
                $path = $request->file($img)->store('content', 'public');
                $pairs[$img] = 'storage/' . $path;
            }
        }

        Setting::setMany($pairs);

        return back()->with('success', 'ল্যান্ডিং কনটেন্ট সেভ হয়েছে — ল্যান্ডিং পেজে দেখুন।');
    }

    /** Payment: online payment (bKash / Nagad) on/off + send-money numbers. */
    public function payment()
    {
        return view('admin.payment', [
            'settings' => Setting::allCached(),
        ]);
    }

    public function savePayment(Request $request)
    {
        $data = $request->validate([
            'online_payment_enabled' => 'nullable|boolean',
            'bkash_enabled' => 'nullable|boolean',
            'bkash_mode' => 'nullable|in:sandbox,live',
            'bkash_app_key' => 'nullable|string|max:120',
            'bkash_app_secret' => 'nullable|string|max:120',
            'bkash_username' => 'nullable|string|max:120',
            'bkash_password' => 'nullable|string|max:120',
            'nagad_enabled' => 'nullable|boolean',
            'nagad_mode' => 'nullable|in:sandbox,live',
            'nagad_merchant_id' => 'nullable|string|max:120',
            'nagad_public_key' => 'nullable|string|max:5000',
            'nagad_private_key' => 'nullable|string|max:5000',
        ]);

        Setting::setMany([
            'online_payment_enabled' => $request->boolean('online_payment_enabled') ? '1' : '',
            // bKash (Tokenized Checkout)
            'bkash_enabled' => $request->boolean('bkash_enabled') ? '1' : '',
            'bkash_mode' => $data['bkash_mode'] ?? 'sandbox',
            'bkash_app_key' => trim($data['bkash_app_key'] ?? ''),
            'bkash_app_secret' => trim($data['bkash_app_secret'] ?? ''),
            'bkash_username' => trim($data['bkash_username'] ?? ''),
            'bkash_password' => trim($data['bkash_password'] ?? ''),
            // Nagad (PGW)
            'nagad_enabled' => $request->boolean('nagad_enabled') ? '1' : '',
            'nagad_mode' => $data['nagad_mode'] ?? 'sandbox',
            'nagad_merchant_id' => trim($data['nagad_merchant_id'] ?? ''),
            'nagad_public_key' => trim($data['nagad_public_key'] ?? ''),
            'nagad_private_key' => trim($data['nagad_private_key'] ?? ''),
        ]);

        return back()->with('success', 'পেমেন্ট সেটিংস সেভ হয়েছে — চেকআউটে দেখুন।');
    }

    /** Tracking pixels: FB / GA4 / GTM / TikTok. */
    public function tracking()
    {
        return view('admin.tracking', [
            'pixels' => json_decode(Setting::get('pixels_json', ''), true) ?: [],
        ]);
    }

    public function saveTracking(Request $request, string $key)
    {
        $data = $request->validate([
            'value' => 'nullable|string|max:80',
            'enabled' => 'nullable|boolean',
        ]);

        $all = json_decode(Setting::get('pixels_json', ''), true) ?: [];
        $current = $all[$key] ?? ['enabled' => false, 'value' => ''];
        $current['value'] = trim($data['value'] ?? '');
        if ($request->has('enabled')) {
            $current['enabled'] = $request->boolean('enabled');
        }
        $all[$key] = $current;

        Setting::set('pixels_json', json_encode($all));

        return back()->with('success', 'ট্র্যাকিং সেটিংস সেভ হয়েছে (ডেমো)।');
    }
}
