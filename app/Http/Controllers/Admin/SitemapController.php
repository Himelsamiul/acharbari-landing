<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class SitemapController extends Controller
{
    public function page()
    {
        return view('admin.sitemap', [
            'xml' => $this->buildSitemap(),
            'productCount' => Product::where('is_active', true)->count(),
        ]);
    }

    public function xml()
    {
        return response($this->buildSitemap(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    private function buildSitemap(): string
    {
        $base = rtrim(config('app.url') ?: url('/'), '/');
        $today = now()->toDateString();

        $urls = [
            [$base . '/', '1.0', 'daily'],
            [$base . '/products', '0.9', 'daily'],
        ];

        Product::where('is_active', true)->orderBy('sort_order')->get()
            ->each(function ($p) use (&$urls, $base, $today) {
                $urls[] = [$base . '/product/' . $p->slug, '0.8', 'weekly'];
            });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as [$loc, $priority, $freq]) {
            $xml .= "  <url>\n    <loc>{$loc}</loc>\n    <lastmod>{$today}</lastmod>\n    <changefreq>{$freq}</changefreq>\n    <priority>{$priority}</priority>\n  </url>\n";
        }
        $xml .= '</urlset>';

        return $xml;
    }
}
