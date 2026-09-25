<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    public function index()
    {
        return view('admin.seo', [
            'title' => Setting::get('seo_title', 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ'),
            'desc' => Setting::get('seo_desc', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু, ঘি ও চাটনি — প্রিজার্ভেটিভ মুক্ত, ক্যাশ অন ডেলিভারিতে সারা বাংলাদেশে হোম ডেলিভারি।'),
            'keywords' => Setting::get('seo_keywords', 'deshi achar, mango pickle, আচারবাড়ি, homemade pickle BD, sundarban honey, deshi ghee, tamarind chutney, achar online BD, খাঁটি মধু, দেশি ঘি'),
            'canonical' => Setting::get('seo_canonical', ''),
            'ogTitle' => Setting::get('og_title', ''),
            'ogDesc' => Setting::get('og_desc', ''),
            'ogImage' => Setting::get('og_image', ''),
            'gscVerification' => Setting::get('gsc_verification', ''),
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'seo_title' => 'required|string|max:150',
            'seo_desc' => 'required|string|max:400',
            'seo_keywords' => 'required|string|max:500',
            'seo_canonical' => 'nullable|url|max:300',
            'og_title' => 'nullable|string|max:150',
            'og_desc' => 'nullable|string|max:300',
            'gsc_verification' => 'nullable|string|max:200',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=600,min_height=315',
        ]);

        $pairs = [
            'seo_title' => $data['seo_title'],
            'seo_desc' => $data['seo_desc'],
            'seo_keywords' => $data['seo_keywords'],
            'seo_canonical' => $data['seo_canonical'] ?? '',
            'og_title' => $data['og_title'] ?? '',
            'og_desc' => $data['og_desc'] ?? '',
            'gsc_verification' => trim($data['gsc_verification'] ?? ''),
        ];

        if ($request->hasFile('og_image')) {
            if ($old = Setting::get('og_image')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $old));
            }
            $path = $request->file('og_image')->store('seo', 'public');
            $pairs['og_image'] = 'storage/' . $path;
        }

        if ($request->boolean('remove_og_image')) {
            if ($old = Setting::get('og_image')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $old));
            }
            $pairs['og_image'] = '';
        }

        Setting::setMany($pairs);

        return back()->with('success', 'SEO সেটিংস সেভ হয়েছে — মেটা, Open Graph ও স্ট্রাকচার্ড ডেটা লাইভ প্রয়োগ হবে।');
    }

    public function robotsPage()
    {
        return view('admin.robots', [
            'robots' => Setting::get('robots_txt', self::defaultRobots()),
        ]);
    }

    public function saveRobots(Request $request)
    {
        $request->validate(['robots_txt' => 'required|string|max:3000']);
        Setting::set('robots_txt', $request->robots_txt);

        return back()->with('success', 'robots.txt সেভ হয়েছে — ' . url('/robots.txt') . ' এ লাইভ।');
    }

    public function robotsTxt()
    {
        return response(Setting::get('robots_txt', self::defaultRobots()), 200, ['Content-Type' => 'text/plain']);
    }

    public static function defaultRobots(): string
    {
        $base = rtrim(config('app.url') ?: url('/'), '/');

        return "User-agent: *\nAllow: /\nDisallow: /admin\n\nSitemap: {$base}/sitemap.xml";
    }
}
