@extends('layouts.admin')

@section('title', 'অর্ডারসমূহ')
@section('page_title', 'অর্ডারসমূহ')
@section('page_sub', 'সব অর্ডারের তালিকা ও স্ট্যাটাস')

@section('content')
    @php $labels = \App\Models\Order::statusLabels(); @endphp

    <div class="filter-tabs">
        <a class="filter-tab {{ is_null($status) ? 'active' : '' }}" href="{{ route('admin.orders.index', request('q') ? ['q' => request('q')] : []) }}">সব <b>({{ array_sum($counts) }})</b></a>
        @foreach ($labels as $key => $label)
            <a class="filter-tab {{ $status === $key ? 'active' : '' }}" href="{{ route('admin.orders.index', array_filter(['status' => $key, 'q' => request('q')])) }}">{{ $label }} <b>({{ $counts[$key] ?? 0 }})</b></a>
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
                    <tr><th>ইনভয়েস</th><th>কাস্টমার</th><th>মোবাইল</th><th>এরিয়া</th><th>মোট</th><th>পেমেন্ট</th><th>স্ট্যাটাস</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($orders as $o)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $o) }}" style="color:#047857;font-weight:800;text-decoration:none"><b>#{{ $o->order_code }}</b></a></td>
                            <td>{{ $o->customer_name }}</td>
                            <td>{{ $o->phone }}</td>
                            <td>{{ $o->area === 'inside' ? 'ঢাকার ভিতরে' : 'ঢাকার বাহিরে' }}</td>
                            <td><b>৳{{ number_format($o->total) }}</b></td>
                            <td><span class="pill mut">{{ strtoupper($o->payment_method) }}</span></td>
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
                                <form method="POST" action="{{ route('admin.orders.destroy', $o) }}" onsubmit="return confirm('অর্ডারটি মুছে ফেলবেন?')">
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
