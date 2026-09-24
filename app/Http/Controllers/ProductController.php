<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_key', $request->category);
        }

        $products = $query->orderBy('sort_order')->get();

        $categories = Product::active()
            ->select('category', 'category_en', 'category_key')
            ->groupBy('category', 'category_en', 'category_key')
            ->get();

        return view('products', [
            'products' => $products,
            'categories' => $categories,
            'qv' => buildQuickView($products),
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('product-details', compact('product'));
    }
}
