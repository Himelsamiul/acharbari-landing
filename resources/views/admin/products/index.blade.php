@extends('layouts.admin')

@section('title', 'প্রোডাক্ট')
@section('page_title', 'প্রোডাক্ট')
@section('page_sub', 'সব প্রোডাক্ট ম্যানেজ করুন — CRUD, স্টক, বারকোড')

@section('content')
    @if ($errors->any())
        <div class="alert-success" style="background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.3);color:#dc2626">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:10px">
            <div>
                <h3>প্রোডাক্ট লিস্ট</h3>
                <p class="desc">মোট {{ $products->count() }}টি প্রোডাক্ট</p>
            </div>
            <a class="a-btn" href="{{ route('admin.products.create') }}"><i class="fa-solid fa-plus"></i> নতুন প্রোডাক্ট</a>
        </div>
        <input type="text" id="productSearch" class="a-input" autocomplete="off"
            placeholder="🔍 নাম, ক্যাটাগরি, ব্র্যান্ড বা বারকোড দিয়ে খুঁজুন…" style="max-width:340px;margin-bottom:12px">
        <table class="tbl" id="productTable">
            <thead>
                <tr><th>প্রোডাক্ট</th><th>ক্যাটাগরি/ব্র্যান্ড</th><th>দাম</th><th>VAT</th><th>স্টক</th><th>বারকোড</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                    @php
                        $pOrders = (int) ($orderCounts[$p->id] ?? 0);
                        $pPurchases = (int) ($purchaseCounts[$p->id] ?? 0);
                        $deleteBlocked = $pOrders > 0 || $pPurchases > 0;
                    @endphp
                    <tr>
                        <td><img class="pimg" src="{{ asset($p->image) }}" alt=""><b>{{ Str::limit($p->name, 38) }}</b>
                            @if ($p->is_featured)<span class="pill wait" style="margin-left:6px">ফিচার্ড</span>@endif
                            @if ($pOrders > 0)<span class="pill mut" style="margin-left:4px" title="এই প্রোডাক্টের অর্ডার আছে — মোছা যাবে না"><i class="fa-solid fa-cart-shopping"></i> {{ $pOrders }}</span>@endif
                        </td>
                        <td>{{ $p->category }}<br><small style="color:#8b7355">{{ $p->brand }}</small></td>
                        <td><b>৳{{ number_format($p->price) }}</b></td>
                        <td>{{ $p->vat_percent > 0 ? $p->vat_percent . '%' : '—' }}</td>
                        <td>
                            @if ($p->stock > 5)
                                <span class="pill ok">{{ $p->stock }} {{ $p->unit }}</span>
                            @elseif ($p->stock > 0)
                                <span class="pill wait">{{ $p->stock }} {{ $p->unit }} (কম)</span>
                            @else
                                <span class="pill red">স্টক শেষ</span>
                            @endif
                        </td>
                        <td><code style="font-size:11px">{{ $p->barcode }}</code></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:6px">
                                @if ($p->is_active)<span class="pill ok">লাইভ</span>
                                @else<span class="pill red">বন্ধ</span>@endif
                                <form method="POST" action="{{ route('admin.products.toggle', $p) }}">
                                    @csrf
                                    <button class="btn-icon" type="submit" title="{{ $p->is_active ? 'বন্ধ করুন' : 'লাইভ করুন' }}">
                                        <i class="fa-solid {{ $p->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i></button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <a class="side-link" style="background:rgba(5,150,105,.08);color:#1f4234;border-radius:10px;padding:7px 12px;width:auto;text-decoration:none"
                                    href="{{ route('admin.products.edit', $p) }}"><i class="fa-solid fa-pen"></i></a>
                                @if ($deleteBlocked)
                                    <button class="btn-icon" type="button" disabled
                                        title="অর্ডার/পারচেজে ব্যবহৃত — মোছা যাবে না (বদলে বন্ধ করুন)"
                                        style="opacity:.4;cursor:not-allowed">
                                        <i class="fa-solid fa-lock"></i>
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}"
                                        onsubmit="return confirm('প্রোডাক্টটি মুছে ফেলবেন?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-icon" type="submit"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        // client-side product search: matches any text in the row
        document.getElementById('productSearch').addEventListener('input', function () {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll('#productTable tbody tr').forEach(function (tr) {
                tr.style.display = tr.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
            });
        });
    </script>
@endsection
