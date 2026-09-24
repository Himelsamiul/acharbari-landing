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

        $data = $request->validate([
            'brand_bn1' => 'required|string|max:20',
            'brand_bn2' => 'nullable|string|max:20',
            'brand_en1' => 'required|string|max:20',
            'brand_en2' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $pairs = [
            'brand_bn1' => $data['brand_bn1'],
            'brand_bn2' => $data['brand_bn2'] ?? '',
            'brand_en1' => $data['brand_en1'],
            'brand_en2' => $data['brand_en2'] ?? '',
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('brand', 'public');
            $pairs['logo_path'] = 'storage/' . $path;
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
