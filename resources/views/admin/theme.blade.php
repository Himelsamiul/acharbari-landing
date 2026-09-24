@extends('layouts.admin')

@section('title', 'থিম ও কালার')
@section('page_title', 'থিম ও কালার')
@section('page_sub', 'পুরো ওয়েবসাইটের ডিজাইন থিম পরিবর্তন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-palette"></i>
        <span>থিম সেভ করলে পুরো ওয়েবসাইটের রঙ বদলে যাবে — ল্যান্ডিং পেজে সাথে সাথেই প্রয়োগ হবে।</span>
    </div>

    <div class="card">
        <h3>রেডিমেড থিম</h3>
        <p class="desc">এক ক্লিকে পুরো সাইটের কালার থিম পরিবর্তন — সেভ না করা পর্যন্ত প্রিভিউ হয়</p>
        <div class="preset-grid" id="presetGrid"></div>
    </div>

    <div class="card">
        <h3>কাস্টম কালার</h3>
        <p class="desc">নিজের পছন্দমতো ব্র্যান্ড রঙ সেট করুন</p>
        <div class="color-row">
            <input type="color" id="cpPrimary" value="#059669">
            <label>প্রাইমারি রঙ</label><code id="hexPrimary">#059669</code>
        </div>
        <div class="color-row">
            <input type="color" id="cpDark" value="#064e3b">
            <label>ডার্ক রঙ (হেডার/ফুটার)</label><code id="hexDark">#064e3b</code>
        </div>
        <div class="color-row">
            <input type="color" id="cpAccent" value="#10b981">
            <label>অ্যাকসেন্ট রঙ</label><code id="hexAccent">#10b981</code>
        </div>
        <button class="a-btn" onclick="applyCustomTheme()"><i class="fa-solid fa-check"></i> কাস্টম থিম প্রয়োগ করুন</button>
        <button class="a-btn warn" onclick="resetTheme()" style="margin-left:8px"><i class="fa-solid fa-rotate-left"></i> ডিফল্টে ফিরুন (Herbal Green)</button>
    </div>

    <style>
        .preset-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 170px), 1fr)); gap: 14px; }
        .preset-card {
            border: 2px solid rgba(5,150,105,.15); border-radius: 14px; padding: 14px;
            cursor: pointer; background: #fff; text-align: left; position: relative;
            font-family: inherit; transition: transform .15s, border .2s, box-shadow .2s;
        }
        .preset-card:hover { transform: translateY(-3px); box-shadow: 0 14px 30px -16px rgba(6,78,59,.4); }
        .preset-card.active { border-color: var(--sc, #059669); }
        .preset-swatches { display: flex; gap: 5px; margin-bottom: 10px; }
        .preset-swatches i { width: 26px; height: 26px; border-radius: 8px; display: block; }
        .preset-card b { font-size: 13.5px; display: block; }
        .preset-card span { font-size: 11px; color: #8b7355; }
    </style>
@endsection

@push('scripts')
    <script>
        var THEMES = {
            herbal: { bn: 'হার্বাল গ্রিন', en: 'Herbal Green', primary: '#059669', hover: '#047857', dark: '#064e3b', xdark: '#022c22', accent: '#10b981', accentLight: '#34d399', lime: '#84cc16', limeNeon: '#a3e635', limeDeep: '#65a30d', teal: '#14b8a6', tealLight: '#5eead4' },
            spice: { bn: 'মসলা অ্যাম্বার', en: 'Spice Amber', primary: '#d97706', hover: '#b45309', dark: '#7c2d12', xdark: '#431407', accent: '#ea580c', accentLight: '#fb923c', lime: '#ca8a04', limeNeon: '#fbbf24', limeDeep: '#a16207', teal: '#dc2626', tealLight: '#fca5a5' },
            chili: { bn: 'চিলি রেড', en: 'Chili Red', primary: '#dc2626', hover: '#b91c1c', dark: '#7f1d1d', xdark: '#450a0a', accent: '#ef4444', accentLight: '#f87171', lime: '#c2410c', limeNeon: '#fb923c', limeDeep: '#9a3412', teal: '#ea580c', tealLight: '#fdba74' },
            mango: { bn: 'ম্যাঙ্গো ফ্রেশ', en: 'Mango Fresh', primary: '#ca8a04', hover: '#a16207', dark: '#713f12', xdark: '#422006', accent: '#eab308', accentLight: '#facc15', lime: '#84cc16', limeNeon: '#a3e635', limeDeep: '#65a30d', teal: '#65a30d', tealLight: '#bef264' },
            jamun: { bn: 'জামুন পার্পল', en: 'Jamun Purple', primary: '#7c3aed', hover: '#6d28d9', dark: '#4c1d95', xdark: '#2e1065', accent: '#8b5cf6', accentLight: '#a78bfa', lime: '#c026d3', limeNeon: '#e879f9', limeDeep: '#a21caf', teal: '#9333ea', tealLight: '#d8b4fe' },
            neel: { bn: 'নীল ব্লু', en: 'Neel Blue', primary: '#2563eb', hover: '#1d4ed8', dark: '#1e3a8a', xdark: '#172554', accent: '#3b82f6', accentLight: '#60a5fa', lime: '#0891b2', limeNeon: '#22d3ee', limeDeep: '#0e7490', teal: '#0ea5e9', tealLight: '#7dd3fc' }
        };

        var currentTheme = @json(\App\Models\Setting::get('theme_id', 'herbal'));
        var grid = document.getElementById('presetGrid');

        Object.keys(THEMES).forEach(function (id) {
            var t = THEMES[id];
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'preset-card' + (currentTheme === id ? ' active' : '');
            btn.innerHTML =
                '<div class="preset-swatches">' +
                '<i style="background:' + t.primary + '"></i>' +
                '<i style="background:' + t.accent + '"></i>' +
                '<i style="background:' + t.dark + '"></i>' +
                '<i style="background:' + t.limeNeon + '"></i>' +
                '</div><b>' + t.bn + '</b><span>' + t.en + '</span>';
            btn.onclick = function () {
                // preview instantly
                var s = document.documentElement.style;
                s.setProperty('--ds-primary', t.primary);
                s.setProperty('--ds-primary-hover', t.hover);
                s.setProperty('--ds-primary-dark', t.dark);
                s.setProperty('--ds-accent', t.accent);
                // save to server
                var fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fd.append('theme_id', id);
                fd.append('theme_json', JSON.stringify(t));
                fetch('{{ route('admin.settings.theme.save') }}', { method: 'POST', body: fd })
                    .then(function (r) { if (!r.ok) throw 0; showToast('"' + t.bn + '" থিম প্রয়োগ ও সেভ হয়েছে'); window.location.reload(); });
            };
            grid.appendChild(btn);
        });

        var cpP = document.getElementById('cpPrimary');
        var cpD = document.getElementById('cpDark');
        var cpA = document.getElementById('cpAccent');
        cpP.addEventListener('input', function () { document.getElementById('hexPrimary').textContent = this.value; });
        cpD.addEventListener('input', function () { document.getElementById('hexDark').textContent = this.value; });
        cpA.addEventListener('input', function () { document.getElementById('hexAccent').textContent = this.value; });

        function applyCustomTheme() {
            var fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('primary', cpP.value);
            fd.append('dark', cpD.value);
            fd.append('accent', cpA.value);
            fetch('{{ route('admin.settings.theme.custom') }}', { method: 'POST', body: fd })
                .then(function (r) { if (!r.ok) throw 0; showToast('কাস্টম থিম প্রয়োগ হয়েছে — ল্যান্ডিং পেজে দেখুন!'); window.location.reload(); });
        }
        function resetTheme() {
            var fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fetch('{{ route('admin.settings.theme.reset') }}', { method: 'POST', body: fd })
                .then(function (r) { if (!r.ok) throw 0; showToast('ডিফল্ট থিমে ফিরে গেছে'); window.location.reload(); });
        }
    </script>
@endpush
