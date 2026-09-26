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

        $orders = Order::when($status && in_array($status, Order::statuses()),
                fn ($query) => $query->where('status', $status))
            ->when($q !== '', fn ($query) => $query->where(function ($sub) use ($q) {
                $sub->where('phone', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%")
                    ->orWhere('order_code', 'like', "%{$q}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [];
        foreach (Order::statuses() as $s) {
            $counts[$s] = Order::where('status', $s)->count();
        }

        return view('admin.orders.index', compact('orders', 'status', 'counts'));
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

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'অর্ডারটি মুছে ফেলা হয়েছে।');
    }
}
