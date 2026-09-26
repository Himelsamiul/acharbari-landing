@extends('layouts.admin')

@section('title', 'কমপ্লেইন')
@section('page_title', 'কমপ্লেইন')
@section('page_sub', 'কাস্টমারদের কমপ্লেইন দেখুন ও সমাধান করুন')

@php
    $avatarPalette = [
        ['#059669', '#34d399'], ['#0ea5e9', '#7dd3fc'], ['#d97706', '#fbbf24'],
        ['#7c3aed', '#a78bfa'], ['#dc2626', '#f87171'], ['#0d9488', '#5eead4'],
    ];
@endphp

@section('content')
    {{-- ===== STATS ===== --}}
    <div class="cmp-stats">
        <div class="cmp-stat">
            <span class="cs-ic" style="--cc:#059669"><i class="fa-solid fa-inbox"></i></span>
            <div class="cs-body"><b>{{ bn_num($stats['total']) }}</b><small>মোট কমপ্লেইন</small></div>
        </div>
        <div class="cmp-stat {{ $stats['open'] ? 'is-alert' : '' }}">
            <span class="cs-ic" style="--cc:#dc2626"><i class="fa-solid fa-triangle-exclamation"></i></span>
            <div class="cs-body"><b>{{ bn_num($stats['open']) }}</b><small>অমীমাংসিত</small></div>
            @if ($stats['open'])
                <span class="cs-flag">দ্রুত দেখুন</span>
            @endif
        </div>
        <div class="cmp-stat">
            <span class="cs-ic" style="--cc:#16a34a"><i class="fa-solid fa-circle-check"></i></span>
            <div class="cs-body"><b>{{ bn_num($stats['resolved']) }}</b><small>সমাধান হয়েছে</small></div>
        </div>
    </div>

    <div class="card">
        <div class="cmp-head">
            <div>
                <h3>সব কমপ্লেইন <span class="cmp-count" id="cmpCount"></span></h3>
                <p class="desc">ল্যান্ডিং পেজের "কমপ্লেইন" ফর্ম থেকে আসা অভিযোগ — সমাধান হলে ✓ চাপুন।</p>
            </div>
            <div class="cmp-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input id="cmpSearch" class="a-input" placeholder="নাম, ফোন বা অর্ডার আইডি…" autocomplete="off">
            </div>
        </div>

        @if ($complaints->count())
            <div class="cmp-filters" id="cmpFilters">
                <button type="button" class="cmp-f active" data-f="all">সব <span class="cmp-fc" data-c="all"></span></button>
                <button type="button" class="cmp-f" data-f="open"><i class="fa-solid fa-circle" data-open-dot></i> অমীমাংসিত <span class="cmp-fc" data-c="open"></span></button>
                <button type="button" class="cmp-f" data-f="done">সমাধান হয়েছে <span class="cmp-fc" data-c="done"></span></button>
            </div>

            <div class="cmp-list" id="cmpList">
                @foreach ($complaints as $complaint)
                    @php
                        $pal = $avatarPalette[crc32((string) $complaint->phone) % count($avatarPalette)];
                        $long = mb_strlen(trim((string) $complaint->description)) > 130;
                    @endphp
                    <div class="cmp-row {{ $complaint->is_resolved ? 'is-done' : '' }}"
                        data-state="{{ $complaint->is_resolved ? 'done' : 'open' }}"
                        data-search="{{ mb_strtolower($complaint->name . ' ' . $complaint->phone . ' ' . ($complaint->order_code ?? '') . ' ' . $complaint->description) }}">
                        <span class="cmp-avatar" style="background:linear-gradient(135deg, {{ $pal[0] }}, {{ $pal[1] }})">{{ mb_substr(trim($complaint->name), 0, 1) }}</span>

                        <div class="cmp-main">
                            <div class="cmp-top">
                                <b class="cmp-name">{{ $complaint->name }}</b>
                                <a class="cmp-phone" href="tel:{{ $complaint->phone }}"><i class="fa-solid fa-phone"></i> {{ $complaint->phone }}</a>
                                @if ($complaint->order_code)
                                    <code class="cmp-order"><i class="fa-solid fa-box"></i> {{ $complaint->order_code }}</code>
                                @endif
                            </div>

                            <p class="cmp-desc {{ $long ? 'is-clamped' : '' }}">{{ $complaint->description }}</p>
                            @if ($long)
                                <button type="button" class="cmp-more">আরো দেখুন <i class="fa-solid fa-chevron-down"></i></button>
                            @endif

                            <div class="cmp-meta">
                                <span class="cmp-badge {{ $complaint->is_resolved ? 'done' : 'open' }}">
                                    <i class="fa-solid {{ $complaint->is_resolved ? 'fa-check' : 'fa-circle' }}"></i>
                                    {{ $complaint->is_resolved ? 'সমাধান হয়েছে' : 'অমীমাংসিত' }}
                                </span>
                                <span class="cmp-time" title="{{ $complaint->created_at->format('d M, h:i A') }}" data-ts="{{ $complaint->created_at->toIso8601String() }}">
                                    <i class="fa-regular fa-clock"></i> {{ $complaint->created_at->format('d M, h:i A') }}
                                </span>
                            </div>
                        </div>

                        <div class="cmp-actions">
                            <form method="POST" action="{{ route('admin.complaints.toggle', $complaint) }}">
                                @csrf
                                <button type="submit" class="cmp-act resolve" title="{{ $complaint->is_resolved ? 'পুনরায় খুলুন' : 'সমাধান হয়েছে চিহ্নিত করুন' }}">
                                    <i class="fa-solid {{ $complaint->is_resolved ? 'fa-rotate-left' : 'fa-check' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.complaints.destroy', $complaint) }}"
                                onsubmit="return confirm('কমপ্লেইনটি মুছে ফেলবেন?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cmp-act del" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cmp-nomatch" id="cmpNoMatch" hidden>
                <i class="fa-solid fa-magnifying-glass-minus"></i> কোনো কমপ্লেইন মেলেনি — সার্চ বা ফিল্টার বদলে দেখুন।
            </div>

            @if ($complaints->hasPages())
                <div class="cmp-pager">{{ $complaints->withQueryString()->links() }}</div>
            @endif
        @else
            <div class="cmp-empty">
                <span class="ce-ic"><i class="fa-regular fa-face-smile-beam"></i></span>
                <b>এখনো কোনো কমপ্লেইন আসেনি 🎉</b>
                <p>ল্যান্ডিং পেজের কমপ্লেইন ফর্মে কেউ লিখলে সেটা এখানে দেখা যাবে।</p>
            </div>
        @endif
    </div>

    <style>
        /* ---- stats row ---- */
        .cmp-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 180px), 1fr)); gap: 14px; margin-bottom: 18px; }
        .cmp-stat {
            position: relative; display: flex; align-items: center; gap: 14px; overflow: hidden;
            background: #fff; border: 1px solid rgba(5, 150, 105, .12); border-radius: 16px; padding: 16px 18px;
            box-shadow: 0 1px 2px rgba(6, 78, 59, .04); transition: transform .15s, box-shadow .2s;
        }
        .cmp-stat:hover { transform: translateY(-2px); box-shadow: 0 16px 34px -18px rgba(6, 78, 59, .45); }
        .cs-ic {
            width: 44px; height: 44px; border-radius: 13px; flex-shrink: 0; font-size: 17px;
            display: grid; place-items: center;
            background: color-mix(in srgb, var(--cc, #059669) 12%, white);
            color: var(--cc, #059669);
        }
        .cs-body b { display: block; font-size: 22px; line-height: 1.1; color: #12261d; }
        .cs-body small { font-size: 12px; color: #8b7355; font-weight: 600; }
        .cmp-stat.is-alert { border-color: rgba(220, 38, 38, .28); background: linear-gradient(135deg, #fff, rgba(220, 38, 38, .04)); }
        .cs-flag {
            position: absolute; top: 12px; right: 12px; font-size: 10px; font-weight: 800; color: #b91c1c;
            background: rgba(220, 38, 38, .09); border-radius: 999px; padding: 3px 9px;
            animation: cmp-pulse 2.2s ease-in-out infinite;
        }
        @keyframes cmp-pulse { 0%, 100% { opacity: 1; } 50% { opacity: .45; } }

        /* ---- head + search ---- */
        .cmp-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; flex-wrap: wrap; }
        .cmp-head h3 { margin: 0; }
        .cmp-count { font-size: 12px; color: #8b7355; font-weight: 600; }
        .cmp-search { position: relative; display: flex; align-items: center; }
        .cmp-search > i { position: absolute; left: 13px; color: #059669; font-size: 13px; pointer-events: none; }
        .cmp-search .a-input { padding-left: 34px; min-width: 250px; border-radius: 999px; }

        /* ---- filter chips ---- */
        .cmp-filters { display: flex; gap: 8px; flex-wrap: wrap; margin: 14px 0 4px; }
        .cmp-f {
            border: 1.5px solid rgba(5, 150, 105, .22); background: #fff; color: #1f4234; cursor: pointer;
            padding: 7px 15px; border-radius: 999px; font-size: 12.5px; font-weight: 700; font-family: inherit;
            display: inline-flex; align-items: center; gap: 7px; transition: all .15s;
        }
        .cmp-f:hover { border-color: #059669; background: rgba(5, 150, 105, .05); }
        .cmp-f.active { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border-color: transparent; box-shadow: 0 8px 18px -8px rgba(5, 150, 105, .6); }
        .cmp-fc { font-size: 11px; background: rgba(5, 150, 105, .12); border-radius: 999px; padding: 1px 8px; }
        .cmp-f.active .cmp-fc { background: rgba(255, 255, 255, .22); }
        .cmp-f [data-open-dot] { font-size: 7px; color: #dc2626; animation: cmp-pulse 1.6s infinite; }
        .cmp-f.active [data-open-dot] { color: #fecaca; }

        /* ---- list rows ---- */
        .cmp-list { display: flex; flex-direction: column; margin-top: 10px; }
        .cmp-row {
            display: flex; gap: 14px; align-items: flex-start; padding: 16px 6px;
            border-bottom: 1px solid rgba(5, 150, 105, .09); border-radius: 12px;
            transition: background .15s; animation: cmp-in .25s ease both;
        }
        .cmp-row:nth-child(2) { animation-delay: .03s; } .cmp-row:nth-child(3) { animation-delay: .06s; }
        .cmp-row:nth-child(4) { animation-delay: .09s; } .cmp-row:nth-child(5) { animation-delay: .12s; }
        @keyframes cmp-in { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }
        .cmp-row:hover { background: rgba(5, 150, 105, .04); }
        .cmp-row:last-child { border-bottom: 0; }

        .cmp-avatar {
            width: 42px; height: 42px; border-radius: 13px; flex-shrink: 0;
            display: grid; place-items: center; color: #fff; font-size: 17px; font-weight: 800;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3), 0 6px 14px -6px rgba(6, 78, 59, .5);
        }
        .cmp-main { flex: 1; min-width: 0; }
        .cmp-top { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .cmp-name { font-size: 14px; color: #12261d; }
        .cmp-phone { font-size: 12px; color: #8b7355; text-decoration: none; display: inline-flex; gap: 5px; align-items: center; }
        .cmp-phone:hover { color: #059669; }
        .cmp-order {
            font-size: 11px; color: #065f46; background: rgba(5, 150, 105, .08);
            border: 1px dashed rgba(5, 150, 105, .3); border-radius: 7px; padding: 2px 8px;
            display: inline-flex; gap: 5px; align-items: center;
        }
        .cmp-desc { margin: 6px 0 0; font-size: 13px; color: #44403c; line-height: 1.55; white-space: pre-wrap; word-break: break-word; }
        .cmp-desc.is-clamped { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .cmp-more {
            border: 0; background: none; color: #059669; font-size: 11.5px; font-weight: 700; cursor: pointer;
            font-family: inherit; padding: 3px 0; display: inline-flex; gap: 5px; align-items: center;
        }
        .cmp-more:hover { text-decoration: underline; }

        .cmp-meta { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-top: 8px; }
        .cmp-badge {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 800; border-radius: 999px; padding: 3px 11px;
        }
        .cmp-badge.open { background: rgba(220, 38, 38, .09); color: #dc2626; }
        .cmp-badge.open i { font-size: 6px; animation: cmp-pulse 1.6s infinite; }
        .cmp-badge.done { background: rgba(22, 163, 74, .11); color: #16a34a; }
        .cmp-time { font-size: 11.5px; color: #a8a29e; display: inline-flex; gap: 5px; align-items: center; }

        .cmp-actions { display: flex; flex-direction: column; gap: 7px; flex-shrink: 0; }
        .cmp-actions form { margin: 0; }
        .cmp-act {
            width: 34px; height: 34px; border-radius: 10px; cursor: pointer; font-size: 13px;
            border: 1.5px solid rgba(5, 150, 105, .2); background: #fff; color: #059669;
            display: grid; place-items: center; transition: all .15s;
        }
        .cmp-act:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -10px rgba(6, 78, 59, .5); }
        .cmp-act.resolve:hover { background: #16a34a; border-color: #16a34a; color: #fff; }
        .cmp-act.del { border-color: rgba(220, 38, 38, .25); color: #dc2626; }
        .cmp-act.del:hover { background: #dc2626; border-color: #dc2626; color: #fff; }

        /* resolved (done) rows */
        .cmp-row.is-done .cmp-name, .cmp-row.is-done .cmp-desc { color: #79716b; }
        .cmp-row.is-done .cmp-desc { text-decoration: line-through; text-decoration-color: rgba(22, 163, 74, .35); }
        .cmp-row.is-done { background: linear-gradient(90deg, rgba(22, 163, 74, .045), transparent 55%); }

        /* empty states */
        .cmp-empty { text-align: center; padding: 44px 16px; }
        .ce-ic {
            width: 74px; height: 74px; margin: 0 auto 14px; border-radius: 24px; font-size: 30px;
            display: grid; place-items: center; color: #059669;
            background: color-mix(in srgb, #059669 9%, white);
        }
        .cmp-empty b { font-size: 15px; color: #12261d; display: block; }
        .cmp-empty p { font-size: 12.5px; color: #8b7355; margin: 6px 0 0; }
        .cmp-nomatch {
            text-align: center; color: #8b7355; font-size: 13px; padding: 30px 0;
            display: flex; gap: 8px; align-items: center; justify-content: center;
        }
        .cmp-pager { margin-top: 14px; }

        @media (max-width: 640px) {
            .cmp-row { flex-wrap: wrap; }
            .cmp-actions { flex-direction: row; }
        }
    </style>
@endsection

@push('scripts')
    <script>
        /* ---------- Bengali digits ---------- */
        function bnDig(s) {
            var m = { '0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯' };
            return String(s).replace(/[0-9]/g, function (d) { return m[d]; });
        }

        /* ---------- relative time ---------- */
        function relTime(iso) {
            var sec = (Date.now() - new Date(iso).getTime()) / 1000;
            if (sec < 0 || isNaN(sec)) return null;
            if (sec < 60) return 'এইমাত্র';
            if (sec < 3600) return bnDig(Math.floor(sec / 60)) + ' মিনিট আগে';
            if (sec < 86400) return bnDig(Math.floor(sec / 3600)) + ' ঘণ্টা আগে';
            if (sec < 2592000) return bnDig(Math.floor(sec / 86400)) + ' দিন আগে';
            return null;
        }

        document.querySelectorAll('.cmp-time').forEach(function (el) {
            var rel = relTime(el.dataset.ts);
            if (rel) el.innerHTML = '<i class="fa-regular fa-clock"></i> ' + rel;
        });

        /* ---------- filters + search ---------- */
        var rows = Array.prototype.slice.call(document.querySelectorAll('.cmp-row'));
        var filter = 'all';
        var searchEl = document.getElementById('cmpSearch');

        /* chip counts = current page */
        (function () {
            var c = { all: rows.length, open: 0, done: 0 };
            rows.forEach(function (r) { c[r.dataset.state]++; });
            document.querySelectorAll('.cmp-fc').forEach(function (sp) { sp.textContent = bnDig(c[sp.dataset.c]); });
            document.getElementById('cmpCount').textContent = '(দেখানো হচ্ছে ' + bnDig(rows.length) + 'টি)';
        })();

        function applyCmpFilter() {
            var q = searchEl.value.trim().toLowerCase();
            var shown = 0;
            rows.forEach(function (r) {
                var okF = filter === 'all' || r.dataset.state === filter;
                var okS = q === '' || r.dataset.search.indexOf(q) !== -1;
                var show = okF && okS;
                r.hidden = !show;
                if (show) shown++;
            });
            document.getElementById('cmpNoMatch').hidden = shown !== 0;
            document.getElementById('cmpCount').textContent = '(দেখানো হচ্ছে ' + bnDig(shown) + 'টি)';
        }

        document.querySelectorAll('.cmp-f').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.cmp-f').forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                filter = btn.dataset.f;
                applyCmpFilter();
            });
        });

        searchEl.addEventListener('input', applyCmpFilter);
        searchEl.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { searchEl.value = ''; applyCmpFilter(); }
        });

        /* ---------- description expand ---------- */
        document.querySelectorAll('.cmp-more').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var desc = btn.parentNode.querySelector('.cmp-desc');
                var open = desc.classList.toggle('is-clamped');
                btn.innerHTML = open
                    ? 'আরো দেখুন <i class="fa-solid fa-chevron-down"></i>'
                    : 'গুটিয়ে নিন <i class="fa-solid fa-chevron-up"></i>';
            });
        });
    </script>
@endpush
