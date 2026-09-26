@extends('layouts.admin')

@section('title', 'লোগো ও ব্র্যান্ড')
@section('page_title', 'লোগো ও ব্র্যান্ড')
@section('page_sub', 'লোগো আপলোড ও ব্র্যান্ডের নাম পরিবর্তন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-wand-magic-sparkles"></i>
        <span>লোগো, ব্র্যান্ডের নাম বা যোগাযোগের তথ্য বদলালে <b>সাথে সাথে</b> ল্যান্ডিং পেজে দেখা যাবে।</span>
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
                        <button type="button" class="a-btn ghost" onclick="removeLogo()">
                            <i class="fa-solid fa-rotate-left"></i> ডিফল্টে ফিরুন
                        </button>
                        <button type="submit" class="a-btn" id="logoSaveBtn" hidden>
                            <i class="fa-solid fa-floppy-disk"></i> সেভ
                        </button>
                        <p class="brand-hint">সর্বোচ্চ 2MB • JPG/PNG/SVG</p>
                    </div>
                </div>
            </form>
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
                        <p class="brand-hint">সর্বোচ্চ 1MB • PNG/SVG/ICO/JPG</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== BRAND NAME ===== --}}
    <div class="card brand-card">
        <h3><span class="brand-ic" style="--bc:#d97706"><i class="fa-solid fa-spell-check"></i></span> ব্র্যান্ডের নাম</h3>
        <p class="desc">লোগোর পাশের টেক্সট — প্রথম অংশ সাধারণ, দ্বিতীয় অংশ অ্যাকসেন্ট রঙে দেখায়</p>
        <div class="brand-preview-strip">
            <span class="bp-part">{{ $settings['brand_bn1'] ?? 'আচার' }}</span><span class="bp-part accent">{{ $settings['brand_bn2'] ?? 'বাড়ি' }}</span>
            <small>← এভাবে দেখাবে (লাইভ প্রিভিউ)</small>
        </div>
        <form method="POST" action="{{ route('admin.settings.brand.save') }}">
            @csrf
            <div class="brand-grid">
                <div class="a-field">
                    <label>বাংলা নাম — প্রথম অংশ</label>
                    <input class="a-input" name="brand_bn1" value="{{ $settings['brand_bn1'] ?? 'আচার' }}">
                </div>
                <div class="a-field">
                    <label>বাংলা নাম — দ্বিতীয় অংশ (রঙিন)</label>
                    <input class="a-input" name="brand_bn2" value="{{ $settings['brand_bn2'] ?? 'বাড়ি' }}">
                </div>
                <div class="a-field">
                    <label>English — Part 1</label>
                    <input class="a-input" name="brand_en1" value="{{ $settings['brand_en1'] ?? 'Achar' }}">
                </div>
                <div class="a-field">
                    <label>English — Part 2 (Accent)</label>
                    <input class="a-input" name="brand_en2" value="{{ $settings['brand_en2'] ?? 'Bari' }}">
                </div>
            </div>
            <button class="a-btn"><i class="fa-solid fa-floppy-disk"></i> ব্র্যান্ড নাম সেভ করুন</button>
        </form>
    </div>

    {{-- ===== CONTACT INFO ===== --}}
    <div class="card brand-card">
        <h3><span class="brand-ic" style="--bc:#0ea5e9"><i class="fa-solid fa-address-book"></i></span> যোগাযোগের তথ্য</h3>
        <p class="desc">ফুটার, চ্যাট উইজেট ও কল-টু-অ্যাকশন বাটনে এই নম্বর/লিংকগুলো ব্যবহৃত হয়</p>
        <form method="POST" action="{{ route('admin.settings.brand.save') }}">
            @csrf
            <div class="brand-grid">
                <div class="a-field">
                    <label><i class="fa-solid fa-phone contact-ic"></i> হটলাইন ফোন</label>
                    <input class="a-input" name="contact_phone" value="{{ $settings['contact_phone'] ?? '01707373692' }}" placeholder="01707373692">
                </div>
                <div class="a-field">
                    <label><i class="fa-brands fa-whatsapp contact-ic wa"></i> WhatsApp — নম্বর বা পুরো লিংক</label>
                    <input class="a-input" name="contact_whatsapp" value="{{ $settings['contact_whatsapp'] ?? '8801707373692' }}" placeholder="8801707373692 অথবা https://wa.me/8801707373692">
                </div>
                <div class="a-field">
                    <label><i class="fa-brands fa-facebook-messenger contact-ic ms"></i> Messenger — ইউজারনেম বা লিংক</label>
                    <input class="a-input" name="contact_messenger" value="{{ $settings['contact_messenger'] ?? 'AcharBari' }}" placeholder="AcharBari অথবা https://m.me/AcharBari">
                </div>
                <div class="a-field">
                    <label><i class="fa-brands fa-facebook contact-ic fb"></i> Facebook পেজ URL</label>
                    <input class="a-input" name="contact_facebook" value="{{ $settings['contact_facebook'] ?? '' }}" placeholder="https://facebook.com/yourpage">
                </div>
            </div>
            <button class="a-btn"><i class="fa-solid fa-floppy-disk"></i> যোগাযোগ সেভ করুন</button>
        </form>
    </div>

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
        .logo-preview img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; }
        .logo-actions { display: flex; flex-direction: column; gap: 8px; align-items: flex-start; }
        .brand-hint { font-size: 11.5px; color: #8b7355; margin: 4px 0 0; }
        .brand-preview-strip {
            display: flex; align-items: baseline; gap: 2px; margin-bottom: 16px;
            background: rgba(5, 150, 105, .04); border: 1px solid rgba(5, 150, 105, .12);
            border-radius: 12px; padding: 12px 18px; align-items: center;
        }
        .bp-part { font-size: 22px; font-weight: 800; color: #12261d; }
        .bp-part.accent { color: #059669; }
        .brand-preview-strip small { color: #8b7355; font-size: 11.5px; margin-left: 12px; }
        .contact-ic { width: 20px; text-align: center; color: #059669; }
        .contact-ic.wa { color: #16a34a; }
        .contact-ic.ms { color: #0ea5e9; }
        .contact-ic.fb { color: #2563eb; }
        @media (max-width: 860px) {
            .brand-grid-top { grid-template-columns: 1fr; }
        }
    </style>
@endsection

@push('scripts')
    <script>
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('logoPreview').innerHTML = '<img src="' + e.target.result + '">';
                };
                reader.readAsDataURL(input.files[0]);
                document.getElementById('logoSaveBtn').hidden = false;
            }
        }
        function removeLogo() {
            document.getElementById('removeLogoFlag').value = '1';
            var f = document.createElement('form');
            f.method = 'POST';
            f.action = '{{ route('admin.settings.brand.save') }}';
            var t = document.createElement('input');
            t.type = 'hidden'; t.name = '_token'; t.value = '{{ csrf_token() }}';
            var r = document.createElement('input');
            r.type = 'hidden'; r.name = 'remove_logo'; r.value = '1';
            f.appendChild(t); f.appendChild(r);
            document.body.appendChild(f);
            f.submit();
        }
        function previewFavicon(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('faviconPreview').innerHTML = '<img src="' + e.target.result + '">';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function removeFavicon() {
            document.getElementById('removeFaviconFlag').value = '1';
            var f = document.createElement('form');
            f.method = 'POST';
            f.action = '{{ route('admin.settings.brand.save') }}';
            var t = document.createElement('input');
            t.type = 'hidden'; t.name = '_token'; t.value = '{{ csrf_token() }}';
            var r = document.createElement('input');
            r.type = 'hidden'; r.name = 'remove_favicon'; r.value = '1';
            f.appendChild(t); f.appendChild(r);
            document.body.appendChild(f);
            f.submit();
        }
    </script>
@endpush
