<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    public function index()
    {
        return view('admin.taxonomy', [
            'categories' => Category::withCount('products')->get(),
            'brands' => Brand::withCount('products')->get(),
        ]);
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60',
            'name_en' => 'required|string|max:60',
            'key' => 'required|string|max:30|unique:categories,key',
        ]);

        Category::create($data);

        return back()->with('success', 'ক্যাটাগরি "' . $data['name'] . '" যোগ হয়েছে।');
    }

    public function storeBrand(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60|unique:brands,name',
        ]);

        Brand::create($data);

        return back()->with('success', 'ব্র্যান্ড "' . $data['name'] . '" যোগ হয়েছে।');
    }

    public function destroyCategory(Category $category)
    {
        $inUse = \App\Models\Product::where('category_key', $category->key)->count();
        if ($inUse > 0) {
            return back()->withErrors(['taxonomy' => $inUse . 'টি প্রোডাক্ট এই ক্যাটাগরিতে আছে — আগে ওগুলো সরান।']);
        }

        $category->delete();

        return back()->with('success', 'ক্যাটাগরি মুছে ফেলা হয়েছে।');
    }

    public function destroyBrand(Brand $brand)
    {
        $inUse = \App\Models\Product::where('brand', $brand->name)->count();
        if ($inUse > 0) {
            return back()->withErrors(['taxonomy' => $inUse . 'টি প্রোডাক্ট এই ব্র্যান্ডে আছে — আগে ওগুলো সরান।']);
        }

        $brand->delete();

        return back()->with('success', 'ব্র্যান্ড মুছে ফেলা হয়েছে।');
    }
}
