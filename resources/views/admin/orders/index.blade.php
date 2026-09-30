@extends('layouts.admin')

@section('title', 'অর্ডারসমূহ')
@section('page_title', 'অর্ডারসমূহ')
@section('page_sub', 'সব অর্ডারের তালিকা ও স্ট্যাটাস')

@section('content')
    @php $labels = \App\Models\Order::statusLabels(); @endphp

    {{-- ===== মাসিক সামারি ===== --}}
    @php
        $monthLabel = $month !== ''
            ? \Illuminate\Support\Carbon::parse($month . '-01')->locale('bn')->translatedFormat('F Y')
            : 'সব সময়';
    @endphp
    <div class="fgrid" style="grid-template-columns:repeat(auto-fit,minmax(150px,1fr));margin-bottom:14px">
        <div class="card" style="margin:0">
            <p class="desc" style="margin:0">{{ $monthLabel }} — বিক্রি</p>
            <h3 style="margin:2px 0 0">৳{{ number_format($summary['total']) }}</h3>
        </div>
        <div class="card" style="margin:0">
            <p class="desc" style="margin:0">অর্ডার সংখ্যা</p>
            <h3 style="margin:2px 0 0">{{ $summary['count'] }}টি</h3>
        </div>
        <div class="card" style="margin:0">
            <p class="desc" style="margin:0">ডেলিভারি সম্পন্ন</p>
            <h3 style="margin:2px 0 0">{{ $summary['delivered'] }}টি</h3>
        </div>
        <div class="card" style="margin:0">
            <p class="desc" style="margin:0">বাতিল</p>
            <h3 style="margin:2px 0 0;color:#dc2626">{{ $summary['cancelled'] }}টি</h3>
        </div>
        <div class="card" style="margin:0;display:flex;align-items:center">
            {{-- মাস সিলেক্ট + সার্চ বাটন — form submit, JS ছাড়াই ১০০% কাজ করে --}}
            <form method="GET" action="{{ route('admin.orders.index') }}" style="margin:0;width:100%">
                @if ($status)<input type="hidden" name="status" value="{{ $status }}">@endif
                @if ($q !== '')<input type="hidden" name="q" value="{{ $q }}">@endif
                <div class="a-field" style="margin:0">
                    <label style="font-size:11px;color:#8b7355">মাস বাছাই করুন</label>
                    <select name="month" class="a-input" style="margin-bottom:6px">
                        <option value="">সব সময়</option>
                        @for ($i = 0; $i < 18; $i++)
                            @php
                                $mDate = now()->subMonths($i);
                                $mKey = $mDate->format('Y-m');
                            @endphp
                            <option value="{{ $mKey }}" {{ $month === $mKey ? 'selected' : '' }}>
                                {{ $mDate->locale('bn')->translatedFormat('F Y') }}
                            </option>
                        @endfor
                    </select>
                    <button class="a-btn" type="submit" style="width:100%;padding:7px 0">
                        <i class="fa-solid fa-magnifying-glass"></i> সার্চ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="filter-tabs">
        <a class="filter-tab {{ is_null($status) ? 'active' : '' }}" href="{{ route('admin.orders.index', array_filter(['q' => request('q'), 'month' => $month])) }}">সব <b>({{ array_sum($counts) }})</b></a>
        @foreach ($labels as $key => $label)
            <a class="filter-tab {{ $status === $key ? 'active' : '' }}" href="{{ route('admin.orders.index', array_filter(['status' => $key, 'q' => request('q'), 'month' => $month])) }}">{{ $label }} <b>({{ $counts[$key] ?? 0 }})</b></a>
        @endforeach
    </div>

    <div class="card">
        <h3>অর্ডার তালিকা</h3>
        <p class="desc">স্ট্যাটাস পরিবর্তন করতে সিলেক্ট ব্যবহার করুন — সাথে সাথে সেভ হয়</p>

        <div style="margin:0 0 16px">
            <input id="orderSearch" class="a-input" type="search" value="{{ request('q') }}"
                placeholder="কাস্টমারের নাম, মোবাইল বা ইনভয়েস দিয়ে খুঁজুন..."
                autocomplete="off" style="max-width:360px">
        </div>

        <div id="ordersArea">
        @if ($orders->isEmpty())
            <p style="text-align:center;color:#8b7355;font-size:13px;padding:24px 0">এই ফিল্টারে কোনো অর্ডার নেই।</p>
        @else
            <table class="tbl">
                <thead>
                    <tr><th>ইনভয়েস</th><th>কাস্টমার</th><th>মোবাইল</th><th>তারিখ ও সময়</th><th>এরিয়া</th><th>মোট</th><th>পেমেন্ট</th><th>স্ট্যাটাস</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($orders as $o)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $o) }}" style="color:#047857;font-weight:800;text-decoration:none"><b>#{{ $o->order_code }}</b></a></td>
                            <td>{{ $o->customer_name }}</td>
                            <td>{{ $o->phone }}</td>
                            <td style="white-space:nowrap"><b>{{ $o->created_at?->format('d M Y') }}</b><br><small style="color:#8b7355">{{ $o->created_at?->format('h:i A') }}</small></td>
                            <td>{{ $o->area === 'inside' ? 'ঢাকার ভিতরে' : 'ঢাকার বাহিরে' }}</td>
                            <td><b>৳{{ number_format($o->total) }}</b></td>
                            <td>
                                <span class="pill mut">{{ strtoupper($o->payment_method) }}</span>
                                @if ($o->payment_method !== 'cod' && $o->payment_status)
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

            <div style="margin-top:16px;display:flex;gap:6px;flex-wrap:wrap">
                {{ $orders->links() }}
            </div>
        @endif
        </div>
    </div>
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
