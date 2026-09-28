@extends('layouts.admin')

@section('title', 'লোগো ও ব্র্যান্ড')
@section('page_title', 'লোগো ও ব্র্যান্ড')
@section('page_sub', 'লোগো আপলোড ও ব্র্যান্ডের নাম পরিবর্তন')

@section('content')
    @if (isset($errors) && $errors->any())
        <div class="alert-success brand-errors" style="background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.3);color:#dc2626">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <b>এগুলো ঠিক করে আবার সেভ করুন:</b>
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="note-banner">
        <i class="fa-solid fa-wand-magic-sparkles"></i>
        <span>লোগো, ব্র্যান্ডের নাম বা যোগাযোগের তথ্য বদলালে <b>সাথে সাথে</b> ল্যান্ডিং পেজে দেখা যাবে। যোগাযোগের ঘর <b>খালি রাখলে</b> সাইটের ডিফল্ট নম্বর ব্যবহার হবে।</span>
    </div>

    <div class="brand-grid-top">
        {{-- ===== LOGO ===== --}}
        <div class="card brand-card">
            <h3><span class="brand-ic" style="--bc:#059669"><i class="fa-solid fa-image"></i></span> ওয়েবসাইট লোগো</h3>
            <p class="desc">হেডার ও ফুটারে দেখা যায় (PNG/JPG/SVG — স্কয়ার সাইজ ভালো)</p>
            <form method="POST" action="{{ route('admin.settings.brand.save') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="remove_logo" value="0" id="removeLogoFlag">
                <div class="logo-upload-row">
                    <div class="logo-preview" id="logoPreview">
                        @if (!empty($settings['logo_path']))
                            <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                        @else
                            <i class="fa-solid fa-jar"></i>
                        @endif
                    </div>
                    <div class="logo-actions">
                        <input type="file" name="logo" id="logoFile" accept="image/*" style="display:none" onchange="previewLogo(this)">
                        <button type="button" class="a-btn" onclick="document.getElementById('logoFile').click()">
                            <i class="fa-solid fa-upload"></i> আপলোড
                        </button>
                        @if (!empty($settings['logo_path']))
                            <button type="button" class="a-btn ghost" onclick="removeLogo()">
                                <i class="fa-solid fa-rotate-left"></i> ডিফল্টে ফিরুন
                            </button>
                        @endif
                        <button type="submit" class="a-btn" id="logoSaveBtn" hidden>
                            <i class="fa-solid fa-floppy-disk"></i> সেভ
                        </button>
                        <p class="brand-hint">সর্বোচ্চ 2MB • JPG/PNG/SVG</p>
                    </div>
                </div>
            </form>
            <p class="desc" style="margin-top:12px;margin-bottom:0">✨ <a href="{{ route('admin.settings.theme') }}"><b>থিম ও কালার</b></a> পেজে গিয়ে লোগোর রঙ থেকে এক ক্লিকে পুরো থিম বানাতে পারবেন।</p>
        </div>

        {{-- ===== FAVICON ===== --}}
        <div class="card brand-card">
            <h3><span class="brand-ic" style="--bc:#7c3aed"><i class="fa-solid fa-window-restore"></i></span> ফেভিকন</h3>
            <p class="desc">ব্রাউজার ট্যাবের আইকন (স্কয়ার — PNG/SVG/ICO)</p>
            <form method="POST" action="{{ route('admin.settings.brand.save') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="remove_favicon" value="0" id="removeFaviconFlag">
                <div class="logo-upload-row">
                    <div class="logo-preview" id="faviconPreview">
                        @if (!empty($settings['favicon_path']))
                            <img src="{{ asset($settings['favicon_path']) }}" alt="favicon">
                        @else
                            <img src="{{ asset('assets/img/favicon.svg') }}" alt="default favicon" style="opacity:.55">
                        @endif
                    </div>
                    <div class="logo-actions">
                        <input type="file" name="favicon" id="faviconFile" accept="image/*" style="display:none" onchange="previewFavicon(this)">
                        <button type="button" class="a-btn" onclick="document.getElementById('faviconFile').click()">
                            <i class="fa-solid fa-upload"></i> আপলোড
                        </button>
                        @if (!empty($settings['favicon_path']))
                            <button type="button" class="a-btn ghost" onclick="removeFavicon()">
                                <i class="fa-solid fa-rotate-left"></i> ডিফল্টে ফিরুন
                            </button>
                        @endif
                        <button type="submit" class="a-btn" id="faviconSaveBtn" hidden>
                            <i class="fa-solid fa-floppy-disk"></i> সেভ
                        </button>
                        <p class="brand-hint">সর্বোচ্চ 1MB • PNG/SVG/ICO/JPG</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== ব্র্যান্ড নাম + যোগাযোগ: একটাই ফর্ম ===== --}}
    <form method="POST" action="{{ route('admin.settings.brand.save') }}" id="brandMainForm">
        @csrf
        <div class="card brand-card">
            <h3><span class="brand-ic" style="--bc:#d97706"><i class="fa-solid fa-spell-check"></i></span> ব্র্যান্ডের নাম</h3>
            <p class="desc">লোগোর পাশের টেক্সট — প্রথম অংশ সাধারণ, দ্বিতীয় অংশ অ্যাকসেন্ট রঙে দেখায় • লিখতে লিখতেই নিচের প্রিভিউ বদলাবে</p>

            {{-- হেডার মকআপ: সাইটে যেভাবে দেখাবে --}}
            <div class="header-mock">
                <span class="hm-logo" id="hmLogo">
                    @if (!empty($settings['logo_path']))
                        <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                    @else
                        <i class="fa-solid fa-jar"></i>
                    @endif
                </span>
                <span class="hm-name"><b id="hmName1">{{ $settings['brand_bn1'] ?? 'আচার' }}</b><b id="hmName2" class="hm-accent">{{ $settings['brand_bn2'] ?? 'বাড়ি' }}</b></span>
                <span class="hm-pill">হোম</span>
                <span class="hm-pill hm-ghost">মেনু</span>
                <span class="hm-btn">অর্ডার করুন</span>
                <small>← হেডারে এভাবে দেখাবে (লাইভ)</small>
            </div>

            <div class="brand-preview-strip">
                <span class="bp-part" id="bpBn1">{{ $settings['brand_bn1'] ?? 'আচার' }}</span><span class="bp-part accent" id="bpBn2">{{ $settings['brand_bn2'] ?? 'বাড়ি' }}</span>
                <small>বাংলা</small>
            </div>
            <div class="brand-preview-strip">
                <span class="bp-part bp-en" id="bpEn1">{{ $settings['brand_en1'] ?? 'Achar' }}</span><span class="bp-part accent bp-en" id="bpEn2">{{ $settings['brand_en2'] ?? 'Bari' }}</span>
                <small>English</small>
            </div>

            <div class="brand-grid">
                <div class="a-field @error('brand_bn1') field-error @enderror">
                    <label>বাংলা নাম — প্রথম অংশ *</label>
                    {{-- required server-e check hoy: logo thakle name lage na --}}
                    <input class="a-input" name="brand_bn1" id="inBrandBn1" maxlength="20" value="{{ old('brand_bn1', $settings['brand_bn1'] ?? 'আচার') }}" data-live="bpBn1">
                    @error('brand_bn1')<small class="field-err-msg">{{ $message }}</small>@enderror
                </div>
                <div class="a-field @error('brand_bn2') field-error @enderror">
                    <label>বাংলা নাম — দ্বিতীয় অংশ (রঙিন)</label>
                    <input class="a-input" name="brand_bn2" id="inBrandBn2" maxlength="20" value="{{ old('brand_bn2', $settings['brand_bn2'] ?? 'বাড়ি') }}" data-live="bpBn2" data-live2="hmName2">
                    @error('brand_bn2')<small class="field-err-msg">{{ $message }}</small>@enderror
                </div>
                <div class="a-field @error('brand_en1') field-error @enderror">
                    <label>English — Part 1 *</label>
                    <input class="a-input" name="brand_en1" id="inBrandEn1" maxlength="20" value="{{ old('brand_en1', $settings['brand_en1'] ?? 'Achar') }}" data-live="bpEn1">
                    @error('brand_en1')<small class="field-err-msg">{{ $message }}</small>@enderror
                </div>
                <div class="a-field @error('brand_en2') field-error @enderror">
                    <label>English — Part 2 (Accent)</label>
                    <input class="a-input" name="brand_en2" id="inBrandEn2" maxlength="20" value="{{ old('brand_en2', $settings['brand_en2'] ?? 'Bari') }}" data-live="bpEn2">
                    @error('brand_en2')<small class="field-err-msg">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="card brand-card">
            <h3><span class="brand-ic" style="--bc:#0ea5e9"><i class="fa-solid fa-address-book"></i></span> যোগাযোগের তথ্য</h3>
            <p class="desc">ফুটার, চ্যাট উইজেট ও কল-টু-অ্যাকশনে ব্যবহৃত হয় • খালি রাখলে ডিফল্ট নম্বর কাজ করবে • লিখার সময়ই ভুল ধরা পড়বে</p>
            <div class="brand-grid">
                <div class="a-field @error('contact_phone') field-error @enderror">
                    <label><i class="fa-solid fa-phone contact-ic"></i> হটলাইন ফোন</label>
                    <input class="a-input" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" placeholder="01XXXXXXXXX" data-validate="phone">
                    <small class="val-status"></small>
                    @error('contact_phone')<small class="field-err-msg">{{ $message }}</small>@enderror
                </div>
                <div class="a-field @error('contact_whatsapp') field-error @enderror">
                    <label><i class="fa-brands fa-whatsapp contact-ic wa"></i> WhatsApp — নম্বর বা পুরো লিংক</label>
                    <input class="a-input" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '') }}" placeholder="01XXXXXXXXX অথবা https://wa.me/01XXXXXXXXX" data-validate="wa">
                    <small class="val-status"></small>
                    @error('contact_whatsapp')<small class="field-err-msg">{{ $message }}</small>@enderror
                </div>
                <div class="a-field @error('contact_messenger') field-error @enderror">
                    <label><i class="fa-brands fa-facebook-messenger contact-ic ms"></i> Messenger — ইউজারনেম বা লিংক</label>
                    <input class="a-input" name="contact_messenger" value="{{ old('contact_messenger', $settings['contact_messenger'] ?? '') }}" placeholder="পেজের ইউজারনেম অথবা https://m.me/username" data-validate="ms">
                    <small class="val-status"></small>
                    @error('contact_messenger')<small class="field-err-msg">{{ $message }}</small>@enderror
                </div>
                <div class="a-field @error('contact_facebook') field-error @enderror">
                    <label><i class="fa-brands fa-facebook contact-ic fb"></i> Facebook পেজ URL</label>
                    <input class="a-input" name="contact_facebook" value="{{ old('contact_facebook', $settings['contact_facebook'] ?? '') }}" placeholder="https://facebook.com/yourpage" data-validate="fb">
                    <small class="val-status"></small>
                    @error('contact_facebook')<small class="field-err-msg">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="brand-savebar">
            <button class="a-btn" style="padding:12px 28px">
                <i class="fa-solid fa-floppy-disk"></i> ব্র্যান্ড ও যোগাযোগ সেভ করুন
            </button>
            <span class="brand-savehint">উপরের দুই কার্ড একসাথে সেভ হয় • পেজ স্ক্রল করলেও বাটন চোখের সামনে থাকবে</span>
        </div>
    </form>

    <style>
        .brand-card { margin-bottom: 18px; }
        .brand-card h3 { display: flex; align-items: center; gap: 10px; }
        .brand-ic {
            width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
            display: grid; place-items: center; font-size: 14px;
            background: color-mix(in srgb, var(--bc, #059669) 12%, white);
            color: var(--bc, #059669);
        }
        .brand-grid-top { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; align-items: start; margin-bottom: 18px; }
        .logo-upload-row { display: flex; gap: 16px; align-items: center; }
        .logo-preview {
            width: 96px; height: 96px; flex-shrink: 0; border-radius: 14px;
            border: 2px dashed rgba(5, 150, 105, .35); background: rgba(5, 150, 105, .03);
            display: grid; place-items: center; overflow: hidden; color: rgba(5, 150, 105, .4); font-size: 30px;
        }
        .logo-preview img { width: 100%; height: 100%; object-fit: contain; padding: 6px; box-sizing: border-box; border-radius: 12px; background: #fff; }
        .logo-actions { display: flex; flex-direction: column; gap: 8px; align-items: flex-start; }
        .brand-hint { font-size: 11.5px; color: #8b7355; margin: 4px 0 0; }
        .brand-preview-strip {
            display: flex; align-items: baseline; gap: 2px; margin-bottom: 10px;
            background: rgba(5, 150, 105, .04); border: 1px solid rgba(5, 150, 105, .12);
            border-radius: 12px; padding: 12px 18px;
        }
        .bp-part { font-size: 22px; font-weight: 800; color: #12261d; }
        .bp-part.accent { color: #059669; }
        .bp-part.bp-en { font-size: 18px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .brand-preview-strip small { color: #8b7355; font-size: 11.5px; margin-left: auto; }

        /* header mockup — সাইটের হেডারের মতো দেখায় */
        .header-mock {
            display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
            background: linear-gradient(135deg, var(--ds-primary-dark, #064e3b), var(--ds-primary-xdark, #022c22));
            border-radius: 14px; padding: 14px 18px; margin-bottom: 14px;
        }
        .hm-logo {
            width: 34px; height: 34px; border-radius: 10px; overflow: hidden; flex-shrink: 0;
            background: rgba(255,255,255,.12); display: grid; place-items: center; color: #fff; font-size: 15px;
        }
        .hm-logo img { width: 100%; height: 100%; object-fit: contain; padding: 2px; box-sizing: border-box; }
        .hm-name b { font-size: 17px; font-weight: 800; color: #fff; }
        .hm-name .hm-accent { color: var(--ds-accent-light, #34d399); }
        .hm-pill {
            font-size: 11px; color: #d1fae5; background: rgba(255,255,255,.1);
            padding: 5px 12px; border-radius: 999px;
        }
        .hm-pill.hm-ghost { opacity: .5; }
        .hm-btn {
            font-size: 11px; font-weight: 700; color: #064e3b;
            background: linear-gradient(135deg, var(--ds-lime-neon, #a3e635), var(--ds-accent-light, #34d399));
            padding: 6px 13px; border-radius: 999px;
        }
        .header-mock small { color: rgba(255,255,255,.55); font-size: 11px; margin-left: auto; }

        .contact-ic { width: 20px; text-align: center; color: #059669; }
        .contact-ic.wa { color: #16a34a; }
        .contact-ic.ms { color: #0ea5e9; }
        .contact-ic.fb { color: #2563eb; }

        /* per-field errors + live validation */
        .field-error .a-input { border-color: #dc2626 !important; background: rgba(220,38,38,.04); }
        .field-err-msg { display: block; color: #dc2626; font-size: 11.5px; margin-top: 4px; font-weight: 600; }
        .val-status { display: block; font-size: 11.5px; margin-top: 4px; font-weight: 600; min-height: 14px; }
        .val-status.ok { color: #16a34a; }
        .val-status.bad { color: #dc2626; }
        .brand-errors ul { margin: 6px 0 0; padding-left: 18px; }
        .brand-errors li { font-size: 12.5px; }

        /* sticky save bar */
        .brand-savebar {
            display: flex; gap: 12px; align-items: center; flex-wrap: wrap;
            position: sticky; bottom: 12px; background: #fff;
            border: 1px solid rgba(5, 150, 105, .2); border-radius: 14px;
            padding: 12px 18px; box-shadow: 0 18px 40px -18px rgba(6, 78, 59, .45); z-index: 5;
        }
        .brand-savehint { font-size: 12px; color: #8b7355; }
        @media (max-width: 860px) {
            .brand-grid-top { grid-template-columns: 1fr; }
        }
    </style>
@endsection

@push('scripts')
    <script>
        var BRAND_SAVE_URL = '{{ route('admin.settings.brand.save') }}';

        /* ---------- logo / favicon preview + size check ---------- */

        function fileSizeFail(input, limitMb) {
            var f = input.files && input.files[0];
            if (f && f.size > limitMb * 1024 * 1024) {
                showToast('ছবিটা খুব বড় — সর্বোচ্চ ' + limitMb + 'MB দিন (এখন ' + (f.size / 1048576).toFixed(1) + 'MB)');
                input.value = '';
                return true;
            }
            return false;
        }

        function previewLogo(input) {
            if (fileSizeFail(input, 2)) return;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('logoPreview').innerHTML = '<img src="' + e.target.result + '">';
                    var hm = document.getElementById('hmLogo');
                    if (hm) hm.innerHTML = '<img src="' + e.target.result + '">';
                };
                reader.readAsDataURL(input.files[0]);
                document.getElementById('logoSaveBtn').hidden = false;
            }
        }
        function removeLogo() {
            document.getElementById('removeLogoFlag').value = '1';
            var f = document.createElement('form');
            f.method = 'POST';
            f.action = BRAND_SAVE_URL;
            var t = document.createElement('input');
            t.type = 'hidden'; t.name = '_token'; t.value = '{{ csrf_token() }}';
            var r = document.createElement('input');
            r.type = 'hidden'; r.name = 'remove_logo'; r.value = '1';
            f.appendChild(t); f.appendChild(r);
            document.body.appendChild(f);
            f.submit();
        }
        function previewFavicon(input) {
            if (fileSizeFail(input, 1)) return;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('faviconPreview').innerHTML = '<img src="' + e.target.result + '">';
                };
                reader.readAsDataURL(input.files[0]);
                document.getElementById('faviconSaveBtn').hidden = false;
                showToast('এখন "সেভ" চাপুন — তাহলেই ফেভিকন বসবে');
            }
        }
        function removeFavicon() {
            document.getElementById('removeFaviconFlag').value = '1';
            var f = document.createElement('form');
            f.method = 'POST';
            f.action = BRAND_SAVE_URL;
            var t = document.createElement('input');
            t.type = 'hidden'; t.name = '_token'; t.value = '{{ csrf_token() }}';
            var r = document.createElement('input');
            r.type = 'hidden'; r.name = 'remove_favicon'; r.value = '1';
            f.appendChild(t); f.appendChild(r);
            document.body.appendChild(f);
            f.submit();
        }

        /* ---------- live brand-name preview (bn + en + header mock) ---------- */

        document.querySelectorAll('[data-live]').forEach(function (inp) {
            inp.addEventListener('input', function () {
                var el = document.getElementById(inp.dataset.live);
                if (el) el.textContent = inp.value;
                if (inp.dataset.live2) {
                    var el2 = document.getElementById(inp.dataset.live2);
                    if (el2) el2.textContent = inp.value;
                }
                if (inp.id === 'inBrandBn1') document.getElementById('hmName1').textContent = inp.value;
                if (inp.id === 'inBrandBn2') document.getElementById('hmName2').textContent = inp.value;
            });
        });

        /* ---------- real-time contact validation ---------- */

        var VALIDATORS = {
            phone: function (v) {
                if (!v) return [true, 'খালি রাখলে ডিফল্ট নম্বর চলবে'];
                return [/^01[3-9]\d{8}$/.test(v), '১১ ডিজিটের মোবাইল নম্বর দিন (যেমন: 01712345678)'];
            },
            wa: function (v) {
                if (!v) return [true, 'খালি রাখলে ফোন নম্বরটাই চলবে'];
                if (/^https?:\/\/.+/i.test(v)) return [true, 'লিংক ঠিক আছে'];
                return [/^01[3-9]\d{8}$/.test(v), '১১ ডিজিটের নম্বর অথবা পুরো লিংক দিন'];
            },
            ms: function (v) {
                if (!v) return [true, ''];
                if (/^https?:\/\/.+/i.test(v)) return [true, 'লিংক ঠিক আছে'];
                return [/^[A-Za-z0-9._-]{3,}$/.test(v), 'ইউজারনেম (স্পেস ছাড়া) অথবা পুরো লিংক দিন'];
            },
            fb: function (v) {
                if (!v) return [true, 'খালি রাখলে ফুটারে ফেসবুক দেখাবে না'];
                return [/^https:\/\/.+/i.test(v), 'https:// সহ পুরো লিংক দিন (যেমন: https://facebook.com/yourpage)'];
            }
        };

        document.querySelectorAll('[data-validate]').forEach(function (inp) {
            var status = inp.parentNode.querySelector('.val-status');
            inp.addEventListener('input', function () {
                var res = VALIDATORS[inp.dataset.validate](inp.value.trim());
                if (res[0]) {
                    status.textContent = inp.value.trim() ? '✓ ' + res[1] : res[1];
                    status.className = 'val-status' + (inp.value.trim() ? ' ok' : '');
                    inp.style.borderColor = inp.value.trim() ? '#16a34a' : '';
                } else {
                    status.textContent = '✕ ' + res[1];
                    status.className = 'val-status bad';
                    inp.style.borderColor = '#dc2626';
                }
            });
            inp.dispatchEvent(new Event('input'));
        });
    </script>
@endpush
