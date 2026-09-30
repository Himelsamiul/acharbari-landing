@extends('layouts.admin')

@section('title', 'অর্ডারসমূহ')
@section('page_title', 'অর্ডারসমূহ')
@section('page_sub', 'সব অর্ডারের তালিকা, তারিখ ফিল্টার ও স্ট্যাটাস')

@section('content')
    @php $labels = \App\Models\Order::statusLabels(); @endphp
    @php
        // quick range chips — আজ / ৭ দিন / এই মাসে / গত মাস
        $quickRanges = [
            'today' => ['আজ', now()->toDateString(), now()->toDateString()],
            '7d' => ['গত ৭ দিন', now()->subDays(6)->toDateString(), now()->toDateString()],
            'this_month' => ['এই মাসে', now()->startOfMonth()->toDateString(), now()->toDateString()],
            'last_month' => ['গত মাসে', now()->subMonth()->startOfMonth()->toDateString(), now()->subMonth()->endOfMonth()->toDateString()],
        ];
        $rangeActive = $from !== '' || $to !== '';
        $tabParams = array_filter(['q' => $q ?: null, 'from' => $from ?: null, 'to' => $to ?: null]);
    @endphp

    {{-- ===== সামারি কার্ড ===== --}}
    <div class="fgrid" style="grid-template-columns:repeat(auto-fit,minmax(170px,1fr));margin-bottom:14px">
        <div class="card" style="margin:0;border-top:3px solid #059669">
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                <p class="desc" style="margin:0">মোট বিক্রি</p>
                <span style="width:30px;height:30px;border-radius:9px;display:grid;place-items:center;background:rgba(5,150,105,.12);color:#059669;font-size:13px"><i class="fa-solid fa-money-bill-trend-up"></i></span>
            </div>
            <h3 style="margin:4px 0 0">৳{{ number_format($summary['total']) }}</h3>
        </div>
        <div class="card" style="margin:0;border-top:3px solid #2563eb">
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                <p class="desc" style="margin:0">অর্ডার সংখ্যা</p>
                <span style="width:30px;height:30px;border-radius:9px;display:grid;place-items:center;background:rgba(37,99,235,.12);color:#2563eb;font-size:13px"><i class="fa-solid fa-cart-shopping"></i></span>
            </div>
            <h3 style="margin:4px 0 0">{{ $summary['count'] }}টি</h3>
        </div>
        <div class="card" style="margin:0;border-top:3px solid #10b981">
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                <p class="desc" style="margin:0">ডেলিভারি সম্পন্ন</p>
                <span style="width:30px;height:30px;border-radius:9px;display:grid;place-items:center;background:rgba(16,185,129,.12);color:#059669;font-size:13px"><i class="fa-solid fa-truck-fast"></i></span>
            </div>
            <h3 style="margin:4px 0 0;color:#047857">{{ $summary['delivered'] }}টি</h3>
        </div>
        <div class="card" style="margin:0;border-top:3px solid #dc2626">
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                <p class="desc" style="margin:0">বাতিল</p>
                <span style="width:30px;height:30px;border-radius:9px;display:grid;place-items:center;background:rgba(220,38,38,.1);color:#dc2626;font-size:13px"><i class="fa-solid fa-ban"></i></span>
            </div>
            <h3 style="margin:4px 0 0;color:#dc2626">{{ $summary['cancelled'] }}টি</h3>
        </div>
    </div>

    {{-- ===== তারিখ ফিল্টার ===== --}}
    <div class="card" style="margin-bottom:14px">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            @if ($status)<input type="hidden" name="status" value="{{ $status }}">@endif
            @if ($q !== '')<input type="hidden" name="q" value="{{ $q }}">@endif
            <div style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap">
                <div class="a-field" style="margin:0">
                    <label style="font-size:11px;font-weight:800;color:#8b7355">তারিখ থেকে</label>
                    <input type="date" name="from" value="{{ $from }}" class="a-input" style="min-width:150px">
                </div>
                <div class="a-field" style="margin:0">
                    <label style="font-size:11px;font-weight:800;color:#8b7355">তারিখ পর্যন্ত</label>
                    <input type="date" name="to" value="{{ $to }}" class="a-input" style="min-width:150px">
                </div>
                <button class="a-btn" type="submit" style="padding:10px 22px"><i class="fa-solid fa-filter"></i> ফিল্টার করুন</button>
                @if ($rangeActive)
                    <a class="a-btn ghost" style="padding:10px 18px" href="{{ route('admin.orders.index', array_filter(['status' => $status ?: null, 'q' => $q ?: null])) }}"><i class="fa-solid fa-rotate-left"></i> রিসেট</a>
                @endif
            </div>
        </form>
        {{-- quick range chips --}}
        <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:12px;align-items:center">
            <small style="font-weight:800;color:#8b7355;margin-right:2px">দ্রুত বাছাই:</small>
            @foreach ($quickRanges as $key => [$label, $qFrom, $qTo])
                @php $chipActive = $from === $qFrom && $to === $qTo; @endphp
                <a href="{{ route('admin.orders.index', array_filter(['q' => $q ?: null, 'status' => $status ?: null, 'from' => $qFrom, 'to' => $qTo])) }}"
                    class="filter-tab {{ $chipActive ? 'active' : '' }}" style="padding:5px 13px;font-size:12px">{{ $label }}</a>
            @endforeach
        </div>
    </div>

    {{-- ===== স্ট্যাটাস ট্যাব ===== --}}
    <div class="filter-tabs" style="margin-bottom:14px">
        <a class="filter-tab {{ is_null($status) ? 'active' : '' }}" href="{{ route('admin.orders.index', $tabParams) }}">সব <b>({{ array_sum($counts) }})</b></a>
        @foreach ($labels as $key => $label)
            <a class="filter-tab {{ $status === $key ? 'active' : '' }}" href="{{ route('admin.orders.index', array_filter($tabParams + ['status' => $key])) }}">{{ $label }} <b>({{ $counts[$key] ?? 0 }})</b></a>
        @endforeach
    </div>

    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap">
            <div>
                <h3 style="margin-bottom:2px">অর্ডার তালিকা</h3>
                <p class="desc" style="margin:0">স্ট্যাটাস পরিবর্তন করতে সিলেক্ট ব্যবহার করুন — সাথে সাথে সেভ হয়</p>
            </div>
            <input id="orderSearch" class="a-input" type="search" value="{{ request('q') }}"
                placeholder="🔍 নাম, মোবাইল বা ইনভয়েস..."
                autocomplete="off" style="max-width:300px">
        </div>

        <div id="ordersArea" style="margin-top:14px">
        @if ($orders->isEmpty())
            <p style="text-align:center;color:#8b7355;font-size:13px;padding:32px 0">
                <i class="fa-solid fa-box-open" style="font-size:26px;display:block;margin-bottom:8px;opacity:.5"></i>
                এই ফিল্টারে কোনো অর্ডার নেই।
            </p>
        @else
            <div style="overflow-x:auto">
            <table class="tbl ord-tbl">
                <thead>
                    <tr><th>ইনভয়েস</th><th>কাস্টমার</th><th>মোবাইল</th><th>তারিখ ও সময়</th><th>এরিয়া</th><th>মোট</th><th>পেমেন্ট</th><th>স্ট্যাটাস</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($orders as $o)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $o) }}" style="color:#047857;font-weight:800;text-decoration:none"><b>#{{ $o->order_code }}</b></a></td>
                            <td style="font-weight:600">{{ $o->customer_name }}</td>
                            <td>{{ $o->phone }}</td>
                            <td style="white-space:nowrap"><b>{{ $o->created_at?->format('d M Y') }}</b><br><small style="color:#8b7355">{{ $o->created_at?->format('h:i A') }}</small></td>
                            <td>{{ $o->area === 'inside' ? 'ঢাকার ভিতরে' : 'ঢাকার বাহিরে' }}</td>
                            <td><b>৳{{ number_format($o->total) }}</b></td>
                            <td>
                                <span class="pill mut">{{ strtoupper($o->payment_method) }}</span>
                                @if ($o->payment_status)
                                    <span class="pill {{ $o->payment_status === 'paid' ? 'ok' : ($o->payment_status === 'pending' ? 'wait' : 'red') }}"
                                        style="margin-top:4px;display:inline-block">{{ $o->payment_status === 'paid' ? 'PAID ✓' : ($o->payment_status === 'pending' ? 'পেমেন্ট বাকি' : strtoupper($o->payment_status)) }}</span><br>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.orders.status', $o) }}" style="display:flex;gap:6px;align-items:center">
                                    @csrf
                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                        @foreach ($labels as $key => $label)
                                            <option value="{{ $key }}" {{ $o->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.orders.destroy', $o) }}" onsubmit="return swConfirmSubmit(event, 'অর্ডারটি মুছে ফেলবেন?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="মুছুন"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

            <div style="margin-top:16px;display:flex;gap:6px;flex-wrap:wrap">
                {{ $orders->links() }}
            </div>
        @endif
        </div>
    </div>

    <style>
        .ord-tbl th { white-space:nowrap; font-size:11px; text-transform:uppercase; letter-spacing:.5px; }
        .ord-tbl td { vertical-align:middle; }
        .ord-tbl tbody tr { transition: background .15s; }
        .ord-tbl tbody tr:hover { background: rgba(5,150,105,.05); }
    </style>
@endsection

@push('scripts')
    <script>
        // live search: type kori ar table auto-update hoy (page reload chara)
        (function () {
            var input = document.getElementById('orderSearch');
            var area = document.getElementById('ordersArea');
            if (!input || !area) return;

            var timer = null;
            var controller = null;

            function run() {
                var q = input.value.trim();
                var url = new URL(window.location.href);
                if (q) { url.searchParams.set('q', q); } else { url.searchParams.delete('q'); }

                if (controller) controller.abort();
                controller = new AbortController();

                area.style.opacity = '.5';
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, signal: controller.signal })
                    .then(function (r) { return r.text(); })
                    .then(function (html) {
                        var doc = new DOMParser().parseFromString(html, 'text/html');
                        var fresh = doc.getElementById('ordersArea');
                        if (fresh) area.innerHTML = fresh.innerHTML;
                        window.history.replaceState(null, '', url);
                        area.style.opacity = '';
                    })
                    .catch(function () { area.style.opacity = ''; });
            }

            input.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(run, 350);
            });
        })();
    </script>
@endpush
