@extends('layouts.admin')

@section('title', $product->name . ' — বিস্তারিত')
@section('page_title', $product->name)
@section('page_sub', 'প্রোডাক্টের সব তথ্য, ভ্যারিয়েন্ট ও পারচেজ হিস্ট্রি')

@section('content')
    <div style="display:flex;gap:8px;align-items:center;margin-bottom:12px;flex-wrap:wrap">
        <a class="a-btn ghost" href="{{ route('admin.products.index') }}"><i class="fa-solid fa-arrow-left"></i> তালিকায় ফিরুন</a>
        <a class="a-btn" href="{{ route('admin.products.edit', $product) }}"><i class="fa-solid fa-pen"></i> এডিট করুন</a>
        @if ($product->is_active)<span class="pill ok">লাইভ</span>
        @else<span class="pill red">বন্ধ</span>@endif
    </div>

    {{-- ===== স্ট্যাট ===== --}}
    <div class="fgrid" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr));margin-bottom:16px">
        <div class="card" style="margin:0"><h3 style="font-size:13px;color:#8b7355">বিক্রি হয়েছে</h3><h3>{{ $soldQty }}</h3></div>
        <div class="card" style="margin:0"><h3 style="font-size:13px;color:#8b7355">পারচেজ করা হয়েছে</h3><h3>{{ $purchasedQty }}</h3></div>
        <div class="card" style="margin:0"><h3 style="font-size:13px;color:#8b7355">পারচেজ খরচ</h3><h3>৳{{ number_format($purchaseTotal) }}</h3></div>
        <div class="card" style="margin:0"><h3 style="font-size:13px;color:#8b7355">বর্তমান স্টক</h3><h3>{{ $product->stock }} {{ $product->unit }}</h3></div>
    </div>

    {{-- ===== বেসিক তথ্য ===== --}}
    <div class="card">
        <h3>প্রোডাক্টের তথ্য</h3>
        <div style="display:flex;gap:18px;flex-wrap:wrap;margin-top:10px">
            <img src="{{ asset($product->image) }}" alt="" style="width:140px;height:140px;object-fit:cover;border-radius:14px;border:1px solid rgba(5,150,105,.2)">
            <table class="tbl" style="flex:1;min-width:300px">
                <tbody>
                    <tr><td style="color:#8b7355;width:40%">নাম</td><td><b>{{ $product->name }}</b> ({{ $product->name_en }})</td></tr>
                    <tr><td style="color:#8b7355">ক্যাটাগরি / ব্র্যান্ড</td><td>{{ $product->category }} • {{ $product->brand ?: '—' }}</td></tr>
                    <tr><td style="color:#8b7355">দাম (ভ্যারিয়েন্ট না থাকলে)</td><td><b>৳{{ number_format($product->price) }}</b> @if($product->old_price > $product->price)<s style="color:#b0a08c">৳{{ number_format($product->old_price) }}</s>@endif</td></tr>
                    <tr><td style="color:#8b7355">VAT</td><td>{{ $product->vat_percent }}%</td></tr>
                    <tr><td style="color:#8b7355">বারকোড</td><td><code>{{ $product->barcode }}</code></td></tr>
                    <tr><td style="color:#8b7355">স্লাগ</td><td><code>{{ $product->slug }}</code></td></tr>
                    <tr><td style="color:#8b7355">বিবরণ</td><td>{{ $product->description ?: '—' }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== ভ্যারিয়েন্ট ===== --}}
    <div class="card" style="margin-top:16px">
        <h3>ভ্যারিয়েন্ট ({{ $product->variants->count() }}টি)</h3>
        @if ($product->variants->isEmpty())
            <p class="desc">এই প্রোডাক্টে কোনো ভ্যারিয়েন্ট নেই — এডিট করে যোগ করতে পারেন।</p>
        @else
            <table class="tbl">
                <thead><tr><th>সাইজ / রং</th><th>দাম</th><th>VAT</th><th>স্টক</th><th>SKU</th><th>অবস্থা</th></tr></thead>
                <tbody>
                    @foreach ($product->variants as $v)
                        <tr>
                            <td><b>{{ $v->size }}</b>
                                @if ($v->discount_bn || $product->discount_bn)<span class="pill wait" style="margin-left:4px">{{ $v->discount_bn ?: $product->discount_bn }}</span>@endif
                            </td>
                            <td><b>৳{{ number_format($v->price) }}</b> @if ($v->old_price > $v->price)<s style="color:#b0a08c;font-size:12px">৳{{ number_format($v->old_price) }}</s>@endif</td>
                            <td>{{ $v->vat_percent !== null ? $v->vat_percent . '%' : 'প্রোডাক্টেরটা' }}</td>
                            <td>{{ $v->stock }}</td>
                            <td><code>{{ $v->sku ?: '—' }}</code></td>
                            <td>@if ($v->is_active)<span class="pill ok">চালু</span>@else<span class="pill red">বন্ধ</span>@endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ===== পারচেজ হিস্ট্রি ===== --}}
    <div class="card" style="margin-top:16px">
        <h3>পারচেজ হিস্ট্রি ({{ $purchases->count() }}টি)</h3>
        @if ($purchases->isEmpty())
            <p class="desc">এখনো কোনো পারচেজ নেই — সাপ্লায়ার পেজ থেকে এন্ট্রি দিন।</p>
        @else
            <table class="tbl">
                <thead><tr><th>তারিখ</th><th>সাপ্লায়ার</th><th>ভ্যারিয়েন্ট</th><th>পরিমাণ</th><th>একক দাম</th><th>মোট</th><th>নোট</th></tr></thead>
                <tbody>
                    @foreach ($purchases as $pu)
                        <tr>
                            <td>{{ $pu->purchased_at->format('d M Y') }}</td>
                            <td>{{ $pu->supplier?->name ?? '—' }}</td>
                            <td>@if ($pu->variant)<span class="pill info">{{ $pu->variant->size }}</span>@else<span style="color:#8b7355">সাধারণ</span>@endif</td>
                            <td>{{ $pu->quantity }}</td>
                            <td>৳{{ number_format($pu->unit_cost) }}</td>
                            <td><b>৳{{ number_format($pu->total) }}</b></td>
                            <td><small style="color:#8b7355">{{ $pu->note }}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ===== সাম্প্রতিক অর্ডার ===== --}}
    <div class="card" style="margin-top:16px">
        <h3>সাম্প্রতিক অর্ডার (শেষ {{ $orderItems->count() }}টি)</h3>
        @if ($orderItems->isEmpty())
            <p class="desc">এই প্রোডাক্টের এখনো কোনো অর্ডার আসেনি।</p>
        @else
            <table class="tbl">
                <thead><tr><th>অর্ডার</th><th>কাস্টমার</th><th>ভ্যারিয়েন্ট</th><th>পরিমাণ</th><th>লাইন মোট</th><th>অবস্থা</th></tr></thead>
                <tbody>
                    @foreach ($orderItems as $oi)
                        <tr>
                            <td><a href="{{ $oi->order ? route('admin.orders.show', $oi->order) : '#' }}"><b>{{ $oi->order?->order_code ?? '—' }}</b></a></td>
                            <td>{{ $oi->order?->customer_name ?? '—' }}</td>
                            <td>{{ $oi->variant_size ?: 'সাধারণ' }}</td>
                            <td>{{ $oi->quantity }}</td>
                            <td><b>৳{{ number_format($oi->line_total) }}</b></td>
                            <td><span class="pill mut">{{ $oi->order?->status ?? '—' }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
