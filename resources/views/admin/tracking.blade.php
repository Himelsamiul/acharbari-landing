@extends('layouts.admin')

@section('title', 'ট্র্যাকিং ও পিক্সেল')
@section('page_title', 'ট্র্যাকিং ও পিক্সেল')
@section('page_sub', 'মার্কেটিং পিক্সেল ও অ্যানালিটিক্স সংযোগ')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-chart-simple"></i>
        <span>Pixel/ID দিয়ে <b>চালু</b> করলে ল্যান্ডিং পেজে স্বয়ংক্রিয়ভাবে ট্র্যাকিং স্ক্রিপ্ট যুক্ত হয়ে যাবে।</span>
    </div>

    <div class="track-grid">
        @foreach (['fb' => ['Facebook Pixel', 'fa-brands fa-facebook', '#1877F2', 'Pixel ID (যেমন: 123456789012345)'],
                  'ga' => ['Google Analytics 4', 'fa-solid fa-chart-line', '#F9AB00', 'Measurement ID (G-XXXXXXXXXX)'],
                  'gtm' => ['Google Tag Manager', 'fa-solid fa-tags', '#246FDB', 'Container ID (GTM-XXXXXXX)'],
                  'tiktok' => ['TikTok Pixel', 'fa-brands fa-tiktok', '#000000', 'Pixel Code ID'] as $key => $t)
            <div class="track-card" style="--tc: {{ $t[2] }}">
                <div class="track-head">
                    <span class="track-ic"><i class="{{ $t[1] }}"></i></span>
                    <b>{{ $t[0] }}</b>
                </div>
                <form method="POST" action="{{ route('admin.settings.tracking.save', $key) }}">
                    @csrf
                    <label class="track-toggle">
                        <input type="checkbox" name="enabled" value="1" {{ ($pixels[$key]['enabled'] ?? false) ? 'checked' : '' }}>
                        <span>সক্রিয়</span>
                    </label>
                    <input class="a-input" style="margin:10px 0" name="value" placeholder="{{ $t[3] }}"
                        value="{{ $pixels[$key]['value'] ?? '' }}">
                    <button class="a-btn" style="width:100%"><i class="fa-solid fa-floppy-disk"></i> সেভ করুন</button>
                </form>
            </div>
        @endforeach
    </div>

    <style>
        .track-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr)); gap: 16px; }
        .track-card {
            background: #fff; border: 1px solid rgba(5,150,105,.16);
            border-top: 4px solid var(--tc); border-radius: 16px; padding: 18px;
            box-shadow: 0 10px 30px -18px rgba(6,78,59,.35);
            transition: transform .25s, box-shadow .3s;
        }
        .track-card:hover { transform: translateY(-3px); box-shadow: 0 20px 44px -18px rgba(6,78,59,.45); }
        .track-head { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .track-ic {
            width: 38px; height: 38px; border-radius: 11px;
            display: grid; place-items: center;
            background: color-mix(in srgb, var(--tc) 12%, white);
            color: var(--tc); font-size: 17px;
        }
        .track-head b { font-size: 14.5px; }
        .track-toggle { display: flex; align-items: center; gap: 8px; font-size: 12.5px; font-weight: 700; color: #1f4234; margin-bottom: 8px; }
        .track-toggle input { accent-color: var(--tc); width: 16px; height: 16px; }
    </style>
@endsection
