<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Redirect;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        // store orders only — landing-design orders (source='landing') belong
        // to the super admin's /super/orders section, not the client dashboard
        $store = Order::where('source', Order::SOURCE_STORE);

        $stats = [
            'orders_today' => (clone $store)->whereDate('created_at', today())->count(),
            'orders_total' => (clone $store)->count(),
            'pending' => (clone $store)->where('status', 'pending')->count(),
            'revenue' => (clone $store)->whereIn('status', ['processing', 'shipped', 'delivered'])->sum('total'),
            'products' => Product::where('is_active', true)->count(),
            'customers' => (clone $store)->distinct('phone')->count('phone'),
        ];

        $recent = (clone $store)->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recent') + ['seoChecks' => $this->seoChecks()]);
    }

    private function seoChecks(): array
    {
        // khali hole dynamic default-i cholche — check ta effective value er upor
        $title = Setting::get('seo_title') ?: ab_seo_default_title();
        $desc = Setting::get('seo_desc') ?: ab_seo_default_desc();
        $active = Product::where('is_active', true);
        $total = (clone $active)->count();

        return [
            ['ok' => mb_strlen($title) >= 30, 'label' => 'Meta Title সেট (' . mb_strlen($title) . ' অক্ষর)', 'url' => route('admin.seo')],
            ['ok' => mb_strlen($desc) >= 120, 'label' => 'Meta Description সেট (' . mb_strlen($desc) . ' অক্ষর)', 'url' => route('admin.seo')],
            ['ok' => (bool) Setting::get('og_image'), 'label' => 'OG Image আপলোড (সোশ্যাল শেয়ার)', 'url' => route('admin.seo')],
            ['ok' => (bool) Setting::get('gsc_verification'), 'label' => 'Search Console ভেরিফিকেশন', 'url' => route('admin.seo')],
            ['ok' => (bool) Setting::get('robots_txt'), 'label' => 'robots.txt কাস্টমাইজড', 'url' => route('admin.robots')],
            ['ok' => $total === 0 || (clone $active)->whereNotNull('meta_title')->count() === $total, 'label' => 'সব প্রোডাক্টে Meta Title', 'url' => route('admin.products.index')],
            ['ok' => $total === 0 || (clone $active)->whereNotNull('image_alt')->count() === $total, 'label' => 'সব প্রোডাক্টে Alt Text', 'url' => route('admin.products.index')],
            ['ok' => Redirect::exists(), 'label' => '301 রিডাইরেক্ট কনফিগারড', 'url' => route('admin.redirects.index')],
        ];
    }
}
