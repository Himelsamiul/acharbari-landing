@extends('layouts.admin')

@section('title', 'থিম ও কালার')
@section('page_title', 'থিম ও কালার')
@section('page_sub', 'পুরো ওয়েবসাইটের ডিজাইন থিম পরিবর্তন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-palette"></i>
        <span>থিম সেভ করলে পুরো ওয়েবসাইটের রঙ বদলে যাবে — ল্যান্ডিং পেজে সাথে সাথেই প্রয়োগ হবে।</span>
    </div>

    {{-- ===== LIVE LANDING PREVIEW ===== --}}
    <div class="card">
        <div class="lp-prev-head">
            <h3>লাইভ প্রিভিউ</h3>
            <div class="lp-prev-devices">
                <button type="button" class="a-btn ghost lp-dev-btn active" data-w="desktop" onclick="setPrevWidth(this)"><i class="fa-solid fa-desktop"></i> ডেস্কটপ</button>
                <button type="button" class="a-btn ghost lp-dev-btn" data-w="mobile" onclick="setPrevWidth(this)"><i class="fa-solid fa-mobile-screen"></i> মোবাইল</button>
            </div>
        </div>
        <p class="desc">নিচের প্রিভিউতে আসল ল্যান্ডিং পেজ দেখা যায় — রঙ বা থিম বদলালেই সাথে সাথে বদলে যায়। পছন্দ হলে তবেই সেভ/প্রয়োগ করুন।</p>
        <div class="lp-prev-frame" id="prevFrameWrap">
            <iframe id="landingPreview" src="{{ url('/') }}" title="ল্যান্ডিং প্রিভিউ" loading="lazy"></iframe>
        </div>
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

        /* live landing preview */
        .lp-prev-head { display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; }
        .lp-prev-head h3 { margin: 0; }
        .lp-prev-devices { display: flex; gap: 8px; }
        .lp-dev-btn { padding: 8px 14px; font-size: 12.5px; }
        .lp-dev-btn.active { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border-color: transparent; }
        .lp-prev-frame {
            margin-top: 12px; border: 1.5px solid rgba(5,150,105,.22); border-radius: 16px;
            overflow: hidden; background: #f6faf8; transition: max-width .3s ease;
        }
        .lp-prev-frame iframe { display: block; width: 100%; height: 560px; border: 0; background: #fff; }
        .lp-prev-frame.mobile { max-width: 402px; margin-left: auto; margin-right: auto; }
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

        /* ---------- live landing preview (same-origin iframe) ---------- */
        var lastPreview = null;

        function rgbTriplet(hex) {
            var h = String(hex).replace('#', '');
            if (h.length === 3) h = h[0] + h[0] + h[1] + h[1] + h[2] + h[2];
            var n = parseInt(h, 16);
            return ((n >> 16) & 255) + ', ' + ((n >> 8) & 255) + ', ' + (n & 255);
        }

        /* exact JS port of ThemeLibrary::shade() so preview == saved result */
        function shade(hex, pct) {
            var h = String(hex).replace('#', '');
            if (h.length === 3) h = h[0] + h[0] + h[1] + h[1] + h[2] + h[2];
            var n = parseInt(h, 16), target = pct > 0 ? 255 : 0, p = Math.abs(pct);
            function mix(c) { return Math.round(c + (target - c) * p); }
            function hx(v) { return ('0' + v.toString(16)).slice(-2); }
            return '#' + hx(mix((n >> 16) & 255)) + hx(mix((n >> 8) & 255)) + hx(mix(n & 255));
        }

        /* exact JS port of ThemeLibrary::custom() */
        function deriveTheme(primary, dark, accent) {
            return {
                primary: primary, hover: shade(primary, -0.14), dark: dark, xdark: shade(dark, -0.28),
                accent: accent, accentLight: shade(accent, 0.32),
                lime: shade(primary, 0.18), limeNeon: shade(accent, 0.4), limeDeep: shade(primary, -0.2),
                teal: shade(accent, -0.12), tealLight: shade(accent, 0.5)
            };
        }

        function previewVars(t) {
            lastPreview = t;
            try {
                var doc = document.getElementById('landingPreview').contentDocument;
                if (!doc || !doc.documentElement) return;
                var s = doc.documentElement.style;
                s.setProperty('--ds-primary', t.primary);
                s.setProperty('--ds-primary-hover', t.hover);
                s.setProperty('--ds-primary-dark', t.dark);
                s.setProperty('--ds-primary-xdark', t.xdark);
                s.setProperty('--ds-accent', t.accent);
                s.setProperty('--ds-accent-light', t.accentLight);
                s.setProperty('--ds-lime', t.lime);
                s.setProperty('--ds-lime-neon', t.limeNeon);
                s.setProperty('--ds-lime-deep', t.limeDeep);
                s.setProperty('--ds-teal', t.teal);
                s.setProperty('--ds-teal-light', t.tealLight);
                s.setProperty('--ds-primary-rgb', rgbTriplet(t.primary));
                s.setProperty('--ds-primary-dark-rgb', rgbTriplet(t.dark));
                s.setProperty('--ds-primary-xdark-rgb', rgbTriplet(t.xdark));
                s.setProperty('--ds-accent-rgb', rgbTriplet(t.accent));
                s.setProperty('--ds-lime-rgb', rgbTriplet(t.lime));
                s.setProperty('--ds-lime-neon-rgb', rgbTriplet(t.limeNeon));
                s.setProperty('--ds-teal-rgb', rgbTriplet(t.teal));
            } catch (e) { /* cross-origin or not ready — ignore */ }
        }

        /* drop inline overrides -> iframe falls back to its saved (DB) theme */
        function restorePreview() {
            lastPreview = null;
            try {
                var doc = document.getElementById('landingPreview').contentDocument;
                if (!doc || !doc.documentElement) return;
                var s = doc.documentElement.style;
                ['--ds-primary', '--ds-primary-hover', '--ds-primary-dark', '--ds-primary-xdark',
                 '--ds-accent', '--ds-accent-light', '--ds-lime', '--ds-lime-neon', '--ds-lime-deep',
                 '--ds-teal', '--ds-teal-light', '--ds-primary-rgb', '--ds-primary-dark-rgb',
                 '--ds-primary-xdark-rgb', '--ds-accent-rgb', '--ds-lime-rgb', '--ds-lime-neon-rgb',
                 '--ds-teal-rgb'].forEach(function (k) { s.removeProperty(k); });
            } catch (e) { }
        }

        /* re-apply pending preview when the iframe finishes (re)loading */
        document.getElementById('landingPreview').addEventListener('load', function () {
            if (lastPreview) previewVars(lastPreview);
        });

        function setPrevWidth(btn) {
            document.querySelectorAll('.lp-dev-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            document.getElementById('prevFrameWrap').classList.toggle('mobile', btn.dataset.w === 'mobile');
        }

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
            btn.addEventListener('mouseenter', function () { previewVars(t); });
            btn.addEventListener('mouseleave', restorePreview);
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

        function livePreviewCustom() {
            previewVars(deriveTheme(cpP.value, cpD.value, cpA.value));
        }
        cpP.addEventListener('input', function () { document.getElementById('hexPrimary').textContent = this.value; livePreviewCustom(); });
        cpD.addEventListener('input', function () { document.getElementById('hexDark').textContent = this.value; livePreviewCustom(); });
        cpA.addEventListener('input', function () { document.getElementById('hexAccent').textContent = this.value; livePreviewCustom(); });

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
