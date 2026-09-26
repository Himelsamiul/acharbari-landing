@extends('layouts.admin')

@section('title', 'সেকশন ডিজাইন')
@section('page_title', 'সেকশন ডিজাইন')
@section('page_sub', 'প্রতিটা সেকশনের জন্য আলাদা ডিজাইন বেছে নিন — দেখে, তারপর সেভ')

@section('content')
    @php
        $selected = [];
        foreach ($catalog as $sec) {
            $sel = (int) ($saved[$sec['section']] ?? 1);
            $selected[$sec['section']] = $sel;
        }
        $customized = count(array_filter($selected, fn ($d) => $d !== 1));
        $totalDesigns = array_sum(array_map(fn ($s) => count($s['designs']), $catalog));
    @endphp

    <div class="note-banner">
        <i class="fa-solid fa-object-group"></i>
        <span>প্রতিটা সেকশনের ডিজাইন আলাদাভাবে বদলান — <b>প্রিভিউ দেখে</b> পছন্দ হলে সেভ করুন। কনটেন্ট, ছবি, থিম বা অর্ডার ফ্লো কিছুই বদলাবে না, শুধু সাজানো বদলাবে।</span>
    </div>

    {{-- ===== SUMMARY ===== --}}
    <div class="sec-summary">
        <div class="sec-stat"><b>{{ count($catalog) }}</b><span>সেকশন</span></div>
        <div class="sec-stat"><b>{{ $totalDesigns }}</b><span>মোট ডিজাইন</span></div>
        <div class="sec-stat"><b>{{ count($catalog) - $customized }}</b><span>ডিফল্ট ডিজাইনে</span></div>
        <div class="sec-stat"><b>{{ $customized }}</b><span>কাস্টমাইজড</span></div>
    </div>

    {{-- ===== TOOLBAR ===== --}}
    <div class="sec-toolbar">
        <input type="text" id="sectionSearch" class="a-input sec-search" placeholder="সেকশন খুঁজুন...">
        <div class="sec-toolbar-actions">
            <button type="button" class="a-btn ghost" onclick="previewFull()" id="fullPreviewBtn">
                <i class="fa-solid fa-eye"></i> পুরো পেজ প্রিভিউ
            </button>
            <button type="button" class="a-btn ghost" onclick="resetAll()" id="resetAllBtn">
                <i class="fa-solid fa-rotate-left"></i> সব ডিফল্টে
            </button>
            <button type="button" class="a-btn" onclick="saveDesigns()" id="saveBtn">
                <i class="fa-solid fa-floppy-disk"></i> সেভ করুন
            </button>
        </div>
    </div>
    <p class="sec-unsaved" id="unsavedBar" hidden><i class="fa-solid fa-triangle-exclamation"></i> অসংরক্ষিত পরিবর্তন আছে — সেভ না করলে ল্যান্ডিংয়ে যাবে না।</p>

    {{-- ===== SECTION CARDS ===== --}}
    <div class="sec-list" id="sectionList">
        @foreach ($catalog as $sec)
            <div class="card sec-block" data-section="{{ $sec['section'] }}" data-name="{{ $sec['bn'] }} {{ $sec['en'] }}">
                <div class="sec-block-head">
                    <div>
                        <h3>{{ $sec['bn'] }} <span class="sec-en">{{ $sec['en'] }}</span></h3>
                        <small>{{ count($sec['designs']) }}টি ডিজাইন</small>
                    </div>
                    <div class="sec-block-actions">
                        <button type="button" class="a-btn ghost sec-preview" onclick="previewSection('{{ $sec['section'] }}')">
                            <i class="fa-solid fa-eye"></i> প্রিভিউ
                        </button>
                        <button type="button" class="a-btn ghost sec-reset" onclick="resetSection('{{ $sec['section'] }}')" title="ডিফল্ট ডিজাইনে ফিরুন">
                            <i class="fa-solid fa-rotate-left"></i>
                        </button>
                    </div>
                </div>
                <div class="sec-designs">
                    @foreach ($sec['designs'] as $d)
                        @php $isSel = ($selected[$sec['section']] ?? 1) === $d['n']; @endphp
                        <button type="button"
                            class="design-card {{ $isSel ? 'selected' : '' }}"
                            data-section="{{ $sec['section'] }}" data-design="{{ $d['n'] }}"
                            onclick="pickDesign(this)">
                            <span class="design-thumb design-thumb-{{ $d['n'] % 5 }}">
                                <i></i><i></i><i></i>
                            </span>
                            <span class="design-no">ডিজাইন {{ bn_num($d['n']) }}</span>
                            <b>{{ $d['name'] }}</b>
                            <small>{{ $d['desc'] }}</small>
                            @if ($d['recommended'])<em class="design-badge">রেকমেন্ডেড</em>@endif
                            <span class="design-sel"><i class="fa-solid fa-check"></i> নির্বাচিত</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- ===== PREVIEW MODAL ===== --}}
    <div class="pv-overlay" id="pvOverlay" onclick="if(event.target===this)closePreview()">
        <div class="pv-box">
            <div class="pv-head">
                <b id="pvTitle">প্রিভিউ</b>
                <div class="pv-devices">
                    <button type="button" class="pv-dev active" data-w="desktop" onclick="setPvDevice(this)"><i class="fa-solid fa-desktop"></i></button>
                    <button type="button" class="pv-dev" data-w="tablet" onclick="setPvDevice(this)"><i class="fa-solid fa-tablet-screen-button"></i></button>
                    <button type="button" class="pv-dev" data-w="mobile" onclick="setPvDevice(this)"><i class="fa-solid fa-mobile-screen"></i></button>
                </div>
                <button type="button" class="pv-close" onclick="closePreview()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="pv-frame-wrap" id="pvFrameWrap">
                <iframe id="pvFrame" title="সেকশন প্রিভিউ" loading="lazy"></iframe>
            </div>
            <p class="pv-note"><i class="fa-solid fa-circle-info"></i> প্রিভিউ আসল ল্যান্ডিং পেজ — আপনার কনটেন্ট, ছবি ও থিমসহ। সেভ না করা পর্যন্ত ভিজিটর কিছু দেখবে না।</p>
        </div>
    </div>

    <style>
        .sec-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 140px), 1fr)); gap: 10px; margin-bottom: 16px; }
        .sec-stat { background: #fff; border: 1.5px solid rgba(5,150,105,.16); border-radius: 14px; padding: 12px 16px; }
        .sec-stat b { display: block; font-size: 20px; color: #065f46; }
        .sec-stat span { font-size: 11.5px; color: #8b7355; font-weight: 600; }
        .sec-toolbar { display: flex; gap: 10px; align-items: center; justify-content: space-between; flex-wrap: wrap; margin-bottom: 10px; }
        .sec-search { max-width: 280px; }
        .sec-toolbar-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .sec-unsaved { display: flex; gap: 8px; align-items: center; background: #fffbeb; border: 1.5px dashed #f59e0b; color: #92400e; border-radius: 12px; padding: 9px 14px; font-size: 12.5px; font-weight: 700; margin-bottom: 12px; }
        .sec-list { display: flex; flex-direction: column; gap: 16px; }
        .sec-block-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; flex-wrap: wrap; margin-bottom: 12px; }
        .sec-block-head h3 { margin: 0; }
        .sec-block-head small { color: #8b7355; }
        .sec-en { font-size: 11px; color: #8b7355; font-weight: 600; }
        .sec-block-actions { display: flex; gap: 8px; }
        .sec-designs { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 175px), 1fr)); gap: 12px; }
        .design-card {
            position: relative; border: 2px solid rgba(5,150,105,.15); border-radius: 14px; padding: 12px;
            background: #fff; cursor: pointer; text-align: left; font-family: inherit;
            display: flex; flex-direction: column; gap: 4px;
            transition: transform .15s, border-color .2s, box-shadow .2s;
        }
        .design-card:hover { transform: translateY(-3px); box-shadow: 0 14px 30px -16px rgba(6,78,59,.4); }
        .design-card.selected { border-color: #059669; background: rgba(5,150,105,.03); }
        .design-thumb { display: flex; gap: 4px; height: 44px; border-radius: 9px; padding: 8px; margin-bottom: 8px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); }
        .design-thumb i { flex: 1; border-radius: 4px; background: rgba(5,150,105,.25); display: block; }
        .design-thumb-1 i:nth-child(1) { flex: 2; }
        .design-thumb-2 i:nth-child(2) { flex: 2; }
        .design-thumb-3 { flex-direction: column; }
        .design-thumb-4 i { border-radius: 50%; }
        .design-no { font-size: 10.5px; font-weight: 800; color: #059669; text-transform: uppercase; letter-spacing: .4px; }
        .design-card b { font-size: 13px; color: #12261d; }
        .design-card small { font-size: 11px; color: #8b7355; line-height: 1.45; }
        .design-badge { position: absolute; top: 8px; right: 8px; font-size: 9.5px; font-style: normal; font-weight: 800; background: #fef3c7; color: #92400e; border-radius: 999px; padding: 2px 8px; }
        .design-sel { display: none; margin-top: 6px; font-size: 11.5px; font-weight: 800; color: #059669; }
        .design-card.selected .design-sel { display: inline-flex; gap: 5px; align-items: center; }
        .pv-overlay { display: none; position: fixed; inset: 0; z-index: 120; background: rgba(2,26,20,.62); backdrop-filter: blur(3px); padding: 4vh 16px; }
        .pv-overlay.open { display: flex; align-items: flex-start; justify-content: center; }
        .pv-box { background: #fff; border-radius: 18px; width: 100%; max-width: 1100px; max-height: 92vh; display: flex; flex-direction: column; overflow: hidden; }
        .pv-head { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-bottom: 1.5px solid rgba(5,150,105,.15); }
        .pv-head b { flex: 1; }
        .pv-devices { display: flex; gap: 6px; }
        .pv-dev { width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid rgba(5,150,105,.25); background: #fff; cursor: pointer; font-size: 14px; color: #1f4234; }
        .pv-dev.active { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border-color: transparent; }
        .pv-close { border: none; background: rgba(220,38,38,.08); color: #dc2626; width: 36px; height: 36px; border-radius: 10px; cursor: pointer; font-size: 15px; }
        .pv-frame-wrap { overflow: auto; background: #f0f4f2; display: flex; justify-content: center; transition: max-width .3s ease; width: 100%; margin: 0 auto; }
        .pv-frame-wrap iframe { width: 100%; height: 68vh; border: 0; background: #fff; transition: max-width .3s ease, width .3s ease; }
        .pv-frame-wrap.tablet iframe { max-width: 820px; }
        .pv-frame-wrap.mobile iframe { max-width: 402px; }
        .pv-note { margin: 0; padding: 9px 16px; font-size: 11.5px; color: #8b7355; border-top: 1.5px solid rgba(5,150,105,.12); }
        @media (max-width: 640px) {
            .sec-designs { grid-template-columns: 1fr 1fr; }
        }
    </style>
@endsection

@push('scripts')
    <script>
        var SAVED = @json($saved);
        var CURRENT = @json($selected);
        var DIRTY = false;
        var SECTIONS = @json(array_column($catalog, 'section'));

        function configQuery() {
            return '?dp=' + encodeURIComponent(btoa(unescape(encodeURIComponent(JSON.stringify(CURRENT)))));
        }
        function anchorFor(section) {
            var anchors = { hero: 'ds-hero', products: 'ds-products', 'why-us': 'ds-why', faq: 'ds-faq', reviews: 'ds-reviews', checkout: 'order-form' };
            return anchors[section] ? '#' + anchors[section] : '';
        }
        function markDirty() {
            DIRTY = true;
            document.getElementById('unsavedBar').hidden = false;
            document.getElementById('saveBtn').classList.add('sec-save-pulse');
        }
        window.addEventListener('beforeunload', function (e) {
            if (DIRTY) { e.preventDefault(); e.returnValue = ''; }
        });

        function pickDesign(card) {
            var sec = card.dataset.section, n = parseInt(card.dataset.design, 10);
            if (CURRENT[sec] === n) return;
            CURRENT[sec] = n;
            document.querySelectorAll('.design-card[data-section="' + sec + '"]').forEach(function (c) {
                c.classList.toggle('selected', parseInt(c.dataset.design, 10) === n);
            });
            markDirty();
        }

        function resetSection(sec) {
            CURRENT[sec] = 1;
            document.querySelectorAll('.design-card[data-section="' + sec + '"]').forEach(function (c) {
                c.classList.toggle('selected', parseInt(c.dataset.design, 10) === 1);
            });
            markDirty();
        }

        function resetAll() {
            if (DIRTY && !confirm('সব পরিবর্তন ডিফল্টে ফিরিয়ে নেওয়া হবে — নিশ্চিত?')) return;
            SECTIONS.forEach(function (sec) {
                CURRENT[sec] = 1;
                document.querySelectorAll('.design-card[data-section="' + sec + '"]').forEach(function (c) {
                    c.classList.toggle('selected', parseInt(c.dataset.design, 10) === 1);
                });
            });
            markDirty();
        }

        function saveDesigns() {
            var fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('designs', JSON.stringify(CURRENT));
            var btn = document.getElementById('saveBtn');
            btn.disabled = true;
            fetch('{{ route('admin.settings.sections.save') }}', { method: 'POST', body: fd })
                .then(function (r) { if (!r.ok) throw 0; DIRTY = false; document.getElementById('unsavedBar').hidden = true; showToast('সেকশন ডিজাইন সেভ হয়েছে'); window.location.reload(); })
                .catch(function () { btn.disabled = false; showToast('সেভ ব্যর্থ — আবার চেষ্টা করুন'); });
        }

        function openPreview(url, title) {
            document.getElementById('pvTitle').textContent = title;
            document.getElementById('pvFrame').src = url;
            document.getElementById('pvOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closePreview() {
            document.getElementById('pvOverlay').classList.remove('open');
            document.getElementById('pvFrame').src = 'about:blank';
            document.body.style.overflow = '';
        }
        function setPvDevice(btn) {
            document.querySelectorAll('.pv-dev').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var wrap = document.getElementById('pvFrameWrap');
            wrap.classList.toggle('tablet', btn.dataset.w === 'tablet');
            wrap.classList.toggle('mobile', btn.dataset.w === 'mobile');
        }
        function previewSection(sec) {
            openPreview('{{ url('/') }}' + configQuery() + anchorFor(sec), 'সেকশন প্রিভিউ');
        }
        function previewFull() {
            openPreview('{{ url('/') }}' + configQuery(), 'পুরো ল্যান্ডিং প্রিভিউ');
        }

        // live search filter
        document.getElementById('sectionSearch').addEventListener('input', function () {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll('.sec-block').forEach(function (block) {
                var hit = !q || block.dataset.name.toLowerCase().indexOf(q) !== -1;
                block.style.display = hit ? '' : 'none';
            });
        });
    </script>
@endpush
