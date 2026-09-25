<?php

namespace App\Http\Controllers;

use App\Models\CustomerNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderNotification;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        $vatTotal = 0;
        $lines = [];
        foreach ($items as $item) {
            $product = $products[(int) $item['id']] ?? null;
            if (! $product) continue;
            $qty = max(1, min(20, (int) ($item['qty'] ?? 1)));
            if ($product->stock > 0 && $qty > $product->stock) {
                $qty = (int) $product->stock;
            }
            $line = $product->price * $qty;
            $vat = round($line * (float) $product->vat_percent / 100, 2);
            $subtotal += $line;
            $vatTotal += $vat;
            $lines[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty,
                'line_total' => $line,
                'vat_percent' => (float) $product->vat_percent,
            ];
        }

        if (empty($lines)) {
            return back()->withErrors(['items' => 'প্রোডাক্ট পাওয়া যায়নি — আবার চেষ্টা করুন।']);
        }

        // Coupon: percent off subtotal, validated against the active coupons table
        $discount = 0;
        $couponCode = null;
        $code = strtoupper(trim($data['coupon_code'] ?? ''));
        if ($code !== '') {
            $coupon = \App\Models\Coupon::valid($code);
            if ($coupon) {
                $discount = round($subtotal * $coupon->percent / 100);
                $couponCode = $coupon->code;
            }
        }

        $shipping = $data['area'] === 'inside' ? 80 : 150;
        $total = max(0, $subtotal - $discount) + $vatTotal + $shipping;

        $order = DB::transaction(function () use ($data, $lines, $subtotal, $discount, $couponCode, $vatTotal, $shipping, $total) {
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
                'vat_total' => $vatTotal,
                'shipping_cost' => $shipping,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($lines as $line) {
                $order->items()->create($line);

                // stock management: decrement sold quantity
                Product::where('id', $line['product_id'])->decrement('stock', $line['quantity']);
            }

            // admin notification (bell in admin panel)
            OrderNotification::create(['order_id' => $order->id]);

            // customer notification (visible on tracking page)
            CustomerNotification::create([
                'order_id' => $order->id,
                'title' => 'অর্ডার গৃহীত হয়েছে',
                'message' => 'আপনার অর্ডার #' . $order->order_code . ' সফলভাবে গৃহীত হয়েছে — আমাদের প্রতিনিধি শীঘ্রই কল করবেন।',
            ]);

            return $order;
        });

        // order confirmation mail (uses log driver until SMTP is configured)
        try {
            Mail::raw(
                "নতুন অর্ডার #{$order->order_code}\n"
                . "কাস্টমার: {$order->customer_name} ({$order->phone})\n"
                . "মোট: ৳" . number_format($order->total) . "\n"
                . "ট্র্যাকিং কোড: {$order->order_code}",
                function ($message) {
                    $message->to('admin@khorak.shop')->subject('নতুন অর্ডার — আচারবাড়ি');
                }
            );
        } catch (\Throwable $e) {
            report($e); // SMTP configured না থাকলেও order flow থামবে না
        }

        return redirect()->route('order.success', $order->order_code);
    }

    public function success($code)
    {
        $order = Order::where('order_code', $code)->with('items')->firstOrFail();
        return view('order-success', compact('order'));
    }

    /** Public order tracking: requires BOTH tracking code and phone (privacy) */
    public function track(Request $request)
    {
        $code = strtoupper(trim((string) $request->query('code', '')));
        $phone = trim((string) $request->query('phone', ''));

        $order = null;
        if ($code !== '' && $phone !== '') {
            $order = Order::with('items')
                ->where('order_code', $code)
                ->where('phone', $phone)
                ->first();
        }

        return view('track', compact('order', 'code', 'phone'));
    }
}
