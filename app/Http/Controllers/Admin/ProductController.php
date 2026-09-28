<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // ডিফল্টে চালু ইন্ডাস্ট্রির প্রোডাক্ট — ফিল্টার দিয়ে অন্য ইন্ডাস্ট্রিও দেখা যায়
        $currentIndustry = ab_industry_active();
        $filter = IndustryPack::valid((string) $request->query('industry'))
            ? $request->query('industry')
            : null;
        $viewIndustry = $filter ?? $currentIndustry;

        $products = Product::forIndustry($viewIndustry)->with('variants')->orderBy('sort_order')->get();
        $ids = $products->pluck('id');

        // dependency tracking: kon product e order/purchase ase — delete er age dekhano lage
        $orderCounts = \App\Models\OrderItem::whereIn('product_id', $ids)
            ->selectRaw('product_id, COUNT(DISTINCT order_id) as c')
            ->groupBy('product_id')
            ->pluck('c', 'product_id');
        $purchaseCounts = \App\Models\Purchase::whereIn('product_id', $ids)
            ->selectRaw('product_id, COUNT(*) as c')
            ->groupBy('product_id')
            ->pluck('c', 'product_id');

        return view('admin.products.index', compact(
            'products', 'orderCounts', 'purchaseCounts', 'currentIndustry', 'viewIndustry'
        ) + ['industries' => IndustryPack::all()]);
    }

    public function create()
    {
        $categories = Category::forIndustry(ab_industry_active())->orderBy('id')->get();
        $brands = Brand::all();

        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => $categories,
            'brands' => $brands,
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        // নতুন প্রোডাক্ট অটো চালু ইন্ডাস্ট্রিতে ট্যাগ হয়
        $data['industry'] = ab_industry_active();
        $data = $this->handleUpload($request, $data, $data['industry']);
        // barcode: admin typed nijer moto — khali rakhle auto-generate hobe
        $data['barcode'] = trim((string) ($data['barcode'] ?? '')) !== '' ? $data['barcode'] : $this->nextBarcode();
        $data['supplier_id'] = $request->filled('supplier_id') ? (int) $request->input('supplier_id') : null;

        $product = Product::create($data);
        $this->syncVariants($request, $product);

        // initial stock bought from a supplier -> remember it as a purchase
        $cost = (float) $request->input('purchase_cost', 0);
        if ($data['supplier_id'] && $cost > 0 && (int) $data['stock'] > 0) {
            Purchase::create([
                'supplier_id' => $data['supplier_id'],
                'product_id' => $product->id,
                'quantity' => (int) $data['stock'],
                'unit_cost' => $cost,
                'purchased_at' => now()->toDateString(),
                'note' => 'প্রোডাক্ট তৈরির সময় প্রাথমিক স্টক',
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'প্রোডাক্ট "' . $product->name . '" তৈরি হয়েছে (বারকোড: ' . $product->barcode . ')।');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::forIndustry($product->industry ?: ab_industry_active())->orderBy('id')->get(),
            'brands' => Brand::all(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request, $product);
        // ইন্ডাস্ট্রি এডিটে অপরিবর্তিত থাকে — $data-তে industry নেই তাই update এতে ধরে না
        $data = $this->handleUpload($request, $data, $product->industry ?: ab_industry_active());
        $data['supplier_id'] = $request->filled('supplier_id') ? (int) $request->input('supplier_id') : null;

        $product->update($data);
        $this->syncVariants($request, $product);

        return redirect()->route('admin.products.index')
            ->with('success', 'প্রোডাক্ট আপডেট হয়েছে।');
    }

    public function destroy(Product $product)
    {
        // order/purchase e thakle delete block — 500 na, clear bangla message
        $orderCount = \App\Models\OrderItem::where('product_id', $product->id)->distinct('order_id')->count('order_id');
        $purchaseCount = \App\Models\Purchase::where('product_id', $product->id)->count();

        if ($orderCount > 0 || $purchaseCount > 0) {
            $parts = [];
            if ($orderCount > 0) {
                $parts[] = $orderCount . 'টি অর্ডারে';
            }
            if ($purchaseCount > 0) {
                $parts[] = $purchaseCount . 'টি পারচেজে';
            }

            return back()->withErrors([
                'product' => '"' . $product->name . '" মুছে ফেলা যাবে না — প্রোডাক্টটি ' . implode(' ও ', $parts) . ' ব্যবহৃত হয়েছে। এর বদলে প্রোডাক্টটি বন্ধ করে দিন।',
            ]);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'প্রোডাক্ট মুছে ফেলা হয়েছে।');
    }

    /** Flip live/off on the products list. */
    public function toggle(Product $product)
    {
        $product->update(['is_active' => ! $product->is_active]);

        return back()->with('success', '"' . $product->name . '" এখন ' . ($product->is_active ? 'লাইভ' : 'বন্ধ') . '।');
    }

    /**
     * Variant rows sync: form e ja ase setai DB te — bad deya row delete,
     * notun row create, purano row update. Khali row gulo bad porjay.
     */
    private function syncVariants(Request $request, Product $product): void
    {
        $rows = $request->input('variants', []);
        if (!is_array($rows)) $rows = [];

        $keepIds = [];

        foreach (array_values($rows) as $i => $row) {
            if (!is_array($row)) continue;

            $size = trim((string) ($row['size'] ?? ''));
            $price = (float) ($row['price'] ?? 0);
            if ($size === '' || $price <= 0) continue; // ardhek bhora row — ignore

            $payload = [
                'size' => $size,
                'price' => $price,
                'old_price' => isset($row['old_price']) && $row['old_price'] !== '' ? (float) $row['old_price'] : null,
                'vat_percent' => isset($row['vat_percent']) && $row['vat_percent'] !== '' ? (float) $row['vat_percent'] : null,
                'discount_bn' => trim((string) ($row['discount_bn'] ?? '')) !== '' ? trim((string) $row['discount_bn']) : null,
                'discount_en' => trim((string) ($row['discount_en'] ?? '')) !== '' ? trim((string) $row['discount_en']) : null,
                'stock' => max(0, (int) ($row['stock'] ?? 0)),
                'sku' => trim((string) ($row['sku'] ?? '')) !== '' ? trim((string) $row['sku']) : null,
                'is_active' => !empty($row['is_active']),
                'sort_order' => (int) ($row['sort_order'] ?? $i),
            ];

            // existing row update (shudhu ei product tar tai)
            $existing = null;
            if (!empty($row['id'])) {
                $existing = ProductVariant::where('id', (int) $row['id'])
                    ->where('product_id', $product->id)->first();
            }

            if ($existing) {
                $existing->update($payload);
                $keepIds[] = $existing->id;
            } else {
                $keepIds[] = $product->variants()->create($payload)->id;
            }
        }

        // form e ja ashe niye baki gulo delete (sohoj: submit e jeta nai seta muche jabe)
        $product->variants()->whereNotIn('id', $keepIds)->delete();
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        // variant row thakle price/stock variant theke ase — product level er
        // field gulo optional (form e hide o thake)
        $hasVariantRows = collect($request->input('variants', []))
            ->contains(fn ($r) => is_array($r)
                && trim((string) ($r['size'] ?? '')) !== ''
                && (float) ($r['price'] ?? 0) > 0);

        $data = $request->validate([
            'name' => 'required|string|max:200',
            'name_en' => 'required|string|max:200',
            'slug' => 'nullable|string|max:220',
            'category_key' => 'required|string|exists:categories,key',
            'brand' => 'nullable|string|max:80',
            'unit' => 'required|in:pcs,gm,kg,ml,liter,jar', // form e জার (jar) option-o ase
            'stock' => ($hasVariantRows ? 'nullable' : 'required') . '|integer|min:0',
            'price' => ($hasVariantRows ? 'nullable' : 'required') . '|numeric|min:0',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|integer',
            'variants.*.size' => 'nullable|string|max:50', // khali row sync e ignore hoy
            'variants.*.price' => 'nullable|numeric|min:0|max:9999999',
            'variants.*.old_price' => 'nullable|numeric|min:0|max:9999999',
            'variants.*.vat_percent' => 'nullable|numeric|min:0|max:100',
            'variants.*.discount_bn' => 'nullable|string|max:30',
            'variants.*.discount_en' => 'nullable|string|max:30',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.sku' => 'nullable|string|max:60',
            'variants.*.sort_order' => 'nullable|integer|min:0',
            'variants.*.is_active' => 'nullable|boolean',
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
            'barcode' => 'nullable|string|max:40|unique:products,barcode' . ($product ? ',' . $product->id : ''),
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'meta_title' => 'nullable|string|max:150',
            'meta_description' => 'nullable|string|max:320',
            'image_alt' => 'nullable|string|max:200',
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

        // variant thakle ei duita hidden thake — DB e 0 bosiye dao (variant thekei asbe)
        $data['price'] = (float) ($data['price'] ?? 0);
        $data['stock'] = (int) ($data['stock'] ?? 0);

        return $data;
    }

    private function handleUpload(Request $request, array $data, string $industry): array
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = 'storage/' . $path;
        } elseif (!isset($data['image']) || trim((string) $data['image']) === '') {
            // strict MySQL: products.image has no default — placeholder keeps no-image products savable.
            // ছবি না থাকলে ওই ইন্ডাস্ট্রির genre-pack আর্ট, না পেলে জেনেরিক অর্গানিক প্লেসহোল্ডার
            $placeholder = 'assets/img/genres/' . $industry . '/product-1.jpg';
            $data['image'] = is_file(public_path($placeholder)) ? $placeholder : 'assets/img/prod_mango.jpg';
        }
        return $data;
    }

    private function nextBarcode(): string
    {
        $last = Product::max('id');
        return 'ABP-' . str_pad((string) ($last + 1), 4, '0', STR_PAD_LEFT);
    }
}
