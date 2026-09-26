{{-- Section: products | Design 2 — Modern Horizontal Carousel (scoped: prod-v2)
     Preserves: .ds-filter-btn filtering, .ds-product-card/.product-card hooks,
     openQuickView(), selectProductForOrder(), data-category. All products shown —
     carousel scrolling replaces the See-More reveal. --}}
<section class="prod-v2" id="ds-products">
    <div class="prod-v2__in">
        @php
            $v2ph = ab_t('prod_eyebrow', 'জনপ্রিয় কালেকশন', 'Popular Collections');
            $v2ph2a = ab_t('prod_h2a', 'এই মুহূর্তের ', "Today's ");
            $v2ph2b = ab_t('prod_h2b', 'সেরা আচার ডিল', 'Best Pickle Deals');
            $v2psub = ab_t('prod_sub', 'আপনার পছন্দের জার বেছে নিন — ব্যাচ শেষ হওয়ার আগেই অর্ডার করুন ক্যাশ অন ডেলিভারিতে', 'Choose your favourite jar — order on Cash on Delivery before the batch runs out');
            $v2cntAll = $products->count();
            $v2cntBy = $products->countBy('category_key');
            $v2fAll = ab_t('filter_all', 'সব প্রোডাক্ট', 'All Items');
            $v2pillIcons = [
                'pickle' => '<path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/>',
                'pure' => '<path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/>',
                'chaatni' => '<path d="M4 11h16"/><path d="M5.5 11a6.5 6.5 0 0 0 13 0"/><path d="M9.5 7.5V6"/><path d="M12 7.5V5"/><path d="M14.5 7.5V6"/>',
            ];
            $v2homeCategories = \App\Models\Category::orderBy('id')->get();
        @endphp

        <div class="prod-v2__head">
            <div>
                <span class="prod-v2__eyebrow" data-en="{{ $v2ph['en'] }}">{{ $v2ph['bn'] }}</span>
                <h2 class="prod-v2__h2"><span data-en="{{ $v2ph2a['en'] }}">{{ $v2ph2a['bn'] }}</span><span class="prod-v2__grad" data-en="{{ $v2ph2b['en'] }}">{{ $v2ph2b['bn'] }}</span></h2>
                <p class="prod-v2__sub" data-en="{{ $v2psub['en'] }}">{{ $v2psub['bn'] }}</p>
            </div>
            <div class="ds-filter-wrap prod-v2__filters">
                <button class="ds-filter-btn active" data-filter="all">
                    <span data-en="{{ $v2fAll['en'] }}">{{ $v2fAll['bn'] }}</span> <span class="ds-filter-count">{{ bn_num($v2cntAll) }}</span>
                </button>
                @foreach ($v2homeCategories as $cat)
                    <button class="ds-filter-btn" data-filter="{{ $cat->key }}">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $v2pillIcons[$cat->key] ?? '<circle cx="12" cy="12" r="9"/>' !!}</svg>
                        <span data-en="{{ $cat->name_en }}">{{ $cat->name }}</span> <span class="ds-filter-count">{{ bn_num($v2cntBy->get($cat->key, 0)) }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="prod-v2__rail" id="productGridContainer">
            @foreach ($products as $p)
                <article class="ds-product-card product-card prod-v2__card"
                    data-category="{{ $p->category_key }}" data-product-id="{{ $p->id }}" data-advance="0">
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
                        <h3 class="ds-product-title" data-en="{{ $p->name_en }}">{{ $p->name }}</h3>
                        <div class="ds-product-rating">
                            <span>{{ number_format($p->rating, 1) }} <span data-en="({{ $p->reviews_count }} reviews)">({{ bn_num($p->reviews_count) }}টি রিভিউ)</span></span>
                        </div>
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
        <p class="prod-v2__hint"><i class="fa-solid fa-arrow-right-long"></i> <span data-en="Scroll to see more">স্ক্রল করে সব দেখুন</span></p>
    </div>
</section>
<style>
    .prod-v2 { padding: 54px 0 40px; background: var(--ds-section-alt-bg, #f8fbf9); }
    .prod-v2__in { max-width: 1240px; margin: 0 auto; padding: 0 20px; }
    .prod-v2__head { display: flex; justify-content: space-between; align-items: flex-end; gap: 18px; flex-wrap: wrap; margin-bottom: 22px; }
    .prod-v2__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .prod-v2__h2 { margin: 0 0 8px; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; }
    .prod-v2__grad { background: linear-gradient(90deg, var(--ds-primary), var(--ds-accent)); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .prod-v2__sub { margin: 0; font-size: 13.5px; color: #4b6357; max-width: 520px; }
    .prod-v2__filters { margin: 0; }
    .prod-v2__rail {
        display: grid; grid-auto-flow: column; grid-auto-columns: minmax(250px, 280px);
        gap: 16px; overflow-x: auto; padding: 6px 4px 18px;
        scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;
        scrollbar-width: thin; scrollbar-color: rgba(5,150,105,.4) transparent;
    }
    .prod-v2__rail::-webkit-scrollbar { height: 8px; }
    .prod-v2__rail::-webkit-scrollbar-thumb { background: rgba(5,150,105,.35); border-radius: 999px; }
    .prod-v2__card { scroll-snap-align: start; }
    .prod-v2__hint { margin: 4px 0 0; font-size: 12px; color: #8b7355; display: flex; gap: 7px; align-items: center; }
    @media (max-width: 768px) {
        .prod-v2__rail { grid-auto-columns: minmax(210px, 240px); }
    }
</style>
