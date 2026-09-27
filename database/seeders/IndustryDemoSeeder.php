<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\IndustryPack;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Per-industry demo catalogue: every genre gets its own demo products +
 * categories, tagged with the `industry` column so the landing page and the
 * admin panel can scope by the active preset. Idempotent — safe to re-run.
 */
class IndustryDemoSeeder extends Seeder
{
    public function run(): void
    {
        $claimedCategoryKeys = [];

        foreach (IndustryPack::all() as $genre => $pack) {
            // genre categories (first genre claims a shared key like `set`)
            $genreCatKeys = [];
            foreach (IndustryPack::products($genre) as $p) {
                $genreCatKeys[$p['category_key']] = [$p['category'], $p['category_en']];
            }
            foreach ($genreCatKeys as $ck => [$bn, $en]) {
                if ($genre !== 'organic' && in_array($ck, $claimedCategoryKeys, true)) {
                    continue;
                }
                $claimedCategoryKeys[] = $ck;
                Category::updateOrCreate(
                    ['key' => $ck],
                    ['name' => $bn, 'name_en' => $en, 'industry' => $genre, 'is_active' => true]
                );
            }

            foreach (IndustryPack::products($genre) as $i => $p) {
                $payload = [
                    'name' => $p['name'], 'name_en' => $p['name_en'],
                    'category' => $p['category'], 'category_en' => $p['category_en'], 'category_key' => $p['category_key'],
                    'industry' => $genre,
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
                ];

                if (str_starts_with($p['slug'], 'demo-')) {
                    Product::updateOrCreate(['slug' => $p['slug']], $payload);
                } else {
                    // legacy organic slugs already carry the richer DatabaseSeeder copy — only tag them
                    $existing = Product::where('slug', $p['slug'])->first();
                    if ($existing) {
                        $existing->update(['industry' => $genre, 'is_active' => true]);
                    } else {
                        Product::create($payload + ['slug' => $p['slug']]);
                    }
                }
            }
        }
    }
}
