@extends('layouts.admin')

@section('title', 'SEO Settings')
@section('page_title', 'SEO Settings')
@section('page_sub', 'Meta, Open Graph, Canonical ও Search Console')

@section('content')
    <form method="POST" action="{{ route('admin.seo.save') }}" enctype="multipart/form-data">
        @csrf

        <div style="display:grid;grid-template-columns:1.15fr 1fr;gap:18px;align-items:start" class="seo-grid">
            <div>
                <div class="card">
                    <h3><i class="fa-solid fa-heading"></i> Meta Title</h3>
                    <p class="desc">গুগল সার্চে যে টাইটেল দেখাবে — <b>৫০-৮০ অক্ষর</b></p>
                    <input class="a-input" name="seo_title" id="seoTitle" value="{{ $title }}" maxlength="150">
                    <div class="char-counter" id="cntTitle"></div>

                    <h3 style="margin-top:18px"><i class="fa-solid fa-align-left"></i> Meta Description</h3>
                    <p class="desc"><b>১৬০-৩০০ অক্ষর</b></p>
                    <textarea class="a-input" name="seo_desc" id="seoDesc" rows="4">{{ $desc }}</textarea>
                    <div class="char-counter" id="cntDesc"></div>

                    <h3 style="margin-top:18px"><i class="fa-solid fa-key"></i> Meta Keywords</h3>
                    <p class="desc">কমা দিয়ে আলাদা করুন — <b>১০-১৫টি</b></p>
                    <textarea class="a-input" name="seo_keywords" id="seoKeywords" rows="3">{{ $keywords }}</textarea>
                    <div class="char-counter" id="cntKeywords"></div>

                    <h3 style="margin-top:18px"><i class="fa-solid fa-link"></i> Canonical URL</h3>
                    <p class="desc">হোমপেজের ক্যানোনিকাল — www ছাড়া/সহ এক ঠিকানা ঠিক করতে (খালি রাখলে অটো)। যেমন: <code>https://khorak.shop</code></p>
                    <input class="a-input" type="url" name="seo_canonical" value="{{ $canonical }}" placeholder="https://khorak.shop" maxlength="300">

                    <h3 style="margin-top:18px"><i class="fa-brands fa-google"></i> Google Search Console</h3>
                    <p class="desc">Search Console → Settings → Ownership verification → HTML tag থেকে <code>content="..."</code>-এর ভ্যালুটা পেস্ট করুন। শুধু কোডটা, পুরো ট্যাগ নয়।</p>
                    <input class="a-input" name="gsc_verification" value="{{ $gscVerification }}" placeholder="google-site-verification কোড">
                </div>

                <div class="card">
                    <h3><i class="fa-solid fa-share-nodes"></i> Open Graph (Facebook / WhatsApp)</h3>
                    <p class="desc">লিংক শেয়ার করলে যা দেখাবে — খালি রাখলে Meta থেকে নেবে</p>

                    <div class="a-field">
                        <label>OG Title</label>
                        <input class="a-input" name="og_title" value="{{ $ogTitle }}" maxlength="150" placeholder="Meta title ব্যবহার হবে">
                    </div>
                    <div class="a-field">
                        <label>OG Description</label>
                        <textarea class="a-input" name="og_desc" rows="2" maxlength="300" placeholder="Meta description ব্যবহার হবে">{{ $ogDesc }}</textarea>
                    </div>
                    <div class="a-field">
                        <label>OG Image (১২০০×৬৩০ রেকমেন্ডেড)</label>
                        @if ($ogImage)
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px">
                                <img src="{{ asset($ogImage) }}" alt="OG image" style="width:150px;height:79px;object-fit:cover;border-radius:10px;border:1px solid rgba(5,150,105,.2)">
                                <label style="display:flex;gap:8px;align-items:center;font-size:12.5px;font-weight:700;cursor:pointer">
                                    <input type="checkbox" name="remove_og_image" value="1"> মুছে ফেলুন
                                </label>
                            </div>
                        @endif
                        <input class="a-input" type="file" name="og_image" accept="image/jpeg,image/png,image/webp">
                    </div>

                    <button class="a-btn" style="margin-top:10px"><i class="fa-solid fa-floppy-disk"></i> SEO সেভ করুন</button>
                </div>
            </div>

            <div>
                <div class="card">
                    <h3><i class="fa-solid fa-magnifying-glass"></i> Google Preview</h3>
                    <p class="desc">সার্চ রেজাল্টে যেভাবে দেখাবে</p>
                    <div class="serp">
                        <div class="serp-url"><span class="serp-fav"><i class="fa-solid fa-jar"></i></span> {{ parse_url(url('/'), PHP_URL_HOST) }}</div>
                        <div class="serp-title" id="serpTitle"></div>
                        <div class="serp-desc" id="serpDesc"></div>
                    </div>
                </div>

                <div class="card">
                    <h3><i class="fa-brands fa-facebook"></i> Social Share Preview</h3>
                    <p class="desc">Facebook / WhatsApp-এ যেভাবে দেখাবে</p>
                    <div class="ogcard">
                        <div class="ogcard-img" id="ogImgBox">
                            @if ($ogImage)<img src="{{ asset($ogImage) }}" alt="">@endif
                        </div>
                        <div class="ogcard-body">
                            <div class="ogcard-url">{{ strtoupper(parse_url(url('/'), PHP_URL_HOST)) }}</div>
                            <div class="ogcard-title" id="ogTitlePrev"></div>
                            <div class="ogcard-desc" id="ogDescPrev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
        .char-counter { font-size: 11.5px; font-weight: 700; margin-top: 7px; color: #8b7355; }
        .char-counter.ok { color: #16a34a; }
        .char-counter.warn { color: #d97706; }
        .char-counter.bad { color: #dc2626; }
        .serp { border: 1px solid #dfe1e5; border-radius: 14px; padding: 16px 18px; background: #fff; }
        .serp-url { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #4d5156; }
        .serp-fav { width: 22px; height: 22px; border-radius: 50%; background: rgba(5,150,105,.14); display: inline-grid; place-items: center; color: #059669; font-size: 10px; }
        .serp-title { color: #1a0dab; font-size: 17px; margin: 6px 0 4px; line-height: 1.4; }
        .serp-desc { color: #4d5156; font-size: 12.5px; line-height: 1.6; }
        .ogcard { border: 1px solid #dddfe2; border-radius: 10px; overflow: hidden; background: #fff; box-shadow: 0 6px 18px -10px rgba(0,0,0,.25); }
        .ogcard-img { height: 130px; background: linear-gradient(135deg, #064e3b, #059669); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.55); font-size: 12px; overflow: hidden; }
        .ogcard-img img { width: 100%; height: 100%; object-fit: cover; }
        .ogcard-body { padding: 10px 14px 12px; background: #f2f3f5; }
        .ogcard-url { font-size: 10px; text-transform: uppercase; color: #606770; letter-spacing: .5px; }
        .ogcard-title { font-size: 14px; font-weight: 700; color: #1d2129; margin: 3px 0 2px; }
        .ogcard-desc { font-size: 11.5px; color: #606770; line-height: 1.5; }
        @media (max-width: 900px) { .seo-grid { grid-template-columns: 1fr !important; } }
    </style>
@endsection

@push('scripts')
    <script>
        function seoRange(len, min, max) {
            if (len >= min && len <= max) return 'ok';
            if (len >= min * 0.6 && len <= max * 1.2) return 'warn';
            return 'bad';
        }
        function updateSeoCounters() {
            var t = document.getElementById('seoTitle').value.length;
            var d = document.getElementById('seoDesc').value.length;
            var k = document.getElementById('seoKeywords').value;
            var kw = k.split(',').filter(function (x) { return x.trim(); }).length;

            var ct = document.getElementById('cntTitle');
            ct.textContent = t + ' অক্ষর • রেঞ্জ: ৫০-৮০';
            ct.className = 'char-counter ' + seoRange(t, 50, 80);

            var cd = document.getElementById('cntDesc');
            cd.textContent = d + ' অক্ষর • রেঞ্জ: ১৬০-৩০০';
            cd.className = 'char-counter ' + seoRange(d, 160, 300);

            var ck = document.getElementById('cntKeywords');
            ck.textContent = kw + 'টি কিওয়ার্ড • ' + k.length + ' অক্ষর';
            ck.className = 'char-counter ' + (kw >= 10 && kw <= 15 ? 'ok' : kw >= 5 ? 'warn' : 'bad');

            document.getElementById('serpTitle').textContent = document.getElementById('seoTitle').value || 'Meta title…';
            document.getElementById('serpDesc').textContent = document.getElementById('seoDesc').value || 'Meta description…';

            var ot = document.querySelector('[name="og_title"]');
            var od = document.querySelector('[name="og_desc"]');
            document.getElementById('ogTitlePrev').textContent = (ot && ot.value) || document.getElementById('seoTitle').value || 'OG title…';
            document.getElementById('ogDescPrev').textContent = (od && od.value) || document.getElementById('seoDesc').value || 'OG description…';
        }
        ['seoTitle', 'seoDesc', 'seoKeywords', 'og_title', 'og_desc'].forEach(function (name) {
            var el = document.querySelector('[name="' + name + '"]');
            if (el) el.addEventListener('input', updateSeoCounters);
        });
        document.addEventListener('DOMContentLoaded', updateSeoCounters);
    </script>
@endpush
