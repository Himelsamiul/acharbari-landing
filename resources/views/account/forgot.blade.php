@extends('layouts.auth')

@section('title', 'পাসওয়ার্ড রিসেট')

@section('content')
    <h1>পাসওয়ার্ড ভুলে গেছেন?</h1>
    <p class="sub">আপনার ইমেইল দিন — রিসেট লিংক পাঠিয়ে দেব</p>

    @if (session('status'))
        <div class="ab-auth-ok">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="ab-auth-err">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="ab-field">
            <label>ইমেইল</label>
            <input class="ab-input" type="email" name="email" value="{{ old('email') }}" placeholder="apnar@email.com" required autofocus>
        </div>
        <button class="ab-btn" type="submit">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            রিসেট লিংক পাঠান
        </button>
    </form>

    <p class="ab-auth-note">মোবাইল নম্বর দিয়ে খোলা অ্যাকাউন্টের পাসওয়ার্ড রিসেট করতে আমাদের সাপোর্টে যোগাযোগ করুন।</p>
    <p class="ab-auth-foot">
        <a href="{{ route('login') }}">লগইনে ফিরে যান</a>
    </p>
@endsection
