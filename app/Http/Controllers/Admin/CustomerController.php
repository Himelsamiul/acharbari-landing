<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /** Date-range query param parse (from/to, YYYY-MM-DD) — report duitay lage. */
    private function dateRange(Request $request): array
    {
        $from = (string) $request->query('from', '');
        $to = (string) $request->query('to', '');

        $from = preg_match('/^\d{4}-\d{2}-\d{2}$/', $from) ? $from : '';
        $to = preg_match('/^\d{4}-\d{2}-\d{2}$/', $to) ? $to : '';

        return [$from, $to];
    }

    private function rangeQuery(Request $request)
    {
        [$from, $to] = $this->dateRange($request);

        return Order::query()
            ->when($from !== '', fn ($query) => $query->where('created_at', '>=', $from . ' 00:00:00'))
            ->when($to !== '', fn ($query) => $query->where('created_at', '<=', $to . ' 23:59:59'));
    }

    /**
     * Customers derived from orders (grouped by phone) with search + date range.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        [$from, $to] = $this->dateRange($request);

        $customers = $this->rangeQuery($request)
            ->selectRaw('phone, MAX(customer_name) as name, COUNT(*) as orders_count,
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
            'from' => $from,
            'to' => $to,
            'uniqueCount' => Order::distinct('phone')->count('phone'),
        ]);
    }

    /** Report download — PDF (dompdf) ba CSV (Excel e khule). */
    public function export(Request $request, string $type)
    {
        $q = trim((string) $request->query('q', ''));
        [$from, $to] = $this->dateRange($request);

        // date range er VITORE order gulo — prottek customer ki kinsilo
        $orders = $this->rangeQuery($request)
            ->when($q !== '', fn ($query) => $query->where(function ($sub) use ($q) {
                $sub->where('phone', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%");
            }))
            ->with('items')
            ->orderBy('customer_name')
            ->orderBy('created_at')
            ->get();

        if ($orders->isEmpty()) {
            return back()->withErrors(['report' => 'এই ফিল্টারে কোনো অর্ডার নেই — ডাউনলোড করার কিছু নেই।']);
        }

        $period = ($from !== '' || $to !== '')
            ? ($from !== '' && $to !== '' ? $from . ' থেকে ' . $to : ($from !== '' ? $from . ' থেকে আজ' : 'শুরু থেকে ' . $to))
            : 'সব সময়';

        if ($type === 'pdf') {
            // PDF ta A-to-Z English — brand/slogan er English version + English product name
            $periodEn = ($from !== '' || $to !== '')
                ? ($from !== '' && $to !== '' ? $from . ' to ' . $to : ($from !== '' ? $from . ' onwards' : 'up to ' . $to))
                : 'All time';
            $productNamesEn = \App\Models\Product::whereIn('id', $orders->flatMap->items->pluck('product_id'))
                ->get()
                ->mapWithKeys(fn ($p) => [$p->id => $p->name_en ?: $p->name])
                ->all();

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.customers.report-pdf', [
                'orders' => $orders,
                'period' => $periodEn,
                'totalMoney' => (float) $orders->sum('total'),
                'brandName' => ab_brand('en'),
                'productNamesEn' => $productNamesEn,
            ]);
            $name = 'customer-report-' . now()->format('Ymd-His') . '.pdf';

            return $pdf->download($name);
        }

        // CSV (Excel-friendly, UTF-8 BOM soho jate Bangla thik dekhay)
        $name = 'customer-report-' . now()->format('Ymd-His') . '.csv';
        $rows = [['Date', 'Invoice', 'Customer', 'Mobile', 'Products', 'Total (Tk)', 'Status']];
        foreach ($orders as $o) {
            $items = $o->items->map(fn ($i) => $i->product_name . ' x' . $i->quantity)->implode(', ');
            $rows[] = [
                $o->created_at?->format('d M Y h:i A'),
                $o->order_code,
                $o->customer_name,
                $o->phone,
                $items,
                number_format((float) $o->total, 2),
                $o->status,
            ];
        }

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }
            fclose($out);
        }, $name, ['Content-Type' => 'text/csv; charset=UTF-8']);
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
