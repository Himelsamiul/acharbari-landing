@extends('layouts.admin')

@php $isSuper = $me->isSuperAdmin(); @endphp

@section('title', 'অ্যাডমিন ম্যানেজমেন্ট')
@section('page_title', 'অ্যাডমিন ম্যানেজমেন্ট')
@section('page_sub', $isSuper ? 'সব অ্যাডমিন অ্যাকাউন্ট তৈরি, অনুমতি সেট ও ম্যানেজ করুন' : 'আপনার টিমের অ্যাকাউন্ট তৈরি, অনুমতি সেট ও ম্যানেজ করুন')

@section('styles')
    @include('admin.team._styles')
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
    @endif

    <div class="note-banner">
        <i class="fa-solid fa-shield-halved"></i>
        <span>নতুন অ্যাকাউন্ট <b>/admin/login</b> থেকে ইমেইল ও পাসওয়ার্ড দিয়ে লগইন করবে — শুধু যেসব অনুমতি দেবেন সেগুলোই দেখতে পাবে।@unless ($isSuper) আপনার নিজের যতটুকু অনুমতি আছে, তার বেশি কাউকে দিতে পারবেন না। টিমের সবাই একে অপরকে দেখতে পায়, কিন্তু এডিট বা মুছতে পারবেন শুধু আপনার (ও আপনার টিমের) তৈরি অ্যাকাউন্ট।@endunless</span>
    </div>

    @if ($me->hasPermission('team.create'))
        <div class="card">
            <h3>নতুন অ্যাকাউন্ট তৈরি করুন</h3>
            <p class="desc">ইমেইল ইউনিক হতে হবে। একটি প্যাকেজ বেছে নিতে পারেন — পরে এডিট পেজ থেকে প্রতিটি অনুমতি আলাদাভাবে ঠিক করা যায়।</p>
            <form method="POST" action="{{ route('admin.admins.store') }}">
                @csrf
                <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:end">
                    <div class="a-field" style="flex:1;min-width:160px">
                        <label>নাম</label>
                        <input class="a-input" name="name" value="{{ old('name') }}" placeholder="যেমন: রফিকুল ইসলাম" required>
                    </div>
                    <div class="a-field" style="flex:1;min-width:180px">
                        <label>ইমেইল</label>
                        <input class="a-input" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
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
                @if ($me->isPlatformOwner())
                    <label style="display:inline-flex;align-items:center;gap:7px;margin-top:12px;font-size:13px;color:#1f4234;cursor:pointer">
                        <input type="checkbox" name="is_protected" value="1" {{ old('is_protected') ? 'checked' : '' }}>
                        <i class="fa-solid fa-lock" style="color:#b45309"></i>
                        ডিলিট-লক — এই অ্যাকাউন্ট শুধু আপনি মুছতে পারবেন
                    </label>
                @endif
            </form>
        </div>
    @endif

    <div class="card">
        <h3>{{ $isSuper ? 'সব অ্যাডমিন' : 'আপনার টিম' }} <span style="color:#6b8a7a;font-weight:400">({{ $admins->count() }}টি)</span></h3>
        <table class="tbl">
            <thead>
                <tr>
                    <th>নাম</th>
                    <th>ইমেইল</th>
                    <th>ভূমিকা</th>
                    <th>তৈরি করেছে</th>
                    <th>অনুমতি</th>
                    <th>স্ট্যাটাস</th>
                    <th>যোগ হয়েছে</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {{-- creators are looked up in this list only — nobody outside it ever gets named --}}
                @php $byId = $admins->keyBy('id'); @endphp
                @foreach ($admins as $admin)
                    @php
                        $self = $admin->id === $me->id;
                        $manage = ! $self && $me->canManageUser($admin);
                    @endphp
                    <tr>
                        <td>
                            <b>{{ $admin->name }}</b>
                            @if ($self)<span class="tag-me">আপনি</span>@endif
                            @if ($admin->is_protected)<span class="tag-lock" title="লক করা — মুছে ফেলা যাবে না"><i class="fa-solid fa-lock"></i> লকড</span>@endif
                        </td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            @if ($admin->isSuperAdmin())
                                <span class="pill gold">সুপার অ্যাডমিন</span>
                            @else
                                <span class="pill green">অ্যাডমিন</span>
                            @endif
                        </td>
                        <td style="color:#6b8a7a">{{ $admin->created_by ? ($byId->get($admin->created_by)?->name ?? '—') : '—' }}</td>
                        <td style="max-width:240px;font-size:12px;color:#1f4234">{{ $admin->permissionsSummary() }}</td>
                        <td>
                            @if ($admin->is_active)
                                <span class="pill ok">সক্রিয়</span>
                            @else
                                <span class="pill red">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                        <td style="color:#6b8a7a">{{ $admin->created_at?->format('d M Y') ?? '—' }}</td>
                        <td style="white-space:nowrap">
                            <div style="display:flex;gap:6px;flex-wrap:wrap">
                                @if ($self && ! $isSuper)
                                    <a class="btn-mini" href="{{ route('admin.account') }}"><i class="fa-solid fa-user"></i> আমার অ্যাকাউন্ট</a>
                                @elseif ($self || $manage)
                                    @if ($me->hasPermission('team.edit'))
                                        <a class="btn-mini" href="{{ route('admin.admins.edit', $admin) }}"><i class="fa-solid fa-pen"></i> এডিট</a>
                                    @endif
                                    @if ($manage)
                                        @if ($me->hasPermission('team.edit'))
                                            <form method="POST" action="{{ route('admin.admins.toggle', $admin) }}" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn-mini">
                                                    <i class="fa-solid fa-power-off"></i> {{ $admin->is_active ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}
                                                </button>
                                            </form>
                                        @endif
                                        @if ($me->isPlatformOwner())
                                            <form method="POST" action="{{ route('admin.admins.protect', $admin) }}" style="display:inline">
                                                @csrf
                                                <button type="submit" class="btn-mini">
                                                    <i class="fa-solid {{ $admin->is_protected ? 'fa-lock-open' : 'fa-lock' }}"></i> {{ $admin->is_protected ? 'লক সরান' : 'ডিলিট-লক' }}
                                                </button>
                                            </form>
                                        @endif
                                        @if ($me->hasPermission('team.delete'))
                                            @if ($admin->is_protected && ! $me->isPlatformOwner())
                                                <span class="btn-mini off" title="লক করা — মুছে ফেলা যাবে না"><i class="fa-solid fa-lock"></i> মুছুন</span>
                                            @else
                                                {{-- the name travels as data, never as code --}}
                                                <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" style="display:inline"
                                                    data-confirm="&quot;{{ $admin->name }}&quot; অ্যাকাউন্ট মুছে ফেলবেন?"
                                                    onsubmit="return swConfirmSubmit(event, this.dataset.confirm)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-mini red"><i class="fa-solid fa-trash"></i> মুছুন</button>
                                                </form>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    <span style="color:#6b8a7a;font-size:12px" title="এই অ্যাকাউন্টটি আপনার টিমের, তবে আপনি তৈরি করেননি — শুধু দেখতে পারবেন">
                                        <i class="fa-solid fa-eye"></i> শুধু দেখা
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
