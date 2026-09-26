@extends('layouts.landing')

@section('nav', 'products')

@section('title', 'সব প্রোডাক্ট — ' . ab_brand('bn'))

@section('content')
<section class="ds-hero pp-hero">
        <div class="ds-container" style="text-align: center;">
            <span class="ds-chip-hero">
                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="All homemade products">সব হোমমেড প্রোডাক্ট এক জায়গায়</span>
            </span>
            <h1 class="ds-h1" style="margin-top: 18px;">
                <span data-en="Our ">আমাদের </span><span class="ds-grad" data-en="Product Collection">প্রোডাক্ট কালেকশন</span>
            </h1>
            <p class="ds-lead" style="max-width: 640px; margin: 14px auto 0;" data-en="Handmade pickles, honey, ghee &amp; chutney — sealed jars delivered to your home across Bangladesh.">
                হাতে তৈরি আচার, মধু, ঘি ও চাটনি — সিল করা জারে সারা বাংলাদেশে হোম ডেলিভারি।
            </p>
        </div>
    </section>
<!-- ================= PRODUCTS DISCOVERY ================= -->
    <section class="ds-section ds-section-alt" id="ds-products">
        <div class="ds-container">
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="Popular Collections">জনপ্রিয় কালেকশন</span>
                <h2 class="ds-h2"><span data-en="Today's ">এই মুহূর্তের </span><span class="ds-grad" data-en="Best Pickle Deals">সেরা আচার ডিল</span></h2>
                <p class="ds-sub" data-en="Choose your favourite jar — order on Cash on Delivery before the batch runs out">আপনার পছন্দের জার বেছে নিন — ব্যাচ শেষ হওয়ার আগেই অর্ডার করুন ক্যাশ অন ডেলিভারিতে</p>
            </div>

            <!-- Filter bar: search + category pills + brand + sort -->
            <form method="GET" action="{{ route('products') }}" class="pp-filterbar" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin-bottom:14px">
                <div style="display:flex;gap:8px;flex:1;min-width:240px">
                    <input type="text" name="q" value="{{ $q }}" class="a-input" autocomplete="off"
                        placeholder="🔍 প্রোডাক্টের নাম লিখে খুঁজুন…" style="max-width:280px;padding:10px 14px">
                    <select name="brand" class="a-input" style="max-width:180px;padding:10px" onchange="this.form.submit()">
                        <option value="">সব ব্র্যান্ড</option>
                        @foreach ($brands as $b)
                            <option value="{{ $b->name }}" {{ $activeBrand === $b->name ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                    <select name="sort" class="a-input" style="max-width:190px;padding:10px" onchange="this.form.submit()">
                        <option value="popular" {{ $activeSort === 'popular' ? 'selected' : '' }}>জনপ্রিয়তা অনুসারে</option>
                        <option value="price_low" {{ $activeSort === 'price_low' ? 'selected' : '' }}>দাম: কম → বেশি</option>
                        <option value="price_high" {{ $activeSort === 'price_high' ? 'selected' : '' }}>দাম: বেশি → কম</option>
                        <option value="name" {{ $activeSort === 'name' ? 'selected' : '' }}>নাম (অ-ঐ)</option>
                    </select>
                </div>
                <input type="hidden" name="category" value="{{ $activeCategory }}">
                <button class="a-btn" type="submit" style="padding:10px 18px"><i class="fa-solid fa-magnifying-glass"></i> খুঁজুন</button>
                @if ($q !== '' || $activeBrand !== '' || $activeCategory !== 'all')
                    <a class="a-btn ghost" href="{{ route('products') }}" style="padding:10px 14px">✕ ফিল্টার সরান</a>
                @endif
            </form>
            <div class="ds-filter-wrap">
                <a href="{{ route('products', array_merge(request()->query(), ['category' => 'all'])) }}"
                   class="ds-filter-btn {{ $activeCategory === 'all' ? 'active' : '' }}" style="text-decoration:none">
                    <span data-en="All Items">সব প্রোডাক্ট</span>
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('products', array_merge(request()->query(), ['category' => $cat->category_key])) }}"
                       class="ds-filter-btn {{ $activeCategory === $cat->category_key ? 'active' : '' }}" style="text-decoration:none">
                        <span data-en="{{ $cat->category_en }}">{{ $cat->category }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Products Grid -->
            <div class="ds-product-grid" id="productGridContainer">

                <!-- Product 1: Mango Kuchi Achar -->
                @foreach ($products as $p)
                <article class="ds-product-card product-card" data-category="{{ $p->category_key }}" data-product-id="{{ $p->id }}" data-advance="0">
                    <div class="ds-product-media">
                        <img src="{{ asset(ab_img($p->image)) }}" alt="{{ $p->image_alt ?: $p->name }}" loading="lazy">
                        <div class="ds-product-badges">
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
                            <span class="ds-product-stock-pill" data-en="{{ $p->stock_badge_en }}">{{ $p->stock_badge }}</span>
                        </div>
                        <div class="ds-product-actions">
                            <a class="ds-btn ds-btn-block" href="{{ url('/') }}#order-form" style="text-decoration:none">
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="Order Now">অর্ডার করুন</span>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
</div>

            </div>
        </div>
    </section>

@endsection
