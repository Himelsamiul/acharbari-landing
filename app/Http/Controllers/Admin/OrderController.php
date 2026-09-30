<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $q = trim((string) $request->query('q', ''));

        // date range filter: from/to (YYYY-MM-DD) — khali hole soB somoy
        $from = (string) $request->query('from', '');
        $to = (string) $request->query('to', '');
        $from = preg_match('/^\d{4}-\d{2}-\d{2}$/', $from) ? $from : '';
        $to = preg_match('/^\d{4}-\d{2}-\d{2}$/', $to) ? $to : '';

        $applyRange = function ($query) use ($from, $to) {
            if ($from !== '') {
                $query->where('created_at', '>=', $from . ' 00:00:00');
            }
            if ($to !== '') {
                $query->where('created_at', '<=', $to . ' 23:59:59');
            }

            return $query;
        };

        $searchFilter = fn ($query) => $q === '' ? $query : $query->where(function ($sub) use ($q) {
            $sub->where('phone', 'like', "%{$q}%")
                ->orWhere('customer_name', 'like', "%{$q}%")
                ->orWhere('order_code', 'like', "%{$q}%");
        });

        $orders = Order::when($status && in_array($status, Order::statuses()),
                fn ($query) => $query->where('status', $status))
            ->when($q !== '', $searchFilter)
            ->when($from !== '' || $to !== '', $applyRange)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // summary: ei range er biki + order songkha
        $summaryQuery = Order::when($from !== '' || $to !== '', $applyRange);
        $summary = [
            'total' => (clone $summaryQuery)->where('status', '!=', 'cancelled')->sum('total'),
            'count' => (clone $summaryQuery)->count(),
            'delivered' => (clone $summaryQuery)->where('status', 'delivered')->count(),
            'cancelled' => (clone $summaryQuery)->where('status', 'cancelled')->count(),
        ];

        // status tab er count gulo o range+search er moddhei gonona hoy
        $countsBase = Order::when($q !== '', $searchFilter)->when($from !== '' || $to !== '', $applyRange);
        $counts = [];
        foreach (Order::statuses() as $s) {
            $counts[$s] = (clone $countsBase)->where('status', $s)->count();
        }

        return view('admin.orders.index', compact('orders', 'status', 'counts', 'summary', 'q', 'from', 'to'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', Order::statuses()),
        ]);

        $order->update(['status' => $data['status']]);

        // timeline history — customer tracking e kokhon kon status holo dekhay
        $order->statusHistories()->create(['status' => $data['status']]);

        return back()->with('success', 'অর্ডার #' . $order->order_code . ' স্ট্যাটাস আপডেট হয়েছে।');
    }

    /**
     * Payment verification — manual order-এ admin TrxID দেখে paid করে,
     * COD order-এ টাকা হাতে পেলে paid করে ('clear' দিলে আবার ফাঁকা),
     * gateway order অটো paid হয় (ভুল হলে হাতে ঠিক করা যায়)।
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
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

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'অর্ডারটি মুছে ফেলা হয়েছে।');
    }
}
