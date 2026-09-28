@extends('layouts.admin')

@section('title', 'আমার অ্যাকাউন্ট')
@section('page_title', 'আমার অ্যাকাউন্ট')
@section('page_sub', 'নিজের তথ্য ও পাসওয়ার্ড ম্যানেজ করুন')

@section('content')
    <div class="card">
        <h3>আমার তথ্য</h3>
        <div class="fgrid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr));margin-top:10px">
            <div class="a-field">
                <label>নাম</label>
                <input class="a-input" value="{{ $user->name }}" disabled>
            </div>
            <div class="a-field">
                <label>ইমেইল</label>
                <input class="a-input" value="{{ $user->email }}" disabled>
            </div>
            <div class="a-field">
                <label>পারমিশন</label>
                <input class="a-input" value="{{ count($user->permissions ?? []) }}টি সেকশন" disabled>
            </div>
        </div>
    </div>

    <div class="card">
        <h3>পাসওয়ার্ড বদলান</h3>
        <p class="desc">নতুন পাসওয়ার্ড দিতে বর্তমান পাসওয়ার্ড জানতে হবে</p>
        <form method="POST" action="{{ route('admin.account.password') }}">
            @csrf
            <div class="fgrid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
                <div class="a-field @error('current_password') field-error @enderror">
                    <label>বর্তমান পাসওয়ার্ড *</label>
                    <input class="a-input" type="password" name="current_password" required>
                    @error('current_password')<small style="color:#dc2626">{{ $message }}</small>@enderror
                </div>
                <div class="a-field @error('password') field-error @enderror">
                    <label>নতুন পাসওয়ার্ড *</label>
                    <input class="a-input" type="password" name="password" required minlength="6">
                    @error('password')<small style="color:#dc2626">{{ $message }}</small>@enderror
                </div>
                <div class="a-field">
                    <label>নতুন পাসওয়ার্ড (আবার) *</label>
                    <input class="a-input" type="password" name="password_confirmation" required minlength="6">
                </div>
            </div>
            <button class="a-btn" style="margin-top:12px"><i class="fa-solid fa-key"></i> পাসওয়ার্ড বদলান</button>
        </form>
    </div>
@endsection
