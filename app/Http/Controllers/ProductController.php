<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category = (string) $request->query('category', 'all');
        $brand = trim((string) $request->query('brand', ''));
        $sort = (string) $request->query('sort', 'popular');

        $query = Product::active();

        if ($category !== '' && $category !== 'all') {
            $query->where('category_key', $category);
        }

        if ($brand !== '') {
            $query->where('brand', $brand);
        }

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('name_en', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%");
            });
        }

        switch ($sort) {
            case 'price_low':  $query->orderBy('price'); break;
            case 'price_high': $query->orderByDesc('price'); break;
            case 'name':       $query->orderBy('name'); break;
            default:           $query->orderBy('sort_order');
        }

        $products = $query->get();

        $categories = Product::active()
            ->select('category', 'category_en', 'category_key')
            ->groupBy('category', 'category_en', 'category_key')
            ->get();

        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        return view('products', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'q' => $q,
            'activeCategory' => $category,
            'activeBrand' => $brand,
            'activeSort' => $sort,
            'qv' => buildQuickView($products),
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('product-details', compact('product'));
    }
}
