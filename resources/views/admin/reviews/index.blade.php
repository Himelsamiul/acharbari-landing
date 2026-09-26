@extends('layouts.admin')

@section('title', 'রিভিউ')
@section('page_title', 'রিভিউ')
@section('page_sub', 'গ্রাহক রিভিউ ম্যানেজ করুন — Google বা সাধারণ রিভিউ। রেটিং বার, সংখ্যা ও গড় স্কোর অটো হিসাব হয়')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-star"></i>
        <span>প্রতিটি রিভিউ কার্ডে <b>Source</b> বেছে দিন — <b>Google</b> হলে ল্যান্ডিং পেজে Google ব্যাজ দেখাবে। নিচের রেটিং সামারি (গড় স্কোর, বার, সংখ্যা) কোনো ঘর না ভরাই <b>রিভিউগুলো থেকে অটো হিসাব</b> হয় — আলাদা করে দেওয়ার দরকার নেই।</span>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-chart-simple"></i> রেটিং সামারি (অটো হিসাব — লাইভ)</h3>
        <div style="display:flex;gap:24px;align-items:center;flex-wrap:wrap;padding:8px 0">
            <div style="text-align:center">
                <div id="rvAvgBig" style="font-size:34px;font-weight:800;color:#065f46">—</div>
                <div style="font-size:11px;color:#6b7280">গড় /৫</div>
            </div>
            <div style="flex:1;min-width:260px">
                <div id="rvBars"></div>
            </div>
            <div style="font-size:13px;color:#374151">মোট রিভিউ: <b id="rvCount">0</b></div>
        </div>
    </div>

    <div class="card" style="margin-top:16px">
        <h3><i class="fa-solid fa-comments"></i> গ্রাহক রিভিউ কার্ড</h3>
        <p class="desc">ছবির ঘরে পাথ লিখুন (যেমন: assets/img/rev1.jpg) • Source: Google দিলে ল্যান্ডিং পেজে Google ব্যাজ দেখাবে</p>
        <form method="POST" action="{{ route('admin.reviews.save') }}" class="rep-form">
            @csrf
            <div class="rep" data-json="reviews_json">
                @foreach ($reviewRows as $row)
                    <div class="rep-row rep-row-block">
                        <div class="rep-line">
                            <input class="a-input" data-k="name" value="{{ $row['name'] ?? '' }}" placeholder="নাম">
                            <input class="a-input" data-k="img" value="{{ $row['img'] ?? '' }}" placeholder="ছবির পাথ">
                            <input class="a-input" data-k="stars" value="{{ $row['stars'] ?? 5 }}" placeholder="তারা (1-5)" style="max-width:100px">
                            <select class="a-input" data-k="source" style="max-width:150px">
                                <option value="normal" {{ ($row['source'] ?? 'normal') === 'normal' ? 'selected' : '' }}>সাধারণ রিভিউ</option>
                                <option value="google" {{ ($row['source'] ?? '') === 'google' ? 'selected' : '' }}>Google রিভিউ</option>
                            </select>
                            <button type="button" class="btn-icon rep-del" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                        <div class="rep-line">
                            <input class="a-input" data-k="loc_bn" value="{{ $row['loc_bn'] ?? '' }}" placeholder="লোকেশন (বাংলা)">
                            <input class="a-input" data-k="loc_en" value="{{ $row['loc_en'] ?? '' }}" placeholder="Location (English)">
                        </div>
                        <div class="rep-line">
                            <textarea class="a-input" rows="2" data-k="text_bn" placeholder="রিভিউ (বাংলা)">{{ $row['text_bn'] ?? '' }}</textarea>
                            <textarea class="a-input" rows="2" data-k="text_en" placeholder="Review (English)">{{ $row['text_en'] ?? '' }}</textarea>
                        </div>
                        <div class="rep-line">
                            <input class="a-input" data-k="likes_bn" value="{{ $row['likes_bn'] ?? '' }}" placeholder="Like (বাংলা)">
                            <input class="a-input" data-k="likes_en" value="{{ $row['likes_en'] ?? '' }}" placeholder="Like (English)">
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="a-btn ghost rep-add" style="margin-top:10px"><i class="fa-solid fa-plus"></i> নতুন রিভিউ</button>
            <input type="hidden" name="reviews_json">
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> রিভিউ সেভ করুন</button>
        </form>
    </div>

    <style>
        .rv-bar-row { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; font-size: 12px; }
        .rv-track { flex: 1; height: 8px; background: #e5e7eb; border-radius: 99px; overflow: hidden; }
        .rv-fill { display: block; height: 100%; background: #f59e0b; border-radius: 99px; }
    </style>
    <script>
        var starLabel = { 5: '৫★', 4: '৪★', 3: '৩★', 2: '২★', 1: '১★' };

        function recomputeSummary() {
            var stars = [0, 0, 0, 0, 0, 0]; // index 1..5
            document.querySelectorAll('.rep[data-json="reviews_json"] .rep-row').forEach(function (row) {
                var s = parseInt(row.querySelector('[data-k="stars"]').value, 10);
                if (isNaN(s) || s < 1 || s > 5) s = 5;
                stars[s]++;
            });
            var total = stars[1] + stars[2] + stars[3] + stars[4] + stars[5];
            var sum = stars[1] * 1 + stars[2] * 2 + stars[3] * 3 + stars[4] * 4 + stars[5] * 5;
            var avg = total ? (sum / total).toFixed(1) : '—';
            document.getElementById('rvAvgBig').textContent = avg;
            document.getElementById('rvCount').textContent = total;

            var html = '';
            for (var s = 5; s >= 1; s--) {
                var pct = total ? Math.round(stars[s] * 100 / total) : 0;
                html += '<div class="rv-bar-row"><span style="width:30px">' + starLabel[s] + '</span>'
                    + '<span class="rv-track"><span class="rv-fill" style="width:' + pct + '%"></span></span>'
                    + '<span style="width:60px">' + stars[s] + ' টি (' + pct + '%)</span></div>';
            }
            document.getElementById('rvBars').innerHTML = html;
        }

        (function () {
            var wrap = document.querySelector('.rep[data-json="reviews_json"]');
            var form = wrap.closest('form');

            function bindDel(row) {
                row.querySelector('.rep-del').addEventListener('click', function () { row.remove(); recomputeSummary(); });
            }
            wrap.querySelectorAll('.rep-row').forEach(bindDel);

            form.querySelector('.rep-add').addEventListener('click', function () {
                var clone = wrap.querySelector('.rep-row').cloneNode(true);
                clone.querySelectorAll('[data-k]').forEach(function (el) {
                    if (el.tagName === 'SELECT') el.selectedIndex = 0; else el.value = '';
                });
                var st = clone.querySelector('[data-k="stars"]'); if (st) st.value = '5';
                bindDel(clone);
                wrap.appendChild(clone);
                recomputeSummary();
            });

            wrap.addEventListener('input', recomputeSummary);
            wrap.addEventListener('change', recomputeSummary);

            form.addEventListener('submit', function () {
                var rows = [];
                wrap.querySelectorAll('.rep-row').forEach(function (row) {
                    var obj = {};
                    var hasValue = false;
                    row.querySelectorAll('[data-k]').forEach(function (el) {
                        var v = el.value.trim();
                        obj[el.dataset.k] = v;
                        if (v !== '') hasValue = true;
                    });
                    if (hasValue) rows.push(obj);
                });
                form.querySelector('input[type=hidden][name="reviews_json"]').value = rows.length ? JSON.stringify(rows) : '';
            });

            recomputeSummary();
        })();
    </script>
@endsection
