@extends('layouts.auth')

@section('title', 'রেজিস্টার')

@section('content')
    <h1>অ্যাকাউন্ট খুলুন</h1>
    <p class="sub">অর্ডার ট্র্যাক করতে ও ইতিহাস দেখতে একটি ফ্রি অ্যাকাউন্ট বানান</p>

    @if ($errors->any())
        <div class="ab-auth-err">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register.attempt') }}">
        @csrf
        <div class="ab-field">
            <label>আপনার নাম</label>
            <input class="ab-input" type="text" name="name" value="{{ old('name') }}" placeholder="যেমন: মোঃ কামরুল হাসান" required autofocus>
        </div>
        <div class="ab-field">
            <label>মোবাইল নম্বর</label>
            <input class="ab-input" type="tel" inputmode="numeric" maxlength="15" name="phone" value="{{ old('phone') }}"
                placeholder="০১xxxxxxxxx" required
                oninput="this.value=this.value.replace(/[^0-9]/g,'')">
        </div>
        <div class="ab-field">
            <label>ইমেইল <span style="color:#8b7355;font-weight:400">(ঐচ্ছিক)</span></label>
            <input class="ab-input" type="email" name="email" value="{{ old('email') }}" placeholder="apnar@email.com">
            <p class="ab-auth-note" style="text-align:left;margin-top:5px">ইমেইল দিলে পাসওয়ার্ড রিসেট করতে পারবেন</p>
        </div>
        <div class="ab-field">
            <label>পাসওয়ার্ড</label>
            <input class="ab-input" type="password" name="password" placeholder="কমপক্ষে ৬ অক্ষর" required minlength="6">
        </div>
        <div class="ab-field">
            <label>পাসওয়ার্ড আবার লিখুন</label>
            <input class="ab-input" type="password" name="password_confirmation" placeholder="••••••••" required minlength="6">
        </div>
        <button class="ab-btn" type="submit">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            অ্যাকাউন্ট তৈরি করুন
        </button>
    </form>

    <p class="ab-auth-foot">
        আগে থেকেই অ্যাকাউন্ট আছে? <a href="{{ route('login') }}">লগইন করুন</a>
    </p>
@endsection
