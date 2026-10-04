@extends('layouts.super')

@section('title', 'ওভারভিউ')
@section('page_title', 'ওভারভিউ')
@section('page_sub', 'পুরো প্ল্যাটফর্মের সারসংক্ষেপ এক নজরে')

@section('content')
    <div class="stat-grid">
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-sack-dollar"></i></span>
            <div class="lbl">মোট রেভিনিউ</div>
            <div class="val">৳ {{ number_format($stats['revenue']) }}</div>
            <div class="chg mut">বাতিল বাদে সব অর্ডার</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-box-open"></i></span>
            <div class="lbl">মোট অর্ডার</div>
            <div class="val">{{ $stats['orders_total'] }}</div>
            <div class="chg mut">সব টাইম</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-clock"></i></span>
            <div class="lbl">পেন্ডিং অর্ডার</div>
            <div class="val">{{ $stats['pending'] }}</div>
            <div class="chg mut">দ্রুত প্রসেস করুন</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-jar"></i></span>
            <div class="lbl">অ্যাক্টিভ প্রোডাক্ট</div>
            <div class="val">{{ $stats['products'] }}</div>
            <div class="chg mut">{{ $stats['categories'] }} টি ক্যাটাগরি</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-triangle-exclamation"></i></span>
            <div class="lbl">কমপ্লেইন</div>
            <div class="val">{{ $stats['complaints'] }}</div>
            <div class="chg {{ $stats['complaints_open'] > 0 ? 'red' : 'mut' }}">{{ $stats['complaints_open'] }} টি অমীমাংসিত</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-users"></i></span>
            <div class="lbl">রেজিস্টার্ড কাস্টমার</div>
            <div class="val">{{ $stats['customers'] }}</div>
            <div class="chg mut">স্টোরফ্রন্ট অ্যাকাউন্ট</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-user-shield"></i></span>
            <div class="lbl">অ্যাডমিন ইউজার্স</div>
            <div class="val">{{ $stats['admins'] }}</div>
            <div class="chg mut">সুপার + ক্লায়েন্ট অ্যাডমিন</div>
        </div>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-bolt"></i> কুইক অ্যাকশন</h3>
        <p class="desc">ক্লায়েন্ট প্রভিশনিং ও দৈনন্দিন কাজের শর্টকাট</p>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
            <a class="a-btn" href="{{ route('super.admins.index') }}"><i class="fa-solid fa-user-plus"></i> নতুন অ্যাডমিন তৈরি</a>
            <a class="a-btn ghost" href="{{ route('admin.settings.theme') }}"><i class="fa-solid fa-industry"></i> ইন্ডাস্ট্রি প্রিসেট প্রয়োগ</a>
            <a class="a-btn ghost" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high"></i> অ্যাডমিন প্যানেল</a>
        </div>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-clock-rotate-left"></i> সাম্প্রতিক অর্ডার</h3>
        <p class="desc">সর্বশেষ ১০টি অর্ডার</p>
        @if ($recent->isEmpty())
            <p style="text-align:center;color:#6d5f8a;font-size:13px;padding:24px 0">এখনো কোনো অর্ডার আসেনি।</p>
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
                                <span class="pill {{ ['pending' => 'red', 'processing' => 'gold', 'shipped' => 'violet', 'delivered' => 'ok', 'cancelled' => 'mut'][$o->status] }}">
                                    {{ $labels[$o->status] }}
                                </span>
                            </td>
                            <td><a class="btn-mini" href="{{ route('admin.orders.show', $o) }}">দেখুন</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
