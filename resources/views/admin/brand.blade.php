@extends('layouts.admin')

@section('title', 'লোগো ও ব্র্যান্ড')
@section('page_title', 'লোগো ও ব্র্যান্ড')
@section('page_sub', 'লোগো আপলোড ও ব্র্যান্ডের নাম পরিবর্তন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-wand-magic-sparkles"></i>
        <span>লোগো বা ব্র্যান্ডের নাম পরিবর্তন করে সেভ করুন — ল্যান্ডিং পেজে <b>সাথে সাথে</b> পরিবর্তন দেখা যাবে।</span>
    </div>

    {{-- ===== LOGO ===== --}}
    <div class="card">
        <h3>ওয়েবসাইট লোগো</h3>
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
                <div>
                    <input type="file" name="logo" id="logoFile" accept="image/*" style="display:none" onchange="previewLogo(this)">
                    <button type="button" class="a-btn" onclick="document.getElementById('logoFile').click()">
                        <i class="fa-solid fa-upload"></i> নতুন লোগো আপলোড
                    </button>
                    <button type="button" class="a-btn ghost" style="margin-left:8px" onclick="removeLogo()">
                        <i class="fa-solid fa-rotate-left"></i> ডিফল্টে ফিরুন
                    </button>
                    <button type="submit" class="a-btn" style="margin-left:8px" id="logoSaveBtn" hidden>
                        <i class="fa-solid fa-floppy-disk"></i> সেভ করুন
                    </button>
                    <p style="font-size:11.5px;color:#8b7355;margin:10px 0 0">সর্বোচ্চ 2MB • JPG/PNG/SVG</p>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== FAVICON ===== --}}
    <div class="card">
        <h3>ফেভিকন (ব্রাউজার ট্যাবের আইকন)</h3>
        <p class="desc">ব্রাউজার ট্যাব ও বুকমার্কে দেখায় (স্কয়ার সাইজ — PNG/SVG/ICO ভালো)</p>
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
                <div>
                    <input type="file" name="favicon" id="faviconFile" accept="image/*" style="display:none" onchange="previewFavicon(this)">
                    <button type="button" class="a-btn" onclick="document.getElementById('faviconFile').click()">
                        <i class="fa-solid fa-upload"></i> নতুন ফেভিকন আপলোড
                    </button>
                    @if (!empty($settings['favicon_path']))
                        <button type="button" class="a-btn ghost" style="margin-left:8px" onclick="removeFavicon()">
                            <i class="fa-solid fa-rotate-left"></i> ডিফল্টে ফিরুন
                        </button>
                    @endif
                    <p style="font-size:11.5px;color:#8b7355;margin:10px 0 0">সর্বোচ্চ 1MB • PNG/SVG/ICO/JPG</p>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== BRAND NAME ===== --}}
    <div class="card">
        <h3>ব্র্যান্ডের নাম</h3>
        <p class="desc">লোগোর পাশের টেক্সট — প্রথম অংশ সাধারণ, দ্বিতীয় অংশ অ্যাকসেন্ট রঙে দেখায়</p>
        <form method="POST" action="{{ route('admin.settings.brand.save') }}">
            @csrf
            <div class="brand-grid">
                <div class="a-field">
                    <label>বাংলা নাম — প্রথম অংশ</label>
                    <input class="a-input" name="brand_bn1" value="{{ $settings['brand_bn1'] ?? 'আচার' }}">
                </div>
                <div class="a-field">
                    <label>বাংলা নাম — দ্বিতীয় অংশ</label>
                    <input class="a-input" name="brand_bn2" value="{{ $settings['brand_bn2'] ?? 'বাড়ি' }}">
                </div>
                <div class="a-field">
                    <label>English — Part 1</label>
                    <input class="a-input" name="brand_en1" value="{{ $settings['brand_en1'] ?? 'Achar' }}">
                </div>
                <div class="a-field">
                    <label>English — Part 2</label>
                    <input class="a-input" name="brand_en2" value="{{ $settings['brand_en2'] ?? 'Bari' }}">
                </div>
            </div>
            <button class="a-btn"><i class="fa-solid fa-floppy-disk"></i> ব্র্যান্ড সেভ করুন</button>
        </form>
    </div>

    {{-- ===== CONTACT INFO ===== --}}
    <div class="card">
        <h3>যোগাযোগ তথ্য</h3>
        <p class="desc">ফুটার, চ্যাট উইজেট ও কল-টু-অ্যাকশন বাটনে এই নম্বর/লিংকগুলো ব্যবহৃত হয়</p>
        <form method="POST" action="{{ route('admin.settings.brand.save') }}">
            @csrf
            <div class="brand-grid">
                <div class="a-field">
                    <label>হটলাইন ফোন</label>
                    <input class="a-input" name="contact_phone" value="{{ $settings['contact_phone'] ?? '01707373692' }}" placeholder="01707373692">
                </div>
                <div class="a-field">
                    <label>WhatsApp — নম্বর বা পুরো লিংক</label>
                    <input class="a-input" name="contact_whatsapp" value="{{ $settings['contact_whatsapp'] ?? '8801707373692' }}" placeholder="8801707373692 অথবা https://wa.me/8801707373692">
                </div>
                <div class="a-field">
                    <label>Messenger — ইউজারনেম বা পুরো লিংক</label>
                    <input class="a-input" name="contact_messenger" value="{{ $settings['contact_messenger'] ?? 'AcharBari' }}" placeholder="AcharBari অথবা https://m.me/AcharBari">
                </div>
                <div class="a-field">
                    <label>Facebook পেজ URL</label>
                    <input class="a-input" name="contact_facebook" value="{{ $settings['contact_facebook'] ?? '' }}" placeholder="https://facebook.com/yourpage">
                </div>
            </div>
            <button class="a-btn"><i class="fa-solid fa-floppy-disk"></i> যোগাযোগ সেভ করুন</button>
        </form>
    </div>

    <style>
        .logo-preview img { width: 100%; height: 100%; object-fit: cover; border-radius: 16px; }
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
            // submit via a tiny standalone form post
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
