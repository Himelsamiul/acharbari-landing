<?php

namespace App\Http\Controllers;

use App\Models\CustomerNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderNotification;
use App\Models\Product;
use App\Services\Payment\BkashGateway;
use App\Services\Payment\NagadGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // online methods follow the admin gateways — COD is always allowed (universal)
        $payMethods = ['cod'];
        if (BkashGateway::enabled()) {
            $payMethods[] = 'bkash';
        }
        if (NagadGateway::enabled()) {
            $payMethods[] = 'nagad';
        }
        // manual (bkash/nagad number e send money) — gateway theke alada
        if (ab_manual_payment()) {
            $payMethods[] = 'manual';
        }

        $data = $request->validate([
            'customer_name' => 'required|string|max:120',
            'phone' => 'required|string|max:20',
            'address' => "required|string|max:500",
            'area' => 'required|in:inside,outside',
            'district' => 'nullable|string|max:100',
            'payment_method' => 'required|in:' . implode(',', $payMethods),
            'coupon_code' => 'nullable|string|max:30',
            // manual payment hole TrxID abashyok — baki method e lagbe na
            'payment_ref' => $request->input('payment_method') === 'manual'
                ? 'required|string|max:60'
                : 'nullable|string|max:60',
            'items' => 'required|json',
        ]);

        $items = json_decode($data['items'], true);
        if (!is_array($items) || count($items) === 0) {
            return back()->withErrors(['items' => 'কার্ট খালি — অন্তত একটি প্রোডাক্ট যোগ করুন।']);
        }

        // phone: shudhu valid BD mobile (11 digit, 01[3-9]...) — 10 digit/bhul format reject
        $phone = ab_normalize_phone((string) $data['phone']);
        if ($phone === null) {
            return back()
                ->withErrors(['phone' => 'সঠিক মোবাইল নম্বর দিন — ১১ ডিজিটের নম্বর 01 দিয়ে শুরু (যেমন: 01712345678)।'])
                ->withInput();
        }
        $data['phone'] = $phone;

        $productIds = array_map(fn ($i) => (int) $i['id'], $items);
        // industry scoping: landing only sells the active industry's products —
        // hidden (other-industry) ids must not be orderable either
        $products = Product::whereIn('id', $productIds)->where('is_active', true)->forIndustry()->get()->keyBy('id');

        // variant map: valid, ACTIVE variants of the ordered products only
        $variantIds = array_values(array_filter(array_map(
            fn ($i) => (int) ($i['variant_id'] ?? 0),
            $items
        )));
        $variants = $variantIds
            ? \App\Models\ProductVariant::whereIn('id', $variantIds)
                ->whereIn('product_id', $products->keys())->where('is_active', true)
                ->get()->keyBy('id')
            : collect();

        $subtotal = 0;
        $vatTotal = 0;
        $lines = [];
        foreach ($items as $item) {
            $product = $products[(int) $item['id']] ?? null;
            if (! $product) continue;
            $qty = max(1, min(20, (int) ($item['qty'] ?? 1)));

            // variant line: price/stock variant er ta — na thakle default variant,
            // seta-o na thakle product er nijer price (variant-chara product)
            $variant = $variants[(int) ($item['variant_id'] ?? 0)] ?? null;
            if ($variant && (int) $variant->product_id !== (int) $product->id) {
                $variant = null;
            }
            if (! $variant) {
                $variant = $product->defaultVariant();
            }

            if ($variant) {
                $unitPrice = (float) $variant->price;
                $stock = $variant->stock;
                $name = $product->name . ' (' . $variant->size . ')';
            } else {
                $unitPrice = (float) $product->price;
                $stock = $product->stock;
                $name = $product->name;
            }

            // VAT: variant er nijer VAT thakle seta, nahole product er ta
            $vatPercent = $variant && $variant->vat_percent !== null
                ? (float) $variant->vat_percent
                : (float) $product->vat_percent;

            if ($stock > 0 && $qty > $stock) {
                $qty = (int) $stock;
            }
            $line = $unitPrice * $qty;
            $vat = round($line * $vatPercent / 100, 2);
            $subtotal += $line;
            $vatTotal += $vat;
            $lines[] = [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'product_name' => $name,
                'variant_size' => $variant?->size,
                'price' => $unitPrice,
                'quantity' => $qty,
                'line_total' => $line,
                'vat_percent' => $vatPercent,
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

        // Delivery: admin-configured district-wise charges, legacy inside/outside fallback
        $districts = ab_districts();
        $districtName = trim((string) ($data['district'] ?? ''));
        $area = $data['area'];

        if ($districtName !== '') {
            $match = null;
            foreach ($districts as $d) {
                if (strcasecmp((string) $d['en'], $districtName) === 0) {
                    $match = $d;
                    break;
                }
            }

            if (! $match) {
                return back()->withErrors(['district' => 'দুঃখিত — এই এলাকায় আমরা এখন ডেলিভারি করি না।']);
            }

            $shipping = (int) $match['charge'];
            $area = strcasecmp($districtName, 'Dhaka') === 0 ? 'inside' : 'outside';
            $districtName = $match['en'];
        } else {
            $shipping = $area === 'inside'
                ? ab_charge('delivery_charge_inside', 80)
                : ab_charge('delivery_charge_outside', 150);
        }

        $total = max(0, $subtotal - $discount) + $vatTotal + $shipping;

        $order = DB::transaction(function () use ($data, $lines, $subtotal, $discount, $couponCode, $vatTotal, $shipping, $total, $area, $districtName) {
            $order = Order::create([
                'order_code' => 'AB-' . strtoupper(uniqid()),
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'area' => $area,
                'district' => $districtName !== '' ? $districtName : null,
                'payment_method' => $data['payment_method'],
                // manual = pending theke shuru — admin TrxID verify kore show page theke paid kore
                'payment_status' => in_array($data['payment_method'], ['bkash', 'nagad', 'manual']) ? 'pending' : null,
                // manual payment e customer-er deya TrxID/number — admin hisheber jonno
                'payment_txn_id' => $data['payment_method'] === 'manual'
                    ? (trim((string) ($data['payment_ref'] ?? '')) ?: null)
                    : null,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'coupon_code' => $couponCode,
                'vat_total' => $vatTotal,
                'shipping_cost' => $shipping,
                'total' => $total,
                'status' => 'pending',
            ]);

            // tracking timeline er prothom dhap — pending @ order time
            \App\Models\OrderStatusHistory::create(['order_id' => $order->id, 'status' => 'pending']);

            foreach ($lines as $line) {
                $order->items()->create($line);

                // stock management: variant thakle variant er stock, nahole product er
                if (!empty($line['variant_id'])) {
                    \App\Models\ProductVariant::where('id', $line['variant_id'])->decrement('stock', $line['quantity']);
                } else {
                    Product::where('id', $line['product_id'])->decrement('stock', $line['quantity']);
                }
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
                    $message->to('admin@khorak.shop')->subject('নতুন অর্ডার — ' . ab_brand('bn'));
                }
            );
        } catch (\Throwable $e) {
            report($e); // SMTP configured না থাকলেও order flow থামবে না
        }

        // API payment: hand the customer to the bKash / Nagad checkout page.
        // The gateway redirects back to PaymentController, which verifies and flags paid/failed.
        if (in_array($order->payment_method, ['bkash', 'nagad'])) {
            $payUrl = $this->initiateGatewayPayment($order);

            if ($payUrl) {
                return redirect()->away($payUrl);
            }

            // gateway not ready / call failed — order stays, agent follows up on the call
            $order->update(['payment_status' => 'failed']);
        }

        return redirect()->route('order.success', $order->order_code);
    }

    /** Ask the chosen gateway for a checkout URL. */
    private function initiateGatewayPayment(Order $order): ?string
    {
        try {
            if ($order->payment_method === 'bkash' && BkashGateway::ready()) {
                return BkashGateway::createPayment($order, route('payment.callback.bkash', $order->order_code))['bkashURL'] ?? null;
            }

            if ($order->payment_method === 'nagad' && NagadGateway::ready()) {
                return NagadGateway::initialize($order, route('payment.callback.nagad', $order->order_code));
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return null;
    }

    public function success($code)
    {
        $order = Order::where('order_code', $code)->with('items')->firstOrFail();
        return view('order-success', compact('order'));
    }

    /** Printable PDF invoice — all order details + tracking code (English). */
    public function invoice($code)
    {
        $order = Order::where('order_code', $code)->with('items')->firstOrFail();

        // English brand name + optional logo, both configurable from admin settings
        $brandName = trim(\App\Models\Setting::get('brand_en1', 'Achar') . ' ' . \App\Models\Setting::get('brand_en2', 'Bari'));
        $logo = (string) \App\Models\Setting::get('logo_path', '');
        $contactPhone = ab_contact('phone');

        // prefer the English product name when the product still exists
        $productNames = Product::whereIn('id', $order->items->pluck('product_id'))
            ->get()
            ->mapWithKeys(fn ($p) => [$p->id => $p->name_en ?: $p->name])
            ->all();

        // product barcodes (scanable on the printed invoice)
        $productBarcodes = Product::whereIn('id', $order->items->pluck('product_id'))
            ->pluck('barcode', 'id')
            ->all();

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('invoice', [
            'order' => $order,
            'brandName' => $brandName !== '' ? $brandName : ab_brand('en'),
            'logo' => $logo,
            'contactPhone' => $contactPhone,
            'productNames' => $productNames,
            'productBarcodes' => $productBarcodes,
        ])
            ->setPaper('a4')
            ->download('invoice-' . $order->order_code . '.pdf');
    }

    /** Public order tracking: requires BOTH tracking code and phone (privacy) */
    public function track(Request $request)
    {
        $code = strtoupper(trim((string) $request->query('code', '')));
        $phone = trim((string) $request->query('phone', ''));

        $order = null;
        if ($code !== '' && $phone !== '') {
            // invoice prefix (AB-) chara shudhu tail dileo match korbe
            $order = Order::with('items')
                ->where(function ($q) use ($phone) {
                    $norm = ab_normalize_phone($phone);
                    $q->where('phone', $phone);
                    if ($norm !== null && $norm !== $phone) {
                        $q->orWhere('phone', $norm);
                    }
                })
                ->where(function ($q) use ($code) {
                    $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $code);
                    $q->where('order_code', $code)
                        ->orWhere('order_code', 'like', '%' . $escaped);
                })
                ->first();
        }

        return view('track', compact('order', 'code', 'phone'));
    }

    /** JSON lookup for the landing-page tracking modal (phone and/or tracking code). */
    public function trackJson(Request $request)
    {
        $phone = trim((string) $request->query('phone', ''));
        $code = strtoupper(trim((string) $request->query('invoice_id', '')));

        if ($phone === '' && $code === '') {
            return response()->json(['success' => false, 'message' => 'মোবাইল নম্বর অথবা ট্র্যাকিং কোড দিন।']);
        }

        $query = Order::with('items')->latest('id');
        if ($code !== '') {
            // puro code (AB-XXXX) o chole, prefix chara shudhu tail-o chole —
            // customer onek somoy "AB-" na likhe shudhu number ta dey
            $query->where(function ($q) use ($code) {
                $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $code);
                $q->where('order_code', $code)
                    ->orWhere('order_code', 'like', '%' . $escaped);
            });
            if ($phone !== '') {
                $query->where(function ($q) use ($phone) {
                    $norm = ab_normalize_phone($phone);
                    $q->where('phone', $phone);
                    if ($norm !== null && $norm !== $phone) {
                        $q->orWhere('phone', $norm);
                    }
                });
            }
        } else {
            $query->where(function ($q) use ($phone) {
                $norm = ab_normalize_phone($phone);
                $q->where('phone', $phone);
                if ($norm !== null && $norm !== $phone) {
                    $q->orWhere('phone', $norm);
                }
            });
        }
        $orders = $query->limit(5)->get();

        if ($orders->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'কোনো অর্ডার পাওয়া যায়নি — তথ্য মিলিয়ে আবার চেষ্টা করুন।']);
        }

        $labels = Order::statusLabels();
        $images = Product::whereIn('id', $orders->flatMap->items->pluck('product_id'))
            ->pluck('image', 'id');

        return response()->json([
            'success' => true,
            'orders' => $orders->map(function ($o) use ($labels, $images) {
                return [
                    'invoice_id' => $o->order_code,
                    'date' => $o->created_at->format('d M Y, h:i A'),
                    'status' => $labels[$o->status] ?? $o->status,
                    'timeline' => collect($o->statusTimeline())->map(fn ($t) => [
                        'status' => $t['status'],
                        'label' => $t['label'],
                        'time' => $t['time'],
                    ])->values()->all(),
                    'customer_name' => $o->customer_name,
                    'customer_phone' => $o->phone,
                    'area' => $o->district ?: ($o->area === 'inside' ? 'ঢাকার ভিতরে' : 'ঢাকার বাহিরে'),
                    'address' => $o->address,
                    'subtotal' => (float) $o->subtotal,
                    'shipping_charge' => (float) $o->shipping_cost,
                    'discount' => (float) $o->discount,
                    'grand_total' => (float) $o->total,
                    'items' => $o->items->map(function ($i) use ($images) {
                        return [
                            'image' => asset($images[$i->product_id] ?? 'assets/img/prod_mix.webp'),
                            'name' => $i->product_name,
                            'price' => (float) $i->price,
                            'qty' => (int) $i->quantity,
                        ];
                    })->all(),
                ];
            })->all(),
        ]);
    }
}
