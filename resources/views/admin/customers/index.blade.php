@extends('layouts.admin')

@section('title', 'গ্রাহক')
@section('page_title', 'গ্রাহক')
@section('page_sub', 'অর্ডার থেকে স্বয়ংক্রিয়ভাবে তৈরি গ্রাহক তালিকা — সার্চ, নাম ঠিক করা বা মুছে ফেলা')

@section('content')
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:10px">
            <div>
                <h3>গ্রাহক লিস্ট</h3>
                <p class="desc">মোট {{ $uniqueCount }} জন ইউনিক গ্রাহক (মোবাইল নম্বর অনুযায়ী)</p>
            </div>
            <form method="GET" action="{{ route('admin.customers') }}" style="display:flex;gap:8px">
                <input type="text" class="a-input" name="q" value="{{ $q }}" placeholder="🔍 নাম বা মোবাইল নম্বর…" style="max-width:260px" autocomplete="off">
                <button class="a-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> খুঁজুন</button>
                @if ($q !== '')
                    <a class="a-btn ghost" href="{{ route('admin.customers') }}">সব দেখুন</a>
                @endif
            </form>
        </div>
        <table class="tbl">
            <thead>
                <tr><th>গ্রাহক</th><th>মোবাইল</th><th>অর্ডার</th><th>মোট কেনাকাটা</th><th>শেষ অর্ডার</th><th>অ্যাকশন</th></tr>
            </thead>
            <tbody>
                @forelse ($customers as $c)
                    <tr>
                        <td><b>{{ $c->name }}</b></td>
                        <td><code style="font-size:12px">{{ $c->phone }}</code></td>
                        <td>{{ $c->orders_count }} টি</td>
                        <td><b>৳{{ number_format($c->total_spent) }}</b></td>
                        <td>{{ \Carbon\Carbon::parse($c->last_order_at)->format('d M Y') }}</td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;align-items:center">
                                <a class="side-link" style="background:rgba(5,150,105,.08);color:#1f4234;border-radius:10px;padding:7px 12px;width:auto;text-decoration:none"
                                    href="{{ route('admin.orders.index') }}?q={{ $c->phone }}"><i class="fa-solid fa-box"></i> অর্ডার</a>
                                <button type="button" class="side-link" style="background:rgba(37,99,235,.08);color:#1e40af;border-radius:10px;padding:7px 12px;width:auto;border:0;cursor:pointer"
                                    onclick="renameCustomer(@js($c->phone), @js($c->name))"><i class="fa-solid fa-pen"></i></button>
                                <form method="POST" action="{{ route('admin.customers.destroy', $c->phone) }}"
                                    onsubmit="return confirm('গ্রাহক ({{ $c->phone }}) এর {{ $c->orders_count }} টি অর্ডার সহ সব ডেটা মুছে যাবে — নিশ্চিত?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-icon" type="submit"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:#8b7355;padding:20px">{{ $q !== '' ? 'কিছু পাওয়া যায়নি।' : 'এখনো কোনো গ্রাহক নেই — অর্ডার এলে অটো দেখা যাবে।' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <form method="POST" action="{{ route('admin.customers.rename') }}" id="renameForm" style="display:none">
        @csrf
        <input type="hidden" name="phone" id="renamePhone">
    </form>

    <script>
        function renameCustomer(phone, currentName) {
            var name = prompt('নতুন নাম লিখুন (' + phone + '):', currentName);
            if (name === null || name.trim() === '') return;
            document.getElementById('renamePhone').value = phone;
            var nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'name';
            nameInput.value = name.trim();
            document.getElementById('renameForm').appendChild(nameInput);
            document.getElementById('renameForm').submit();
        }
    </script>
@endsection
