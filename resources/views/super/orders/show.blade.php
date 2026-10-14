@extends('layouts.super')

@section('title', 'ল্যান্ডিং অর্ডার #' . $order->order_code)
@section('page_title', 'ল্যান্ডিং অর্ডার #' . $order->order_code)
@section('page_sub', 'শোকেস কার্ট থেকে আসা ডিজাইন অর্ডারের বিস্তারিত')

@section('content')
    @php $labels = \App\Models\Order::statusLabels(); @endphp
    <div class="card">
        <h3><i class="fa-solid fa-file-invoice"></i> অর্ডারের বিবরণ</h3>
        <p class="desc">ইনভয়েস #{{ $order->order_code }} • {{ $order->created_at->format('d M Y, h:i A') }}</p>

        <div class="fgrid" style="margin-bottom:14px">
            <div class="a-field"><label>কাস্টমার</label><input class="a-input" value="{{ $order->customer_name }}" readonly></div>
            <div class="a-field"><label>মোবাইল</label><input class="a-input" value="{{ $order->phone }}" readonly></div>
            <div class="a-field"><label>ঠিকানা</label><input class="a-input" value="{{ $order->address }}{{ $order->district ? ', ' . $order->district : '' }}" readonly></div>
            <div class="a-field"><label>পেমেন্ট মেথড</label><input class="a-input" value="{{ strtoupper($order->payment_method) }}{{ $order->payment_txn_id ? ' (TrxID: ' . $order->payment_txn_id . ')' : '' }}" readonly></div>
        </div>

        <div style="overflow-x:auto">
            <table class="tbl">
                <thead><tr><th>ডিজাইন</th><th>দাম</th><th>পরিমাণ</th><th>মোট</th></tr></thead>
                <tbody>
                    @foreach ($order->items as $i)
                        <tr>
                            <td>{{ $i->product_name }}</td>
                            <td>৳{{ number_format($i->price) }}</td>
                            <td>{{ $i->quantity }}</td>
                            <td><b>৳{{ number_format($i->line_total) }}</b></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">সাবটোটাল</td>
                        <td>৳{{ number_format($order->subtotal) }}</td>
                    </tr>
                    @if ($order->discount > 0)
                        <tr>
                            <td colspan="3">ডিসকাউন্ট {{ $order->coupon_code ? '(' . $order->coupon_code . ')' : '' }}</td>
                            <td>− ৳{{ number_format($order->discount) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3">ডেলিভারি চার্জ</td>
                        <td>৳{{ number_format($order->shipping_cost) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>সর্বমোট</b></td>
                        <td><b>৳{{ number_format($order->total) }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-sliders"></i> অর্ডার ম্যানেজমেন্ট</h3>
        <p class="desc">স্ট্যাটাস ও পেমেন্ট আপডেট — কাস্টমার ট্র্যাকিং পেজে সাথে সাথে দেখাবে</p>

        <form method="POST" action="{{ route('super.orders.status', $order) }}">
            @csrf
            <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
                <select class="a-input" name="status" style="max-width:220px">
                    @foreach ($labels as $s => $label)
                        <option value="{{ $s }}" @selected($order->status === $s)>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="a-btn" type="submit"><i class="fa-solid fa-rotate"></i> স্ট্যাটাস আপডেট</button>
            </div>
        </form>

        <form method="POST" action="{{ route('super.orders.payment', $order) }}" style="margin-top:14px">
            @csrf
            <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
                <select class="a-input" name="status" style="max-width:220px">
                    <option value="paid" @selected($order->payment_status === 'paid')>PAID</option>
                    <option value="pending" @selected($order->payment_status === 'pending')>PENDING</option>
                    <option value="failed" @selected($order->payment_status === 'failed')>FAILED</option>
                    <option value="clear">— মুছে ফেলুন —</option>
                </select>
                <button class="a-btn gold" type="submit"><i class="fa-solid fa-credit-card"></i> পেমেন্ট আপডেট</button>
            </div>
        </form>

        <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap">
            <a class="btn-mini" href="{{ route('super.orders.index') }}"><i class="fa-solid fa-arrow-left"></i> সব ল্যান্ডিং অর্ডার</a>
            <a class="btn-mini" href="{{ route('order.invoice', $order->order_code) }}" target="_blank" rel="noopener"><i class="fa-solid fa-file-arrow-down"></i> ইনভয়েস PDF</a>
        </div>
    </div>
@endsection
