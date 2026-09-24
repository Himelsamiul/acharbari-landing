<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'orders_total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'revenue' => Order::whereIn('status', ['processing', 'shipped', 'delivered'])->sum('total'),
            'products' => Product::where('is_active', true)->count(),
            'customers' => Order::distinct('phone')->count('phone'),
        ];

        $recent = Order::latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }
}
