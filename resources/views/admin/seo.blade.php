@extends('layouts.admin')

@section('title', 'SEO Settings')
@section('page_title', 'SEO Settings')
@section('page_sub', 'Meta title, description ও keywords')

@section('content')
    <div class="card">
        <h3>Meta Title</h3>
        <p class="desc">গুগল সার্চে যে টাইটেল দেখাবে — <b>৫০-৮০ অক্ষর</b></p>
        <form method="POST" action="{{ route('admin.seo.save') }}">
            @csrf
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

            <button class="a-btn" style="margin-top:16px"><i class="fa-solid fa-floppy-disk"></i> SEO সেভ করুন</button>
        </form>
    </div>

    <div class="card">
        <h3>Google Preview</h3>
        <p class="desc">সার্চ রেজাল্টে যেভাবে দেখাবে</p>
        <div class="serp">
            <div class="serp-url"><span class="serp-fav"><i class="fa-solid fa-jar"></i></span> khorak.shop</div>
            <div class="serp-title" id="serpTitle"></div>
            <div class="serp-desc" id="serpDesc"></div>
        </div>
    </div>

    <style>
        .char-counter { font-size: 11.5px; font-weight: 700; margin-top: 7px; color: #8b7355; }
        .char-counter.ok { color: #16a34a; }
        .char-counter.warn { color: #d97706; }
        .char-counter.bad { color: #dc2626; }
        .serp { border: 1px solid #dfe1e5; border-radius: 14px; padding: 16px 18px; max-width: 560px; background: #fff; }
        .serp-url { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #4d5156; }
        .serp-fav { width: 22px; height: 22px; border-radius: 50%; background: rgba(5,150,105,.14); display: inline-grid; place-items: center; color: #059669; font-size: 10px; }
        .serp-title { color: #1a0dab; font-size: 17px; margin: 6px 0 4px; line-height: 1.4; }
        .serp-desc { color: #4d5156; font-size: 12.5px; line-height: 1.6; }
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
        }
        ['seoTitle', 'seoDesc', 'seoKeywords'].forEach(function (id) {
            document.getElementById(id).addEventListener('input', updateSeoCounters);
        });
        document.addEventListener('DOMContentLoaded', updateSeoCounters);
    </script>
@endpush
