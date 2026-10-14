@extends('layouts.super')

@section('title', 'ল্যান্ডিং অর্ডার')
@section('page_title', 'ল্যান্ডিং অর্ডার')
@section('page_sub', 'শোকেস থেকে বেচা ল্যান্ডিং পেজ ডিজাইনের অর্ডার — source: landing')

@section('content')
    <div class="card">
        <h3><i class="fa-solid fa-cart-shopping"></i> ল্যান্ডিং ডিজাইন অর্ডার</h3>
        <p class="desc">শুধু /showcase কার্ট থেকে আসা অর্ডার — ক্লায়েন্ট অ্যাডমিনের প্রোডাক্ট অর্ডার এখানে দেখাবে না।</p>

        <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px">
            <input class="a-input" type="text" name="q" value="{{ $q }}" placeholder="নাম / মোবাইল / ইনভয়েস দিয়ে খুঁজুন" style="flex:1;min-width:200px">
            <button class="a-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> খুঁজুন</button>
        </form>

        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px">
            <a class="btn-mini" href="{{ route('super.orders.index') }}">সব ({{ array_sum($counts) }})</a>
            @foreach (\App\Models\Order::statusLabels() as $s => $label)
                <a class="btn-mini" href="{{ route('super.orders.index', ['status' => $s]) }}">{{ $label }} ({{ $counts[$s] ?? 0 }})</a>
            @endforeach
        </div>

        @if ($orders->isEmpty())
            <p style="text-align:center;color:#6d5f8a;font-size:13px;padding:24px 0">এখনো কোনো ল্যান্ডিং অর্ডার আসেনি।</p>
        @else
            <div style="overflow-x:auto">
                <table class="tbl">
                    <thead>
                        <tr><th>ইনভয়েস</th><th>কাস্টমার</th><th>ডিজাইন</th><th>মোট</th><th>পেমেন্ট</th><th>স্ট্যাটাস</th><th>তারিখ</th><th></th></tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $o)
                            @php $labels = \App\Models\Order::statusLabels(); @endphp
                            <tr>
                                <td><b>#{{ $o->order_code }}</b></td>
                                <td>{{ $o->customer_name }}<br><small style="color:#6d5f8a">{{ $o->phone }}</small></td>
                                <td>
                                    @foreach ($o->items as $i)
                                        <div style="font-size:12px">{{ $i->product_name }} ×{{ $i->quantity }}</div>
                                    @endforeach
                                </td>
                                <td><b>৳{{ number_format($o->total) }}</b></td>
                                <td>
                                    @if ($o->payment_status)
                                        <span class="pill {{ $o->payment_status === 'paid' ? 'ok' : ($o->payment_status === 'failed' ? 'red' : 'gold') }}">{{ strtoupper($o->payment_status) }}</span>
                                    @else
                                        <span class="pill mut">{{ strtoupper($o->payment_method) }}</span>
                                    @endif
                                </td>
                                <td><span class="pill {{ ['pending' => 'red', 'processing' => 'gold', 'shipped' => 'violet', 'delivered' => 'ok', 'cancelled' => 'mut'][$o->status] }}">{{ $labels[$o->status] }}</span></td>
                                <td style="white-space:nowrap">{{ $o->created_at->format('d M Y, h:i A') }}</td>
                                <td><a class="btn-mini" href="{{ route('super.orders.show', $o) }}">দেখুন</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $orders->links() }}
        @endif
    </div>
@endsection
