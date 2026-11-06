@extends('layouts.admin')

@php
    $self = $user->id === $me->id;
    $isOwner = $me->isPlatformOwner();
@endphp

@section('title', 'অ্যাকাউন্ট এডিট — ' . $user->name)
@section('page_title', $user->name)
@section('page_sub', 'প্রোফাইল, অনুমতি ও পাসওয়ার্ড')

@section('styles')
    @include('admin.team._styles')
@endsection

@section('content')
    <a class="btn-mini" href="{{ route('admin.admins.index') }}" style="margin-bottom:14px"><i class="fa-solid fa-arrow-left"></i> সব অ্যাকাউন্ট</a>

    @if ($errors->any())
        <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
    @endif

    <div class="card">
        <h3><i class="fa-solid fa-user-gear"></i> প্রোফাইল</h3>
        <p class="desc">লগইন ইমেইল ও নাম পরিবর্তন করুন</p>
        <form method="POST" action="{{ route('admin.admins.update', $user) }}">
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
                <button class="a-btn"><i class="fa-solid fa-floppy-disk"></i> প্রোফাইল সেভ করুন</button>
            </div>
        </form>
        <div style="display:flex;gap:10px;align-items:center;margin-top:10px;flex-wrap:wrap">
            @unless ($self)
                <form method="POST" action="{{ route('admin.admins.toggle', $user) }}" style="display:inline">
                    @csrf
                    <button type="submit" class="a-btn ghost">{{ $user->is_active ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}</button>
                </form>
                @if ($isOwner)
                    <form method="POST" action="{{ route('admin.admins.protect', $user) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="a-btn ghost"><i class="fa-solid {{ $user->is_protected ? 'fa-lock-open' : 'fa-lock' }}"></i> {{ $user->is_protected ? 'ডিলিট-লক সরান' : 'ডিলিট-লক করুন' }}</button>
                    </form>
                @endif
            @endunless
            <span class="pill {{ $user->is_active ? 'ok' : 'red' }}">{{ $user->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span>
            @if ($user->is_protected)
                <span class="tag-lock" style="margin-left:0"><i class="fa-solid fa-lock"></i> {{ $isOwner ? 'ডিলিট-লকড (শুধু আপনি মুছতে পারবেন)' : 'লক করা' }}</span>
            @endif
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
            <p class="desc">কোন মডিউলের কোন ফিচার এই অ্যাকাউন্ট ব্যবহার করতে পারবে। ড্যাশবোর্ড ও নোটিফিকেশন সবার জন্য চালু থাকে।@unless ($me->isSuperAdmin()) আপনার নিজের যেসব অনুমতি আছে, শুধু সেগুলোই এখানে দেখাচ্ছে।@endunless</p>

            @if ($modules === [])
                <p class="desc" style="color:#b45309">আপনার নিজের কোনো অনুমতি দেওয়ার মতো নেই।</p>
            @else
                <div class="preset-row">
                    <span style="font-size:12px;font-weight:800;color:#6b8a7a;align-self:center">প্যাকেজ:</span>
                    @foreach ($presets as $key => $preset)
                        <button type="button" class="btn-mini" onclick="applyPreset('{{ $key }}')">
                            <i class="fa-solid fa-box-open"></i> {{ $preset['label'] }}
                        </button>
                    @endforeach
                    <button type="button" class="btn-mini" onclick="clearMatrix()"><i class="fa-solid fa-eraser"></i> সব খালি</button>
                </div>

                <form method="POST" action="{{ route('admin.admins.update', $user) }}" id="matrixForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    {{-- an all-unchecked matrix posts no permissions at all — this marks it as a matrix save --}}
                    <input type="hidden" name="matrix" value="1">
                    <div class="pm-grid">
                        @foreach ($modules as $module => $info)
                            @php
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
            @endif
        </div>
    @endif

    {{-- ================= PASSWORD ================= --}}
    <div class="card">
        <h3><i class="fa-solid fa-key"></i> নতুন পাসওয়ার্ড</h3>
        <p class="desc">পাসওয়ার্ড ভুলে গেলে এখান থেকে নতুন পাসওয়ার্ড সেট করে দিন</p>
        <form method="POST" action="{{ route('admin.admins.password', $user) }}">
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

    {{-- ================= DELETE ================= --}}
    @if (! $self && $me->hasPermission('team.delete'))
        <div class="card" style="border-color:rgba(220,38,38,.25)">
            <h3><i class="fa-solid fa-triangle-exclamation" style="color:#dc2626"></i> অ্যাকাউন্ট মুছে ফেলা</h3>
            <p class="desc">মুছে ফেললে এই অ্যাকাউন্ট আর লগইন করতে পারবে না। নিজের অ্যাকাউন্ট বা শেষ অ্যাডমিন মুছে ফেলা যাবে না।</p>
            @if ($user->is_protected && ! $isOwner)
                <p class="desc" style="color:#b45309"><i class="fa-solid fa-lock"></i> এই অ্যাকাউন্টটি লক করা আছে — মুছে ফেলা যাবে না।</p>
            @else
                {{-- the name travels as data, never as code --}}
                <form method="POST" action="{{ route('admin.admins.destroy', $user) }}"
                    data-confirm="&quot;{{ $user->name }}&quot; অ্যাকাউন্ট মুছে ফেলবেন?"
                    onsubmit="return swConfirmSubmit(event, this.dataset.confirm, 'এই কাজটি ফেরানো যাবে না।')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="a-btn red"><i class="fa-solid fa-trash"></i> মুছে ফেলুন</button>
                </form>
            @endif
        </div>
    @endif
@endsection

@push('scripts')
<script>
    /* preset buttons pre-fill the matrix (the server caps again on save) */
    var PRESETS = @json(collect($presets)->map(fn ($p) => $p['map']));
    var MODULE_FEATURES = @json(collect($modules)->map(fn ($info) => array_keys($info['features'])));

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
        var card = header ? header.closest('.pm-card') : null;
        var badge = card ? card.querySelector('.pm-count') : null;
        if (badge) badge.textContent = checked.length + '/' + all.length;
    }

    function applyPreset(key) {
        var map = PRESETS[key];
        if (!map) return;
        Object.keys(MODULE_FEATURES).forEach(function (m) {
            var grant = map === '*' ? '*' : map[m];
            if (grant === '*' || (grant && grant.indexOf('*') !== -1)) {
                setModule(m, true);
                return;
            }
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
