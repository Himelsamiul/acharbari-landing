@extends('layouts.admin')

@section('title', $info['name'])
@section('page_title', $info['name'])
@section('page_sub', 'ড্রাফট মডিউল — টেমপ্লেট প্রস্তুত')

@section('content')
    <div class="module-hero" style="--mc: {{ $info['color'] }}">
        <div class="mh-icon"><i class="{{ $info['icon'] }}"></i></div>
        <div>
            <span class="mh-badge"><i class="fa-solid fa-pen-ruler"></i> DRAFT — টেমপ্লেট প্রস্তুত</span>
            <h3>{{ $info['name'] }}</h3>
            <p>{{ $info['desc'] }}</p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:18px;align-items:start" class="module-grid">
        <div class="card">
            <h3><i class="fa-solid fa-list-check"></i> এই মডিউলে যা যা থাকবে</h3>
            <p class="desc">প্ল্যান করা ফিচারসমূহ — ফিউচার ডেভেলপমেন্টের জন্য টেমপ্লেট</p>
            <ul class="feature-list">
                @foreach ($info['features'] as $feature)
                    <li><i class="fa-solid fa-circle-check"></i> {{ $feature }}</li>
                @endforeach
            </ul>
            <button class="soon-btn" disabled><i class="fa-solid fa-hourglass-half"></i> শীঘ্রই আসছে</button>
        </div>

        <div class="card">
            <h3><i class="fa-solid fa-layer-group"></i> ডেভেলপমেন্ট স্ট্যাটাস</h3>
            <p class="desc">মডিউল প্ল্যান</p>
            <div class="dev-steps">
                <div class="dev-step done"><span class="ds-ic"><i class="fa-solid fa-check"></i></span>
                    <div><b>টেমপ্লেট ডিজাইন</b><span>লেআউট ও স্ট্রাকচার প্রস্তুত</span></div></div>
                <div class="dev-step done"><span class="ds-ic"><i class="fa-solid fa-check"></i></span>
                    <div><b>সাইডবার ইন্টিগ্রেশন</b><span>অ্যাডমিন প্যানেলে যুক্ত</span></div></div>
                <div class="dev-step next"><span class="ds-ic"><i class="fa-solid fa-code"></i></span>
                    <div><b>ব্যাকএন্ড ডেভেলপমেন্ট</b><span>ডেটাবেজ ও লজিক — ফিউচারে</span></div></div>
                <div class="dev-step"><span class="ds-ic"><i class="fa-solid fa-rocket"></i></span>
                    <div><b>লঞ্চ</b><span>ফুল ফাংশনাল মডিউল</span></div></div>
            </div>
        </div>
    </div>

    <style>
        .module-hero {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #fff;
            border: 1px solid rgba(5, 150, 105, .14);
            border-left: 5px solid var(--mc);
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 18px;
            box-shadow: 0 14px 34px -22px rgba(6, 78, 59, .4);
            animation: cardIn .4s ease both;
        }
        .mh-icon {
            width: 64px; height: 64px; border-radius: 18px;
            display: grid; place-items: center;
            background: color-mix(in srgb, var(--mc) 14%, white);
            color: var(--mc);
            font-size: 26px;
            flex-shrink: 0;
        }
        .mh-badge {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: 10px; font-weight: 800; letter-spacing: 1px;
            padding: 4px 12px; border-radius: 999px;
            background: rgba(251, 191, 36, .15);
            color: #b45309;
            border: 1px solid rgba(251, 191, 36, .4);
        }
        .module-hero h3 { margin: 8px 0 5px; font-size: 20px; }
        .module-hero p { margin: 0; font-size: 13px; color: #5f7a6d; max-width: 560px; }
        .feature-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
        .feature-list li {
            display: flex; align-items: center; gap: 10px;
            font-size: 13.5px; font-weight: 600; color: #1f4234;
            background: rgba(5, 150, 105, .05);
            border: 1px solid rgba(5, 150, 105, .12);
            border-radius: 10px; padding: 10px 14px;
        }
        .feature-list li i { color: #10b981; }
        .soon-btn {
            margin-top: 14px;
            border: none; cursor: not-allowed;
            background: rgba(5, 150, 105, .1); color: #5f7a6d;
            font-family: inherit; font-weight: 800; font-size: 13px;
            padding: 11px 22px; border-radius: 12px;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .dev-steps { display: flex; flex-direction: column; gap: 14px; }
        .dev-step { display: flex; gap: 12px; align-items: flex-start; }
        .dev-step .ds-ic {
            width: 34px; height: 34px; border-radius: 50%;
            display: grid; place-items: center; flex-shrink: 0;
            font-size: 13px;
            background: rgba(5, 150, 105, .1); color: #059669;
        }
        .dev-step.next .ds-ic, .dev-step:not(.done):not(.next) .ds-ic {
            background: rgba(5, 150, 105, .07); color: #8b7355;
        }
        .dev-step b { display: block; font-size: 13.5px; color: #12261d; }
        .dev-step span { display: block; font-size: 11.5px; color: #8b7355; }
        @media (max-width: 900px) {
            .module-grid { grid-template-columns: 1fr !important; }
            .module-hero { flex-direction: column; text-align: center; align-items: center; }
        }
    </style>
@endsection
