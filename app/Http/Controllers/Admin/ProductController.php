<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('sort_order')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        $data = $this->handleUpload($request, $data);
        $data['barcode'] = $this->nextBarcode();

        $product = Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'প্রোডাক্ট "' . $product->name . '" তৈরি হয়েছে (বারকোড: ' . $product->barcode . ')।');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request, $product);
        $data = $this->handleUpload($request, $data);

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'প্রোডাক্ট আপডেট হয়েছে।');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'প্রোডাক্ট মুছে ফেলা হয়েছে।');
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'name_en' => 'required|string|max:200',
            'slug' => 'nullable|string|max:220',
            'category_key' => 'required|string|exists:categories,key',
            'brand' => 'nullable|string|max:80',
            'unit' => 'required|in:pcs,gm,kg,ml,liter',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'vat_percent' => 'nullable|numeric|min:0|max:100',
            'old_price' => 'nullable|numeric|min:0',
            'discount_bn' => 'nullable|string|max:30',
            'discount_en' => 'nullable|string|max:30',
            'stock_badge' => 'nullable|string|max:40',
            'stock_badge_en' => 'nullable|string|max:40',
            'description' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews_count' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en']) ?: Str::random(8);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // unique slug (append number if taken by another product)
        $base = $data['slug'];
        $i = 1;
        while (Product::where('slug', $data['slug'])->when($product, fn ($q) => $q->where('id', '!=', $product->id))->exists()) {
            $data['slug'] = $base . '-' . ++$i;
        }

        $data['category'] = optional(Category::where('key', $data['category_key'])->first())->name ?? 'আচার';
        $data['category_en'] = optional(Category::where('key', $data['category_key'])->first())->category_en ?? 'Pickles';

        foreach (['vat_percent', 'old_price', 'rating', 'reviews_count', 'sort_order'] as $num) {
            $data[$num] = $data[$num] ?? 0;
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['brand'] = $data['brand'] ?? 'আচারবাড়ি';

        return $data;
    }

    private function handleUpload(Request $request, array $data): array
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = 'storage/' . $path;
        }
        return $data;
    }

    private function nextBarcode(): string
    {
        $last = Product::max('id');
        return 'ABP-' . str_pad((string) ($last + 1), 4, '0', STR_PAD_LEFT);
    }
}
