@extends('layouts.admin')

@section('title', 'অ্যাডমিন ম্যানেজমেন্ট')
@section('page_title', 'অ্যাডমিন ম্যানেজমেন্ট')
@section('page_sub', 'নতুন অ্যাডমিন তৈরি, পারমিশন ও পাসওয়ার্ড ম্যানেজ করুন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-shield-halved"></i>
        <span>রোল সিলেক্ট করলে পারমিশনগুলো অটো বসে যায় — চাইলে চেকবক্স দিয়ে কাস্টমাইজও করা যাবে।
            প্রথম অ্যাডমিন (মূল অ্যাকাউন্ট) এই লিস্টে আসে না; পাসওয়ার্ড কখনো দেখানো হয় না।
            নিজের পারমিশন নিজে এডিট করা যাবে না; শেষ অ্যাডমিন মুছে ফেলা যাবে না।</span>
    </div>

    {{-- ===== নতুন অ্যাডমিন ===== --}}
    <div class="card">
        <h3>নতুন অ্যাডমিন</h3>
        <p class="desc">ইমেইল ইউনিক হতে হবে — একই ইমেইলে দুটো অ্যাডমিন হয় না</p>
        <form method="POST" action="{{ route('admin.admins.store') }}">
            @csrf
            <div class="fgrid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
                <div class="a-field">
                    <label>নাম *</label>
                    <input class="a-input" name="name" value="{{ old('name') }}" placeholder="যেমন: রফিকুল ইসলাম" required>
                </div>
                <div class="a-field">
                    <label>ইমেইল *</label>
                    <input class="a-input" type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                </div>
                <div class="a-field">
                    <label>পাসওয়ার্ড *</label>
                    <input class="a-input" type="password" name="password" placeholder="কমপক্ষে ৬ অক্ষর" required minlength="6">
                </div>
                <div class="a-field">
                    <label>রোল (পারমিশন অটো)</label>
                    <select class="a-input role-preset" data-grid="perm-grid">
                        @foreach ($rolePresets as $key => $preset)
                            <option value="{{ $key }}">{{ $preset['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @include('admin.partials.perm-checkboxes', ['selected' => old('permissions', [])])

            <div style="display:flex;gap:10px;align-items:center;margin-top:14px;flex-wrap:wrap">
                <button class="a-btn"><i class="fa-solid fa-user-plus"></i> তৈরি করুন</button>
                <button type="button" class="a-btn ghost perm-toggle" data-target="perm-grid">
                    <i class="fa-solid fa-check-double"></i> সব সিলেক্ট / বাদ
                </button>
                @error('permissions')<span style="color:#dc2626;font-size:12px;font-weight:600">{{ $message }}</span>@enderror
            </div>
        </form>
    </div>

    {{-- ===== এডিট কার্ড (?edit=<id>) ===== --}}
    @if ($editUser)
        <div class="card" style="border-color:rgba(5,150,105,.45)">
            <h3>এডিট করুন — {{ $editUser->name }}</h3>
            <p class="desc">পারমিশন টিক/উঠিয়ে দিন; পাসওয়ার্ড রিসেট করতে চাইলে নতুন পাসওয়ার্ড লিখুন (না লিখলে অপরিবর্তিত)</p>
            <form method="POST" action="{{ route('admin.admins.update', $editUser) }}">
                @csrf
                @method('PUT')
                <div class="fgrid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
                    <div class="a-field">
                        <label>নাম</label>
                        <input class="a-input" value="{{ $editUser->name }}" disabled>
                    </div>
                    <div class="a-field">
                        <label>ইমেইল</label>
                        <input class="a-input" value="{{ $editUser->email }}" disabled>
                    </div>
                    <div class="a-field">
                        <label>নতুন পাসওয়ার্ড (ঐচ্ছিক)</label>
                        <input class="a-input" type="password" name="password" placeholder="খালি রাখলে অপরিবর্তিত" minlength="6">
                    </div>
                    <div class="a-field">
                        <label>রোল (পারমিশন অটো)</label>
                        <select class="a-input role-preset" data-grid="perm-grid-edit" data-selected="{{ $editUser->roleLabel() }}">
                            @foreach ($rolePresets as $key => $preset)
                                <option value="{{ $key }}">{{ $preset['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @include('admin.partials.perm-checkboxes', ['selected' => $editUser->permissions ?? [], 'gridId' => 'perm-grid-edit'])

                <div style="display:flex;gap:10px;align-items:center;margin-top:14px;flex-wrap:wrap">
                    <button class="a-btn"><i class="fa-solid fa-floppy-disk"></i> সেভ করুন</button>
                    <a class="a-btn ghost" href="{{ route('admin.admins.index') }}"><i class="fa-solid fa-xmark"></i> বাতিল</a>
                    @error('permissions')<span style="color:#dc2626;font-size:12px;font-weight:600">{{ $message }}</span>@enderror
                </div>
            </form>
        </div>
    @endif

    {{-- ===== সব অ্যাডমিন ===== --}}
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
                    <th>পারমিশন</th>
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
                        <td style="font-family:monospace">{{ $admin->email }}</td>
                        <td>
                            <span class="pill info">{{ $admin->roleLabel() }}</span>
                            <span class="pill mut" style="margin-left:4px">{{ count($admin->permissions ?? []) }}টি সেকশন</span>
                        </td>
                        <td style="color:#8b7355">{{ $admin->created_at?->format('d M Y') ?? '—' }}</td>
                        <td style="white-space:nowrap">
                            @if ($admin->id !== $currentId)
                                <a class="btn" style="padding:6px 12px;font-size:12px" href="{{ route('admin.admins.index', ['edit' => $admin->id]) }}">এডিট</a>
                            @else
                                <span style="color:#8b7355;font-size:12px">বর্তমান লগইন</span>
                            @endif
                            <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" style="display:inline"
                                onsubmit="return swConfirmSubmit(event, @js($admin->id === $currentId
                                    ? 'নিজের অ্যাকাউন্ট মুছলে লগআউট হয়ে যাবে — আপনি নিশ্চিত?'
                                    : 'অ্যাডমিন ' . $admin->name . ' মুছে ফেলবেন?'))">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="padding:6px 12px;font-size:12px;background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.3);color:#dc2626">মুছুন</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        .perm-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:8px; margin-top:12px; }
        .perm-item { display:flex; align-items:center; gap:8px; padding:9px 12px; border:1px solid rgba(5,150,105,.2);
            border-radius:10px; cursor:pointer; font-size:13px; font-weight:600; color:#33443c; background:#fff; }
        .perm-item:hover { border-color:rgba(5,150,105,.5); }
        .perm-item:has(input:checked) { border-color:#059669; background:rgba(5,150,105,.06); color:#065f46; }
        .perm-item input { accent-color:#059669; width:15px; height:15px; flex-shrink:0; }
    </style>

    <script>
        /* সব সিলেক্ট / বাদ toggle */
        document.querySelectorAll('.perm-toggle').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var grid = document.getElementById(btn.dataset.target);
                if (!grid) return;
                var boxes = grid.querySelectorAll('input[type="checkbox"]');
                var allOn = Array.from(boxes).every(function (b) { return b.checked; });
                boxes.forEach(function (b) { b.checked = !allOn; });
            });
        });

        /* রোল প্রিসেট: dropdown change korlei checkbox gulo auto-fill */
        @php
            $rolePermsJs = array_map(
                fn ($p) => $p['perms'] ?? array_keys(\App\Models\User::PERMISSIONS),
                $rolePresets
            );
        @endphp
        var ROLE_PERMS = @json($rolePermsJs);

        function applyRolePreset(select) {
            var perms = ROLE_PERMS[select.value] || [];
            var grid = document.getElementById(select.dataset.grid);
            if (!grid) return;
            grid.querySelectorAll('input[type="checkbox"]').forEach(function (b) {
                b.checked = perms.indexOf(b.value) !== -1;
            });
        }

        document.querySelectorAll('.role-preset').forEach(function (sel) {
            // edit form: current permission der sathe mille seta preselect
            if (sel.dataset.selected) {
                Object.keys(ROLE_PERMS).forEach(function (k) {
                    var perms = ROLE_PERMS[k];
                    var grid = document.getElementById(sel.dataset.grid);
                    if (!grid) return;
                    var cur = Array.from(grid.querySelectorAll('input[type="checkbox"]'))
                        .filter(function (b) { return b.checked; })
                        .map(function (b) { return b.value; })
                        .sort();
                    if (JSON.stringify(perms.slice().sort()) === JSON.stringify(cur)) sel.value = k;
                });
            }
            sel.addEventListener('change', function () { applyRolePreset(sel); });
        });
    </script>
@endsection
