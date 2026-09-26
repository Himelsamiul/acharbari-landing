<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Customers derived from orders (grouped by phone) with search.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $customers = Order::selectRaw('phone, MAX(customer_name) as name, COUNT(*) as orders_count,
                SUM(total) as total_spent, MAX(created_at) as last_order_at')
            ->groupBy('phone')
            ->when($q !== '', function ($query) use ($q) {
                $query->having('phone', 'like', "%{$q}%")
                    ->orHaving('name', 'like', "%{$q}%");
            })
            ->orderByDesc('last_order_at')
            ->get();

        return view('admin.customers.index', [
            'customers' => $customers,
            'q' => $q,
            'uniqueCount' => Order::distinct('phone')->count('phone'),
        ]);
    }

    /** Rename a customer across all of their orders. */
    public function rename(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|string|max:20',
            'name' => 'required|string|max:120',
        ]);

        $updated = Order::where('phone', $data['phone'])->update(['customer_name' => $data['name']]);

        return back()->with('success', "{$updated} টি অর্ডারে নাম আপডেট হয়েছে ({$data['name']})।");
    }

    /** Delete a customer: removes every order placed with this phone number. */
    public function destroy(string $phone)
    {
        $deleted = Order::where('phone', $phone)->delete();

        return redirect()->route('admin.customers')
            ->with('success', "গ্রাহক ({$phone}) এবং তার {$deleted} টি অর্ডার মুছে ফেলা হয়েছে।");
    }
}
