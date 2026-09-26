@extends('layouts.admin')

@section('title', 'সেকশন ডিজাইন')
@section('page_title', 'সেকশন ডিজাইন স্টুডিও')
@section('page_sub', 'প্রতিটা সেকশনের জন্য আলাদা ডিজাইন — দেখুন, তুলনা করুন, তারপর সেভ করুন')

@section('content')
    @php
        $selected = [];
        foreach ($catalog as $sec) {
            $selected[$sec['section']] = (int) ($saved[$sec['section']] ?? 1);
        }
        $customized = count(array_filter($selected, fn ($d) => $d !== 1));
        $totalDesigns = array_sum(array_map(fn ($s) => count($s['designs']), $catalog));
    @endphp

    <div class="note-banner">
        <i class="fa-solid fa-object-group"></i>
        <span>প্রতিটা সেকশনের ডিজাইন আলাদাভাবে বদলান — কনটেন্ট, ছবি, থিম বা অর্ডার ফ্লো কিছুই বদলাবে না, শুধু সাজানো বদলাবে। কার্ডের <b>👁 লাইভ দেখুন</b> বাটনে চাপ দিলেই ছোট্ট লাইভ প্রিভিউ।</span>
    </div>

    {{-- ===== FIRST-RUN GUIDE ===== --}}
    @if ($customized === 0)
        <div class="sec-guide">
            <div class="sec-guide-emoji">🎨</div>
            <div>
                <b>আপনার সাইট এখন ডিফল্ট ডিজাইনে আছে</b>
                <p>নিচের যেকোনো ডিজাইন কার্ডে ক্লিক করে বেছে নিন, 👁 দিয়ে লাইভ দেখুন — অথবা ওপরের একটা <b>স্টাইল প্রিসেট</b> চেপে এক ক্লিকে পুরো সাইটের লুক বদলান। পছন্দ না হলে "সব ডিফল্টে" চাপলেই আগের অবস্থায় ফিরে যাবে।</p>
            </div>
        </div>
    @endif

    {{-- ===== STYLE PRESETS ===== --}}
    <div class="card preset-card-wrap">
        <h3><i class="fa-solid fa-wand-magic-sparkles"></i> স্টাইল প্রিসেট <small>— এক ক্লিকে পুরো সাইটের লুক</small></h3>
        <div class="preset-row">
            <button type="button" class="style-preset" onclick="applyPreset('classic', this)">
                <span class="sp-ic">🌿</span><b>ক্লাসিক</b><small>সব ডিফল্ট ডিজাইন</small>
            </button>
            <button type="button" class="style-preset" onclick="applyPreset('premium', this)">
                <span class="sp-ic">✨</span><b>প্রিমিয়াম</b><small>ডার্ক ও ঝকঝকে</small>
            </button>
            <button type="button" class="style-preset" onclick="applyPreset('commerce', this)">
                <span class="sp-ic">🛒</span><b>কমার্স</b><small>বিক্রি-কেন্দ্রিক</small>
            </button>
            <button type="button" class="style-preset" onclick="applyPreset('minimal', this)">
                <span class="sp-ic">📄</span><b>মিনিমাল</b><small>হালকা ও পরিচ্ছন্ন</small>
            </button>
        </div>
    </div>

    {{-- ===== SUMMARY ===== --}}
    <div class="sec-summary">
        <div class="sec-stat"><b>{{ count($catalog) }}</b><span>সেকশন</span></div>
        <div class="sec-stat"><b>{{ $totalDesigns }}</b><span>মোট ডিজাইন</span></div>
        <div class="sec-stat"><b id="statDefault">{{ count($catalog) - $customized }}</b><span>ডিফল্ট ডিজাইনে</span></div>
        <div class="sec-stat"><b id="statCustom">{{ $customized }}</b><span>কাস্টমাইজড</span></div>
    </div>

    {{-- ===== TOOLBAR ===== --}}
    <div class="sec-toolbar" id="secToolbar">
        <input type="text" id="sectionSearch" class="a-input sec-search" placeholder="🔍 সেকশন খুঁজুন...">
        <div class="sec-toolbar-actions">
            <button type="button" class="a-btn ghost" onclick="previewSectionTab()" title="নতুন ট্যাবে আসল পেজ — ওখানেই সেভ/বাতিল বার পাবেন">
                <i class="fa-solid fa-up-right-from-square"></i> <span class="hide-sm">নতুন ট্যাবে</span> প্রিভিউ
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
                    <div class="sec-block-title">
                        <span class="sec-ic"><i class="fa-solid {{ $sec['icon'] }}"></i></span>
                        <div>
                            <h3>{{ $sec['bn'] }} <span class="sec-en">{{ $sec['en'] }}</span></h3>
                            <small>{{ count($sec['designs']) }}টি ডিজাইন</small>
                        </div>
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
                            <span class="lv-wrap">
                                <span class="lv-mock lv-mock-{{ $d['n'] % 4 }}"><i></i><i></i><i></i></span>
                                <span class="lv-play" onclick="event.stopPropagation(); toggleLive(this)" title="লাইভ প্রিভিউ দেখুন"><i class="fa-solid fa-eye"></i> লাইভ দেখুন</span>
                            </span>
                            <span class="design-no">ডিজাইন {{ bn_num($d['n']) }}</span>
                            <b>{{ $d['name'] }}</b>
                            <small>{{ $d['desc'] }}</small>
                            @if (!empty($d['features']))
                                <span class="design-feats">
                                    @foreach (array_slice($d['features'], 0, 3) as $feat)
                                        <em>✓ {{ $feat }}</em>
                                    @endforeach
                                </span>
                            @endif
                            @if ($d['recommended'])<em class="design-badge">রেকমেন্ডেড</em>@endif
                            <span class="design-sel"><i class="fa-solid fa-check"></i> নির্বাচিত</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- ===== PREVIEW MODAL (compare + language + devices) ===== --}}
    <div class="pv-overlay" id="pvOverlay" onclick="if(event.target===this)closePreview()">
        <div class="pv-box">
            <div class="pv-head">
                <b id="pvTitle">প্রিভিউ</b>
                <div class="pv-compare" id="pvCompare" hidden>
                    <button type="button" class="pv-cmp active" data-mode="new" onclick="setPvMode('new')">নতুন</button>
                    <button type="button" class="pv-cmp" data-mode="current" onclick="setPvMode('current')">এখনকার</button>
                    <button type="button" class="pv-cmp" data-mode="split" onclick="setPvMode('split')">পাশাপাশি</button>
                </div>
                <div class="pv-lang">
                    <button type="button" onclick="pvSetLang('bn')" title="বাংলা প্রিভিউ">বাং</button>
                    <button type="button" onclick="pvSetLang('en')" title="English preview">EN</button>
                </div>
                <div class="pv-devices">
                    <button type="button" class="pv-dev active" data-w="desktop" onclick="setPvDevice(this)"><i class="fa-solid fa-desktop"></i></button>
                    <button type="button" class="pv-dev" data-w="tablet" onclick="setPvDevice(this)"><i class="fa-solid fa-tablet-screen-button"></i></button>
                    <button type="button" class="pv-dev" data-w="mobile" onclick="setPvDevice(this)"><i class="fa-solid fa-mobile-screen"></i></button>
                </div>
                <button type="button" class="pv-close" onclick="closePreview()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="pv-frame-wrap" id="pvFrameWrap">
                <div class="pv-slot" id="pvSlotNew"><iframe id="pvFrame" title="নতুন ডিজাইন প্রিভিউ" loading="lazy"></iframe></div>
                <div class="pv-slot pv-slot-cur hidden" id="pvSlotCur"><iframe id="pvFrameCur" title="বর্তমান ডিজাইন প্রিভিউ" loading="lazy"></iframe></div>
            </div>
            <p class="pv-note"><i class="fa-solid fa-circle-info"></i> প্রিভিউ আসল ল্যান্ডিং পেজ — আপনার কনটেন্ট, ছবি ও থিমসহ। সেভ না করা পর্যন্ত ভিজিটর কিছু দেখবে না। "নতুন ট্যাবে প্রিভিউ" দিলে ওখানেই সেভ/বাতিল বার পাবেন।</p>
        </div>
    </div>

    {{-- ===== UNDO TOAST ===== --}}
    <div class="undo-toast" id="undoToast" hidden>
        <i class="fa-solid fa-check"></i> সেভ হয়েছে
        <button type="button" onclick="undoSave()"><i class="fa-solid fa-rotate-left"></i> আগের কনফিগে ফিরুন</button>
    </div>

    <style>
        /* hidden attribute must always win over flex/grid class defaults */
        [hidden] { display: none !important; }
        .sec-guide {
            display: flex; gap: 14px; align-items: flex-start;
            background: linear-gradient(135deg, #ecfdf5, #fefce8);
            border: 1.5px solid rgba(5,150,105,.3); border-radius: 16px;
            padding: 16px 18px; margin-bottom: 16px;
        }
        .sec-guide-emoji { font-size: 28px; line-height: 1; }
        .sec-guide b { font-size: 14px; color: #065f46; }
        .sec-guide p { margin: 4px 0 0; font-size: 12.5px; color: #3f5d4f; line-height: 1.6; }
        .preset-card-wrap { margin-bottom: 16px; }
        .preset-card-wrap h3 small { font-weight: 600; color: #8b7355; font-size: 12px; }
        .preset-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 150px), 1fr)); gap: 10px; margin-top: 10px; }
        .style-preset {
            font-family: inherit; cursor: pointer; text-align: center;
            border: 2px solid rgba(5,150,105,.16); background: #fff; border-radius: 14px; padding: 14px 10px;
            transition: transform .15s, border-color .2s, box-shadow .2s;
        }
        .style-preset:hover { transform: translateY(-3px); border-color: #059669; box-shadow: 0 14px 28px -16px rgba(6,78,59,.4); }
        .style-preset .sp-ic { font-size: 22px; display: block; margin-bottom: 6px; }
        .style-preset b { display: block; font-size: 13.5px; color: #12261d; }
        .style-preset small { font-size: 10.5px; color: #8b7355; }
        .sec-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 140px), 1fr)); gap: 10px; margin-bottom: 16px; }
        .sec-stat { background: #fff; border: 1.5px solid rgba(5,150,105,.16); border-radius: 14px; padding: 12px 16px; }
        .sec-stat b { display: block; font-size: 20px; color: #065f46; }
        .sec-stat span { font-size: 11.5px; color: #8b7355; font-weight: 600; }
        .sec-toolbar { display: flex; gap: 10px; align-items: center; justify-content: space-between; flex-wrap: wrap; margin-bottom: 10px; }
        .sec-search { max-width: 280px; }
        .sec-toolbar-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .sec-unsaved { display: flex; gap: 8px; align-items: center; background: #fffbeb; border: 1.5px dashed #f59e0b; color: #92400e; border-radius: 12px; padding: 9px 14px; font-size: 12.5px; font-weight: 700; margin-bottom: 12px; }
        .sec-list { display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px; }
        .sec-block-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; flex-wrap: wrap; margin-bottom: 12px; }
        .sec-block-head h3 { margin: 0; }
        .sec-block-head small { color: #8b7355; }
        .sec-block-title { display: flex; gap: 12px; align-items: center; }
        .sec-ic {
            width: 38px; height: 38px; border-radius: 11px; flex-shrink: 0;
            display: grid; place-items: center; font-size: 15px;
            background: linear-gradient(135deg, rgba(5,150,105,.14), rgba(163,230,53,.16));
            color: #047857;
        }
        .sec-en { font-size: 11px; color: #8b7355; font-weight: 600; }
        .sec-block-actions { display: flex; gap: 8px; }
        .sec-designs { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 195px), 1fr)); gap: 12px; }
        .design-card {
            position: relative; border: 2px solid rgba(5,150,105,.15); border-radius: 14px; padding: 10px 12px 12px;
            background: #fff; cursor: pointer; text-align: left; font-family: inherit;
            display: flex; flex-direction: column; gap: 3px;
            transition: transform .15s, border-color .2s, box-shadow .2s;
        }
        .design-card:hover { transform: translateY(-3px); box-shadow: 0 14px 30px -16px rgba(6,78,59,.4); }
        .design-card.selected { border-color: #059669; background: rgba(5,150,105,.03); }
        .lv-wrap {
            position: relative; display: block; height: 92px; border-radius: 10px; overflow: hidden;
            background: linear-gradient(135deg, #ecfdf5, #d1fae5); margin-bottom: 8px; cursor: zoom-in;
            transition: height .25s ease;
        }
        .lv-wrap.open { height: 150px; background: #fff; }
        .lv-wrap iframe {
            position: absolute; top: 0; left: 0; width: 1280px; height: 840px;
            transform-origin: 0 0; border: 0; pointer-events: none; background: #fff;
        }
        .lv-mock { display: flex; gap: 4px; height: 100%; padding: 14px; }
        .lv-mock i { flex: 1; border-radius: 5px; background: rgba(5,150,105,.22); display: block; }
        .lv-mock-0 i:nth-child(1) { flex: 2; }
        .lv-mock-1 i:nth-child(2) { flex: 2; }
        .lv-mock-2 { flex-direction: column; }
        .lv-mock-3 i { border-radius: 50%; }
        .lv-wrap.open .lv-mock { display: none; }
        .lv-play {
            position: absolute; left: 50%; bottom: 7px; transform: translateX(-50%);
            white-space: nowrap; font-size: 10.5px; font-weight: 800; color: #047857;
            background: rgba(255,255,255,.94); border-radius: 999px; padding: 4px 11px;
            box-shadow: 0 4px 12px -4px rgba(6,78,59,.4);
        }
        .lv-wrap.open .lv-play { display: none; }
        .design-no { font-size: 10.5px; font-weight: 800; color: #059669; text-transform: uppercase; letter-spacing: .4px; }
        .design-card b { font-size: 13px; color: #12261d; }
        .design-card small { font-size: 11px; color: #8b7355; line-height: 1.45; }
        .design-feats { display: flex; flex-wrap: wrap; gap: 3px 8px; margin-top: 3px; }
        .design-feats em { font-style: normal; font-size: 10px; font-weight: 700; color: #047857; background: rgba(5,150,105,.08); border-radius: 999px; padding: 2px 7px; }
        .design-badge { position: absolute; top: 8px; right: 8px; font-size: 9.5px; font-style: normal; font-weight: 800; background: #fef3c7; color: #92400e; border-radius: 999px; padding: 2px 8px; }
        .design-sel { display: none; margin-top: 6px; font-size: 11.5px; font-weight: 800; color: #059669; }
        .design-card.selected .design-sel { display: inline-flex; gap: 5px; align-items: center; }
        .pv-overlay { display: none; position: fixed; inset: 0; z-index: 120; background: rgba(2,26,20,.62); backdrop-filter: blur(3px); padding: 4vh 16px; }
        .pv-overlay.open { display: flex; align-items: flex-start; justify-content: center; }
        .pv-box { background: #fff; border-radius: 18px; width: 100%; max-width: 1180px; max-height: 92vh; display: flex; flex-direction: column; overflow: hidden; }
        .pv-head { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-bottom: 1.5px solid rgba(5,150,105,.15); flex-wrap: wrap; }
        .pv-head b { flex: 1; min-width: 90px; }
        .pv-compare, .pv-lang, .pv-devices { display: flex; gap: 5px; }
        .pv-cmp, .pv-lang button {
            border: 1.5px solid rgba(5,150,105,.25); background: #fff; cursor: pointer; font-family: inherit;
            font-size: 11.5px; font-weight: 800; color: #1f4234; border-radius: 999px; padding: 6px 13px;
        }
        .pv-cmp.active { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border-color: transparent; }
        .pv-dev { width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid rgba(5,150,105,.25); background: #fff; cursor: pointer; font-size: 14px; color: #1f4234; }
        .pv-dev.active { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border-color: transparent; }
        .pv-close { border: none; background: rgba(220,38,38,.08); color: #dc2626; width: 36px; height: 36px; border-radius: 10px; cursor: pointer; font-size: 15px; }
        .pv-frame-wrap { overflow: auto; background: #f0f4f2; display: flex; justify-content: center; width: 100%; min-height: 60vh; }
        .pv-slot { width: 100%; }
        .pv-slot.hidden { display: none; }
        .pv-slot iframe { display: block; width: 100%; height: 68vh; border: 0; background: #fff; }
        .pv-frame-wrap.tablet .pv-slot { max-width: 820px; }
        .pv-frame-wrap.mobile .pv-slot { max-width: 402px; }
        .pv-frame-wrap.split { flex-wrap: nowrap; }
        .pv-frame-wrap.split .pv-slot { width: 50%; }
        .pv-frame-wrap.split .pv-slot iframe { height: 66vh; }
        .pv-note { margin: 0; padding: 9px 16px; font-size: 11.5px; color: #8b7355; border-top: 1.5px solid rgba(5,150,105,.12); }
        .undo-toast {
            position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 130;
            display: flex; gap: 14px; align-items: center;
            background: linear-gradient(135deg, #0d2b20, #064e3b); color: #fff;
            border: 1px solid rgba(163,230,53,.35); border-radius: 999px; padding: 11px 20px;
            font-size: 13px; font-weight: 700; box-shadow: 0 18px 40px -12px rgba(0,0,0,.5);
        }
        .undo-toast button {
            border: none; cursor: pointer; font-family: inherit; font-size: 12px; font-weight: 800;
            background: rgba(163,230,53,.16); color: #a3e635; border-radius: 999px; padding: 6px 14px;
            display: inline-flex; gap: 6px; align-items: center;
        }
        @media (max-width: 768px) {
            .sec-designs { grid-template-columns: 1fr 1fr; }
            .hide-sm { display: none; }
            .sec-toolbar { position: sticky; bottom: 0; z-index: 60; background: #eef5f1; border: 1.5px solid rgba(5,150,105,.2); border-radius: 16px; padding: 10px; box-shadow: 0 -8px 24px -16px rgba(6,78,59,.4); }
            .sec-search { max-width: none; flex: 1; }
        }
        @media (max-width: 640px) {
            .sec-designs { grid-template-columns: 1fr; }
        }
    </style>
@endsection

@push('scripts')
    <script>
        var SAVED = @json($saved);
        var CURRENT = @json($selected);
        var SAVED_BEFORE = @json($saved);
        var DIRTY = false;
        var SECTIONS = @json(array_column($catalog, 'section'));

        var PRESETS = {
            classic: {},
            premium: { navbar: 2, trust: 3, promises: 3, 'how-it-works': 3, 'why-us': 3, faq: 2, 'bottom-cta': 3, footer: 2 },
            commerce: { navbar: 2, trust: 2, promises: 2, 'how-it-works': 2, 'why-us': 2, faq: 2, 'bottom-cta': 2, footer: 2 },
            minimal: { navbar: 2, trust: 2, promises: 3, 'why-us': 3, faq: 3, 'bottom-cta': 2, footer: 2, 'how-it-works': 2 }
        };

        function encConfig(cfg) {
            return '?dp=' + encodeURIComponent(btoa(unescape(encodeURIComponent(JSON.stringify(cfg)))));
        }
        function configQuery() { return encConfig(CURRENT); }
        function anchorFor(section) {
            var anchors = { hero: 'ds-hero', products: 'ds-products', 'why-us': 'ds-why', faq: 'ds-faq', reviews: 'ds-reviews', checkout: 'order-form' };
            return anchors[section] ? '#' + anchors[section] : '';
        }
        function markDirty() {
            DIRTY = true;
            document.getElementById('unsavedBar').hidden = false;
            document.getElementById('saveBtn').classList.add('sec-save-pulse');
        }
        function refreshSummary() {
            var custom = SECTIONS.filter(function (s) { return (CURRENT[s] || 1) !== 1; }).length;
            document.getElementById('statCustom').textContent = custom;
            document.getElementById('statDefault').textContent = SECTIONS.length - custom;
        }
        window.addEventListener('beforeunload', function (e) {
            if (DIRTY) { e.preventDefault(); e.returnValue = ''; }
        });

        /* ===== style presets (one-click site looks) ===== */
        function applyPreset(key, btn) {
            var preset = PRESETS[key] || {};
            SECTIONS.forEach(function (sec) {
                var want = preset[sec] || 1;
                // only apply designs that actually exist for this section
                var card = document.querySelector('.design-card[data-section="' + sec + '"][data-design="' + want + '"]');
                if (!card) want = 1;
                CURRENT[sec] = want;
                document.querySelectorAll('.design-card[data-section="' + sec + '"]').forEach(function (c) {
                    c.classList.toggle('selected', parseInt(c.dataset.design, 10) === want);
                });
            });
            markDirty();
            refreshSummary();
            btn.classList.add('preset-flash');
            setTimeout(function () { btn.classList.remove('preset-flash'); }, 500);
            showToast('প্রিসেট প্রয়োগ হয়েছে — প্রিভিউ দেখে সেভ করুন');
        }

        /* ===== pick / reset ===== */
        function pickDesign(card) {
            var sec = card.dataset.section, n = parseInt(card.dataset.design, 10);
            if (CURRENT[sec] === n) return;
            CURRENT[sec] = n;
            document.querySelectorAll('.design-card[data-section="' + sec + '"]').forEach(function (c) {
                c.classList.toggle('selected', parseInt(c.dataset.design, 10) === n);
            });
            markDirty();
            refreshSummary();
        }

        function resetSection(sec) {
            CURRENT[sec] = 1;
            document.querySelectorAll('.design-card[data-section="' + sec + '"]').forEach(function (c) {
                c.classList.toggle('selected', parseInt(c.dataset.design, 10) === 1);
            });
            markDirty();
            refreshSummary();
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
            refreshSummary();
        }

        /* ===== save (no reload) + undo ===== */
        function saveDesigns(silentCfg, cb) {
            var fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('designs', JSON.stringify(silentCfg || CURRENT));
            var btn = document.getElementById('saveBtn');
            btn.disabled = true;
            fetch('{{ route('admin.settings.sections.save') }}', { method: 'POST', body: fd })
                .then(function (r) {
                    if (!r.ok) throw 0;
                    var prev = JSON.parse(JSON.stringify(SAVED_BEFORE));
                    SAVED = JSON.parse(JSON.stringify(silentCfg || CURRENT));
                    SAVED_BEFORE = SAVED;
                    DIRTY = false;
                    document.getElementById('unsavedBar').hidden = true;
                    document.getElementById('saveBtn').classList.remove('sec-save-pulse');
                    btn.disabled = false;
                    if (cb) { cb(); return; }
                    showToast('সেকশন ডিজাইন সেভ হয়েছে');
                    showUndo(prev);
                })
                .catch(function () { btn.disabled = false; showToast('সেভ ব্যর্থ — আবার চেষ্টা করুন'); });
        }

        var undoTimer = null;
        function showUndo(prev) {
            var t = document.getElementById('undoToast');
            t.hidden = false;
            clearTimeout(undoTimer);
            undoTimer = setTimeout(function () { t.hidden = true; }, 6000);
            window.__undoConfig = prev;
        }
        function undoSave() {
            if (!window.__undoConfig) return;
            var cfg = window.__undoConfig;
            document.getElementById('undoToast').hidden = true;
            saveDesigns(cfg, function () {
                SECTIONS.forEach(function (sec) {
                    var want = cfg[sec] || 1;
                    document.querySelectorAll('.design-card[data-section="' + sec + '"]').forEach(function (c) {
                        c.classList.toggle('selected', parseInt(c.dataset.design, 10) === want);
                    });
                });
                CURRENT = JSON.parse(JSON.stringify(cfg));
                SAVED = JSON.parse(JSON.stringify(cfg));
                refreshSummary();
                showToast('আগের কনফিগে ফিরিয়ে নেওয়া হয়েছে');
            });
        }

        /* ===== preview modal (compare + language + devices) ===== */
        window.__pvIsolated = false;
        window.__pvSection = null;

        function openPreview(url, title, showCompare) {
            document.getElementById('pvTitle').textContent = title;
            document.getElementById('pvCompare').hidden = !showCompare;
            document.getElementById('pvFrame').src = url;
            if (!showCompare) { setPvMode('new', true); }
            document.getElementById('pvOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closePreview() {
            document.getElementById('pvOverlay').classList.remove('open');
            document.getElementById('pvFrame').src = 'about:blank';
            document.getElementById('pvFrameCur').src = 'about:blank';
            document.body.style.overflow = '';
        }
        function setPvMode(mode, skipSrc) {
            document.querySelectorAll('.pv-cmp').forEach(function (b) { b.classList.toggle('active', b.dataset.mode === mode); });
            var sNew = document.getElementById('pvSlotNew');
            var sCur = document.getElementById('pvSlotCur');
            var wrap = document.getElementById('pvFrameWrap');
            wrap.classList.toggle('split', mode === 'split');
            sCur.classList.toggle('hidden', mode === 'new');
            sNew.classList.toggle('hidden', mode === 'current');
            if (mode !== 'new' && !skipSrc) {
                var curUrl = window.__pvIsolated
                    ? pvSectionUrl(window.__pvSection, SAVED[window.__pvSection] || 1)
                    : '{{ url('/') }}';
                document.getElementById('pvFrameCur').src = curUrl;
                pvAutoHeight(document.getElementById('pvFrameCur'), window.__pvIsolated);
            }
        }
        function setPvDevice(btn) {
            document.querySelectorAll('.pv-dev').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var wrap = document.getElementById('pvFrameWrap');
            wrap.classList.toggle('tablet', btn.dataset.w === 'tablet');
            wrap.classList.toggle('mobile', btn.dataset.w === 'mobile');
        }
        function pvSetLang(lang) {
            ['pvFrame', 'pvFrameCur'].forEach(function (id) {
                try {
                    var w = document.getElementById(id).contentWindow;
                    if (w && w.AB) w.AB.setLang(lang);
                } catch (e) { }
            });
        }
        /* ===== isolated section preview: shows ONLY that section ===== */
        function pvSectionUrl(sec, design) {
            return '{{ url('/') }}/preview/section/' + sec + '?design=' + (design || 1);
        }
        // auto-fit iframe height to the isolated section content
        function pvAutoHeight(ifr, enabled) {
            ifr._abAuto = enabled;
            ifr.style.height = enabled ? '220px' : '68vh';
            if (enabled) {
                setTimeout(function () {
                    try {
                        var h = Math.max(
                            ifr.contentDocument.body.scrollHeight,
                            ifr.contentDocument.documentElement.scrollHeight
                        );
                        if (h > 0) ifr.style.height = h + 'px';
                    } catch (e) { }
                }, 350);
            }
        }
        function previewSection(sec) {
            var design = CURRENT[sec] || 1;
            window.__pvIsolated = true;
            window.__pvSection = sec;
            openPreview(pvSectionUrl(sec, design), 'সেকশন প্রিভিউ — শুধু এই অংশ', false);
            var fNew = document.getElementById('pvFrame');
            fNew.addEventListener('load', pvFrameAutoFit);
            pvAutoHeight(fNew, true);
        }
        function pvFrameAutoFit(e) {
            pvAutoHeight(e.target, true);
        }
        function previewFull() {
            window.__pvIsolated = false;
            window.__pvSection = null;
            openPreview('{{ url('/') }}' + configQuery(), 'পুরো ল্যান্ডিং প্রিভিউ', true);
            var f = document.getElementById('pvFrame');
            pvAutoHeight(f, false);
        }
        function previewSectionTab() {
            window.open('{{ url('/') }}' + configQuery(), '_blank');
        }

        /* ===== live mini-preview inside cards ===== */
        function fitLive(wrap, ifr) {
            var sc = wrap.clientWidth / 1280;
            ifr.style.transform = 'scale(' + sc + ')';
            wrap.style.height = Math.round(840 * sc) + 'px';
        }
        function toggleLive(eyeBtn) {
            event.stopPropagation();
            var card = eyeBtn.closest('.design-card');
            var wrap = card.querySelector('.lv-wrap');
            if (!wrap) return;
            if (wrap.dataset.loaded) { wrap.classList.toggle('open'); return; }
            var sec = card.dataset.section, d = parseInt(card.dataset.design, 10);
            var cfg = JSON.parse(JSON.stringify(CURRENT));
            cfg[sec] = d;
            var ifr = document.createElement('iframe');
            ifr.loading = 'lazy';
            ifr.src = location.origin + '/' + encConfig(cfg) + anchorFor(sec);
            ifr.addEventListener('load', function () { setTimeout(function () { fitLive(wrap, ifr); }, 400); });
            wrap.appendChild(ifr);
            wrap.dataset.loaded = '1';
            wrap.classList.add('open');
        }
        window.addEventListener('resize', function () {
            document.querySelectorAll('.lv-wrap.open').forEach(function (wrap) {
                var ifr = wrap.querySelector('iframe');
                if (ifr) fitLive(wrap, ifr);
            });
        });

        // live search filter
        document.getElementById('sectionSearch').addEventListener('input', function () {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll('.sec-block').forEach(function (block) {
                var hit = !q || block.dataset.name.toLowerCase().indexOf(q) !== -1;
                block.style.display = hit ? '' : 'none';
            });
        });
    </script>
    <style>
        .preset-flash { animation: presetFlash .5s ease; }
        .sec-save-pulse { animation: presetFlash .9s ease infinite; }
        @keyframes presetFlash {
            0% { box-shadow: 0 0 0 0 rgba(5,150,105,.5); }
            100% { box-shadow: 0 0 0 14px rgba(5,150,105,0); }
        }
    </style>
@endpush
