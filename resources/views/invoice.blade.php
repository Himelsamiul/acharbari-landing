<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->order_code }}</title>
    <style>
        @page { margin: 36px 40px; }
        * { box-sizing: border-box; }
        body { font-family: Helvetica, Arial, sans-serif; color: #1f2937; font-size: 13px; margin: 0; }
        .brandbar { border-bottom: 3px solid #059669; padding-bottom: 12px; margin-bottom: 16px; }
        .brand { font-size: 24px; font-weight: bold; color: #065f46; margin: 0; }
        .logo { max-height: 52px; margin-bottom: 6px; }
        .tagline { color: #6b7280; font-size: 11px; margin: 2px 0 0; }
        .invtitle { float: right; text-align: right; }
        .invtitle .t { font-size: 20px; font-weight: bold; color: #059669; margin: 0; }
        .invtitle .code { font-size: 14px; font-weight: bold; margin: 2px 0; }
        .invtitle .date { color: #6b7280; font-size: 11px; margin: 0; }
        .clear { clear: both; }
        .info { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .info td { padding: 2px 0; font-size: 12px; vertical-align: top; }
        .info .k { color: #6b7280; width: 140px; }
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
            <p class="t">INVOICE</p>
            <p class="code">{{ $order->order_code }}</p>
            @php $orderBarcode = ab_code39_png($order->order_code, 40, 2); @endphp
            @if ($orderBarcode !== '')
                <img src="{{ $orderBarcode }}" style="width:190px;height:36px;margin-top:4px">
                <div style="font-size:9px;color:#6b7280;letter-spacing:2px;margin-top:1px">*{{ strtoupper($order->order_code) }}*</div>
            @endif
            <p class="date">Date: {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        @if (!empty($logo) && file_exists(public_path($logo)))
            <img class="logo" src="{{ public_path($logo) }}" alt="{{ $brandName }}">
        @endif
        <h1 class="brand">{{ $brandName }}</h1>
        <p class="tagline">Phone: {{ $contactPhone }} — Authentic homemade pickles, honey & ghee</p>
        <div class="clear"></div>
    </div>

    <table class="info">
        <tr><td class="k">Customer Name</td><td class="v">{{ $order->customer_name }}</td></tr>
        <tr><td class="k">Mobile</td><td class="v">{{ $order->phone }}</td></tr>
        <tr><td class="k">Delivery Address</td><td class="v">{{ $order->address }}</td></tr>
        <tr>
            <td class="k">Delivery Area</td>
            <td class="v">{{ $order->district ? $order->district . ' District' : ($order->area === 'inside' ? 'Inside Dhaka' : 'Outside Dhaka') }}</td>
        </tr>
        <tr><td class="k">Payment Method</td><td class="v">{{ strtoupper($order->payment_method) }}</td></tr>
        <tr><td class="k">Order Status</td><td class="v">{{ ucfirst($order->status) }}</td></tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Product</th>
                <th class="num">Price</th>
                <th class="num">Qty</th>
                <th class="num">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                @php
                    $itemBarcodeText = trim((string) ($productBarcodes[$item->product_id] ?? ''));
                    $itemBarcode = $itemBarcodeText !== '' ? ab_code39_png($itemBarcodeText, 26, 1) : '';
                @endphp
                <tr>
                    <td>
                        {{ $productNames[$item->product_id] ?? $item->product_name }}
                        @if ($itemBarcode !== '')
                            <img src="{{ $itemBarcode }}" style="width:120px;height:22px;display:block;margin-top:3px">
                            <span style="font-size:8px;color:#6b7280;font-family:monospace;letter-spacing:1px">{{ $itemBarcodeText }}</span>
                        @endif
                    </td>
                    <td class="num">Tk {{ number_format($item->price, 2) }}</td>
                    <td class="num">{{ $item->quantity }}</td>
                    <td class="num">Tk {{ number_format($item->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr><td class="lbl">Subtotal</td><td class="val">Tk {{ number_format($order->subtotal, 2) }}</td></tr>
        @if ($order->discount > 0)
            <tr><td class="lbl">Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}</td><td class="val">- Tk {{ number_format($order->discount, 2) }}</td></tr>
        @endif
        @if ($order->vat_total > 0)
            <tr><td class="lbl">VAT</td><td class="val">Tk {{ number_format($order->vat_total, 2) }}</td></tr>
        @endif
        <tr><td class="lbl">Delivery Charge</td><td class="val">Tk {{ number_format($order->shipping_cost, 2) }}</td></tr>
        <tr class="grand"><td>Grand Total</td><td class="val">Tk {{ number_format($order->total, 2) }}</td></tr>
    </table>

    <div class="track">
        Tracking Code: <b>{{ $order->order_code }}</b> — use this code with your mobile number on our website's "Track Order" page to see the live status.
    </div>

    <div class="note">
        This invoice was generated automatically. For any questions, please call {{ $contactPhone }}. Thank you for your order!
    </div>
</body>
</html>
