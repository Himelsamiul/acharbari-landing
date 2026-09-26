@extends('layouts.admin')

@section('title', 'অ্যাডমিন ম্যানেজমেন্ট')
@section('page_title', 'অ্যাডমিন ম্যানেজমেন্ট')
@section('page_sub', 'নতুন অ্যাডমিন তৈরি ও ম্যানেজ করুন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-shield-halved"></i>
        <span>নতুন অ্যাডমিন তৈরি করলে ওরা <b>/admin/login</b> থেকে ইমেইল ও পাসওয়ার্ড দিয়ে লগইন করতে পারবে। নিজের অ্যাকাউন্ট বা শেষ অ্যাডমিন মুছে ফেলা যাবে না।</span>
    </div>

    <div class="card">
        <h3>নতুন অ্যাডমিন</h3>
        <p class="desc">ইমেইল ইউনিক হতে হবে — একই ইমেইলে দুটো অ্যাডমিন হয় না</p>
        <form method="POST" action="{{ route('admin.admins.store') }}">
            @csrf
            <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:end">
                <div class="a-field">
                    <label>নাম</label>
                    <input class="a-input" name="name" value="{{ old('name') }}" placeholder="যেমন: রফিকুল ইসলাম" required>
                </div>
                <div class="a-field">
                    <label>ইমেইল</label>
                    <input class="a-input" type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                </div>
                <div class="a-field">
                    <label>পাসওয়ার্ড</label>
                    <input class="a-input" type="password" name="password" placeholder="কমপক্ষে ৬ অক্ষর" required minlength="6">
                </div>
                <button class="a-btn"><i class="fa-solid fa-user-plus"></i> তৈরি করুন</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h3>সব অ্যাডমিন <span style="color:#8b7355;font-weight:400">({{ $admins->count() }}টি)</span></h3>
        @if (session('errors') && session('errors')->first('admin'))
            <p style="color:#dc2626;font-weight:700;font-size:13px">{{ session('errors')->first('admin') }}</p>
        @endif
        <table class="tbl">
            <thead>
                <tr>
                    <th>নাম</th>
                    <th>ইমেইল</th>
                    <th>যোগ হয়েছে</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                    <tr>
                        <td>
                            <b>{{ $admin->name }}</b>
                            @if ($admin->id === $currentId)
                                <span style="display:inline-block;padding:2px 9px;border-radius:999px;font-size:11px;font-weight:700;background:rgba(22,163,74,.12);color:#16a34a;margin-left:6px">আপনি</span>
                            @endif
                        </td>
                        <td>{{ $admin->email }}</td>
                        <td style="color:#8b7355">{{ $admin->created_at?->format('d M Y') ?? '—' }}</td>
                        <td style="white-space:nowrap">
                            @if ($admin->id !== $currentId)
                                <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" style="display:inline"
                                    onsubmit="return confirm('অ্যাডমিন "{{ $admin->name }}" মুছে ফেলবেন?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="padding:6px 12px;font-size:12px;background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.3);color:#dc2626">মুছুন</button>
                                </form>
                            @else
                                <span style="color:#8b7355;font-size:12px">বর্তমান লগইন</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
