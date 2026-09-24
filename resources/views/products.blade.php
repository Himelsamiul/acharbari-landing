@extends('layouts.landing')

@section('nav', 'products')

@section('title', 'সব প্রোডাক্ট — আচারবাড়ি')

@section('content')
<section class="ds-hero pp-hero">
        <div class="ds-container" style="text-align: center;">
            <span class="ds-chip-hero">
                <i class="fa-solid fa-jar"></i> <span data-en="All homemade products">সব হোমমেড প্রোডাক্ট এক জায়গায়</span>
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

            <!-- Dynamic Category Filter Pills -->
            <div class="ds-filter-wrap">
                <button class="ds-filter-btn active" data-filter="all">
                    <i class="fa-solid fa-border-all"></i> <span data-en="All Items">সব প্রোডাক্ট</span> <span class="ds-filter-count">৬</span>
                </button>
                <button class="ds-filter-btn" data-filter="pickle">
                    <i class="fa-solid fa-pepper-hot"></i> <span data-en="Pickles">আচার</span> <span class="ds-filter-count">৩</span>
                </button>
                <button class="ds-filter-btn" data-filter="pure">
                    <i class="fa-solid fa-jar"></i> <span data-en="Honey &amp; Ghee">মধু ও ঘি</span> <span class="ds-filter-count">২</span>
                </button>
                <button class="ds-filter-btn" data-filter="chaatni">
                    <i class="fa-solid fa-bowl-food"></i> <span data-en="Chutney">চাটনি</span> <span class="ds-filter-count">১</span>
                </button>
            </div>

            <!-- Products Grid -->
            <div class="ds-product-grid" id="productGridContainer">

                <!-- Product 1: Mango Kuchi Achar -->
                @foreach ($products as $p)
                <article class="ds-product-card product-card" data-category="{{ $p->category_key }}" data-product-id="{{ $p->id }}" data-advance="0">
                    <div class="ds-product-media">
                        <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" loading="lazy">
                        <div class="ds-product-badges">
                            <span class="ds-badge-discount" data-en="{{ $p->discount_en }}">{{ $p->discount_bn }}</span>
                            <span class="ds-badge-category" data-en="{{ $p->category_en }}">{{ $p->category }}</span>
                        </div>
                        <button class="ds-product-quick-btn" onclick="openQuickView({{ $p->id }})">
                            <i class="fa-solid fa-eye"></i> <span data-en="Details">বিস্তারিত</span>
                        </button>
                    </div>
                    <div class="ds-product-body">
                        <div class="ds-product-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($p->rating >= $i - 0.25) <i class="fa-solid fa-star"></i>
                                @elseif ($p->rating >= $i - 0.75) <i class="fa-solid fa-star-half-stroke"></i>
                                @else <i class="fa-regular fa-star"></i> @endif
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
                                <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">অর্ডার করুন</span>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
</div>
                        <button class="ds-product-quick-btn" onclick="openQuickView(1)">
                            <i class="fa-solid fa-eye"></i> <span data-en="Details">বিস্তারিত</span>
                        </button>
                    </div>
                    <div class="ds-product-body">
                        <div class="ds-product-rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star-half-stroke"></i>
                            <span>৪.৯ <span data-en="(128 reviews)">(১২৮টি রিভিউ)</span></span>
                        </div>
                        <h3 class="ds-product-title" data-en="Authentic Mango Kuchi Achar (500g) — in pure mustard oil">খাঁটি আমের কুচি আচার (৫০০ গ্রাম) — খাঁটি সরিষার তেলে</h3>
                        <div class="ds-product-price-row">
                            <del>৳৬০০</del>
                            <ins>৳৪৫০</ins>
                            <span class="ds-product-stock-pill" data-en="In Stock">স্টকে আছে</span>
                        </div>
                        <div class="ds-product-actions">
                            <button class="ds-btn ds-btn-block" onclick="selectProductForOrder(1)">
                                <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">অর্ডার করুন</span>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Product 2: Jalpai Olive Achar -->
                <article class="ds-product-card product-card" data-category="pickle" data-product-id="2" data-advance="0">
                    <div class="ds-product-media">
                        <img src="{{ asset('assets/img/prod_jalpai.jpg') }}" alt="হাতে তৈরি জলপাই আচার" loading="lazy">
                        <div class="ds-product-badges">
                            <span class="ds-badge-discount" data-en="-15% Off">-১৫% ছাড়</span>
                            <span class="ds-badge-category" data-en="Pickle">আচার</span>
                        </div>
                        <button class="ds-product-quick-btn" onclick="openQuickView(2)">
                            <i class="fa-solid fa-eye"></i> <span data-en="Details">বিস্তারিত</span>
                        </button>
                    </div>
                    <div class="ds-product-body">
                        <div class="ds-product-rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <span>৪.৮ <span data-en="(95 reviews)">(৯৫টি রিভিউ)</span></span>
                        </div>
                        <h3 class="ds-product-title" data-en="Handmade Jalpai Olive Pickle (400g) — Thakumar recipe">হাতে তৈরি জলপাই আচার (৪০০ গ্রাম) — ঠাকুমার রেসিপিতে</h3>
                        <div class="ds-product-price-row">
                            <del>৳৪৫০</del>
                            <ins>৳৩৮০</ins>
                            <span class="ds-product-stock-pill" data-en="In Stock">স্টকে আছে</span>
                        </div>
                        <div class="ds-product-actions">
                            <button class="ds-btn ds-btn-block" onclick="selectProductForOrder(2)">
                                <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">অর্ডার করুন</span>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Product 3: Mixed Achar Pack -->
                <article class="ds-product-card product-card" data-category="pickle" data-product-id="3" data-advance="0">
                    <div class="ds-product-media">
                        <img src="{{ asset('assets/img/prod_mix.jpg') }}" alt="স্পেশাল মিক্সড আচার প্যাক" loading="lazy">
                        <div class="ds-product-badges">
                            <span class="ds-badge-discount" data-en="-28% Off">-২৮% ছাড়</span>
                            <span class="ds-badge-category" data-en="Pickle">আচার</span>
                        </div>
                        <button class="ds-product-quick-btn" onclick="openQuickView(3)">
                            <i class="fa-solid fa-eye"></i> <span data-en="Details">বিস্তারিত</span>
                        </button>
                    </div>
                    <div class="ds-product-body">
                        <div class="ds-product-rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <span>৫.০ <span data-en="(140 reviews)">(১৪০টি রিভিউ)</span></span>
                        </div>
                        <h3 class="ds-product-title" data-en="Special Mixed Pickle Pack (3 Varieties) — mango, olive &amp; chili">স্পেশাল মিক্সড আচার প্যাক (৩ প্রকার) — আম, জলপাই ও মরিচ</h3>
                        <div class="ds-product-price-row">
                            <del>৳৯০০</del>
                            <ins>৳৬৫০</ins>
                            <span class="ds-product-stock-pill" data-en="Hot Deal">হট ডিল</span>
                        </div>
                        <div class="ds-product-actions">
                            <button class="ds-btn ds-btn-block" onclick="selectProductForOrder(3)">
                                <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">অর্ডার করুন</span>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Product 4: Tamarind Chutney -->
                <article class="ds-product-card product-card" data-category="chaatni" data-product-id="4" data-advance="0">
                    <div class="ds-product-media">
                        <img src="{{ asset('assets/img/prod_chutney.jpg') }}" alt="তেঁতুল ঝোল চাটনি" loading="lazy">
                        <div class="ds-product-badges">
                            <span class="ds-badge-discount" data-en="-26% Off">-২৬% ছাড়</span>
                            <span class="ds-badge-category" data-en="Chutney">চাটনি</span>
                        </div>
                        <button class="ds-product-quick-btn" onclick="openQuickView(4)">
                            <i class="fa-solid fa-eye"></i> <span data-en="Details">বিস্তারিত</span>
                        </button>
                    </div>
                    <div class="ds-product-body">
                        <div class="ds-product-rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star-half-stroke"></i>
                            <span>৪.৯ <span data-en="(64 reviews)">(৬৪টি রিভিউ)</span></span>
                        </div>
                        <h3 class="ds-product-title" data-en="Tetul Jhol Tangy Chutney (350g) — perfect with khichuri &amp; snacks">তেঁতুল ঝোল টক-ঝাল চাটনি (৩৫০ গ্রাম) — খিচুড়ি ও নাস্তার সঙ্গী</h3>
                        <div class="ds-product-price-row">
                            <del>৳৩৯০</del>
                            <ins>৳২৯০</ins>
                            <span class="ds-product-stock-pill" data-en="New Arrival">নতুন আগমন</span>
                        </div>
                        <div class="ds-product-actions">
                            <button class="ds-btn ds-btn-block" onclick="selectProductForOrder(4)">
                                <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">অর্ডার করুন</span>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Product 5: Deshi Ghee -->
                <article class="ds-product-card product-card" data-category="pure" data-product-id="5" data-advance="0">
                    <div class="ds-product-media">
                        <img src="{{ asset('assets/img/prod_ghee.jpg') }}" alt="ঘরে ভাঙা খাঁটি দেশি ঘি" loading="lazy">
                        <div class="ds-product-badges">
                            <span class="ds-badge-discount" data-en="-15% Off">-১৫% ছাড়</span>
                            <span class="ds-badge-category" data-en="Honey &amp; Ghee">মধু ও ঘি</span>
                        </div>
                        <button class="ds-product-quick-btn" onclick="openQuickView(5)">
                            <i class="fa-solid fa-eye"></i> <span data-en="Details">বিস্তারিত</span>
                        </button>
                    </div>
                    <div class="ds-product-body">
                        <div class="ds-product-rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <span>৪.৮ <span data-en="(112 reviews)">(১১২টি রিভিউ)</span></span>
                        </div>
                        <h3 class="ds-product-title" data-en="Pure Homemade Deshi Ghee (500ml) — from village cow milk">ঘরে ভাঙা খাঁটি দেশি ঘি (৫০০ মিলি) — গ্রামের গরুর দুধের সর</h3>
                        <div class="ds-product-price-row">
                            <del>৳১,৪০০</del>
                            <ins>৳১,১৯০</ins>
                            <span class="ds-product-stock-pill" data-en="In Stock">স্টকে আছে</span>
                        </div>
                        <div class="ds-product-actions">
                            <button class="ds-btn ds-btn-block" onclick="selectProductForOrder(5)">
                                <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">অর্ডার করুন</span>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Product 6: Sundarban Honey -->
                <article class="ds-product-card product-card" data-category="pure" data-product-id="6" data-advance="0">
                    <div class="ds-product-media">
                        <img src="{{ asset('assets/img/prod_honey.jpg') }}" alt="সুন্দরবনের খাঁটি কাঁচা মধু" loading="lazy">
                        <div class="ds-product-badges">
                            <span class="ds-badge-discount" data-en="-20% Off">-২০% ছাড়</span>
                            <span class="ds-badge-category" data-en="Honey &amp; Ghee">মধু ও ঘি</span>
                        </div>
                        <button class="ds-product-quick-btn" onclick="openQuickView(6)">
                            <i class="fa-solid fa-eye"></i> <span data-en="Details">বিস্তারিত</span>
                        </button>
                    </div>
                    <div class="ds-product-body">
                        <div class="ds-product-rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <span>৫.০ <span data-en="(200+ reviews)">(২০০+ রিভিউ)</span></span>
                        </div>
                        <h3 class="ds-product-title" data-en="Pure Raw Sundarban Honey (1kg) — lab-tested, no sugar added">সুন্দরবনের খাঁটি কাঁচা মধু (১ কেজি) — ল্যাব টেস্টেড, চিনি মুক্ত</h3>
                        <div class="ds-product-price-row">
                            <del>৳১,২৫০</del>
                            <ins>৳৯৯০</ins>
                            <span class="ds-product-stock-pill" data-en="100% Pure">১০০% খাঁটি</span>
                        </div>
                        <div class="ds-product-actions">
                            <button class="ds-btn ds-btn-block" onclick="selectProductForOrder(6)">
                                <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">অর্ডার করুন</span>
                            </button>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

@endsection
