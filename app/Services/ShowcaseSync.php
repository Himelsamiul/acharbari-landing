<?php

namespace App\Services;

use App\Http\Controllers\Admin\IndustryPack;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

/**
 * Showcase catalogue sync — makes sure the rows exist that the public
 * showcase (/showcase) and the genre demo pages (/showcase/{genre}) sell:
 *
 *  - every genre's 6 demo products (slugs demo-<genre>-<n>; organic reuses
 *    its real product slugs) — created only when MISSING, so admin edits,
 *    stock changes and the active industry's data are never overwritten
 *  - one lp-<genre> row per design (industry='showcase') — the sellable
 *    "landing page design" item on the showcase cart, price synced from
 *    the pack, stock pinned to 0 (= unlimited per the order clamp logic)
 *
 * Unlike applyIndustry() this NEVER deactivates another genre's demos and
 * never touches managed/real products.
 */
class ShowcaseSync
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (IndustryPack::all() as $key => $pack) {
                foreach (IndustryPack::products($key) as $i => $p) {
                    // firstOrCreate keeps this idempotent AND non-destructive:
                    // existing rows (admin-managed or seeded) stay untouched —
                    // except is_active: a past clearIndustry() deactivates ALL
                    // demo-* rows, and the demo pages sell exactly those, so a
                    // sleeping row gets woken up (storefront hiding is the
                    // industry scope's job, not is_active's)
                    $row = Product::firstOrCreate(['slug' => $p['slug']], [
                        'name' => $p['name'], 'name_en' => $p['name_en'],
                        'category' => $p['category'], 'category_en' => $p['category_en'], 'category_key' => $p['category_key'],
                        'industry' => $key,
                        'unit' => 'pcs', 'stock' => 50,
                        'barcode' => strtoupper('GEN-' . substr(md5($p['slug']), 0, 6)),
                        'price' => $p['price'], 'old_price' => $p['old_price'],
                        'vat_percent' => 0,
                        'discount_bn' => '-২৫% ছাড়', 'discount_en' => '-25% Off',
                        'stock_badge' => 'স্টকে আছে', 'stock_badge_en' => 'In Stock',
                        'description' => $p['desc'], 'description_en' => $p['desc_en'],
                        'rating' => 5, 'reviews_count' => 24, 'sort_order' => 10 + $i,
                        'is_active' => true, 'is_featured' => $i === 0,
                        'image' => $p['image'], 'image_alt' => $p['name'],
                    ]);
                    if (! $row->is_active) {
                        $row->update(['is_active' => true]);
                    }
                }

                // the sellable landing-design row itself — pack price is the
                // source of truth, stock pinned back to 0 (unlimited)
                Product::updateOrCreate(['slug' => 'lp-' . $key], [
                    'name' => 'ল্যান্ডিং পেজ — ' . $pack['name_bn'],
                    'name_en' => 'Landing Page — ' . $pack['name_en'],
                    'category' => 'ল্যান্ডিং পেজ ডিজাইন', 'category_en' => 'Landing Page Design', 'category_key' => 'lp-design',
                    'industry' => 'showcase',
                    'unit' => 'pcs', 'stock' => 0,
                    'barcode' => strtoupper('LP-' . substr(md5('lp-' . $key), 0, 6)),
                    'price' => (int) ($pack['price'] ?? 9990), 'old_price' => 0,
                    'vat_percent' => 0,
                    'discount_bn' => '', 'discount_en' => '',
                    'stock_badge' => '', 'stock_badge_en' => '',
                    'description' => $pack['desc'] . ' — সম্পূর্ণ ল্যান্ডিং পেজ ডিজাইন, কনটেন্ট সেটআপসহ।',
                    'description_en' => $pack['desc'] . ' — complete landing page design with content setup.',
                    'rating' => 5, 'reviews_count' => 0, 'sort_order' => 100,
                    'is_active' => true, 'is_featured' => false,
                    'image' => 'assets/img/genres/' . $key . '/hero-1.jpg', 'image_alt' => $pack['name_bn'] . ' Landing Page',
                ]);
            }
        });
    }
}
