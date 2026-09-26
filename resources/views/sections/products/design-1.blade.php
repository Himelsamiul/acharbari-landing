{{-- Section: products | Design 1 (extracted original) --}}
<!-- ================= PRODUCTS DISCOVERY ================= -->
    <section class="ds-section ds-section-alt" id="ds-products">
        <div class="ds-container">
            @php
                $ph = ab_t('prod_eyebrow', 'জনপ্রিয় কালেকশন', 'Popular Collections');
                $ph2a = ab_t('prod_h2a', 'এই মুহূর্তের ', "Today's ");
                $ph2b = ab_t('prod_h2b', 'সেরা আচার ডিল', 'Best Pickle Deals');
                $psub = ab_t('prod_sub', 'আপনার পছন্দের জার বেছে নিন — ব্যাচ শেষ হওয়ার আগেই অর্ডার করুন ক্যাশ অন ডেলিভারিতে', 'Choose your favourite jar — order on Cash on Delivery before the batch runs out');
            @endphp
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="{{ $ph['en'] }}">{{ $ph['bn'] }}</span>
                <h2 class="ds-h2"><span data-en="{{ $ph2a['en'] }}">{{ $ph2a['bn'] }}</span><span class="ds-grad" data-en="{{ $ph2b['en'] }}">{{ $ph2b['bn'] }}</span></h2>
                <p class="ds-sub" data-en="{{ $psub['en'] }}">{{ $psub['bn'] }}</p>
            </div>

            <!-- Dynamic Category Filter Pills — generated from the categories table (admin taxonomy) -->
            @php
                $cntAll = $products->count();
                $cntBy = $products->countBy('category_key');
                $fAll = ab_t('filter_all', 'সব প্রোডাক্ট', 'All Items');
                $pillIcons = [
                    'pickle' => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>',
                    'pure' => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>',
                    'chaatni' => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11h16"/><path d="M5.5 11a6.5 6.5 0 0 0 13 0"/><path d="M9.5 7.5V6"/><path d="M12 7.5V5"/><path d="M14.5 7.5V6"/></svg>',
                ];
                $pillIconDefault = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>';
                $homeCategories = \App\Models\Category::orderBy('id')->get();
            @endphp
            <div class="ds-filter-wrap">
                <button class="ds-filter-btn active" data-filter="all">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="14" rx="1.5"/><rect width="7" height="7" x="3" y="14" rx="1.5"/></svg> <span data-en="{{ $fAll['en'] }}">{{ $fAll['bn'] }}</span> <span class="ds-filter-count">{{ bn_num($cntAll) }}</span>
                </button>
                @foreach ($homeCategories as $cat)
                    <button class="ds-filter-btn" data-filter="{{ $cat->key }}">
                        {!! $pillIcons[$cat->key] ?? $pillIconDefault !!} <span data-en="{{ $cat->name_en }}">{{ $cat->name }}</span> <span class="ds-filter-count">{{ bn_num($cntBy->get($cat->key, 0)) }}</span>
                    </button>
                @endforeach
            </div>

            <!-- Products Grid -->
            <div class="ds-product-grid" id="productGridContainer">

                @php
                    $homeVisible = 8;
                @endphp
                @foreach ($products as $i => $p)
                <article class="ds-product-card product-card {{ $i >= $homeVisible ? 'js-extra-product' : '' }}"
                    data-category="{{ $p->category_key }}" data-product-id="{{ $p->id }}" data-advance="0"
                    @if ($i >= $homeVisible) style="display:none" @endif>
                    <div class="ds-product-media">
                        <img src="{{ asset(ab_img($p->image)) }}" alt="{{ $p->image_alt ?: $p->name }}" loading="lazy">
                        <div class="ds-product-badges">
                            @if ($p->is_featured)<span class="ds-badge-discount" style="background:#047857">ফিচার্ড</span>@endif
                            <span class="ds-badge-discount" data-en="{{ $p->discount_en }}">{{ $p->discount_bn }}</span>
                            <span class="ds-badge-category" data-en="{{ $p->category_en }}">{{ $p->category }}</span>
                        </div>
                        <button class="ds-product-quick-btn" onclick="openQuickView({{ $p->id }})">
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg> <span data-en="Details">বিস্তারিত</span>
                        </button>
                    </div>
                    <div class="ds-product-body">
                        <div class="ds-product-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($p->rating >= $i - 0.25) <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                @elseif ($p->rating >= $i - 0.75) <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path fill="currentColor" stroke="none" d="M12 2 8.91 8.26 2 9.27 7 14.14 5.82 21.02 12 17.77Z"/><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                @else <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> @endif
                            @endfor
                            <span>{{ number_format($p->rating, 1) }} <span data-en="({{ $p->reviews_count }} reviews)">({{ bn_num($p->reviews_count) }}টি রিভিউ)</span></span>
                        </div>
                        <h3 class="ds-product-title" data-en="{{ $p->name_en }}">{{ $p->name }}</h3>
                        <div class="ds-product-price-row">
                            <del>৳{{ bn_num($p->old_price) }}</del>
                            <ins>৳{{ bn_num($p->price) }}</ins>
                            @if ($p->stock > 0)
                            <span class="ds-product-stock-pill" data-en="{{ $p->stock_badge_en ?? 'In Stock' }}">{{ $p->stock_badge ?? 'স্টকে আছে' }} ({{ bn_num($p->stock) }} {{ $p->unit }})</span>
                            @else
                            <span class="ds-product-stock-pill" style="background:#fee2e2;color:#dc2626" data-en="Out of Stock">স্টক শেষ</span>
                            @endif
                        </div>
                        <div class="ds-product-actions">
                            @if ($p->stock > 0)
                            <button class="ds-btn ds-btn-block" onclick="selectProductForOrder({{ $p->id }})">
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="Order Now">অর্ডার করুন</span>
                            </button>
                            @else
                            <button class="ds-btn ds-btn-block" disabled style="opacity:.5;cursor:not-allowed">
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m4.9 4.9 14.2 14.2"/></svg> <span data-en="Out of Stock">স্টক শেষ</span>
                            </button>
                            @endif
                        </div>
                    </div>
                </article>
                @endforeach
                @if ($products->count() > $homeVisible)
                    <div style="grid-column:1/-1;text-align:center;margin-top:10px">
                        <button type="button" class="ds-btn" id="seeMoreProducts" onclick="revealExtraProducts()">
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
                            <span data-en="See more">আরো দেখুন (<span class="js-extra-count">{{ $products->count() - $homeVisible }}</span>)</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>
