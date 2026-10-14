<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\IndustryPack;
use App\Models\Product;
use App\Services\ShowcaseSync;
use Illuminate\Http\Request;

/**
 * Public showcase (/showcase) — the super admin's design gallery with its
 * own cart, plus the per-genre live demo pages. Completely standalone from
 * the store's active theme/industry/content settings: demo pages resolve
 * everything per-request from IndustryPack + ThemeLibrary and never write
 * to settings.
 */
class ShowcaseController extends Controller
{
    /** GET /showcase — gallery of the 10 sellable landing-page designs. */
    public function index()
    {
        // the gallery cart sells lp-<genre> rows — make sure they exist
        (new ShowcaseSync)->run();

        $designs = collect(IndustryPack::all())->map(function (array $pack, string $key) {
            $pack['key'] = $key;
            $pack['product'] = Product::where('slug', 'lp-' . $key)->first();
            $pack['cover'] = 'assets/img/genres/' . $key . '/hero-1.jpg';
            // oi design er demo admin credential — card e dekhano (public demo)
            $pack['demo_admin'] = [
                'email' => ShowcaseSync::demoAdminEmail($key),
                'password' => ShowcaseSync::DEMO_ADMIN_PASSWORD,
                'exists' => \App\Models\User::where('email', ShowcaseSync::demoAdminEmail($key))
                    ->where('is_active', true)->exists(),
            ];

            return $pack;
        });

        return view('showcase', ['designs' => $designs, 'coupons' => \App\Models\Coupon::activeMap()]);
    }

    /** GET /showcase/{genre} — full themed live demo with a working product cart. */
    public function demo(string $genre)
    {
        abort_unless(IndustryPack::valid($genre), 404);

        // demo checkout re-prices from real rows — make sure this genre's exist
        (new ShowcaseSync)->run();

        $slugs = array_column(IndustryPack::products($genre), 'slug');
        $products = Product::whereIn('slug', $slugs)
            ->where('is_active', true)
            ->with('variants')
            ->orderBy('sort_order')
            ->get();

        return view('showcase.demo', [
            'genre' => $genre,
            'pack' => IndustryPack::all()[$genre],
            'theme' => \App\Http\Controllers\Admin\ThemeLibrary::get(IndustryPack::all()[$genre]['theme']),
            'products' => $products,
            'qv' => buildQuickView($products),
        ]);
    }
}
