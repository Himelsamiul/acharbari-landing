@extends('layouts.admin')

@section('title', 'কুপন')
@section('page_title', 'কুপন কোড')
@section('page_sub', 'ডিসকাউন্ট কুপন তৈরি ও ম্যানেজ করুন — ল্যান্ডিং চেকআউটে সাথে সাথে কাজ করে')

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
@endsection
