@extends('layouts.admin')

@section('title', 'কুপন')
@section('page_title', 'কুপন কোড')
@section('page_sub', 'ডিসকাউন্ট কুপন তৈরি, এডিট ও ম্যানেজ করুন — ল্যান্ডিং চেকআউটে সাথে সাথে কাজ করে')

@section('content')
    <div class="card">
        <h3>নতুন কুপন</h3>
        <p class="desc">কোড কেস-ইনসেনসিটিভ — কাস্টমার ছোট বা বড় হাতের যেকোনোটা লিখলেই কাজ করবে</p>
        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf
            <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:end">
                <div class="a-field">
                    <label>কোড</label>
                    <input class="a-input" name="code" value="{{ old('code') }}" placeholder="ACHAR10" required style="text-transform:uppercase">
                </div>
                <div class="a-field">
                    <label>ডিসকাউন্ট (%)</label>
                    <input class="a-input" type="number" name="percent" value="{{ old('percent', 10) }}" min="1" max="90" required style="width:110px">
                </div>
                <div class="a-field">
                    <label>মেয়াদ শেষ (অপশনাল)</label>
                    <input class="a-input" type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" style="width:auto">
                </div>
                <button class="a-btn"><i class="fa-solid fa-plus"></i> তৈরি করুন</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h3>সব কুপন <span style="color:#8b7355;font-weight:400">({{ $coupons->total() }}টি)</span></h3>
        <input id="couponSearch" class="a-input" type="search" value="{{ request('q') }}"
            placeholder="কুপন কোড দিয়ে খুঁজুন..." autocomplete="off" style="max-width:320px;margin-bottom:14px">

        <div id="couponsArea">
        @if ($coupons->count())
            <table class="tbl">
                <thead>
                    <tr>
                        <th>কোড</th>
                        <th>ডিসকাউন্ট</th>
                        <th>মেয়াদ</th>
                        <th>স্ট্যাটাস</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td><b>{{ $coupon->code }}</b></td>
                            <td>{{ $coupon->percent }}%</td>
                            <td style="color:#8b7355">{{ $coupon->expires_at ? $coupon->expires_at->format('d M Y, h:i A') : 'সীমাহীন' }}</td>
                            <td>
                                @if ($coupon->is_active && (!$coupon->expires_at || $coupon->expires_at->isFuture()))
                                    <span style="display:inline-block;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:700;background:rgba(22,163,74,.12);color:#16a34a">চালু</span>
                                @else
                                    <span style="display:inline-block;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:700;background:rgba(220,38,38,.1);color:#dc2626">বন্ধ</span>
                                @endif
                            </td>
                            <td style="white-space:nowrap">
                                <button type="button" class="btn" style="padding:6px 12px;font-size:12px"
                                    data-id="{{ $coupon->id }}" data-code="{{ $coupon->code }}"
                                    data-percent="{{ $coupon->percent }}" data-expires="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '' }}"
                                    onclick="openCouponEdit(this)">
                                    <i class="fa-solid fa-pen"></i> এডিট</button>
                                <form method="POST" action="{{ route('admin.coupons.toggle', $coupon) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn" style="padding:6px 12px;font-size:12px">{{ $coupon->is_active ? 'বন্ধ করুন' : 'চালু করুন' }}</button>
                                </form>
                                <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" style="display:inline"
                                    onsubmit="return confirm('কুপনটি মুছে ফেলবেন?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="padding:6px 12px;font-size:12px;background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.3);color:#dc2626">মুছুন</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top:14px">{{ $coupons->withQueryString()->links() }}</div>
        @else
            <p style="color:#8b7355;padding:18px 0">কোনো কুপন নেই — উপরে থেকে তৈরি করুন।</p>
        @endif
        </div>
    </div>

    {{-- ===== EDIT MODAL ===== --}}
    <div id="couponEditModal" style="display:none;position:fixed;inset:0;z-index:100;background:rgba(0,0,0,.55);align-items:center;justify-content:center;padding:16px"
        onclick="if(event.target===this)closeCouponEdit()">
        <div style="background:#fff;border-radius:16px;max-width:430px;width:100%;padding:24px;box-shadow:0 30px 60px -20px rgba(0,0,0,.4)">
            <h3 style="margin:0 0 4px"><i class="fa-solid fa-pen"></i> কুপন এডিট</h3>
            <p class="desc" style="margin:0 0 16px">কোড, ডিসকাউন্ট বা মেয়াদ পাল্টে সেভ করুন</p>
            <form method="POST" action="" id="couponEditForm">
                @csrf
                @method('PUT')
                <div class="a-field">
                    <label>কোড</label>
                    <input class="a-input" name="code" id="editCode" required style="text-transform:uppercase">
                </div>
                <div class="a-field">
                    <label>ডিসকাউন্ট (%)</label>
                    <input class="a-input" type="number" name="percent" id="editPercent" min="1" max="90" required>
                </div>
                <div class="a-field">
                    <label>মেয়াদ শেষ (খালি = সীমাহীন)</label>
                    <input class="a-input" type="datetime-local" name="expires_at" id="editExpires">
                </div>
                <div style="display:flex;gap:10px;margin-top:14px">
                    <button type="submit" class="a-btn" style="flex:1"><i class="fa-solid fa-floppy-disk"></i> সেভ করুন</button>
                    <button type="button" class="a-btn ghost" onclick="closeCouponEdit()">বাতিল</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openCouponEdit(btn) {
            var form = document.getElementById('couponEditForm');
            form.action = '{{ url('admin/coupons') }}/' + btn.dataset.id;
            document.getElementById('editCode').value = btn.dataset.code;
            document.getElementById('editPercent').value = btn.dataset.percent;
            document.getElementById('editExpires').value = btn.dataset.expires;
            document.getElementById('couponEditModal').style.display = 'flex';
        }
        function closeCouponEdit() {
            document.getElementById('couponEditModal').style.display = 'none';
        }
        // live search: type korlei table update hoy (page reload chara)
        (function () {
            var input = document.getElementById('couponSearch');
            var area = document.getElementById('couponsArea');
            if (!input || !area) return;
            var timer = null, controller = null;
            input.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
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
                            var fresh = doc.getElementById('couponsArea');
                            if (fresh) area.innerHTML = fresh.innerHTML;
                            window.history.replaceState(null, '', url);
                            area.style.opacity = '';
                        })
                        .catch(function () { area.style.opacity = ''; });
                }, 350);
            });
        })();
    </script>
@endpush
