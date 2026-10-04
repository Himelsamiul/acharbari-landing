@extends('layouts.landing')

@section('title', 'আমার প্রোফাইল')

@section('content')
    <section style="min-height:70vh; padding:34px 16px 60px" class="max-w-3xl mx-auto w-full">
        <div class="mb-6" style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
            <div>
                <h1 class="text-2xl font-extrabold" style="margin:0">আমার প্রোফাইল</h1>
                <p class="text-sm text-gray-500" style="margin:4px 0 0">স্বাগতম, {{ auth()->user()->name }} 👋</p>
            </div>
            <a href="{{ route('account.orders') }}" class="ds-btn" style="text-decoration:none">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                আমার অর্ডারসমূহ
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border mb-4 px-4 py-3 text-sm font-bold"
                style="background:rgba(22,163,74,.08);border-color:rgba(22,163,74,.3);color:#15803d">
                {{ session('success') }}
            </div>
        @endif

        {{-- Profile form --}}
        <div class="bg-white rounded-2xl shadow-xl mb-5" style="border:1px solid rgba(5,150,105,.12);padding:22px">
            <h2 class="text-lg font-bold mb-1" style="margin-top:0">প্রোফাইল তথ্য</h2>
            <p class="text-sm text-gray-500 mb-4">নাম ও মোবাইল নম্বর ঠিক রাখুন — অর্ডারের সময় এগুলোই আগে থেকে বসে যাবে</p>
            @if ($errors->any() && $errors->hasAny(['name', 'phone', 'address']))
                <div class="rounded-xl border mb-4 px-4 py-3 text-sm" style="background:rgba(220,38,38,.06);border-color:rgba(220,38,38,.25);color:#dc2626">
                    {{ $errors->first('name') ?: $errors->first('phone') ?: $errors->first('address') }}
                </div>
            @endif
            <form method="POST" action="{{ route('account.update') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">নাম</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="ab-in">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">মোবাইল নম্বর</label>
                    <input type="tel" inputmode="numeric" maxlength="15" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                        class="ab-in"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">ডেলিভারি ঠিকানা <span class="text-gray-400 font-normal">(ঐচ্ছিক)</span></label>
                    <textarea name="address" rows="2" maxlength="500"
                        class="ab-in" style="resize:none"
                        placeholder="বাসা নং, রোড, এলাকা, থানা ও জেলা">{{ old('address', auth()->user()->address) }}</textarea>
                </div>
                <button type="submit" class="ds-btn">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    প্রোফাইল সেভ করুন
                </button>
            </form>
        </div>

        {{-- Change password --}}
        <div class="bg-white rounded-2xl shadow-xl" style="border:1px solid rgba(5,150,105,.12);padding:22px">
            <h2 class="text-lg font-bold mb-1" style="margin-top:0">পাসওয়ার্ড পরিবর্তন</h2>
            <p class="text-sm text-gray-500 mb-4">নিরাপত্তার জন্য নিয়মিত পাসওয়ার্ড বদলে রাখুন</p>
            @if ($errors->hasAny(['current_password', 'password']))
                <div class="rounded-xl border mb-4 px-4 py-3 text-sm" style="background:rgba(220,38,38,.06);border-color:rgba(220,38,38,.25);color:#dc2626">
                    {{ $errors->first('current_password') ?: $errors->first('password') }}
                </div>
            @endif
            <form method="POST" action="{{ route('account.password') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">বর্তমান পাসওয়ার্ড</label>
                    <input type="password" name="current_password" required
                        class="ab-in">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">নতুন পাসওয়ার্ড</label>
                        <input type="password" name="password" required minlength="6"
                            class="ab-in">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">আবার লিখুন</label>
                        <input type="password" name="password_confirmation" required minlength="6"
                            class="ab-in">
                    </div>
                </div>
                <button type="submit" class="ds-btn ds-btn-ghost">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    পাসওয়ার্ড বদলান
                </button>
            </form>
        </div>

        @if (isset($orders) && $orders->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-xl" style="margin-top:20px;border:1px solid rgba(5,150,105,.12);padding:22px">
                <h2 class="text-lg font-bold mb-4" style="margin-top:0">সাম্প্রতিক অর্ডার</h2>
                <ul style="list-style:none;margin:0;padding:0">
                    @foreach ($orders as $o)
                        <li style="display:flex;justify-content:space-between;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid rgba(5,150,105,.1);flex-wrap:wrap">
                            <b class="text-sm">#{{ $o->order_code }}</b>
                            <span class="text-xs text-gray-500">{{ $o->created_at->format('d M Y') }}</span>
                            <b class="text-sm text-emerald-600">৳{{ bn_num($o->total) }}</b>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('account.orders') }}" class="text-sm font-bold mt-3 inline-block" style="color:var(--ds-primary,#059669)">সব অর্ডার দেখুন →</a>
            </div>
        @endif
    </section>

    <style>
        .ab-in {
            width: 100%;
            background: #fff;
            border: 1.5px solid rgba(5, 150, 105, .25);
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 14px;
            font-family: inherit;
            color: #12261d;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .ab-in:focus { border-color: var(--ds-primary, #059669); box-shadow: 0 0 0 3px rgba(5, 150, 105, .12); }
    </style>
@endsection
