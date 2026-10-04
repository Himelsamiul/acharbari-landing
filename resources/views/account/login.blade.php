@extends('layouts.auth')

@section('title', 'লগইন')

@section('content')
    <h1>লগইন করুন</h1>
    <p class="sub">ইমেইল অথবা মোবাইল নম্বর দিয়ে লগইন করুন</p>

    @if (session('status'))
        <div class="ab-auth-ok">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="ab-auth-err">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <div class="ab-field">
            <label>ইমেইল অথবা মোবাইল নম্বর</label>
            <input class="ab-input" type="text" name="login" value="{{ old('login') }}"
                placeholder="apnar@email.com অথবা 01xxxxxxxxx" required autofocus>
        </div>
        <div class="ab-field">
            <label>পাসওয়ার্ড</label>
            <input class="ab-input" type="password" name="password" placeholder="••••••••" required>
        </div>
        <label class="remember-row">
            <input type="checkbox" name="remember"> মনে রাখুন
        </label>
        <button class="ab-btn" type="submit">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/></svg>
            লগইন করুন
        </button>
    </form>

    <p class="ab-auth-note" style="margin-top:12px">
        <a href="{{ route('password.request') }}">পাসওয়ার্ড ভুলে গেছেন?</a>
    </p>
    <p class="ab-auth-foot">
        নতুন গ্রাহক? <a href="{{ route('register') }}">অ্যাকাউন্ট খুলুন</a>
    </p>
@endsection
