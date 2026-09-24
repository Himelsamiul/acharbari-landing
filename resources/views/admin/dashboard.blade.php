@extends('layouts.admin')

@section('title', 'ড্যাশবোর্ড')
@section('page_title', 'ড্যাশবোর্ড')
@section('page_sub', 'আজকের সারসংক্ষেপ এক নজরে')

@section('content')
    <div class="dash-banner" style="position:relative;border-radius:18px;overflow:hidden;margin-bottom:18px;min-height:156px;display:flex;align-items:center;box-shadow:0 20px 44px -20px rgba(6,78,59,.5)">
        <img src="{{ asset('assets/img/hero_achar.jpg') }}" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
        <div style="position:relative;z-index:1;width:100%;padding:30px 32px;color:#fff;background:linear-gradient(90deg, rgba(2,44,34,.92), rgba(2,44,34,.55) 62%, rgba(2,44,34,.12))">
            <span style="display:inline-flex;align-items:center;gap:7px;font-size:10.5px;font-weight:800;letter-spacing:1.2px;padding:5px 13px;border-radius:999px;background:rgba(163,230,53,.18);border:1px solid rgba(163,230,53,.45);color:#a3e635">
                <span style="width:7px;height:7px;border-radius:50%;background:#a3e635"></span> LIVE STORE
            </span>
            <h3 style="margin:10px 0 6px;font-size:20px">স্বাগতম, Admin 👋</h3>
            <p style="margin:0;font-size:13px;color:rgba(255,255,255,.85)">আজ <b style="color:#a3e635">{{ $stats['orders_today'] }}টি</b> নতুন অর্ডার এসেছে — মোট {{ $stats['orders_total'] }}টি অর্ডারের মধ্যে {{ $stats['pending'] }}টি পেন্ডিং আছে।</p>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-sack-dollar"></i></span>
            <div class="lbl">মোট রেভিনিউ</div>
            <div class="val">৳ {{ number_format($stats['revenue']) }}</div>
            <div class="chg mut">প্রসেসিং + ডেলিভার্ড অর্ডার</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-box-open"></i></span>
            <div class="lbl">মোট অর্ডার</div>
            <div class="val">{{ $stats['orders_total'] }}</div>
            <div class="chg mut">আজ: {{ $stats['orders_today'] }}টি</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-clock"></i></span>
            <div class="lbl">পেন্ডিং অর্ডার</div>
            <div class="val">{{ $stats['pending'] }}</div>
            <div class="chg mut">দ্রুত প্রসেস করুন</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-users"></i></span>
            <div class="lbl">ইউনিক গ্রাহক</div>
            <div class="val">{{ $stats['customers'] }}</div>
            <div class="chg mut">মোবাইল নম্বর অনুযায়ী</div>
        </div>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-clock-rotate-left"></i> সাম্প্রতিক অর্ডার</h3>
        <p class="desc">সর্বশেষ ৬টি অর্ডার</p>
        @if ($recent->isEmpty())
            <p style="text-align:center;color:#8b7355;font-size:13px;padding:24px 0">এখনো কোনো অর্ডার আসেনি — ল্যান্ডিং পেজ থেকে একটি টেস্ট অর্ডার করে দেখুন।</p>
        @else
            <table class="tbl">
                <thead>
                    <tr><th>ইনভয়েস</th><th>কাস্টমার</th><th>মোট</th><th>স্ট্যাটাস</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($recent as $o)
                        <tr>
                            <td><b>#{{ $o->order_code }}</b></td>
                            <td>{{ $o->customer_name }}</td>
                            <td><b>৳{{ number_format($o->total) }}</b></td>
                            <td>
                                @php $labels = \App\Models\Order::statusLabels(); @endphp
                                <span class="pill {{ ['pending' => 'red', 'processing' => 'wait', 'shipped' => 'info', 'delivered' => 'ok', 'cancelled' => 'mut'][$o->status] }}">
                                    {{ $labels[$o->status] }}
                                </span>
                            </td>
                            <td><a class="side-link" style="background:rgba(5,150,105,.08);color:#1f4234;border-radius:10px;padding:7px 13px;width:auto" href="{{ route('admin.orders.show', $o) }}">দেখুন</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
