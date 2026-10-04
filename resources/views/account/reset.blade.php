@extends('layouts.auth')

@section('title', 'নতুন পাসওয়ার্ড')

@section('content')
    <h1>নতুন পাসওয়ার্ড দিন</h1>
    <p class="sub">আপনার অ্যাকাউন্টের জন্য একটি নতুন পাসওয়ার্ড সেট করুন</p>

    @if (session('status'))
        <div class="ab-auth-ok">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="ab-auth-err">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="ab-field">
            <label>ইমেইল</label>
            <input class="ab-input" type="email" name="email" value="{{ old('email', $email) }}" required>
        </div>
        <div class="ab-field">
            <label>নতুন পাসওয়ার্ড</label>
            <input class="ab-input" type="password" name="password" placeholder="কমপক্ষে ৬ অক্ষর" required minlength="6" autofocus>
        </div>
        <div class="ab-field">
            <label>পাসওয়ার্ড আবার লিখুন</label>
            <input class="ab-input" type="password" name="password_confirmation" placeholder="••••••••" required minlength="6">
        </div>
        <button class="ab-btn" type="submit">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            পাসওয়ার্ড পরিবর্তন করুন
        </button>
    </form>

    <p class="ab-auth-foot">
        <a href="{{ route('login') }}">লগইনে ফিরে যান</a>
    </p>
@endsection
