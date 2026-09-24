<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::active()->orderByDesc('is_featured')->get();

        return view('home', ['products' => $products, 'qv' => buildQuickView($products)]);
    }
}
