{{-- Section: products | Design 3 — Bento Showcase (scoped: prod-v3)
     Preserves: .ds-filter-btn, .ds-product-card/.product-card, openQuickView(), selectProductForOrder(), data-category.
     Shows all products (carousel/grid scrolling replaces See-More). --}}
<section class="prod-v3" id="ds-products">
    <div class="prod-v3__in">
        @php
            $v3ph = ab_t('prod_eyebrow', 'জনপ্রিয় কালেকশন', 'Popular Collections');
            $v3ph2a = ab_t('prod_h2a', 'এই মুহূর্তের ', "Today's ");
            $v3ph2b = ab_t('prod_h2b', 'সেরা আচার ডিল', 'Best Pickle Deals');
            $v3psub = ab_t('prod_sub', 'আপনার পছন্দের জার বেছে নিন — ব্যাচ শেষ হওয়ার আগেই অর্ডার করুন ক্যাশ অন ডেলিভারিতে', 'Choose your favourite jar — order on Cash on Delivery before the batch runs out');
            $v3cntAll = $products->count();
            $v3cntBy = $products->countBy('category_key');
            $v3fAll = ab_t('filter_all', 'সব প্রোডাক্ট', 'All Items');
            $v3cats = ab_pill_categories();
        @endphp

        <div class="prod-v3__head">
            <span class="prod-v3__eyebrow" data-en="{{ $v3ph['en'] }}">{{ $v3ph['bn'] }}</span>
            <h2 class="prod-v3__h2"><span data-en="{{ $v3ph2a['en'] }}">{{ $v3ph2a['bn'] }}</span><span class="prod-v3__grad" data-en="{{ $v3ph2b['en'] }}">{{ $v3ph2b['bn'] }}</span></h2>
            <p class="prod-v3__sub" data-en="{{ $v3psub['en'] }}">{{ $v3psub['bn'] }}</p>
            <div class="ds-filter-wrap prod-v3__filters">
                <button class="ds-filter-btn active" data-filter="all">
                    <span data-en="{{ $v3fAll['en'] }}">{{ $v3fAll['bn'] }}</span> <span class="ds-filter-count">{{ bn_num($v3cntAll) }}</span>
                </button>
                @foreach ($v3cats as $cat)
                    <button class="ds-filter-btn" data-filter="{{ $cat->key }}">
                        <span data-en="{{ $cat->name_en }}">{{ $cat->name }}</span> <span class="ds-filter-count">{{ bn_num($v3cntBy->get($cat->key, 0)) }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="prod-v3__bento" id="productGridContainer">
            @foreach ($products as $i => $p)
                @php $feat = $i === 0; @endphp
                <article class="prod-v3__card {{ $feat ? 'prod-v3__card--big' : '' }} ds-product-card product-card"
                    data-category="{{ $p->category_key }}" data-product-id="{{ $p->id }}" data-advance="0">
                    <div class="ds-product-media">
                        <img src="{{ asset(ab_img($p->image)) }}" alt="{{ $p->image_alt ?: $p->name }}" loading="lazy">
                        <div class="ds-product-badges">
                            @if ($p->is_featured)<span class="ds-badge-discount" style="background:#047857">ফিচার্ড</span>@endif
                            <span class="ds-badge-discount" data-en="{{ $p->discount_en }}">{{ $p->discount_bn }}</span>
                            <span class="ds-badge-category" data-en="{{ $p->category_en }}">{{ $p->category }}</span>
                        </div>
                        <button class="ds-product-quick-btn" onclick="openQuickView({{ $p->id }})">
                            <span data-en="Details">বিস্তারিত</span>
                        </button>
                    </div>
                    <div class="ds-product-body">
                        <h3 class="ds-product-title" data-en="{{ $p->name_en }}">{{ $p->name }}</h3>
                        <div class="ds-product-price-row">
                            <del>৳{{ bn_num($p->old_price) }}</del>
                            <ins>৳{{ bn_num($p->price) }}</ins>
                            @if ($p->stock > 0)
                            <span class="ds-product-stock-pill" data-en="{{ $p->stock_badge_en ?? 'In Stock' }}">{{ $p->stock_badge ?? 'স্টকে আছে' }}</span>
                            @else
                            <span class="ds-product-stock-pill" style="background:#fee2e2;color:#dc2626" data-en="Out of Stock">স্টক শেষ</span>
                            @endif
                        </div>
                        <div class="ds-product-actions">
                            @if ($p->stock > 0)
                            <button class="ds-btn ds-btn-block" onclick="selectProductForOrder({{ $p->id }})">
                                <span data-en="Order Now">অর্ডার করুন</span>
                            </button>
                            @else
                            <button class="ds-btn ds-btn-block" disabled style="opacity:.5;cursor:not-allowed">
                                <span data-en="Out of Stock">স্টক শেষ</span>
                            </button>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
<style>
    .prod-v3 { padding: 54px 0 44px; background: var(--ds-section-alt-bg, #f8fbf9); }
    .prod-v3__in { max-width: 1240px; margin: 0 auto; padding: 0 20px; }
    .prod-v3__head { text-align: center; margin-bottom: 26px; }
    .prod-v3__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .prod-v3__h2 { margin: 0 0 8px; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; }
    .prod-v3__grad { background: linear-gradient(90deg, var(--ds-primary), var(--ds-accent)); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .prod-v3__sub { margin: 0 auto 16px; font-size: 13.5px; color: #4b6357; max-width: 520px; }
    .prod-v3__filters { justify-content: center; }
    .prod-v3__bento {
        display: grid; gap: 16px;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 240px), 1fr));
    }
    .prod-v3__card {
        border-radius: 20px; overflow: hidden; background: #fff; border: 1.5px solid rgba(5,150,105,.16);
        box-shadow: 0 18px 38px -28px rgba(6,78,59,.45);
        transition: transform .2s ease, box-shadow .25s ease;
    }
    .prod-v3__card:hover { transform: translateY(-5px); box-shadow: 0 30px 54px -30px rgba(6,78,59,.55); }
    .prod-v3__card--big { grid-column: span 2; grid-row: span 1; }
    .prod-v3__card--big .ds-product-media img { height: 320px; object-fit: cover; width: 100%; }
    .prod-v3__card .ds-product-media img { height: 210px; object-fit: cover; width: 100%; transition: transform .4s ease; }
    .prod-v3__card:hover .ds-product-media img { transform: scale(1.06); }
    @media (max-width: 640px) {
        .prod-v3__card--big { grid-column: span 1; }
    }
</style>
