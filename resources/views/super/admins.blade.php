@extends('layouts.super')

@section('title', 'অ্যাডমিন ইউজার্স')
@section('page_title', 'অ্যাডমিন ইউজার্স')
@section('page_sub', 'ক্লায়েন্ট (অ্যাডমিন) অ্যাকাউন্ট তৈরি, অনুমতি সেট ও ম্যানেজ করুন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-shield-halved"></i>
        <span>নতুন অ্যাডমিন তৈরি করলে ওরা <b>/admin/login</b> থেকে ইমেইল ও পাসওয়ার্ড দিয়ে লগইন করবে — শুধু যেসব মডিউলের অনুমতি দেওয়া হবে সেগুলোই দেখতে পাবে। নিজের অ্যাকাউন্ট বা শেষ অ্যাডমিন মুছে ফেলা যাবে না।</span>
    </div>

    <div class="card">
        <h3>নতুন অ্যাডমিন তৈরি করুন</h3>
        <p class="desc">ইমেইল ইউনিক হতে হবে। তৈরির সময় একটি রেডিমেড প্যাকেজ বেছে নিতে পারেন — পরে এডিট পেজ থেকে প্রতিটি ফিচার আলাদাভাবে ঠিক করা যায়।</p>
        <form method="POST" action="{{ route('super.admins.store') }}">
            @csrf
            <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:end">
                <div class="a-field" style="flex:1;min-width:160px">
                    <label>নাম</label>
                    <input class="a-input" name="name" value="{{ old('name') }}" placeholder="যেমন: রফিকুল ইসলাম" required>
                </div>
                <div class="a-field" style="flex:1;min-width:180px">
                    <label>ইমেইল</label>
                    <input class="a-input" type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                </div>
                <div class="a-field" style="flex:1;min-width:150px">
                    <label>পাসওয়ার্ড</label>
                    <input class="a-input" type="password" name="password" placeholder="কমপক্ষে ৬ অক্ষর" required minlength="6">
                </div>
                <div class="a-field" style="flex:1;min-width:160px">
                    <label>প্যাকেজ (ঐচ্ছিক)</label>
                    <select class="a-input" name="preset">
                        <option value="">কোনো অনুমতি নয় (পরে সেট করব)</option>
                        @foreach ($presets as $key => $preset)
                            <option value="{{ $key }}" {{ old('preset') === $key ? 'selected' : '' }}>{{ $preset['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="a-btn"><i class="fa-solid fa-user-plus"></i> তৈরি করুন</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h3>সব অ্যাডমিন <span style="color:#6d5f8a;font-weight:400">({{ $admins->count() }}টি)</span></h3>
        <table class="tbl">
            <thead>
                <tr>
                    <th>নাম</th>
                    <th>ইমেইল</th>
                    <th>ভূমিকা</th>
                    <th>অনুমতি</th>
                    <th>স্ট্যাটাস</th>
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
                        <td>
                            @if ($admin->isSuperAdmin())
                                <span class="pill gold">সুপার অ্যাডমিন</span>
                            @else
                                <span class="pill violet">অ্যাডমিন</span>
                            @endif
                        </td>
                        <td style="max-width:240px;font-size:12px;color:#4b4463">{{ $admin->permissionsSummary() }}</td>
                        <td>
                            @if ($admin->is_active)
                                <span class="pill ok">সক্রিয়</span>
                            @else
                                <span class="pill red">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                        <td style="color:#6d5f8a">{{ $admin->created_at?->format('d M Y') ?? '—' }}</td>
                        <td style="white-space:nowrap">
                            <div style="display:flex;gap:6px;flex-wrap:wrap">
                                <a class="btn-mini" href="{{ route('super.admins.edit', $admin) }}"><i class="fa-solid fa-pen"></i> এডিট</a>
                                @if ($admin->id !== $currentId)
                                    <form method="POST" action="{{ route('super.admins.toggle', $admin) }}" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn-mini">
                                            <i class="fa-solid fa-power-off"></i> {{ $admin->is_active ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('super.admins.destroy', $admin) }}" style="display:inline"
                                        onsubmit="return swConfirmSubmit(event, 'অ্যাডমিন "{{ $admin->name }}" মুছে ফেলবেন?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-mini red"><i class="fa-solid fa-trash"></i> মুছুন</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
