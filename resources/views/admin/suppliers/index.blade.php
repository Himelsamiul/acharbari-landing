@extends('layouts.admin')

@section('title', 'সাপ্লায়ার')
@section('page_title', 'সাপ্লায়ার')
@section('page_sub', 'সরবরাহকারী ম্যানেজ করুন — পারচেজ হিস্ট্রি সহ')

@section('content')
    <div class="card" style="max-width:920px">
        <h3><i class="fa-solid fa-plus"></i> নতুন সাপ্লায়ার যোগ করুন</h3>
        <p class="desc">সাপ্লায়ার যোগ করার পরে তার প্রোফাইলে গিয়ে পারচেজ এন্ট্রি দিতে পারবেন — কোন প্রোডাক্ট, কত পরিমাণ, কত ক্রয়মূল্যে নিয়েছেন সব সেভ থাকবে।</p>
        <form method="POST" action="{{ route('admin.suppliers.store') }}">
            @csrf
            <div class="fgrid">
                <div class="a-field">
                    <label>সাপ্লায়ারের নাম *</label>
                    <input class="a-input" name="name" value="{{ old('name') }}" required placeholder="যেমন: করিম মিয়া">
                </div>
                <div class="a-field">
                    <label>কোম্পানি / দোকান</label>
                    <input class="a-input" name="company" value="{{ old('company') }}" placeholder="যেমন: কাঁচাবাজার ট্রেডার্স">
                </div>
                <div class="a-field">
                    <label>মোবাইল</label>
                    <input class="a-input" name="phone" value="{{ old('phone') }}" placeholder="017XXXXXXXX">
                </div>
                <div class="a-field">
                    <label>ঠিকানা</label>
                    <input class="a-input" name="address" value="{{ old('address') }}" placeholder="থানা, জেলা">
                </div>
            </div>
            <div class="a-field">
                <label>নোট</label>
                <input class="a-input" name="note" value="{{ old('note') }}" placeholder="ঐচ্ছিক">
            </div>
            <button class="a-btn" type="submit" style="margin-top:10px"><i class="fa-solid fa-floppy-disk"></i> সেভ করুন</button>
        </form>
    </div>

    <div class="card" style="margin-top:16px">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:10px">
            <div>
                <h3>সাপ্লায়ার লিস্ট</h3>
                <p class="desc">মোট {{ $suppliers->count() }} জন সাপ্লায়ার</p>
            </div>
        </div>
        <input type="text" id="supplierSearch" class="a-input" autocomplete="off"
            placeholder="🔍 নাম, কোম্পানি বা মোবাইল দিয়ে খুঁজুন…" style="max-width:320px;margin-bottom:12px">
        <table class="tbl">
            <thead>
                <tr><th>সাপ্লায়ার</th><th>মোবাইল</th><th>কেনা পরিমাণ</th><th>পারচেজ</th><th>মোট টাকা</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $s)
                    <tr>
                        <td>
                            <b>{{ $s->name }}</b>
                            @if ($s->company)<br><small style="color:#8b7355">{{ $s->company }}</small>@endif
                        </td>
                        <td>{{ $s->phone ?: '—' }}</td>
                        <td><b>{{ (int) $s->purchased_qty }}</b> পিস</td>
                        <td>{{ $s->purchases_count }} টি</td>
                        <td><b>৳{{ number_format($s->purchased_total) }}</b></td>
                        <td>
                            @if ($s->is_active)<span class="pill ok">চালু</span>
                            @else<span class="pill red">বন্ধ</span>@endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap">
                                <a class="side-link" style="background:rgba(5,150,105,.08);color:#1f4234;border-radius:10px;padding:7px 12px;width:auto;text-decoration:none"
                                    href="{{ route('admin.suppliers.show', $s) }}"><i class="fa-solid fa-cart-flatbed"></i> পারচেজ</a>
                                <a class="side-link" style="background:rgba(37,99,235,.08);color:#1e40af;border-radius:10px;padding:7px 12px;width:auto;text-decoration:none"
                                    href="{{ route('admin.suppliers.edit', $s) }}"><i class="fa-solid fa-pen"></i></a>
                                <form method="POST" action="{{ route('admin.suppliers.toggle', $s) }}">
                                    @csrf
                                    <button class="btn-icon" type="submit" title="{{ $s->is_active ? 'বন্ধ করুন' : 'চালু করুন' }}">
                                        <i class="fa-solid {{ $s->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i></button>
                                </form>
                                <form method="POST" action="{{ route('admin.suppliers.destroy', $s) }}"
                                    onsubmit="return confirm('সাপ্লায়ার ও তার পারচেজ হিস্ট্রি মুছে ফেলবেন?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-icon" type="submit"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;color:#8b7355;padding:20px">এখনো কোনো সাপ্লায়ার নেই — উপরে থেকে যোগ করুন।</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        // client-side supplier search
        document.getElementById('supplierSearch').addEventListener('input', function () {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll('table.tbl tbody tr').forEach(function (tr) {
                tr.style.display = tr.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
            });
        });
    </script>
@endsection
