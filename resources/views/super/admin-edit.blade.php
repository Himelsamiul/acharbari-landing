@extends('layouts.super')

@section('title', 'অ্যাডমিন এডিট — ' . $user->name)
@section('page_title', $user->name)
@section('page_sub', 'প্রোফাইল, পাসওয়ার্ড, অনুমতি ম্যাট্রিক্স ও ইন্ডাস্ট্রি প্রভিশনিং')

@section('content')
    <a class="btn-mini" href="{{ route('super.admins.index') }}" style="margin-bottom:14px"><i class="fa-solid fa-arrow-left"></i> সব অ্যাডমিন</a>

    @if ($errors->any())
        <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
    @endif

    <div class="card">
        <h3><i class="fa-solid fa-user-gear"></i> প্রোফাইল</h3>
        <p class="desc">লগইন ইমেইল ও নাম পরিবর্তন করুন</p>
        <form method="POST" action="{{ route('super.admins.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="fgrid" style="max-width:640px">
                <div class="a-field">
                    <label>নাম</label>
                    <input class="a-input" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="a-field">
                    <label>ইমেইল</label>
                    <input class="a-input" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>
            <div style="margin-top:14px">
                <button class="a-btn"><i class="fa-solid fa-floppy-disk"></i> প্রোফাইল ও অনুমতি সেভ করুন</button>
            </div>
        </form>
        <div style="display:flex;gap:10px;align-items:center;margin-top:10px;flex-wrap:wrap">
            @if ($user->id !== auth()->id())
                <form method="POST" action="{{ route('super.admins.toggle', $user) }}" style="display:inline">
                    @csrf
                    <button type="submit" class="a-btn ghost">{{ $user->is_active ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}</button>
                </form>
            @endif
            <span class="pill {{ $user->is_active ? 'ok' : 'red' }}">{{ $user->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span>
        </div>
    </div>

    {{-- ================= PERMISSION MATRIX ================= --}}
    @if ($user->isSuperAdmin())
        <div class="card">
            <h3><i class="fa-solid fa-crown"></i> অনুমতি</h3>
            <p class="desc">সুপার অ্যাডমিন সবকিছুর অ্যাক্সেস রাখে — আলাদা কোনো অনুমতি সেট করার দরকার নেই।</p>
        </div>
    @else
        <div class="card">
            <h3><i class="fa-solid fa-key"></i> অনুমতি ম্যাট্রিক্স</h3>
            <p class="desc">কোন মডিউলের কোন ফিচার এই অ্যাডমিন ব্যবহার করতে পারবে — মডিউল কার্ড প্রতি "সব সিলেক্ট" চেকবক্সসহ। ড্যাশবোর্ড ও নোটিফিকেশন সব অ্যাডমিনের জন্য চালু থাকে।</p>

            <div class="preset-row">
                <span style="font-size:12px;font-weight:800;color:#6d5f8a;align-self:center">প্যাকেজ:</span>
                @foreach ($presets as $key => $preset)
                    <button type="button" class="btn-mini" data-preset="{{ $key }}" onclick="applyPreset('{{ $key }}')">
                        <i class="fa-solid fa-box-open"></i> {{ $preset['label'] }}
                    </button>
                @endforeach
                <button type="button" class="btn-mini" onclick="clearMatrix()"><i class="fa-solid fa-eraser"></i> সব খালি</button>
            </div>

            <form method="POST" action="{{ route('super.admins.update', $user) }}" id="matrixForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <style>
                    .pm-head-r { display: inline-flex; align-items: center; gap: 8px; }
                    .pm-count { font-size: 9.5px; font-weight: 800; padding: 2px 8px; border-radius: 999px; background: rgba(139,92,246,.1); color: #6d28d9; white-space: nowrap; }
                    .pm-group { font-size: 9px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: #8b7f9e; padding: 8px 2px 2px; }
                </style>
                <div class="pm-grid">
                    @foreach ($modules as $module => $info)
                        @php
                            // many-feature modules (theme) render grouped sub-headings;
                            // everything else stays one flat card
                            $chunks = [];
                            if (! empty($info['groups'])) {
                                foreach ($info['groups'] as $groupLabel => $groupFeatures) {
                                    $chunks[] = ['group' => $groupLabel, 'features' => $groupFeatures];
                                }
                            } else {
                                $chunks[] = ['group' => null, 'features' => array_keys($info['features'])];
                            }
                        @endphp
                        <div class="pm-card">
                            <div class="pm-head">
                                <b>{{ $info['label'] }}</b>
                                <span class="pm-head-r">
                                    <span class="pm-count">{{ count($checked[$module]) }}/{{ count($info['features']) }}</span>
                                    <label class="pm-all">
                                        <input type="checkbox" class="pm-all-check" data-module="{{ $module }}"
                                            {{ count($checked[$module]) === count($info['features']) ? 'checked' : '' }}>
                                        সব
                                    </label>
                                </span>
                            </div>
                            @foreach ($chunks as $chunk)
                                @if ($chunk['group'])<div class="pm-group">{{ $chunk['group'] }}</div>@endif
                                @foreach ($chunk['features'] as $feature)
                                    @continue(! isset($info['features'][$feature]))
                                    <label class="pm-row">
                                        <input type="checkbox" name="permissions[{{ $module }}][]" value="{{ $feature }}"
                                            data-module="{{ $module }}" class="pm-feature"
                                            {{ in_array($feature, $checked[$module]) ? 'checked' : '' }}>
                                        {{ $info['features'][$feature] }}
                                    </label>
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div style="margin-top:16px">
                    <button class="a-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> অনুমতি সেভ করুন</button>
                </div>
            </form>
        </div>
    @endif

    {{-- ================= PASSWORD ================= --}}
    <div class="card">
        <h3><i class="fa-solid fa-key"></i> নতুন পাসওয়ার্ড</h3>
        <p class="desc">ক্লায়েন্ট পাসওয়ার্ড ভুলে গেলে এখান থেকে নতুন পাসওয়ার্ড সেট করে দিন</p>
        <form method="POST" action="{{ route('super.admins.password', $user) }}">
            @csrf
            <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:end">
                <div class="a-field" style="flex:1;min-width:220px">
                    <label>নতুন পাসওয়ার্ড</label>
                    <input class="a-input" type="password" name="password" placeholder="কমপক্ষে ৬ অক্ষর" required minlength="6">
                </div>
                <button class="a-btn ghost"><i class="fa-solid fa-rotate"></i> পাসওয়ার্ড সেট করুন</button>
            </div>
        </form>
    </div>

    {{-- ================= INDUSTRY SHORTCUT (provisioning in one place) ================= --}}
    @if ($user->isSuperAdmin())
        <div class="card">
            <h3><i class="fa-solid fa-industry"></i> ইন্ডাস্ট্রি প্রিসেট</h3>
            <p class="desc">সুপার অ্যাডমিন নিজেই সব পায় — ইন্ডাস্ট্রি প্রয়োগ করতে <a href="{{ route('admin.settings.theme') }}">থিম পেজ</a> বা নিচের শর্টকাট ব্যবহার করুন।</p>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                @foreach ($industries as $key => $g)
                    <form method="POST" action="{{ route('super.admins.industry', $user) }}" style="display:inline"
                        onsubmit="return swConfirmSubmit(event, '"{{ $g['name_bn'] }}" প্রিসেট প্রয়োগ করবেন?', 'পুরো সাইটের থিম, ছবি ও ডেমো কনটেন্ট বদলে যাবে।')">
                        @csrf
                        <input type="hidden" name="industry" value="{{ $key }}">
                        <input type="hidden" name="mode" value="full">
                        <button type="submit" class="btn-mini {{ ($industry ?? '') === $key ? '' : 'ghost' }}"
                            {{ ($industry ?? '') === $key ? 'style=border-color:#6d28d9;background:rgba(139,92,246,.12)' : '' }}>
                            <i class="fa-solid {{ $g['icon'] }}"></i> {{ $g['name_bn'] }}
                            {{ ($industry ?? '') === $key ? ' ✓' : '' }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    @else
        <div class="card">
            <h3><i class="fa-solid fa-industry"></i> এই ক্লায়েন্টের ব্যবসার ক্যাটাগরি (ইন্ডাস্ট্রি)</h3>
            <p class="desc">এক জায়গা থেকেই প্রভিশনিং — অ্যাডমিন তৈরি + প্যাকেজ + ইন্ডাস্ট্রি। প্রয়োগ করলে পুরো সাইট ওই ব্যবসার লুকে বদলে যাবে (থিম + ছবি + ডেমো কনটেন্ট)।</p>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                @foreach ($industries as $key => $g)
                    <form method="POST" action="{{ route('super.admins.industry', $user) }}" style="display:inline"
                        onsubmit="return swConfirmSubmit(event, '"{{ $g['name_bn'] }}" প্রিসেট প্রয়োগ করবেন?', 'পুরো সাইটের থিম, ছবি ও ডেমো কনটেন্ট বদলে যাবে।')">
                        @csrf
                        <input type="hidden" name="industry" value="{{ $key }}">
                        <input type="hidden" name="mode" value="full">
                        <button type="submit" class="btn-mini {{ ($industry ?? '') === $key ? '' : 'ghost' }}"
                            {{ ($industry ?? '') === $key ? 'style=border-color:#6d28d9;background:rgba(139,92,246,.12)' : '' }}>
                            <i class="fa-solid {{ $g['icon'] }}"></i> {{ $g['name_bn'] }}
                            {{ ($industry ?? '') === $key ? ' ✓' : '' }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ================= DELETE ================= --}}
    @if ($user->id !== auth()->id())
        <div class="card" style="border-color:rgba(220,38,38,.25)">
            <h3><i class="fa-solid fa-triangle-exclamation" style="color:#dc2626"></i> অ্যাকাউন্ট মুছে ফেলা</h3>
            <p class="desc">মুছে ফেললে এই অ্যাডমিন আর লগইন করতে পারবে না। নিজের অ্যাকাউন্ট বা শেষ অ্যাডমিন মুছে ফেলা যাবে না।</p>
            <form method="POST" action="{{ route('super.admins.destroy', $user) }}"
                onsubmit="return swConfirmSubmit(event, 'অ্যাডমিন "{{ $user->name }}" মুছে ফেলবেন?', 'এই কাজটি ফেরানো যাবে না।')">
                @csrf
                @method('DELETE')
                <button type="submit" class="a-btn red"><i class="fa-solid fa-trash"></i> মুছে ফেলুন</button>
            </form>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    /* preset buttons pre-fill the matrix (sellable packages) */
    var PRESETS = @json(collect($presets)->map(function ($p) {
        return $p['map'];
    }));
    var MODULE_FEATURES = @json(collect($modules)->mapWithKeys(function ($info, $module) {
        return [$module => array_keys($info['features'])];
    }));

    function setModule(module, on) {
        document.querySelectorAll('.pm-feature[data-module="' + module + '"]').forEach(function (cb) {
            cb.checked = on;
        });
        syncModuleHeader(module);
    }

    function syncModuleHeader(module) {
        var all = document.querySelectorAll('.pm-feature[data-module="' + module + '"]');
        var checked = document.querySelectorAll('.pm-feature[data-module="' + module + '"]:checked');
        var header = document.querySelector('.pm-all-check[data-module="' + module + '"]');
        if (header) header.checked = all.length > 0 && all.length === checked.length;
        /* keep the granted-count badge in step with the checkboxes */
        var card = header ? header.closest('.pm-card') : null;
        var badge = card ? card.querySelector('.pm-count') : null;
        if (badge) badge.textContent = checked.length + '/' + all.length;
    }

    function applyPreset(key) {
        var map = PRESETS[key];
        if (!map) return;
        if (map === '*') {
            Object.keys(MODULE_FEATURES).forEach(function (m) { setModule(m, true); });
            showToast('প্যাকেজ প্রি-ফিল হয়েছে — সেভ করতে ভুলবেন না', 'info');
            return;
        }
        Object.keys(MODULE_FEATURES).forEach(function (m) {
            var grant = map[m];
            if (grant === '*' || (grant && grant.indexOf('*') !== -1)) {
                setModule(m, true);
                return;
            }
            /* explicit feature list → check exactly those checkboxes so the
               pre-filled matrix matches what the preset actually grants */
            setModule(m, false);
            (grant || []).forEach(function (f) {
                var cb = document.querySelector('.pm-feature[data-module="' + m + '"][value="' + f + '"]');
                if (cb) cb.checked = true;
            });
            syncModuleHeader(m);
        });
        showToast('প্যাকেজ প্রি-ফিল হয়েছে — সেভ করতে ভুলবেন না', 'info');
    }

    function clearMatrix() {
        Object.keys(MODULE_FEATURES).forEach(function (m) { setModule(m, false); });
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList && e.target.classList.contains('pm-all-check')) {
            setModule(e.target.dataset.module, e.target.checked);
        } else if (e.target.classList && e.target.classList.contains('pm-feature')) {
            syncModuleHeader(e.target.dataset.module);
        }
    });

    document.querySelectorAll('.pm-feature').forEach(function (cb) { syncModuleHeader(cb.dataset.module); });
</script>
@endpush
