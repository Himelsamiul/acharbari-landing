@extends('layouts.admin')

@section('title', 'সাপ্লায়ার — ' . $supplier->name)
@section('page_title', 'সাপ্লায়ার: ' . $supplier->name)
@section('page_sub', ($supplier->company ? $supplier->company . ' • ' : '') . ($supplier->phone ?: 'মোবাইল নেই'))

@section('content')
    <div style="display:flex;gap:10px;margin-bottom:12px">
        <a class="a-btn ghost" href="{{ route('admin.suppliers') }}"><i class="fa-solid fa-arrow-left"></i> সব সাপ্লায়ার</a>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:16px" class="order-grid">
        <div class="card" style="text-align:center;margin:0">
            <p class="desc">মোট পারচেজ</p>
            <h3 style="margin:4px 0">{{ $purchases->count() }} টি</h3>
        </div>
        <div class="card" style="text-align:center;margin:0">
            <p class="desc">মোট টাকা (বিনিময়ে)</p>
            <h3 style="margin:4px 0">৳{{ number_format($totalSpent) }}</h3>
        </div>
        <div class="card" style="text-align:center;margin:0">
            <p class="desc">কেনা আইটেমের ধরন</p>
            <h3 style="margin:4px 0">{{ $purchasedProducts->count() }} টি</h3>
        </div>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-cart-flatbed"></i> নতুন পারচেজ এন্ট্রি</h3>
        <p class="desc">কোন প্রোডাক্ট, কত পরিমাণ, কত দামে নিয়েছেন — এন্ট্রি দিলে প্রোডাক্টের স্টক অটো বাড়বে।</p>
        <form method="POST" action="{{ route('admin.suppliers.purchases.store', $supplier) }}">
            @csrf
            <div class="fgrid">
                <div class="a-field">
                    <label>প্রোডাক্ট *</label>
                    <select class="a-input" name="product_id" required>
                        <option value="">— প্রোডাক্ট নির্বাচন করুন —</option>
                        @foreach ($allProducts as $p)
                            <option value="{{ $p->id }}">{{ $p->name }} (স্টক: {{ $p->stock }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="a-field">
                    <label>পরিমাণ *</label>
                    <input class="a-input" type="number" name="quantity" min="1" value="1" required>
                </div>
                <div class="a-field">
                    <label>একক ক্রয়মূল্য (৳) *</label>
                    <input class="a-input" type="number" name="unit_cost" min="0" step="0.01" required placeholder="যেমন: 250">
                </div>
                <div class="a-field">
                    <label>তারিখ</label>
                    <input class="a-input" type="date" name="purchased_at" value="{{ now()->toDateString() }}">
                </div>
            </div>
            <div class="a-field">
                <label>নোট</label>
                <input class="a-input" name="note" placeholder="ঐচ্ছিক — যেমন: বকেয়া ৫০০ টাকা">
            </div>
            <button class="a-btn" type="submit" style="margin-top:10px"><i class="fa-solid fa-floppy-disk"></i> পারচেজ সেভ করুন</button>
        </form>
    </div>

    <div class="card" style="margin-top:16px">
        <h3>পারচেজ হিস্ট্রি</h3>
        <p class="desc">এই সাপ্লায়ারের কাছ থেকে কী কী নিয়েছেন, কত টাকায় — মোট: ৳{{ number_format($totalSpent) }}</p>
        <table class="tbl">
            <thead>
                <tr><th>তারিখ</th><th>প্রোডাক্ট</th><th>পরিমাণ</th><th>একক দাম</th><th>মোট</th><th>নোট</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($purchases as $pu)
                    <tr>
                        <td>{{ $pu->purchased_at->format('d M Y') }}</td>
                        <td><b>{{ $pu->product?->name ?? 'মুছে ফেলা প্রোডাক্ট' }}</b></td>
                        <td>{{ $pu->quantity }}</td>
                        <td>৳{{ number_format($pu->unit_cost) }}</td>
                        <td><b>৳{{ number_format($pu->total) }}</b></td>
                        <td><small style="color:#8b7355">{{ $pu->note }}</small></td>
                        <td>
                            <form method="POST" action="{{ route('admin.purchases.destroy', $pu) }}"
                                onsubmit="return confirm('রেকর্ড মুছলে স্টক থেকেও পরিমাণটা কমে যাবে — নিশ্চিত?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-icon" type="submit"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;color:#8b7355;padding:20px">এখনো কোনো পারচেজ নেই — উপরে থেকে এন্ট্রি দিন।</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($purchasedProducts->count())
        <div class="card" style="margin-top:16px">
            <h3>এই সাপ্লায়ারের কাছ থেকে যা যা কিনেছি</h3>
            <p class="desc">পারচেজ রেকর্ড থেকে — কোন প্রোডাক্ট মোট কত পরিমাণ ও কত টাকায়</p>
            <table class="tbl">
                <thead><tr><th>প্রোডাক্ট</th><th>মোট কেনা পরিমাণ</th><th>মোট টাকা</th></tr></thead>
                <tbody>
                    @foreach ($purchasedProducts as $pp)
                        <tr>
                            <td><b>{{ $pp->product?->name ?? 'মুছে ফেলা প্রোডাক্ট' }}</b></td>
                            <td>{{ (int) $pp->total_qty }} পিস</td>
                            <td><b>৳{{ number_format($pp->total_money) }}</b></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
