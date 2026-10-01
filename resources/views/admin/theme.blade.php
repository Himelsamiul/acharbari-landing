@extends('layouts.admin')

@section('title', 'থিম ও কালার')
@section('page_title', 'থিম ও কালার')
@section('page_sub', 'পুরো ওয়েবসাইটের ডিজাইন থিম, ফন্ট ও স্টাইল পরিবর্তন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-palette"></i>
        <span>থিম সেভ করলে পুরো ওয়েবসাইটের রঙ বদলে যাবে — ল্যান্ডিং পেজে সাথে সাথেই প্রয়োগ হবে।</span>
    </div>

    @if ($activeFestive)
        <div class="note-banner festive-banner">
            <i class="fa-solid fa-calendar-day"></i>
            <span>🎉 এখন <strong>"{{ $activeFestive['label'] }}"</strong> উৎসব থিম চলছে ({{ \Carbon\Carbon::parse($activeFestive['end'])->format('d M') }} পর্যন্ত) — ল্যান্ডিং পেজে এটাই দেখা যাচ্ছে।</span>
        </div>
    @endif

    {{-- ===== INDUSTRY PRESETS (10 genres) ===== --}}
    <div class="card">
        <h3><i class="fa-solid fa-store"></i> ইন্ডাস্ট্রি প্রিসেট</h3>
        <p class="desc">এক ক্লিকে পুরো ওয়েবসাইট ওই ব্যবসার লুকে বদলে যাবে — থিমের রঙ, সব ছবি আর ডেমো কনটেন্টসহ। নিজে কাস্টমাইজ করা টেক্সট/ছবি থাকলে সিস্টেম আপনাকে জিজ্ঞেস করবে।</p>
        <div class="industry-grid" id="industryGrid">
            @foreach (\App\Http\Controllers\Admin\IndustryPack::all() as $key => $g)
                <button type="button"
                    class="industry-tile {{ ($industry ?? '') === $key ? 'active' : '' }}"
                    data-key="{{ $key }}" onclick="pickIndustry('{{ $key }}')">
                    <span class="it-ic"><i class="fa-solid {{ $g['icon'] }}"></i></span>
                    <b>{{ $g['name_bn'] }}</b>
                    <small>{{ $g['name_en'] }}</small>
                    <span class="it-swatch">
                        @foreach ($g['swatch'] as $c)<i style="background:{{ $c }}"></i>@endforeach
                    </span>
                    <span class="it-active"><i class="fa-solid fa-check"></i> চালু</span>
                </button>
            @endforeach
        </div>

        {{-- confirm panel --}}
        <div class="ind-confirm" id="indConfirm" hidden>
            <p><i class="fa-solid fa-triangle-exclamation"></i> <b id="indConfirmTitle"></b></p>
            <p class="ind-confirm-note">আপনার বর্তমান কাস্টমাইজ করা কনটেন্ট (লেখা/ছবি) পরিবর্তিত হতে পারে।</p>
            <div class="ind-confirm-actions">
                <button type="button" class="a-btn" onclick="applyIndustry('full')" id="indApplyFull">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> প্রিসেট প্রয়োগ (থিম+ছবি+কনটেন্ট)
                </button>
                <button type="button" class="a-btn ghost" onclick="applyIndustry('visual')" id="indApplyVisual">
                    <i class="fa-solid fa-palette"></i> শুধু লুক (থিম+ছবি)
                </button>
                <button type="button" class="a-btn ghost" onclick="cancelIndustry()">বাতিল</button>
            </div>
        </div>

        @if (($industry ?? '') !== '')
            <button type="button" class="a-btn ghost" style="margin-top:12px" onclick="clearIndustry()">
                <i class="fa-solid fa-rotate-left"></i> ডিফল্ট আচারবাড়ি লুকে ফিরুন
            </button>
        @endif
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
        <p class="desc">নিচের প্রিভিউতে আসল ল্যান্ডিং পেজ দেখা যায় — রঙ, ফন্ট বা স্টাইল বদলালেই সাথে সাথে বদলে যায়। পছন্দ হলে তবেই সেভ/প্রয়োগ করুন।</p>
        <div class="lp-prev-jumps">
            <span class="lp-jump-label"><i class="fa-solid fa-location-crosshairs"></i> সেকশনে যান:</span>
            <button type="button" onclick="prevJump('top')">টপ</button>
            <button type="button" onclick="prevJump('ds-products')">প্রোডাক্ট</button>
            <button type="button" onclick="prevJump('ds-why')">কেন আমরা</button>
            <button type="button" onclick="prevJump('ds-reviews')">রিভিউ</button>
            <button type="button" onclick="prevJump('ds-faq')">FAQ</button>
            <button type="button" onclick="prevJump('order-form')">অর্ডার ফর্ম</button>
            <button type="button" onclick="prevJump('lp-footer')">ফুটার</button>
        </div>
        <div class="lp-prev-frame" id="prevFrameWrap">
            <iframe id="landingPreview" src="{{ url('/') }}" title="ল্যান্ডিং প্রিভিউ" loading="lazy"></iframe>
        </div>
    </div>

    <div class="card">
        <h3>রেডিমেড থিম</h3>
        <p class="desc">ক্লিক করলে প্রিভিউ দেখাবে — পছন্দ হলে নিচের <b>প্রয়োগ করুন</b> বার থেকে সেভ করুন</p>
        <div class="preset-grid" id="presetGrid"></div>
    </div>

    <div class="card">
        <h3>আমার সেভ করা থিম</h3>
        <p class="desc">নিজের বানানো থিম লাইব্রেরিতে জমিয়ে রাখুন — যেকোনো সময় এক ক্লিকে ফিরে আসুন (নিচের কাস্টম কালার থেকে সেভ করা যায়)</p>
        <div class="preset-grid" id="myThemeGrid"></div>
    </div>

    <div class="card">
        <h3>কাস্টম কালার</h3>
        <p class="desc">নিজের পছন্দমতো ব্র্যান্ড রঙ সেট করুন — সাদা লেখা পড়া যাবে কিনা সাথে সাথে চেক হয়</p>

        <div class="custom-tools">
            <button class="a-btn ghost" onclick="extractLogoTheme()"><i class="fa-solid fa-wand-magic-sparkles"></i> লোগো থেকে থিম বানান</button>
            <button class="a-btn ghost" onclick="surpriseTheme()"><i class="fa-solid fa-dice"></i> সারপ্রাইজ থিম</button>
        </div>

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

        {{-- contrast checker --}}
        <div class="contrast-panel">
            <div class="contrast-title"><i class="fa-solid fa-eye"></i> লেখা পড়ার সহজতা (WCAG)</div>
            <div class="c-row">
                <span class="c-chip" id="cChipPrimary"></span>
                <span class="c-label">প্রাইমারির উপর সাদা লেখা</span>
                <code id="cRatioPrimary">—</code>
                <span class="c-badge" id="cBadgePrimary">—</span>
                <button type="button" class="c-fix" id="cFixPrimary" onclick="fixContrast('primary')" hidden>রঙ ঠিক করুন</button>
            </div>
            <div class="c-row">
                <span class="c-chip" id="cChipDark"></span>
                <span class="c-label">ডার্ক রঙের উপর সাদা লেখা</span>
                <code id="cRatioDark">—</code>
                <span class="c-badge" id="cBadgeDark">—</span>
                <button type="button" class="c-fix" id="cFixDark" onclick="fixContrast('dark')" hidden>রঙ ঠিক করুন</button>
            </div>
        </div>

        <div class="custom-actions">
            <button class="a-btn" onclick="applyCustomTheme()"><i class="fa-solid fa-check"></i> কাস্টম থিম প্রয়োগ করুন</button>
            <button class="a-btn warn" onclick="resetTheme()"><i class="fa-solid fa-rotate-left"></i> ডিফল্টে ফিরুন (Herbal Green)</button>
        </div>

        <div class="save-my-row">
            <input class="a-input" id="myThemeName" maxlength="30" placeholder="থিমের নাম দিন (যেমন: ঈদ গ্রিন)">
            <button class="a-btn ghost" onclick="saveMyTheme()"><i class="fa-solid fa-bookmark"></i> লাইব্রেরিতে সেভ করুন</button>
        </div>
    </div>

    @if (!empty($history))
    <div class="card">
        <h3>সাম্প্রতিক থিম</h3>
        <p class="desc">শেষ বদলের আগের থিমগুলো — এক ক্লিকে ফিরে যান</p>
        <div class="hist-grid">
            @foreach ($history as $i => $h)
                @php $ht = json_decode($h['theme_json'], true); @endphp
                @if (is_array($ht))
                <button type="button" class="hist-chip" onclick="restoreHistory({{ $i }})">
                    <span class="preset-swatches">
                        <i style="background:{{ $ht['primary'] }}"></i>
                        <i style="background:{{ $ht['accent'] }}"></i>
                        <i style="background:{{ $ht['dark'] }}"></i>
                    </span>
                    <span class="hist-meta"><b>{{ $h['label'] }}</b><small>{{ $h['at'] }}</small></span>
                    <i class="fa-solid fa-clock-rotate-left hist-ic"></i>
                </button>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <div class="card">
        <h3>ফন্ট</h3>
        <p class="desc">হেডিং ও বডির ফন্ট আলাদা করে বাছতে পারেন — পরিবর্তন আগে প্রিভিউতে দেখে নিন</p>
        <div class="font-grid">
            <div class="font-field">
                <label>হেডিং ফন্ট</label>
                <select class="a-input" id="selFontHeading" onchange="previewFonts()">
                    @foreach ($fonts as $fid => $f)
                        <option value="{{ $fid }}" @selected($fontHeading === $fid)>{{ $f['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="font-field">
                <label>বডি ফন্ট</label>
                <select class="a-input" id="selFontBody" onchange="previewFonts()">
                    @foreach ($fonts as $fid => $f)
                        @if ($fid !== '')
                        <option value="{{ $fid }}" @selected($fontBody === $fid)>{{ $f['label'] }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <button class="a-btn" onclick="saveFonts()"><i class="fa-solid fa-check"></i> ফন্ট প্রয়োগ করুন</button>
    </div>

    <div class="card">
        <h3>স্টাইল টোকেন</h3>
        <p class="desc">রঙ ছাড়াও পুরো সাইটের কোণার ভঙ্গি আর ছায়ার ধরন বদলান</p>
        <div class="style-grid">
            <div class="style-field">
                <label>কর্নার স্টাইল</label>
                <div class="seg" id="segRadius">
                    <button type="button" data-v="default" class="{{ $styleRadius === 'default' ? 'on' : '' }}">ডিফল্ট</button>
                    <button type="button" data-v="sharp" class="{{ $styleRadius === 'sharp' ? 'on' : '' }}">শার্প কোণ</button>
                    <button type="button" data-v="rounded" class="{{ $styleRadius === 'rounded' ? 'on' : '' }}">বেশি গোলাকার</button>
                </div>
            </div>
            <div class="style-field">
                <label>ছায়া (Shadow)</label>
                <div class="seg" id="segShadow">
                    <button type="button" data-v="default" class="{{ $styleShadow === 'default' ? 'on' : '' }}">ডিফল্ট</button>
                    <button type="button" data-v="soft" class="{{ $styleShadow === 'soft' ? 'on' : '' }}">হালকা</button>
                    <button type="button" data-v="strong" class="{{ $styleShadow === 'strong' ? 'on' : '' }}">গাঢ়</button>
                </div>
            </div>
        </div>
        <button class="a-btn" onclick="saveStyle()"><i class="fa-solid fa-check"></i> স্টাইল প্রয়োগ করুন</button>
    </div>

    <div class="card">
        <h3>উৎসব অটো-শিডিউল</h3>
        <p class="desc">নির্দিষ্ট তারিখে নির্দিষ্ট থিম অটো চালু হবে — ঈদ, পহেলা বৈশাখ, বিজয় দিবস ইত্যাদিতে সাইট নিজেই সাজবে</p>
        <div class="fest-quick">
            <span>দ্রুত যোগ করুন:</span>
            <button type="button" onclick="quickFest('পহেলা বৈশাখ', '04-14', '04-14', 'mango')"><i class="fa-solid fa-plus"></i> পহেলা বৈশাখ (১৪ এপ্রিল)</button>
            <button type="button" onclick="quickFest('বিজয় দিবস', '12-16', '12-16', 'chili')"><i class="fa-solid fa-plus"></i> বিজয় দিবস (১৬ ডিসেম্বর)</button>
            <button type="button" onclick="quickFest('স্বাধীনতা দিবস', '03-26', '03-26', 'chili')"><i class="fa-solid fa-plus"></i> স্বাধীনতা দিবস (২৬ মার্চ)</button>
        </div>
        <div id="festRows"></div>
        <div class="fest-actions">
            <button class="a-btn ghost" onclick="addFestRow()"><i class="fa-solid fa-plus"></i> নতুন সারি</button>
            <button class="a-btn" onclick="saveFestive()"><i class="fa-solid fa-calendar-check"></i> শিডিউল সেভ করুন</button>
        </div>
    </div>

    {{-- ===== STICKY CONFIRM BAR ===== --}}
    <div class="confirm-bar" id="confirmBar" hidden>
        <span class="confirm-text"><i class="fa-solid fa-palette"></i> <b id="confirmName"></b> থিম নির্বাচিত — প্রিভিউ দেখে নিয়েছেন?</span>
        <button type="button" class="a-btn" onclick="applyPending()"><i class="fa-solid fa-check"></i> প্রয়োগ করুন</button>
        <button type="button" class="a-btn ghost confirm-cancel" onclick="cancelPending()">বাতিল</button>
    </div>

    <style>
        /* hidden attribute SOB somoy kaj koruk — nahole .confirm-bar er display:flex
           override kore bar-ta sompurno hidden thakar kotha, sarada dekha jay */
        [hidden] { display: none !important; }

        .festive-banner { background: linear-gradient(135deg, rgba(124, 58, 237, .12), rgba(219, 39, 119, .1)); }

        /* section jump chips */
        .lp-prev-jumps { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-top: 12px; }
        .lp-jump-label { font-size: 11.5px; color: #8b7355; font-weight: 600; margin-right: 2px; }
        .lp-prev-jumps button {
            border: 1px solid rgba(5,150,105,.25); background: #fff; color: #065f46; cursor: pointer;
            padding: 5px 12px; border-radius: 999px; font-size: 11.5px; font-weight: 600; font-family: inherit;
            transition: background .15s, border .15s, transform .12s;
        }
        .lp-prev-jumps button:hover { background: rgba(5,150,105,.08); border-color: #059669; transform: translateY(-1px); }

        /* custom tools */
        .custom-tools { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
        .custom-actions { margin-top: 6px; }

        /* contrast panel */
        .contrast-panel { margin: 16px 0 6px; border: 1.5px dashed rgba(5,150,105,.3); border-radius: 12px; padding: 10px 12px; background: rgba(5,150,105,.03); }
        .contrast-title { font-size: 11.5px; font-weight: 700; color: #065f46; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .c-row { display: flex; align-items: center; gap: 8px; padding: 4px 0; flex-wrap: wrap; }
        .c-chip { width: 18px; height: 18px; border-radius: 6px; border: 1px solid rgba(0,0,0,.12); flex: none; }
        .c-label { font-size: 12px; color: #44403c; min-width: 180px; }
        .c-row code { font-size: 12px; color: #065f46; font-weight: 700; }
        .c-badge { font-size: 10.5px; font-weight: 800; padding: 3px 9px; border-radius: 999px; }
        .c-badge.ok { background: #dcfce7; color: #15803d; }
        .c-badge.warn { background: #fef3c7; color: #b45309; }
        .c-badge.bad { background: #fee2e2; color: #b91c1c; }
        .c-fix {
            border: 0; background: linear-gradient(135deg, #d97706, #f59e0b); color: #fff; cursor: pointer;
            font-size: 11px; font-weight: 700; padding: 5px 11px; border-radius: 999px; font-family: inherit;
        }
        .c-fix:hover { filter: brightness(1.07); }

        /* save-as-my-theme row */
        .save-my-row { display: flex; gap: 8px; margin-top: 16px; padding-top: 14px; border-top: 1.5px dashed rgba(5,150,105,.18); flex-wrap: wrap; }
        .save-my-row .a-input { max-width: 260px; }

        /* preset / my theme cards */
        .preset-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 170px), 1fr)); gap: 14px; }
        .preset-card {
            border: 2px solid rgba(5,150,105,.15); border-radius: 14px; padding: 14px;
            cursor: pointer; background: #fff; text-align: left; position: relative;
            font-family: inherit; transition: transform .15s, border .2s, box-shadow .2s;
        }
        .preset-card:hover { transform: translateY(-3px); box-shadow: 0 14px 30px -16px rgba(6,78,59,.4); }
        .preset-card.active { border-color: var(--sc, #059669); box-shadow: 0 0 0 3px color-mix(in srgb, var(--sc, #059669) 18%, transparent); }
        .preset-card.active::after { content: '✓'; position: absolute; top: 8px; right: 10px; font-size: 12px; font-weight: 900; color: var(--sc, #059669); }
        .preset-swatches { display: flex; gap: 5px; margin-bottom: 10px; }
        .preset-swatches i { width: 26px; height: 26px; border-radius: 8px; display: block; }
        .preset-card b { font-size: 13.5px; display: block; padding-right: 14px; }
        .preset-card span { font-size: 11px; color: #8b7355; }
        .my-del {
            position: absolute; top: -8px; right: -8px; width: 22px; height: 22px; border-radius: 50%;
            border: 0; background: #dc2626; color: #fff; cursor: pointer; font-size: 12px; line-height: 1;
            display: none; align-items: center; justify-content: center; font-family: inherit;
        }
        .preset-card:hover .my-del { display: flex; }

        /* history chips */
        .hist-grid { display: flex; gap: 10px; flex-wrap: wrap; }
        .hist-chip {
            display: flex; align-items: center; gap: 10px; border: 1.5px solid rgba(5,150,105,.18);
            background: #fff; border-radius: 12px; padding: 8px 12px; cursor: pointer; font-family: inherit;
            transition: border .15s, transform .12s;
        }
        .hist-chip:hover { border-color: #059669; transform: translateY(-2px); }
        .hist-chip .preset-swatches { margin: 0; }
        .hist-chip .preset-swatches i { width: 16px; height: 16px; border-radius: 5px; }
        .hist-meta { display: flex; flex-direction: column; align-items: flex-start; }
        .hist-meta b { font-size: 12.5px; }
        .hist-meta small { font-size: 10.5px; color: #a8a29e; }
        .hist-ic { color: #059669; font-size: 13px; }

        /* fonts */
        .font-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 14px; margin-bottom: 14px; }
        .font-field label { display: block; font-size: 12px; font-weight: 700; color: #44403c; margin-bottom: 6px; }

        /* style tokens */
        .style-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 240px), 1fr)); gap: 14px; margin-bottom: 14px; }
        .style-field label { display: block; font-size: 12px; font-weight: 700; color: #44403c; margin-bottom: 6px; }
        .seg { display: inline-flex; border: 1.5px solid rgba(5,150,105,.25); border-radius: 10px; overflow: hidden; background: #fff; }
        .seg button {
            border: 0; background: transparent; padding: 8px 14px; cursor: pointer; font-size: 12px;
            font-weight: 600; color: #57534e; font-family: inherit; transition: background .15s, color .15s;
        }
        .seg button + button { border-left: 1.5px solid rgba(5,150,105,.18); }
        .seg button.on { background: linear-gradient(135deg, #059669, #10b981); color: #fff; }

        /* festive schedule */
        .fest-quick { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; }
        .fest-quick span { font-size: 11.5px; color: #8b7355; font-weight: 600; }
        .fest-quick button {
            border: 1px solid rgba(5,150,105,.25); background: rgba(5,150,105,.04); color: #065f46; cursor: pointer;
            padding: 5px 11px; border-radius: 999px; font-size: 11px; font-weight: 600; font-family: inherit;
        }
        .fest-quick button:hover { background: rgba(5,150,105,.1); border-color: #059669; }
        .fest-row {
            display: grid; grid-template-columns: 1.2fr 1fr 0.9fr 0.9fr auto auto; gap: 8px; align-items: center;
            padding: 8px 0; border-bottom: 1px dashed rgba(5,150,105,.14);
        }
        .fest-row:last-of-type { border-bottom: 0; }
        .fest-row .f-on { display: flex; align-items: center; gap: 5px; font-size: 11.5px; color: #44403c; font-weight: 600; white-space: nowrap; cursor: pointer; }
        .fest-row .f-on input { accent-color: #059669; cursor: pointer; }
        .fest-row .f-del {
            width: 26px; height: 26px; border-radius: 8px; border: 0; background: #fee2e2; color: #b91c1c;
            cursor: pointer; font-size: 14px; line-height: 1; font-family: inherit; flex: none;
        }
        .fest-row .f-del:hover { background: #fecaca; }
        .fest-actions { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; }

        /* sticky confirm bar */
        .confirm-bar {
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
            z-index: 999; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; justify-content: center;
            background: linear-gradient(135deg, #064e3b, #022c22); color: #fff;
            padding: 12px 16px; border-radius: 16px; box-shadow: 0 24px 50px -12px rgba(2, 44, 34, .65);
            max-width: min(94vw, 640px);
        }
        .confirm-text { font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .confirm-text i { color: #6ee7b7; }
        .confirm-cancel { border-color: rgba(255,255,255,.3) !important; color: #d1fae5 !important; }

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

        /* ===== industry preset tiles ===== */
        .industry-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 168px), 1fr)); gap: 12px; margin-top: 10px; }
        .industry-tile {
            position: relative; border: 2px solid rgba(5,150,105,.15); border-radius: 14px; padding: 14px 12px;
            background: #fff; cursor: pointer; text-align: center; font-family: inherit;
            display: flex; flex-direction: column; align-items: center; gap: 3px;
            transition: transform .15s, border-color .2s, box-shadow .2s;
        }
        .industry-tile:hover { transform: translateY(-3px); border-color: #059669; box-shadow: 0 14px 28px -16px rgba(6,78,59,.4); }
        .industry-tile.active { border-color: #059669; background: rgba(5,150,105,.04); }
        .it-ic {
            width: 42px; height: 42px; border-radius: 12px; display: grid; place-items: center;
            font-size: 17px; margin-bottom: 6px;
            background: linear-gradient(135deg, rgba(5,150,105,.14), rgba(163,230,53,.18));
            color: #047857;
        }
        .industry-tile b { font-size: 12.5px; color: #12261d; line-height: 1.3; }
        .industry-tile small { font-size: 10px; color: #8b7355; }
        .it-swatch { display: flex; gap: 4px; margin-top: 6px; }
        .it-swatch i { width: 13px; height: 13px; border-radius: 50%; display: block; border: 1px solid rgba(0,0,0,.08); }
        .it-active { display: none; margin-top: 6px; font-size: 10.5px; font-weight: 800; color: #059669; }
        .industry-tile.active .it-active { display: inline-flex; gap: 4px; align-items: center; }
        .industry-tile.active::after {
            content: ''; position: absolute; inset: -6px; border-radius: 18px; pointer-events: none;
            border: 1.5px dashed rgba(5,150,105,.45);
        }
        .ind-confirm {
            margin-top: 14px; background: #fffbeb; border: 1.5px dashed #f59e0b;
            border-radius: 14px; padding: 14px 16px;
        }
        .ind-confirm p { margin: 0 0 6px; font-size: 13px; color: #92400e; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .ind-confirm-note { font-size: 11.5px; color: #a16207; }
        .ind-confirm-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
    </style>
@endsection

@push('scripts')
    <script>
        var TOKEN = '{{ csrf_token() }}';
        var THEMES = @json(\App\Http\Controllers\Admin\ThemeLibrary::all());
        var FONTS = @json($fonts);
        var MY_THEMES = @json($myThemes);
        var FESTIVE_ROWS = @json($festive);
        var LOGO_URL = @js($logoUrl);
        var currentTheme = @json($themeId);
        var grid = document.getElementById('presetGrid');
        var myGrid = document.getElementById('myThemeGrid');
        var confirmBar = document.getElementById('confirmBar');
        var pending = null; // {id, theme, name}

        var SAVE_URL = '{{ route('admin.settings.theme.save') }}';
        var CUSTOM_URL = '{{ route('admin.settings.theme.custom') }}';
        var RESET_URL = '{{ route('admin.settings.theme.reset') }}';
        var MY_SAVE_URL = '{{ route('admin.settings.theme.my.save') }}';
        var MY_DEL_URL = '{{ route('admin.settings.theme.my.delete') }}';
        var HIST_URL = '{{ route('admin.settings.theme.history.restore') }}';
        var FONTS_URL = '{{ route('admin.settings.theme.fonts') }}';
        var STYLE_URL = '{{ route('admin.settings.theme.style') }}';
        var FESTIVE_URL = '{{ route('admin.settings.theme.festive') }}';

        /* ================= shared helpers ================= */

        function postForm(url, fd) {
            /* AJAX headers so validation errors come back as JSON (not a redirect) */
            return fetch(url, {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            }).then(function (r) {
                return r.json().catch(function () { return {}; }).then(function (j) {
                    if (!r.ok) throw new Error(j.message || 'সেভ করা যায়নি — আবার চেষ্টা করুন');
                    return j;
                });
            });
        }

        function esc(s) {
            return String(s == null ? '' : s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

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

        function hexRgb(hex) {
            var h = String(hex).replace('#', '');
            if (h.length === 3) h = h[0] + h[0] + h[1] + h[1] + h[2] + h[2];
            var n = parseInt(h, 16);
            return [(n >> 16) & 255, (n >> 8) & 255, n & 255];
        }

        function rgbHex(r, g, b) {
            return '#' + [r, g, b].map(function (v) { return ('0' + Math.max(0, Math.min(255, Math.round(v))).toString(16)).slice(-2); }).join('');
        }

        function hslToHex(h, s, l) {
            s /= 100; l /= 100;
            var k = function (n) { return (n + h / 30) % 12; };
            var a = s * Math.min(l, 1 - l);
            var f = function (n) { return l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1))); };
            return rgbHex(f(16) * 255, f(8) * 255, f(0) * 255);
        }

        function hexHue(hex) {
            var c = hexRgb(hex).map(function (v) { return v / 255; });
            var mx = Math.max.apply(null, c), mn = Math.min.apply(null, c), d = mx - mn, h = 0;
            if (d) {
                if (mx === c[0]) h = ((c[1] - c[2]) / d) % 6;
                else if (mx === c[1]) h = (c[2] - c[0]) / d + 2;
                else h = (c[0] - c[1]) / d + 4;
                h *= 60; if (h < 0) h += 360;
            }
            return h;
        }

        /* ================= live preview (iframe + admin page) ================= */

        var ADMIN_VAR_KEYS = ['--ds-primary', '--ds-primary-hover', '--ds-primary-dark', '--ds-primary-xdark', '--ds-accent'];
        var lastPreview = null;

        function iframeDoc() {
            try { return document.getElementById('landingPreview').contentDocument; } catch (e) { return null; }
        }

        function previewVars(t) {
            lastPreview = t;
            var doc = iframeDoc();
            if (doc && doc.documentElement) {
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
            }
        }

        /* drop inline overrides -> iframe falls back to its saved (DB) theme */
        function restorePreview() {
            lastPreview = null;
            var doc = iframeDoc();
            if (doc && doc.documentElement) {
                var s = doc.documentElement.style;
                ['--ds-primary', '--ds-primary-hover', '--ds-primary-dark', '--ds-primary-xdark',
                 '--ds-accent', '--ds-accent-light', '--ds-lime', '--ds-lime-neon', '--ds-lime-deep',
                 '--ds-teal', '--ds-teal-light', '--ds-primary-rgb', '--ds-primary-dark-rgb',
                 '--ds-primary-xdark-rgb', '--ds-accent-rgb', '--ds-lime-rgb', '--ds-lime-neon-rgb',
                 '--ds-teal-rgb'].forEach(function (k) { s.removeProperty(k); });
            }
        }

        function applyAdminVars(t) {
            var s = document.documentElement.style;
            ADMIN_VAR_KEYS.forEach(function (k) { s.removeProperty(k); });
            s.setProperty('--ds-primary', t.primary);
            s.setProperty('--ds-primary-hover', t.hover);
            s.setProperty('--ds-primary-dark', t.dark);
            s.setProperty('--ds-primary-xdark', t.xdark);
            s.setProperty('--ds-accent', t.accent);
        }

        function clearAdminVars() {
            var s = document.documentElement.style;
            ADMIN_VAR_KEYS.forEach(function (k) { s.removeProperty(k); });
        }

        /* re-apply pending preview when the iframe finishes (re)loading */
        document.getElementById('landingPreview').addEventListener('load', function () {
            if (lastPreview) previewVars(lastPreview);
            previewStyleTokens();
            previewFonts();
        });

        function setPrevWidth(btn) {
            document.querySelectorAll('.lp-dev-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            document.getElementById('prevFrameWrap').classList.toggle('mobile', btn.dataset.w === 'mobile');
        }

        function prevJump(id) {
            var doc = iframeDoc();
            if (!doc) return;
            if (id === 'top') { doc.documentElement.scrollTo({ top: 0, behavior: 'smooth' }); return; }
            var el = doc.getElementById(id);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        }

        /* ================= theme cards (presets + my themes) ================= */

        function markActiveCard(el) {
            document.querySelectorAll('.preset-card').forEach(function (c) { c.classList.remove('active'); });
            if (el) el.classList.add('active');
        }

        function markCurrentTheme() {
            var found = null;
            document.querySelectorAll('.preset-card').forEach(function (c) {
                if (c.dataset.themeId === currentTheme) found = c;
            });
            markActiveCard(found);
        }

        function cardHtml(t, bn, en) {
            return '<div class="preset-swatches">' +
                '<i style="background:' + t.primary + '"></i>' +
                '<i style="background:' + t.accent + '"></i>' +
                '<i style="background:' + t.dark + '"></i>' +
                '<i style="background:' + t.limeNeon + '"></i>' +
                '</div><b>' + esc(bn) + '</b><span>' + esc(en) + '</span>';
        }

        function bindCard(btn, id, t, bn) {
            btn.style.setProperty('--sc', t.primary);
            btn.dataset.themeId = id;
            btn.addEventListener('mouseenter', function () { previewVars(t); });
            btn.addEventListener('mouseleave', function () { if (!pending) restorePreview(); else previewVars(pending.theme); });
            btn.onclick = function () { selectTheme(id, t, bn, btn); };
        }

        Object.keys(THEMES).forEach(function (id) {
            var t = THEMES[id];
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'preset-card';
            btn.innerHTML = cardHtml(t, t.bn, t.en);
            bindCard(btn, id, t, t.bn);
            grid.appendChild(btn);
        });

        MY_THEMES.forEach(function (m) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'preset-card';
            btn.innerHTML = cardHtml(m.theme, m.name, 'আমার থিম') +
                '<span class="my-del" role="button" title="মুছে ফেলুন">×</span>';
            btn.querySelector('.my-del').addEventListener('click', function (e) {
                e.stopPropagation();
                swConfirm({ title: '"' + m.name + '" থিমটি মুছে ফেলবেন?', icon: 'warning' }).then(function (ok) {
                    if (!ok) return;
                    var fd = new FormData();
                    fd.append('_token', TOKEN);
                    fd.append('id', m.id);
                    postForm(MY_DEL_URL, fd).then(function () { btn.remove(); }).catch(showErr);
                });
            });
            bindCard(btn, m.id, m.theme, m.name);
            myGrid.appendChild(btn);
        });

        if (!MY_THEMES.length) {
            myGrid.innerHTML = '<p class="desc" style="grid-column:1/-1;margin:0">এখনো কোনো সেভ করা থিম নেই — নিচের কাস্টম কালার বানিয়ে "লাইব্রেরিতে সেভ করুন" চাপুন।</p>';
        }

        markCurrentTheme();

        /* ---------- select -> confirm -> apply flow ---------- */

        function selectTheme(id, t, name, btnEl) {
            pending = { id: id, theme: t, name: name };
            markActiveCard(btnEl);
            previewVars(t);
            applyAdminVars(t);
            document.getElementById('confirmName').textContent = '“' + name + '”';
            confirmBar.hidden = false;
        }

        function cancelPending() {
            pending = null;
            confirmBar.hidden = true;
            restorePreview();
            clearAdminVars();
            markCurrentTheme();
        }

        function applyPending() {
            if (!pending) return;
            var p = pending;
            var fd = new FormData();
            fd.append('_token', TOKEN);
            fd.append('theme_id', p.id);
            fd.append('theme_json', JSON.stringify(p.theme));
            postForm(SAVE_URL, fd)
                .then(function () { showToast('“' + p.name + '” থিম প্রয়োগ ও সেভ হয়েছে'); window.location.reload(); })
                .catch(showErr);
        }

        function showErr(err) { showToast(err && err.message ? err.message : 'কিছু একটা সমস্যা হয়েছে'); }

        /* ================= custom colors + contrast ================= */

        var cpP = document.getElementById('cpPrimary');
        var cpD = document.getElementById('cpDark');
        var cpA = document.getElementById('cpAccent');

        /* WCAG relative luminance + contrast ratio */
        function relLum(hex) {
            var c = hexRgb(hex).map(function (v) {
                v /= 255;
                return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
            });
            return 0.2126 * c[0] + 0.7152 * c[1] + 0.0722 * c[2];
        }

        function contrastRatio(a, b) {
            var l1 = relLum(a), l2 = relLum(b);
            return (Math.max(l1, l2) + 0.05) / (Math.min(l1, l2) + 0.05);
        }

        function updateContrast() {
            [['Primary', cpP], ['Dark', cpD]].forEach(function (pair) {
                var key = pair[0], cp = pair[1];
                var ratio = contrastRatio(cp.value, '#ffffff');
                document.getElementById('cChip' + key).style.background = cp.value;
                document.getElementById('cRatio' + key).textContent = ratio.toFixed(2) + ':1';
                var badge = document.getElementById('cBadge' + key);
                var fixBtn = document.getElementById('cFix' + key);
                if (ratio >= 4.5) { badge.textContent = '✓ ভালো'; badge.className = 'c-badge ok'; fixBtn.hidden = true; }
                else if (ratio >= 3) { badge.textContent = '≈ বড় লেখায় ঠিক'; badge.className = 'c-badge warn'; fixBtn.hidden = false; }
                else { badge.textContent = '✕ পড়া কঠিন'; badge.className = 'c-badge bad'; fixBtn.hidden = false; }
            });
        }

        function fixContrast(which) {
            var cp = which === 'primary' ? cpP : cpD;
            var v = cp.value, tries = 0;
            while (contrastRatio(v, '#ffffff') < 4.5 && tries < 16) { v = shade(v, -0.07); tries++; }
            if (contrastRatio(v, '#ffffff') < 4.5) v = '#1f2937';
            cp.value = v;
            syncCustom();
            showToast('রঙ একটু গাঢ় করা হয়েছে — এখন সাদা লেখা স্পষ্ট পড়া যাবে');
        }

        function syncCustom() {
            document.getElementById('hexPrimary').textContent = cpP.value;
            document.getElementById('hexDark').textContent = cpD.value;
            document.getElementById('hexAccent').textContent = cpA.value;
            previewVars(deriveTheme(cpP.value, cpD.value, cpA.value));
            updateContrast();
        }

        cpP.addEventListener('input', syncCustom);
        cpD.addEventListener('input', syncCustom);
        cpA.addEventListener('input', syncCustom);

        /* initial picker values: continue from the saved custom theme, if any */
        @if ($themeId === 'custom')
            (function () {
                var saved = @json(json_decode($themeJson, true));
                if (saved && saved.primary) { cpP.value = saved.primary; cpD.value = saved.dark; cpA.value = saved.accent; }
            })();
        @endif
        syncCustom();

        /* ---------- logo -> theme (color extraction) ---------- */

        function extractLogoTheme() {
            if (!LOGO_URL) { showToast('আগে ব্র্যান্ড পেজে লোগো আপলোড করুন'); return; }
            var img = new Image();
            img.onload = function () {
                try { buildFromPixels(canvasPixels(img)); }
                catch (e) { extractFromSvgText(); }
            };
            img.onerror = extractFromSvgText;
            img.src = LOGO_URL;
        }

        function canvasPixels(img) {
            var c = document.createElement('canvas');
            c.width = 72; c.height = 72;
            var ctx = c.getContext('2d');
            ctx.drawImage(img, 0, 0, 72, 72);
            var d = ctx.getImageData(0, 0, 72, 72).data, out = [];
            for (var i = 0; i < d.length; i += 4) out.push([d[i], d[i + 1], d[i + 2], d[i + 3]]);
            return out;
        }

        function extractFromSvgText() {
            fetch(LOGO_URL).then(function (r) { return r.text(); }).then(function (txt) {
                var matches = txt.match(/#(?:[0-9a-fA-F]{6}|[0-9a-fA-F]{3})\b|rgba?\([^)]+\)/g) || [];
                var cols = [];
                matches.forEach(function (m) {
                    if (m[0] === '#') {
                        var h = m.slice(1);
                        if (h.length === 3) h = h[0] + h[0] + h[1] + h[1] + h[2] + h[2];
                        var n = parseInt(h, 16);
                        cols.push([(n >> 16) & 255, (n >> 8) & 255, n & 255, 255]);
                    } else {
                        var parts = m.replace(/rgba?\(|\)/g, '').split(',').map(Number);
                        cols.push([parts[0], parts[1], parts[2], 255]);
                    }
                });
                if (!cols.length) { showToast('লোগো থেকে রঙ বের করা গেল না — হাতে বাছুন'); return; }
                buildFromPixels(cols);
            }).catch(function () { showToast('লোগো থেকে রঙ বের করা গেল না'); });
        }

        /* bucket pixels into color clusters, pick the strongest vivid ones */
        function buildFromPixels(pixels) {
            var buckets = {};
            pixels.forEach(function (p) {
                var r = p[0], g = p[1], b = p[2], a = p[3] === undefined ? 255 : p[3];
                if (a < 120) return;
                var mx = Math.max(r, g, b), mn = Math.min(r, g, b);
                if (mn > 210 && mx > 238) return;          /* near white */
                if (r + g + b < 70) return;                /* near black */
                var key = (r >> 5) + '_' + (g >> 5) + '_' + (b >> 5);
                if (!buckets[key]) buckets[key] = { n: 0, r: 0, g: 0, b: 0 };
                buckets[key].n++; buckets[key].r += r; buckets[key].g += g; buckets[key].b += b;
            });

            var entries = Object.keys(buckets).map(function (k) {
                var b = buckets[k];
                var r = b.r / b.n, g = b.g / b.n, bl = b.b / b.n;
                var mx = Math.max(r, g, bl), mn = Math.min(r, g, bl);
                var sat = mx === 0 ? 0 : (mx - mn) / mx;
                return { hex: rgbHex(r, g, bl), score: b.n * (0.3 + sat), sat: sat };
            }).sort(function (a, b) { return b.score - a.score; });

            if (!entries.length) { showToast('লোগো থেকে রঙ বের করা গেল না'); return; }

            var primary = entries[0].sat > 0.2 ? entries[0] : (entries.find(function (e) { return e.sat > 0.2; }) || entries[0]);
            var accent = null, pHue = hexHue(primary.hex);
            for (var i = 1; i < entries.length; i++) {
                if (Math.abs(hexHue(entries[i].hex) - pHue) > 40 && Math.abs(hexHue(entries[i].hex) - pHue) < 320) { accent = entries[i]; break; }
            }
            var accentHex = accent ? accent.hex : shade(primary.hex, 0.3);

            setPickers(primary.hex, shade(primary.hex, -0.72), accentHex);
            showToast('লোগো থেকে থিম তৈরি হয়েছে — পছন্দ হলে "কাস্টম থিম প্রয়োগ করুন" চাপুন');
        }

        function setPickers(p, d, a) { cpP.value = p; cpD.value = d; cpA.value = a; syncCustom(); }

        /* ---------- surprise theme (random harmony) ---------- */

        function surpriseTheme() {
            var h = Math.floor(Math.random() * 360);
            var s = 62 + Math.floor(Math.random() * 18);
            var primary = hslToHex(h, s, 38 + Math.floor(Math.random() * 6));
            var dark = hslToHex(h, Math.max(40, s - 15), 16);
            var jumps = [28, 40, 160, 190, 220];
            var accent = hslToHex((h + jumps[Math.floor(Math.random() * jumps.length)]) % 360, 66, 46);
            setPickers(primary, dark, accent);
            showToast('নতুন থিম বানানো হয়েছে 🎲 — পছন্দ হলে প্রয়োগ করুন');
        }

        /* ---------- custom apply / reset / save-as-my-theme ---------- */

        function applyCustomTheme() {
            var fd = new FormData();
            fd.append('_token', TOKEN);
            fd.append('primary', cpP.value);
            fd.append('dark', cpD.value);
            fd.append('accent', cpA.value);
            postForm(CUSTOM_URL, fd)
                .then(function () { showToast('কাস্টম থিম প্রয়োগ হয়েছে — ল্যান্ডিং পেজে দেখুন!'); window.location.reload(); })
                .catch(showErr);
        }

        function resetTheme() {
            var fd = new FormData();
            fd.append('_token', TOKEN);
            postForm(RESET_URL, fd)
                .then(function () { showToast('ডিফল্ট থিমে ফিরে গেছে'); window.location.reload(); })
                .catch(showErr);
        }

        function saveMyTheme() {
            var nameEl = document.getElementById('myThemeName');
            var name = nameEl.value.trim();
            if (!name) { showToast('আগে থিমের নাম দিন'); nameEl.focus(); return; }
            var fd = new FormData();
            fd.append('_token', TOKEN);
            fd.append('name', name);
            fd.append('primary', cpP.value);
            fd.append('dark', cpD.value);
            fd.append('accent', cpA.value);
            postForm(MY_SAVE_URL, fd)
                .then(function () { showToast('"' + name + '" লাইব্রেরিতে সেভ হয়েছে'); window.location.reload(); })
                .catch(showErr);
        }

        /* ---------- history restore ---------- */

        function restoreHistory(index) {
            var fd = new FormData();
            fd.append('_token', TOKEN);
            fd.append('index', index);
            postForm(HIST_URL, fd)
                .then(function () { showToast('আগের থিমে ফিরে গেছে'); window.location.reload(); })
                .catch(showErr);
        }

        /* ================= fonts ================= */

        var selHead = document.getElementById('selFontHeading');
        var selBody = document.getElementById('selFontBody');

        function injectFontPreview(doc, bodyStack, headStack, google) {
            try {
                var old = doc.getElementById('fontPrevStyle');
                if (old) old.remove();
                var st = doc.createElement('style');
                st.id = 'fontPrevStyle';
                st.textContent = 'body{font-family:' + bodyStack + ' !important}' +
                    (headStack ? 'h1,h2,h3,h4,h5,h6{font-family:' + headStack + ' !important}' : '');
                doc.head.appendChild(st);
                if (google.length) {
                    var lk = doc.createElement('link');
                    lk.rel = 'stylesheet';
                    lk.href = 'https://fonts.googleapis.com/css2?' + google.map(function (g) { return 'family=' + g; }).join('&') + '&display=swap';
                    doc.head.appendChild(lk);
                }
            } catch (e) { /* not ready */ }
        }

        function previewFonts() {
            var bf = FONTS[selBody.value], hf = selHead.value ? FONTS[selHead.value] : null;
            if (!bf) return;
            var google = [bf.google, hf ? hf.google : ''].filter(Boolean);
            injectFontPreview(document, bf.stack, hf ? hf.stack : '', google);
            var doc = iframeDoc();
            if (doc && doc.head) injectFontPreview(doc, bf.stack, hf ? hf.stack : '', google);
        }

        function saveFonts() {
            var fd = new FormData();
            fd.append('_token', TOKEN);
            fd.append('font_heading', selHead.value);
            fd.append('font_body', selBody.value);
            postForm(FONTS_URL, fd)
                .then(function () { showToast('ফন্ট সেভ হয়েছে — ল্যান্ডিং পেজে দেখুন'); window.location.reload(); })
                .catch(showErr);
        }

        /* ================= style tokens (corner + shadow) ================= */

        var RADIUS_PRESETS = {
            sharp: { '--ds-radius-sm': '4px', '--ds-radius-md': '8px', '--ds-radius-lg': '12px', '--ds-radius-xl': '16px', '--ds-radius-full': '10px' },
            rounded: { '--ds-radius-sm': '12px', '--ds-radius-md': '20px', '--ds-radius-lg': '28px', '--ds-radius-xl': '36px' }
        };
        var SHADOW_PRESETS = {
            soft: {
                '--ds-shadow-xs': '0 1px 2px rgba(0,0,0,.03)', '--ds-shadow-sm': '0 2px 8px -2px rgba(6,78,59,.05)',
                '--ds-shadow-md': '0 6px 18px -8px rgba(6,78,59,.08)', '--ds-shadow-lg': '0 12px 30px -12px rgba(6,78,59,.12)',
                '--ds-shadow-glow': '0 0 20px rgba(16,185,129,.2)'
            },
            strong: {
                '--ds-shadow-xs': '0 2px 6px rgba(0,0,0,.07)', '--ds-shadow-sm': '0 8px 22px -4px rgba(6,78,59,.16)',
                '--ds-shadow-md': '0 18px 42px -8px rgba(6,78,59,.22)', '--ds-shadow-lg': '0 28px 70px -12px rgba(6,78,59,.3)',
                '--ds-shadow-glow': '0 0 55px rgba(16,185,129,.5)'
            }
        };
        var ALL_TOKEN_KEYS = [].concat(
            Object.keys(RADIUS_PRESETS.sharp), Object.keys(RADIUS_PRESETS.rounded),
            Object.keys(SHADOW_PRESETS.soft), Object.keys(SHADOW_PRESETS.strong)
        );

        function segVal(id) {
            var on = document.getElementById(id).querySelector('button.on');
            return on ? on.dataset.v : 'default';
        }

        document.querySelectorAll('.seg button').forEach(function (btn) {
            btn.addEventListener('click', function () {
                btn.parentNode.querySelectorAll('button').forEach(function (b) { b.classList.remove('on'); });
                btn.classList.add('on');
                previewStyleTokens();
            });
        });

        function previewStyleTokens() {
            var vars = {};
            var r = RADIUS_PRESETS[segVal('segRadius')], s = SHADOW_PRESETS[segVal('segShadow')];
            if (r) Object.keys(r).forEach(function (k) { vars[k] = r[k]; });
            if (s) Object.keys(s).forEach(function (k) { vars[k] = s[k]; });
            [iframeDoc() ? iframeDoc().documentElement : null, document.documentElement].forEach(function (el) {
                if (!el) return;
                ALL_TOKEN_KEYS.forEach(function (k) { el.style.removeProperty(k); });
                Object.keys(vars).forEach(function (k) { el.style.setProperty(k, vars[k]); });
            });
        }

        function saveStyle() {
            var fd = new FormData();
            fd.append('_token', TOKEN);
            fd.append('style_radius', segVal('segRadius'));
            fd.append('style_shadow', segVal('segShadow'));
            postForm(STYLE_URL, fd)
                .then(function () { showToast('স্টাইল সেভ হয়েছে — ল্যান্ডিং পেজে দেখুন'); window.location.reload(); })
                .catch(showErr);
        }

        /* ================= festive auto-schedule ================= */

        function getThemeObj(id) {
            if (THEMES[id]) return THEMES[id];
            for (var i = 0; i < MY_THEMES.length; i++) {
                if (MY_THEMES[i].id === id) return MY_THEMES[i].theme;
            }
            return THEMES.herbal;
        }

        function themeOptionsHtml(sel) {
            var html = '';
            Object.keys(THEMES).forEach(function (id) {
                html += '<option value="' + id + '"' + (sel === id ? ' selected' : '') + '>' + esc(THEMES[id].bn) + '</option>';
            });
            MY_THEMES.forEach(function (m) {
                html += '<option value="' + m.id + '"' + (sel === m.id ? ' selected' : '') + '>★ ' + esc(m.name) + '</option>';
            });
            return html;
        }

        function addFestRow(d) {
            d = d || { label: '', theme_id: 'herbal', start: '', end: '', enabled: 1 };
            var row = document.createElement('div');
            row.className = 'fest-row';
            row.innerHTML =
                '<input class="a-input f-label" maxlength="50" placeholder="নাম (যেমন: ঈদ সেল)" value="' + esc(d.label) + '">' +
                '<select class="a-input f-theme">' + themeOptionsHtml(d.theme_id) + '</select>' +
                '<input type="date" class="a-input f-start" value="' + esc(d.start) + '">' +
                '<input type="date" class="a-input f-end" value="' + esc(d.end) + '">' +
                '<label class="f-on"><input type="checkbox" class="f-enabled"' + (d.enabled ? ' checked' : '') + '> চালু</label>' +
                '<button type="button" class="f-del" title="মুছুন" onclick="this.parentNode.remove()">×</button>';
            document.getElementById('festRows').appendChild(row);
        }

        function quickFest(label, start, end, themeId) {
            addFestRow({ label: label, theme_id: themeId, start: new Date().getFullYear() + '-' + start, end: new Date().getFullYear() + '-' + end, enabled: 1 });
        }

        FESTIVE_ROWS.forEach(function (r) { addFestRow(r); });

        function saveFestive() {
            var rows = [];
            var err = null;
            document.querySelectorAll('.fest-row').forEach(function (row, i) {
                var label = row.querySelector('.f-label').value.trim();
                var start = row.querySelector('.f-start').value;
                var end = row.querySelector('.f-end').value;
                if (!err && !label) err = 'সারি ' + (i + 1) + ': নাম দিন';
                if (!err && (!start || !end)) err = 'সারি ' + (i + 1) + ': শুরু ও শেষ তারিখ দিন';
                if (!err && end < start) err = 'সারি ' + (i + 1) + ': শেষ তারিখ শুরুর আগে হতে পারে না';
                rows.push({
                    label: label,
                    theme_id: row.querySelector('.f-theme').value,
                    theme_json: JSON.stringify(getThemeObj(row.querySelector('.f-theme').value)),
                    start: start,
                    end: end,
                    enabled: row.querySelector('.f-enabled').checked ? 1 : 0
                });
            });
            if (err) { showToast(err); return; }

            var fd = new FormData();
            fd.append('_token', TOKEN);
            rows.forEach(function (r, i) {
                fd.append('rows[' + i + '][label]', r.label);
                fd.append('rows[' + i + '][theme_id]', r.theme_id);
                fd.append('rows[' + i + '][theme_json]', r.theme_json);
                fd.append('rows[' + i + '][start]', r.start);
                fd.append('rows[' + i + '][end]', r.end);
                fd.append('rows[' + i + '][enabled]', r.enabled);
            });
            postForm(FESTIVE_URL, fd)
                .then(function () { showToast('উৎসব শিডিউল সেভ হয়েছে'); window.location.reload(); })
                .catch(showErr);
        }

        /* ===== industry preset apply ===== */
        var IND_SELECTED = null;

        function pickIndustry(key) {
            IND_SELECTED = key;
            document.getElementById('indConfirmTitle').textContent =
                '"' + key + '" ইন্ডাস্ট্রি প্রিসেট প্রয়োগ করতে চান?';
            document.getElementById('indConfirm').hidden = false;
            document.getElementById('indConfirm').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
        function cancelIndustry() {
            IND_SELECTED = null;
            document.getElementById('indConfirm').hidden = true;
        }
        function applyIndustry(mode) {
            if (!IND_SELECTED) return;
            var buttons = [document.getElementById('indApplyFull'), document.getElementById('indApplyVisual')];
            buttons.forEach(function (b) { b.disabled = true; });
            var fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('industry', IND_SELECTED);
            fd.append('mode', mode);
            fetch('{{ route('admin.settings.industry.apply') }}', {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: fd
            })
                .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, json: j }; }); })
                .then(function (res) {
                    showToast(res.json.message || (res.ok ? 'প্রয়োগ হয়েছে' : 'ব্যর্থ'));
                    if (res.ok) setTimeout(function () { window.location.reload(); }, 800);
                    else buttons.forEach(function (b) { b.disabled = false; });
                })
                .catch(function () {
                    buttons.forEach(function (b) { b.disabled = false; });
                    showToast('নেটওয়ার্ক সমস্যা — আবার চেষ্টা করুন');
                });
        }
        function clearIndustry() {
            swConfirm({
                title: 'ডিফল্ট আচারবাড়ি লুকে ফিরে যেতে হবে?',
                text: 'থিম হার্বাল গ্রিন হবে।',
                confirmText: 'হ্যাঁ, ফিরে যান'
            }).then(function (ok) {
                if (!ok) return;
                var fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fetch('{{ route('admin.settings.industry.clear') }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: fd
            })
                .then(function (r) { return r.json(); })
                .then(function (j) { showToast(j.message); setTimeout(function () { window.location.reload(); }, 700); })
                .catch(function () { showToast('ব্যর্থ'); });
        }
    </script>
@endpush
