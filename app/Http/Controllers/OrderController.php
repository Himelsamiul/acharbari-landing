<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:120',
            'phone' => 'required|string|min:10|max:15',
            'address' => 'required|string|max:500',
            'area' => 'required|in:inside,outside',
            'payment_method' => 'required|in:cod,bkash,nagad,rocket,upay',
            'coupon_code' => 'nullable|string|max:30',
            'items' => 'required|json',
        ]);

        $items = json_decode($data['items'], true);
        if (!is_array($items) || count($items) === 0) {
            return back()->withErrors(['items' => 'কার্ট খালি — অন্তত একটি প্রোডাক্ট যোগ করুন।']);
        }

        $productIds = array_map(fn ($i) => (int) $i['id'], $items);
        $products = Product::whereIn('id', $productIds)->where('is_active', true)->get()->keyBy('id');

        $subtotal = 0;
        $lines = [];
        foreach ($items as $item) {
            $product = $products[(int) $item['id']] ?? null;
            if (! $product) continue;
            $qty = max(1, min(20, (int) ($item['qty'] ?? 1)));
            $line = $product->price * $qty;
            $subtotal += $line;
            $lines[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty,
                'line_total' => $line,
            ];
        }

        if (empty($lines)) {
            return back()->withErrors(['items' => 'প্রোডাক্ট পাওয়া যায়নি — আবার চেষ্টা করুন।']);
        }

        // Coupon (demo): ACHAR10 = 10% off
        $discount = 0;
        $couponCode = null;
        $code = strtoupper(trim($data['coupon_code'] ?? ''));
        if ($code === 'ACHAR10') {
            $discount = round($subtotal * 0.10);
            $couponCode = 'ACHAR10';
        }

        $shipping = $data['area'] === 'inside' ? 80 : 150;
        $total = max(0, $subtotal - $discount) + $shipping;

        $order = DB::transaction(function () use ($data, $lines, $subtotal, $discount, $couponCode, $shipping, $total) {
            $order = Order::create([
                'order_code' => 'AB-' . strtoupper(uniqid()),
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'area' => $data['area'],
                'payment_method' => $data['payment_method'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'coupon_code' => $couponCode,
                'shipping_cost' => $shipping,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($lines as $line) {
                $order->items()->create($line);
            }

            return $order;
        });

        return redirect()->route('order.success', $order->order_code);
    }

    public function success($code)
    {
        $order = Order::where('order_code', $code)->with('items')->firstOrFail();
        return view('order-success', compact('order'));
    }
}
