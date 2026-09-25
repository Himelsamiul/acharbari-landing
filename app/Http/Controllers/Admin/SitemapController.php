<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SitemapUrl;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function page()
    {
        return view('admin.sitemap', [
            'xml' => $this->buildSitemap(),
            'productCount' => Product::where('is_active', true)->count(),
            'urls' => SitemapUrl::orderByDesc('priority')->get(),
        ]);
    }

    public function xml()
    {
        return response($this->buildSitemap(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'loc' => 'required|string|max:500',
            'priority' => 'required|numeric|between:0.1,1',
            'changefreq' => 'required|in:always,hourly,daily,weekly,monthly,yearly,never',
        ]);

        // store as path (leading /) or absolute URL, normalized
        $data['loc'] = '/' . trim(parse_url($data['loc'], PHP_URL_PATH) ?: $data['loc'], '/ ');
        $data['is_active'] = true;

        SitemapUrl::updateOrCreate(['loc' => $data['loc']], $data);

        return back()->with('success', 'URL সাইটম্যাপে যোগ হয়েছে — ' . $data['loc']);
    }

    public function toggle(SitemapUrl $url)
    {
        $url->update(['is_active' => ! $url->is_active]);

        return back()->with('success', $url->is_active ? 'URL চালু করা হয়েছে।' : 'URL সাইটম্যাপ থেকে বাদ দেওয়া হয়েছে।');
    }

    public function destroy(SitemapUrl $url)
    {
        $url->delete();

        return back()->with('success', 'URL মুছে ফেলা হয়েছে।');
    }

    private function buildSitemap(): string
    {
        $base = rtrim(config('app.url') ?: url('/'), '/');
        $today = now()->toDateString();

        // auto URLs: home, products list, active products
        $urls = [
            [$base . '/', '1.0', 'daily'],
            [$base . '/products', '0.9', 'daily'],
        ];

        Product::where('is_active', true)->orderBy('sort_order')->get()
            ->each(function ($p) use (&$urls, $base) {
                $urls[] = [$base . '/product/' . $p->slug, '0.8', 'weekly'];
            });

        // custom URLs from admin
        foreach (SitemapUrl::active() as $u) {
            $loc = str_starts_with($u['loc'], 'http') ? $u['loc'] : $base . $u['loc'];
            $urls[] = [$loc, $u['priority'], $u['freq']];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as [$loc, $priority, $freq]) {
            $xml .= "  <url>\n    <loc>" . htmlspecialchars($loc, ENT_XML1) . "</loc>\n    <lastmod>{$today}</lastmod>\n    <changefreq>{$freq}</changefreq>\n    <priority>{$priority}</priority>\n  </url>\n";
        }
        $xml .= '</urlset>';

        return $xml;
    }
}
