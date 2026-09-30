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

        // month filter: YYYY-MM — khali hole SOB somoy
        $month = (string) $request->query('month', '');
        if (! preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = '';
        }

        $applyMonth = fn ($query) => $month !== ''
            ? $query->whereBetween('created_at', [$month . '-01 00:00:00', \Illuminate\Support\Carbon::parse($month . '-01')->endOfMonth()->endOfDay()])
            : $query;

        $orders = Order::when($status && in_array($status, Order::statuses()),
                fn ($query) => $query->where('status', $status))
            ->when($q !== '', fn ($query) => $query->where(function ($sub) use ($q) {
                $sub->where('phone', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%")
                    ->orWhere('order_code', 'like', "%{$q}%");
            }))
            ->when($month !== '', $applyMonth)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // monthly summary: ei month e koto sell + koyta order
        $summaryQuery = Order::when($month !== '', $applyMonth);
        $summary = [
            'total' => (clone $summaryQuery)->where('status', '!=', 'cancelled')->sum('total'),
            'count' => (clone $summaryQuery)->count(),
            'delivered' => (clone $summaryQuery)->where('status', 'delivered')->count(),
            'cancelled' => (clone $summaryQuery)->where('status', 'cancelled')->count(),
        ];

        $counts = [];
        foreach (Order::statuses() as $s) {
            $counts[$s] = Order::where('status', $s)->count();
        }

        return view('admin.orders.index', compact('orders', 'status', 'counts', 'month', 'summary', 'q'));
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

        return back()->with('success', 'অর্ডার #' . $order->order_code . ' স্ট্যাটাস আপডেট হয়েছে।');
    }

    /**
     * Manual payment verification — admin TrxID চেক করে paid করে দেয়
     * (gateway order-এর ক্ষেত্রেও ভুল থাকলে হাতে ঠিক করা যায়)।
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:paid,pending,failed',
        ]);

        // COD order-এ পেমেন্ট স্ট্যাটাস নেই — ফাঁকা-ই থাকে
        if ($order->payment_method === 'cod') {
            return back()->withErrors(['payment' => 'COD অর্ডারে পেমেন্ট স্ট্যাটাস নেই।']);
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
