@extends('layouts.landing')

@section('nav', 'products')

@section('title', ($product->meta_title ?: $product->name . ' — ' . ab_brand('bn')))

@section('content')
    <section class="ds-section" style="padding-top:34px">
        <div class="ds-container">
            <nav class="pd-breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}" data-en="Home">হোম</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('products') }}" data-en="Products">প্রোডাক্ট</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>{{ $product->name }}</span>
            </nav>

            <div class="pd-grid">
                <div class="pd-media">
                    <img src="{{ asset(ab_img($product->image)) }}" alt="{{ $product->image_alt ?: $product->name }}" loading="eager">
                    @if ($product->discount_bn)<span class="pd-badge">{{ $product->discount_bn }}</span>@endif
                </div>

                <div class="pd-info">
                    <span class="ds-chip-hero" style="font-size:11px">{{ $product->category }} @if($product->brand) • {{ $product->brand }}@endif</span>
                    <h1 class="ds-h2" style="margin:12px 0 8px">{{ $product->name }}</h1>
                    @if ($product->name_en)<p style="margin:0 0 12px;color:#8b7355;font-weight:600">{{ $product->name_en }}</p>@endif

                    @php
                        $vActive = $product->variants->where('is_active', true)->values();
                        $vHas = $vActive->isNotEmpty();
                        $vTotalStock = $vHas ? (int) $vActive->sum('stock') : (int) $product->stock;
                    @endphp

                    <div class="pd-price-row">
                        <span class="pd-price" id="pdPrice">{{ $vHas
                            ? '৳' . number_format($vActive->min('price')) . ' – ৳' . number_format($vActive->max('price'))
                            : '৳' . number_format($product->price) }}</span>
                        @if (! $vHas && $product->old_price > $product->price)
                            <span class="pd-old">৳{{ number_format($product->old_price) }}</span>
                        @endif
                        <span class="pill {{ $vTotalStock > 0 ? 'ok' : 'red' }}">
                            {{ $vTotalStock > 0 ? ($product->stock_badge ?: 'স্টকে আছে') : 'স্টক শেষ' }}
                        </span>
                    </div>

                    @if ($product->rating)
                        <div class="pd-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= round($product->rating) ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                            <span>{{ number_format($product->rating, 1) }} ({{ $product->reviews_count }} রিভিউ)</span>
                        </div>
                    @endif

                    @if ($product->description)
                        <p class="pd-desc">{{ $product->description }}</p>
                    @endif

                    @if ($vHas)
                        {{-- সাইজ সিলেক্ট + কোয়ান্টিটি + মোট দাম --}}
                        <div class="pd-variants">
                            <div class="pd-variants-label">সাইজ বাছুন:</div>
                            <div class="pd-size-grid">
                                @foreach ($vActive as $v)
                                    <label class="pd-size {{ $v->stock <= 0 ? 'off' : '' }} {{ $loop->first ? 'sel' : '' }}">
                                        <input type="radio" name="pd_variant" value="{{ $v->id }}"
                                            data-price="{{ $v->price }}" data-old="{{ $v->old_price ?? '' }}"
                                            data-size="{{ $v->size }}" data-stock="{{ $v->stock }}"
                                            {{ $v->stock <= 0 ? 'disabled' : '' }} {{ $loop->first ? 'checked' : '' }}>
                                        <span class="pd-size-name">{{ $v->size }}</span>
                                        <span class="pd-size-price">৳{{ number_format($v->price) }}</span>
                                        @if ($v->stock <= 0)<small>স্টক শেষ</small>@endif
                                    </label>
                                @endforeach
                            </div>

                            <div class="pd-qty-row">
                                <span class="pd-variants-label">কোয়ান্টিটি:</span>
                                <div class="pd-qty">
                                    <button type="button" id="pdQtyMinus">−</button>
                                    <input type="text" id="pdQty" value="1" readonly>
                                    <button type="button" id="pdQtyPlus">+</button>
                                </div>
                                <span class="pd-total">মোট: <b id="pdTotal">৳{{ number_format($vActive->firstWhere('stock', '>', 0)?->price ?? $vActive->first()->price) }}</b></span>
                            </div>
                        </div>

                        <div class="pd-actions">
                            <button type="button" class="pd-cta" id="pdOrderBtn" {{ $vTotalStock <= 0 ? 'disabled style="opacity:.5;cursor:not-allowed"' : '' }}
                                onclick="orderVariantFromDetails()">
                                <i class="fa-solid fa-cart-shopping"></i> অর্ডার করুন — ক্যাশ অন ডেলিভারি
                            </button>
                            <a class="pd-cta ghost" href="{{ route('products') }}" data-en="All Products">সব প্রোডাক্ট</a>
                        </div>
                    @else
                        <div class="pd-actions">
                            <a class="pd-cta" href="{{ url('/') }}#order" data-en="Order Now — Cash on Delivery">অর্ডার করুন — ক্যাশ অন ডেলিভারি</a>
                            <a class="pd-cta ghost" href="{{ route('products') }}" data-en="All Products">সব প্রোডাক্ট</a>
                        </div>
                    @endif

                    <ul class="pd-usp">
                        <li><i class="fa-solid fa-check"></i> <span data-en="100% homemade — no preservative">১০০% হোমমেড — প্রিজার্ভেটিভ মুক্ত</span></li>
                        <li><i class="fa-solid fa-check"></i> <span data-en="Sealed jar packaging">সিল করা জার প্যাকেজিং</span></li>
                        <li><i class="fa-solid fa-check"></i> <span data-en="Delivery all over Bangladesh">সারা বাংলাদেশে ডেলিভারি</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Products', 'item' => url('/products')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $product->name, 'item' => url('/product/' . $product->slug)],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <style>
        .pd-breadcrumb { display: flex; align-items: center; gap: 9px; font-size: 12.5px; font-weight: 600; margin-bottom: 22px; flex-wrap: wrap; }
        .pd-breadcrumb a { color: #059669; text-decoration: none; }
        .pd-breadcrumb a:hover { text-decoration: underline; }
        .pd-breadcrumb i { font-size: 8px; color: #b7c4bd; }
        .pd-breadcrumb span { color: #8b7355; }
        .pd-grid { display: grid; grid-template-columns: 1fr 1.1fr; gap: 34px; align-items: start; }
        .pd-media { position: relative; border-radius: 22px; overflow: hidden; border: 1px solid rgba(5,150,105,.16); background: #fff; box-shadow: 0 24px 54px -30px rgba(6,78,59,.45); }
        .pd-media img { width: 100%; height: 420px; object-fit: cover; display: block; }
        .pd-badge { position: absolute; top: 14px; left: 14px; background: linear-gradient(135deg, #dc2626, #f97316); color: #fff; font-size: 12px; font-weight: 800; padding: 5px 13px; border-radius: 999px; }
        .pd-price-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin: 14px 0; }
        .pd-price { font-size: 32px; font-weight: 800; color: #047857; }
        .pd-old { font-size: 17px; color: #b0a08c; text-decoration: line-through; font-weight: 700; }
        .pd-rating { display: flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 700; color: #8b7355; margin-bottom: 14px; }
        .pd-rating .fa-star { color: #f59e0b; font-size: 13px; }
        .pd-desc { font-size: 14.5px; line-height: 1.9; color: #4b5f54; margin: 0 0 20px; }
        .pd-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 22px; }
        .pd-cta { display: inline-flex; align-items: center; gap: 9px; background: linear-gradient(135deg, #059669, #10b981); color: #fff; font-weight: 800; font-size: 14.5px; padding: 15px 28px; border-radius: 14px; text-decoration: none; box-shadow: 0 16px 34px -14px rgba(5,150,105,.6); transition: transform .15s, filter .2s; }
        .pd-cta:hover { transform: translateY(-2px); filter: brightness(1.05); }
        .pd-cta.ghost { background: #fff; color: #1f4234; border: 1.5px solid rgba(5,150,105,.3); box-shadow: none; }
        .pd-usp { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 9px; }
        .pd-usp li { display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 600; color: #1f4234; background: rgba(5,150,105,.06); border: 1px solid rgba(5,150,105,.12); padding: 9px 14px; border-radius: 10px; }
        .pd-usp i { color: #10b981; }
        @media (max-width: 860px) {
            .pd-grid { grid-template-columns: 1fr; gap: 20px; }
            .pd-media img { height: 300px; }
        }

        /* ===== ভ্যারিয়েন্ট সিলেক্টর ===== */
        .pd-variants { margin: 4px 0 18px; }
        .pd-variants-label { font-size: 13px; font-weight: 800; color: #1f4234; margin-bottom: 8px; }
        .pd-size-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; }
        .pd-size { display: flex; flex-direction: column; align-items: center; gap: 2px; cursor: pointer;
            border: 2px solid rgba(5,150,105,.22); border-radius: 12px; padding: 10px 16px; background: #fff;
            transition: border-color .15s, background .15s; min-width: 86px; text-align: center; }
        .pd-size:hover { border-color: #059669; }
        .pd-size.sel { border-color: #059669; background: rgba(5,150,105,.07); }
        .pd-size.off { opacity: .45; cursor: not-allowed; }
        .pd-size input { position: absolute; opacity: 0; pointer-events: none; }
        .pd-size-name { font-size: 13.5px; font-weight: 800; color: #1f4234; }
        .pd-size-price { font-size: 13px; font-weight: 700; color: #047857; }
        .pd-size small { font-size: 10px; color: #dc2626; font-weight: 700; }
        .pd-qty-row { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
        .pd-qty { display: inline-flex; align-items: center; border: 1.5px solid rgba(5,150,105,.3); border-radius: 10px; overflow: hidden; }
        .pd-qty button { width: 36px; height: 38px; border: none; background: rgba(5,150,105,.08); color: #047857;
            font-size: 17px; font-weight: 800; cursor: pointer; }
        .pd-qty button:hover { background: rgba(5,150,105,.16); }
        .pd-qty input { width: 46px; height: 38px; border: none; text-align: center; font-size: 15px; font-weight: 800; color: #1f4234; }
        .pd-total { font-size: 15px; font-weight: 700; color: #4b5f54; }
        .pd-total b { color: #047857; font-size: 18px; }
        .pd-cta:disabled { filter: grayscale(.4); }
    </style>

    <script>
        (function () {
            var radios = document.querySelectorAll('input[name="pd_variant"]');
            if (!radios.length) return;
            var qtyInput = document.getElementById('pdQty');
            var totalEl = document.getElementById('pdTotal');
            var priceEl = document.getElementById('pdPrice');

            function selected() {
                return document.querySelector('input[name="pd_variant"]:checked');
            }

            function refresh() {
                var r = selected();
                if (!r) return;
                var price = parseFloat(r.dataset.price) || 0;
                var qty = Math.max(1, parseInt(qtyInput.value, 10) || 1);
                qtyInput.value = qty;

                radios.forEach(function (x) { x.closest('.pd-size').classList.toggle('sel', x.checked); });

                // dam + purano dam dekhao
                var oldPrice = parseFloat(r.dataset.old);
                if (oldPrice > price) {
                    priceEl.innerHTML = '৳' + price.toLocaleString('en-US') + ' <span class="pd-old">৳' + oldPrice.toLocaleString('en-US') + '</span>';
                } else {
                    priceEl.textContent = '৳' + price.toLocaleString('en-US');
                }

                totalEl.textContent = '৳' + (price * qty).toLocaleString('en-US');

                // stock cross theke qty thik kora
                var stock = parseInt(r.dataset.stock, 10);
                if (stock > 0 && qty > stock) {
                    qtyInput.value = stock;
                    totalEl.textContent = '৳' + (price * stock).toLocaleString('en-US');
                }
            }

            radios.forEach(function (r) { r.addEventListener('change', function () { qtyInput.value = 1; refresh(); }); });
            document.getElementById('pdQtyMinus').addEventListener('click', function () {
                qtyInput.value = Math.max(1, (parseInt(qtyInput.value, 10) || 1) - 1); refresh();
            });
            document.getElementById('pdQtyPlus').addEventListener('click', function () {
                qtyInput.value = Math.min(20, (parseInt(qtyInput.value, 10) || 1) + 1); refresh();
            });
            refresh();
        })();

        /* size+qty select kore landing cart e pathano — sessionStorage handoff */
        function orderVariantFromDetails() {
            var r = document.querySelector('input[name="pd_variant"]:checked');
            if (!r) return;
            var qty = Math.max(1, parseInt(document.getElementById('pdQty').value, 10) || 1);
            sessionStorage.setItem('abVariantPick', JSON.stringify({
                id: {{ $product->id }},
                variant_id: parseInt(r.value, 10),
                qty: qty
            }));
            window.location.href = '{{ url('/') }}#order-form';
        }
    </script>
@endsection
