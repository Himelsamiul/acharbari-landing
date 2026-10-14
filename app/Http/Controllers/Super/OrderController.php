<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * Super admin's landing-design orders (/super/orders) — the showcase cart's
 * sales only (source='landing'). Store orders stay in the client admin
 * panel; the two listings never overlap.
 */
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $q = trim((string) $request->query('q', ''));

        $orders = Order::where('source', Order::SOURCE_LANDING)
            ->when($status && in_array($status, Order::statuses()),
                fn ($query) => $query->where('status', $status))
            ->when($q !== '', fn ($query) => $query->where(function ($sub) use ($q) {
                $sub->where('phone', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%")
                    ->orWhere('order_code', 'like', "%{$q}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $countsBase = Order::where('source', Order::SOURCE_LANDING);
        $counts = [];
        foreach (Order::statuses() as $s) {
            $counts[$s] = (clone $countsBase)->where('status', $s)->count();
        }

        return view('super.orders.index', compact('orders', 'status', 'q', 'counts'));
    }

    public function show(Order $order)
    {
        // super admin manages ONLY landing orders here — store orders 404
        abort_unless($order->source === Order::SOURCE_LANDING, 404);

        $order->load('items');

        return view('super.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        abort_unless($order->source === Order::SOURCE_LANDING, 404);

        $data = $request->validate([
            'status' => 'required|in:' . implode(',', Order::statuses()),
        ]);

        $order->update(['status' => $data['status']]);
        $order->statusHistories()->create(['status' => $data['status']]);

        return back()->with('success', 'অর্ডার #' . $order->order_code . ' স্ট্যাটাস আপডেট হয়েছে।');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        abort_unless($order->source === Order::SOURCE_LANDING, 404);

        $data = $request->validate([
            'status' => 'required|in:paid,pending,failed,clear',
        ]);

        if ($data['status'] === 'clear') {
            $order->update(['payment_status' => null]);

            return back()->with('success', 'পেমেন্ট স্ট্যাটাস মুছে ফেলা হয়েছে।');
        }

        $order->update(['payment_status' => $data['status']]);

        return back()->with('success', 'পেমেন্ট স্ট্যাটাস আপডেট হয়েছে — ' . strtoupper($data['status']));
    }
}
