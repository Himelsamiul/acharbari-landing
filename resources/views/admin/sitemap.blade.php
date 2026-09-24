@extends('layouts.admin')

@section('title', 'Sitemap')
@section('page_title', 'Sitemap')
@section('page_sub', 'সাইটম্যাপ জেনারেট ও ডাউনলোড')

@section('content')
    <div class="card">
        <h3>sitemap.xml — লাইভ ভার্সন</h3>
        <p class="desc">
            মোট {{ $productCount }}টি প্রোডাক্ট সহ সাইটম্যাপ — লাইভ লিংক:
            <a href="{{ route('admin.sitemap.xml') }}" target="_blank" style="color:#047857;font-weight:700">{{ route('admin.sitemap.xml') }}</a>
        </p>
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px">
            <button class="a-btn" onclick="copySitemap()"><i class="fa-solid fa-copy"></i> কপি করুন</button>
            <button class="a-btn ghost" onclick="downloadSitemap()"><i class="fa-solid fa-download"></i> ডাউনলোড</button>
        </div>
        <pre class="sitemap-box">{{ $xml }}</pre>
        <p class="gw-note" style="margin-top:12px"><i class="fa-solid fa-circle-info"></i>
            Google Search Console-এ গিয়ে sitemap হিসেবে <b>{{ route('admin.sitemap.xml') }}</b> জমা দিন।</p>
    </div>

    <style>
        .sitemap-box {
            background: #022c22; color: #a3e635;
            border-radius: 12px; padding: 16px 18px;
            font-family: Consolas, Monaco, monospace;
            font-size: 12px; line-height: 1.7;
            overflow-x: auto; white-space: pre;
        }
    </style>
@endsection

@push('scripts')
    <script>
        function copySitemap() {
            var text = document.querySelector('.sitemap-box').textContent;
            if (navigator.clipboard) navigator.clipboard.writeText(text);
            showToast('কপি হয়েছে!');
        }
        function downloadSitemap() {
            var text = document.querySelector('.sitemap-box').textContent;
            var blob = new Blob([text], { type: 'application/xml' });
            var a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'sitemap.xml';
            a.click();
        }
    </script>
@endpush
