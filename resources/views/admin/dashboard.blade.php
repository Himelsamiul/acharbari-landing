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
    <style>
        @media (max-width: 640px) {
            .dash-banner > div { padding: 20px 18px !important; }
            .dash-banner h3 { font-size: 17px !important; }
        }
    </style>

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
    @php
        $seoDone = collect($seoChecks)->where('ok', true)->count();
        $seoTotal = count($seoChecks);
        $seoPct = round($seoDone / max(1, $seoTotal) * 100);
    @endphp
    <div class="card">
        <h3><i class="fa-solid fa-magnifying-glass-chart"></i> SEO চেকলিস্ট</h3>
        <p class="desc">
            স্কোর: <b>{{ $seoPct }}%</b> ({{ $seoDone }}/{{ $seoTotal }}) —
            <span style="display:inline-block;width:130px;height:8px;border-radius:99px;background:rgba(5,150,105,.12);vertical-align:middle;margin-left:6px;overflow:hidden">
                <span style="display:block;height:100%;width:{{ $seoPct }}%;border-radius:99px;background:linear-gradient(90deg,#059669,#10b981)"></span>
            </span>
        </p>
        <div class="seo-checks">
            @foreach ($seoChecks as $c)
                <a href="{{ $c['url'] }}" class="seo-check {{ $c['ok'] ? 'ok' : '' }}">
                    <i class="fa-solid {{ $c['ok'] ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                    <span>{{ $c['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <style>
        .seo-checks { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr)); gap: 8px; }
        .seo-check { display: flex; align-items: center; gap: 10px; font-size: 12.5px; font-weight: 700; color: #b45309; background: rgba(217,119,6,.07); border: 1px solid rgba(217,119,6,.18); padding: 9px 13px; border-radius: 10px; text-decoration: none; transition: transform .15s; }
        .seo-check:hover { transform: translateX(3px); }
        .seo-check.ok { color: #15803d; background: rgba(22,163,74,.07); border-color: rgba(22,163,74,.2); }
    </style>
@endsection
