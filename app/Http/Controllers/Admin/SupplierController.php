<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount(['purchases', 'products'])
            ->withSum('purchases as purchased_qty', 'quantity')
            ->withSum('purchases as purchased_total', 'total')
            ->latest()
            ->get();

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', ['supplier' => $supplier]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Supplier::create($data);

        return back()->with('success', 'সাপ্লায়ার "' . $data['name'] . '" যোগ হয়েছে।');
    }

    public function show(Supplier $supplier)
    {
        // purchase history: what we bought from this supplier and at what cost
        $purchases = $supplier->purchases()->with('product')->latest('purchased_at')->get();

        // per-product rollup: how many units of each item we took from this supplier
        $purchasedProducts = $supplier->purchases()
            ->selectRaw('product_id, SUM(quantity) as total_qty, SUM(total) as total_money')
            ->groupBy('product_id')
            ->orderByDesc('total_money')
            ->with('product')
            ->get();

        return view('admin.suppliers.show', [
            'supplier' => $supplier,
            'purchases' => $purchases,
            'purchasedProducts' => $purchasedProducts,
            'totalSpent' => (float) $purchases->sum('total'),
            'allProducts' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($this->validated($request));

        return back()->with('success', 'সাপ্লায়ার আপডেট হয়েছে।');
    }

    public function toggle(Supplier $supplier)
    {
        $supplier->update(['is_active' => ! $supplier->is_active]);

        return back()->with('success', $supplier->is_active ? 'সাপ্লায়ার চালু হয়েছে।' : 'সাপ্লায়ার বন্ধ করা হয়েছে।');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete(); // purchases cascade; products keep existing with supplier_id null

        return redirect()->route('admin.suppliers')->with('success', 'সাপ্লায়ার ও তার পারচেজ হিস্ট্রি মুছে ফেলা হয়েছে।');
    }

    /** Record a new purchase and increment the product stock. */
    public function storePurchase(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100000',
            'unit_cost' => 'required|numeric|min:0|max:10000000',
            'purchased_at' => 'nullable|date|before_or_equal:today',
            'note' => 'nullable|string|max:300',
        ]);

        Purchase::create([
            'supplier_id' => $supplier->id,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'unit_cost' => $data['unit_cost'],
            'purchased_at' => $data['purchased_at'] ?? now()->toDateString(),
            'note' => $data['note'] ?? null,
        ]);

        Product::where('id', $data['product_id'])->increment('stock', $data['quantity']);

        return back()->with('success', 'পারচেজ যোগ হয়েছে এবং স্টক বাড়ানো হয়েছে।');
    }

    /** Remove a purchase record and take the stock back out. */
    public function destroyPurchase(Purchase $purchase)
    {
        Product::where('id', $purchase->product_id)->decrement('stock', $purchase->quantity);
        $purchase->delete();

        return back()->with('success', 'পারচেজ রেকর্ড মুছে ফেলা হয়েছে (স্টক কমানো হয়েছে)।');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:120',
            'company' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:400',
            'note' => 'nullable|string|max:500',
        ]);
    }
}
