<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->order_code }}</title>
    @font-face {
        font-family: 'Hind Siliguri';
        font-weight: normal;
        src: url('{{ public_path('fonts/HindSiliguri-Regular.ttf') }}');
    }
    @font-face {
        font-family: 'Hind Siliguri';
        font-weight: bold;
        src: url('{{ public_path('fonts/HindSiliguri-Bold.ttf') }}');
    }
    <style>
        @page { margin: 36px 40px; }
        * { box-sizing: border-box; }
        body { font-family: 'Hind Siliguri', sans-serif; color: #1f2937; font-size: 13px; margin: 0; }
        .brandbar { border-bottom: 3px solid #059669; padding-bottom: 12px; margin-bottom: 16px; }
        .brand { font-size: 24px; font-weight: bold; color: #065f46; margin: 0; }
        .tagline { color: #6b7280; font-size: 11px; margin: 2px 0 0; }
        .invtitle { float: right; text-align: right; }
        .invtitle .t { font-size: 20px; font-weight: bold; color: #059669; margin: 0; }
        .invtitle .code { font-size: 14px; font-weight: bold; margin: 2px 0; }
        .invtitle .date { color: #6b7280; font-size: 11px; margin: 0; }
        .clear { clear: both; }
        .info { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .info td { padding: 2px 0; font-size: 12px; vertical-align: top; }
        .info .k { color: #6b7280; width: 130px; }
        .info .v { font-weight: bold; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.items th { background: #059669; color: #fff; padding: 8px 10px; font-size: 12px; text-align: left; }
        table.items td { padding: 8px 10px; border-bottom: 1px solid #e5e7eb; font-size: 12px; }
        table.items .num { text-align: right; }
        .totals { width: 300px; border-collapse: collapse; float: right; margin-top: 12px; }
        .totals td { padding: 5px 10px; font-size: 12px; }
        .totals .lbl { color: #6b7280; }
        .totals .val { text-align: right; font-weight: bold; }
        .totals tr.grand td { background: #f0fdf4; border-top: 2px solid #059669; font-size: 15px; color: #065f46; }
        .note { clear: both; margin-top: 40px; padding: 10px 12px; background: #f9fafb; border-left: 3px solid #059669; font-size: 11px; color: #6b7280; }
        .track { margin-top: 12px; font-size: 11px; color: #6b7280; }
        .track b { color: #1f2937; font-size: 13px; }
    </style>
</head>
<body>
    <div class="brandbar">
        <div class="invtitle">
            <p class="t">ইনভয়েস</p>
            <p class="code">{{ $order->order_code }}</p>
            <p class="date">তারিখ: {{ $order->created_at->format('d-m-Y') }}</p>
        </div>
        <h1 class="brand">আচারবাড়ি</h1>
        <p class="tagline">{{ ab_contact('phone') }} • আচার, মধু, ঘি — গ্রামবাংলার সেরা স্বাদ</p>
        <div class="clear"></div>
    </div>

    <table class="info">
        <tr><td class="k">কাস্টমার নাম</td><td class="v">{{ $order->customer_name }}</td></tr>
        <tr><td class="k">মোবাইল</td><td class="v">{{ $order->phone }}</td></tr>
        <tr><td class="k">ঠিকানা</td><td class="v">{{ $order->address }}</td></tr>
        <tr>
            <td class="k">ডেলিভারি এরিয়া</td>
            <td class="v">{{ $order->district ? $order->district . ' জেলা' : ($order->area === 'inside' ? 'ঢাকার ভিতরে' : 'ঢাকার বাহিরে') }}</td>
        </tr>
        <tr><td class="k">পেমেন্ট মেথড</td><td class="v">{{ strtoupper($order->payment_method) }}</td></tr>
        <tr><td class="k">অর্ডার স্ট্যাটাস</td><td class="v">{{ $order->status }}</td></tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>প্রোডাক্ট</th>
                <th class="num">দাম</th>
                <th class="num">পরিমাণ</th>
                <th class="num">মোট</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="num">৳{{ number_format($item->price) }}</td>
                    <td class="num">{{ bn_num($item->quantity) }}</td>
                    <td class="num">৳{{ number_format($item->line_total) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr><td class="lbl">সাবটোটাল</td><td class="val">৳{{ number_format($order->subtotal) }}</td></tr>
        @if ($order->discount > 0)
            <tr><td class="lbl">ডিসকাউন্ট{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}</td><td class="val">− ৳{{ number_format($order->discount) }}</td></tr>
        @endif
        @if ($order->vat_total > 0)
            <tr><td class="lbl">ভ্যাট</td><td class="val">৳{{ number_format($order->vat_total) }}</td></tr>
        @endif
        <tr><td class="lbl">ডেলিভারি চার্জ</td><td class="val">৳{{ number_format($order->shipping_cost) }}</td></tr>
        <tr class="grand"><td>সর্বমোট</td><td class="val">৳{{ number_format($order->total) }}</td></tr>
    </table>

    <div class="track">
        ট্র্যাকিং কোড: <b>{{ $order->order_code }}</b> — স্ট্যাটাস জানতে ওয়েবসাইটে "অর্ডার ট্র্যাক করুন" পেজে এই কোড ও আপনার মোবাইল নম্বর দিন।
    </div>

    <div class="note">
        এই ইনভয়েসটি স্বয়ংক্রিয়ভাবে তৈরি। যেকোনো প্রশ্নে {{ ab_contact('phone') }} নম্বরে যোগাযোগ করুন। ক্রয়ের জন্য ধন্যবাদ! 🙏
    </div>
</body>
</html>
