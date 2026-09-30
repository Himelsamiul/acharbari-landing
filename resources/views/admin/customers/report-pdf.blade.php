<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Report</title>
    <style>
        {{-- @font-face must stay INSIDE the style tag — bairer thakle font load hoy na,
             ar Bangla lekha (brand/customer/product name) PDF e bhanga dekhay --}}
        @font-face {
            font-family: 'NotoBengali';
            src: url({{ public_path('assets/fonts/NotoSansBengali.ttf') }}) format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body { font-family: 'NotoBengali', 'hind_siliguri', Helvetica, Arial, sans-serif; color: #1f2937; font-size: 11px; margin: 0; }
        h1 { font-size: 18px; margin: 0 0 2px; color: #065f46; }
        .meta { font-size: 10px; color: #6b7280; margin: 0 0 12px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #065f46; color: #ffffff; padding: 6px 5px; text-align: left; font-size: 10px; }
        td { padding: 5px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
        tr.total td { background: #ecfdf5; font-weight: bold; font-size: 12px; }
        .items { color: #4b5563; font-size: 9px; }
    </style>
</head>
<body>
    <h1>Customer Order Report — {{ $brandName }}</h1>
    <p class="meta">Period: {{ $period }} • Total orders: {{ $orders->count() }} • Total sales: ৳{{ number_format($totalMoney, 2) }} • Generated: {{ now()->format('d M Y, h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Mobile</th>
                <th>Products</th>
                <th>Total (Tk)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $o)
                <tr>
                    <td>{{ $o->created_at?->format('d M y, h:i A') }}</td>
                    <td>{{ $o->order_code }}</td>
                    <td>{{ $o->customer_name }}</td>
                    <td>{{ $o->phone }}</td>
                    <td class="items">{{ $o->items->map(fn ($i) => $i->product_name . ' x' . $i->quantity)->implode(', ') }}</td>
                    <td>{{ number_format((float) $o->total, 2) }}</td>
                    <td>{{ strtoupper($o->status) }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="5">GRAND TOTAL</td>
                <td colspan="2">৳{{ number_format($totalMoney, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
