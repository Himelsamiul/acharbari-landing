@extends('layouts.admin')

@section('title', 'Sitemap')
@section('page_title', 'Sitemap')
@section('page_sub', 'সাইটম্যাপ URL ম্যানেজ, জেনারেট ও ডাউনলোড')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-circle-info"></i>
        <span>লাইভ সাইটম্যাপ: <a href="{{ url('/sitemap.xml') }}" target="_blank" style="color:#047857;font-weight:700">{{ url('/sitemap.xml') }}</a> —
            Google Search Console-এ এই লিংকটি sitemap হিসেবে জমা দিন। হোম, /products ও সব লাইভ প্রোডাক্ট <b>অটো</b> যোগ হয়; নিচের ফর্ম থেকে অন্য যেকোনো পেজ <b>ম্যানুয়ালি</b> যোগ করতে পারবেন।</span>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-house"></i></span>
            <div class="lbl">অটো URL</div>
            <div class="val">{{ $productCount + 2 }}</div>
            <div class="chg mut">হোম + /products + {{ $productCount }} প্রোডাক্ট</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-plus"></i></span>
            <div class="lbl">কাস্টম URL</div>
            <div class="val">{{ $urls->count() }}</div>
            <div class="chg mut">চালু: {{ $urls->where('is_active', true)->count() }}টি</div>
        </div>
        <div class="stat-card">
            <span class="ic"><i class="fa-solid fa-sitemap"></i></span>
            <div class="lbl">সাইটম্যাপে মোট</div>
            <div class="val">{{ $productCount + 2 + $urls->where('is_active', true)->count() }}</div>
            <div class="chg mut">sitemap.xml-এ বর্তমানে আছে</div>
        </div>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-plus"></i> নতুন URL যোগ করুন</h3>
        <p class="desc">পাথ দিন (যেমন <code>/track</code>) — একই পাথ আবার দিলে আপডেট হবে</p>
        <form method="POST" action="{{ route('admin.sitemap.store') }}">
            @csrf
            <div class="fgrid" style="grid-template-columns:2fr 130px 160px auto;align-items:end" id="smGrid">
                <div class="a-field">
                    <label>URL / পাথ *</label>
                    <input class="a-input" name="loc" placeholder="/track অথবা /about-us" required maxlength="500">
                </div>
                <div class="a-field">
                    <label>Priority</label>
                    <select class="a-input" name="priority">
                        @foreach (['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'] as $pr)
                            <option value="{{ $pr }}" {{ $pr === '0.5' ? 'selected' : '' }}>{{ $pr }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="a-field">
                    <label>Change Frequency</label>
                    <select class="a-input" name="changefreq">
                        @foreach (['daily' => 'ডেইলি', 'weekly' => 'উইকলি', 'monthly' => 'মাসিক', 'yearly' => 'বার্ষিক', 'hourly' => 'ঘণ্টায়', 'always' => 'সবসময়', 'never' => 'কখনো না'] as $fk => $fl)
                            <option value="{{ $fk }}" {{ $fk === 'weekly' ? 'selected' : '' }}>{{ $fl }} ({{ $fk }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="a-field">
                    <button class="a-btn" style="width:100%"><i class="fa-solid fa-plus"></i> যোগ</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-list"></i> কাস্টম URL তালিকা</h3>
        <p class="desc">বন্ধ করলে সাইটম্যাপ থেকে বাদ যাবে কিন্তু সেভ থাকবে</p>
        @if ($urls->isEmpty())
            <p style="text-align:center;color:#8b7355;font-size:13px;padding:24px 0">এখনো কোনো কাস্টম URL নেই।</p>
        @else
            <table class="tbl">
                <thead>
                    <tr><th>URL</th><th>Priority</th><th>Frequency</th><th>স্ট্যাটাস</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($urls as $u)
                        <tr>
                            <td><code>{{ $u->loc }}</code></td>
                            <td><span class="pill {{ $u->priority >= 0.8 ? 'ok' : 'mut' }}">{{ number_format($u->priority, 1) }}</span></td>
                            <td><span class="pill info">{{ $u->changefreq }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.sitemap.toggle', $u) }}">
                                    @csrf
                                    <button type="submit" class="pill {{ $u->is_active ? 'ok' : 'mut' }}" style="border:none;cursor:pointer;font-family:inherit">
                                        {{ $u->is_active ? 'চালু' : 'বন্ধ' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.sitemap.destroy', $u) }}" onsubmit="return confirm('URL-টি মুছে ফেলবেন?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="মুছুন"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-file-code"></i> লাইভ sitemap.xml প্রিভিউ</h3>
        <p class="desc">মোট {{ $productCount + 2 + $urls->where('is_active', true)->count() }}টি URL</p>
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px">
            <a class="a-btn ghost" href="{{ url('/sitemap.xml') }}" target="_blank" style="text-decoration:none"><i class="fa-solid fa-arrow-up-right-from-square"></i> লাইভ দেখুন</a>
            <button class="a-btn" onclick="copySitemap()"><i class="fa-solid fa-copy"></i> কপি করুন</button>
            <button class="a-btn ghost" onclick="downloadSitemap()"><i class="fa-solid fa-download"></i> ডাউনলোড</button>
        </div>
        <pre class="sitemap-box">{{ $xml }}</pre>
    </div>

    <style>
        .sitemap-box {
            background: #022c22; color: #a3e635;
            border-radius: 12px; padding: 16px 18px;
            font-family: Consolas, Monaco, monospace;
            font-size: 12px; line-height: 1.7;
            overflow-x: auto; white-space: pre;
            max-height: 420px; overflow-y: auto;
        }
        @media (max-width: 900px) { #smGrid { grid-template-columns: 1fr 1fr !important; } }
        @media (max-width: 520px) { #smGrid { grid-template-columns: 1fr !important; } }
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
