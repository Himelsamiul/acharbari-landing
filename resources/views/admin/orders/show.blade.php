@extends('layouts.admin')

@section('title', 'অর্ডার ' . $order->order_code)
@section('page_title', 'অর্ডার #' . $order->order_code)
@section('page_sub', $order->customer_name . ' • ' . $order->created_at->format('d M Y, h:i A'))

@section('content')
    @php $labels = \App\Models\Order::statusLabels(); @endphp

    <div style="display:flex;justify-content:flex-end;margin-bottom:12px">
        <a class="a-btn" href="{{ route('order.invoice', $order->order_code) }}" target="_blank" rel="noopener">
            <i class="fa-solid fa-file-pdf"></i> ইনভয়েস (PDF) ডাউনলোড</a>
    </div>

    <div style="display:grid;grid-template-columns:1.4fr 1fr;gap:18px;align-items:start" class="order-grid">
        <div class="card">
            <h3><i class="fa-solid fa-jar"></i> অর্ডারের আইটেমসমূহ</h3>
            <p class="desc">{{ $order->items->count() }}টি আইটেম</p>
            <table class="tbl">
                <thead><tr><th>প্রোডাক্ট</th><th>দাম</th><th>পরিমাণ</th><th style="text-align:right">মোট</th></tr></thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td><b>{{ $item->product_name }}</b></td>
                            <td>৳{{ number_format($item->price) }}</td>
                            <td>× {{ $item->quantity }}</td>
                            <td style="text-align:right"><b>৳{{ number_format($item->line_total) }}</b></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top:14px;padding-top:12px;border-top:1px dashed rgba(5,150,105,.3)">
                <div style="display:flex;justify-content:space-between;font-size:13px;color:#5f7a6d;padding:4px 0"><span>সাবটোটাল</span><b>৳{{ number_format($order->subtotal) }}</b></div>
                @if ($order->discount > 0)
                    <div style="display:flex;justify-content:space-between;font-size:13px;color:#dc2626;padding:4px 0"><span>ডিসকাউন্ট ({{ $order->coupon_code }})</span><b>−৳{{ number_format($order->discount) }}</b></div>
                @endif
                <div style="display:flex;justify-content:space-between;font-size:13px;color:#5f7a6d;padding:4px 0"><span>ডেলিভারি চার্জ</span><b>৳{{ number_format($order->shipping_cost) }}</b></div>
                <div style="display:flex;justify-content:space-between;font-size:17px;font-weight:800;color:#047857;padding:10px 0 0;margin-top:6px;border-top:2px solid rgba(5,150,105,.25)"><span>সর্বমোট</span><span>৳{{ number_format($order->total) }}</span></div>
            </div>
        </div>

        <div>
            <div class="card">
                <h3><i class="fa-solid fa-user"></i> কাস্টমার ও ডেলিভারি</h3>
                <p class="desc">ডেলিভারি তথ্য</p>
                <div style="display:flex;flex-direction:column;gap:12px;font-size:13px">
                    <div><b style="color:#1f4234">{{ $order->customer_name }}</b></div>
                    <div style="color:#5f7a6d"><i class="fa-solid fa-phone" style="color:#059669;width:18px"></i> {{ $order->phone }}</div>
                    <div style="color:#5f7a6d"><i class="fa-solid fa-location-dot" style="color:#059669;width:18px"></i> {{ $order->address }}</div>
                    <div style="color:#5f7a6d"><i class="fa-solid fa-truck" style="color:#059669;width:18px"></i>
                        @if ($order->district)
                            {{ $order->district }} জেলা — ডেলিভারি চার্জ ৳{{ number_format($order->shipping_cost) }}
                        @else
                            {{ $order->area === 'inside' ? 'ঢাকার ভিতরে' : 'ঢাকার বাহিরে' }} (৳{{ number_format($order->shipping_cost) }})
                        @endif
                    </div>
                    <div style="color:#5f7a6d"><i class="fa-solid fa-credit-card" style="color:#059669;width:18px"></i>
                        {{ strtoupper($order->payment_method) }}</div>
                </div>
            </div>

            <div class="card">
                <h3><i class="fa-solid fa-pen-to-square"></i> স্ট্যাটাস আপডেট</h3>
                <p class="desc">বর্তমান: <span class="pill {{ ['pending' => 'red', 'processing' => 'wait', 'shipped' => 'info', 'delivered' => 'ok', 'cancelled' => 'mut'][$order->status] }}">{{ $labels[$order->status] }}</span></p>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    <select name="status" class="status-select" style="width:100%;padding:11px;font-size:13.5px" required>
                        @foreach ($labels as $key => $label)
                            <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="a-btn" style="width:100%;margin-top:12px;border:none;cursor:pointer;font-family:inherit;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-weight:800;font-size:13.5px;padding:12px;border-radius:12px;box-shadow:0 10px 22px -8px rgba(6,78,59,.5)">
                        <i class="fa-solid fa-floppy-disk"></i> আপডেট করুন
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('অর্ডারটি মুছে ফেলবেন? এটি ফিরে আসবে না।')" style="margin-top:10px">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="a-btn" style="width:100%;background:#fff;color:#dc2626;border:1.5px solid rgba(220,38,38,.4);box-shadow:none;font-size:12.5px;padding:10px">
                        <i class="fa-solid fa-trash"></i> অর্ডার মুছুন
                    </button>
                </form>
            </div>

            <a class="side-link" href="{{ route('admin.orders.index') }}" style="background:#fff;color:#1f4234;border-radius:12px;text-decoration:none"><i class="fa-solid fa-arrow-left"></i> সব অর্ডারে ফিরুন</a>
        </div>
    </div>

    <style>
        @media (max-width: 900px) {
            .order-grid { grid-template-columns: 1fr !important; }
        }
    </style>
@endsection
