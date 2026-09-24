<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="xUCZgiihBezSd99HFloc5A3POiIfMNSLGOVjHPsO">
    <title>সব প্রোডাক্ট — আচারবাড়ি</title>

    <meta name="robots" content="index, follow">
    <meta name="author" content="AcharBari">
    <meta name="description"
        content="আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার, মধু, ঘি ও চাটনির বিশ্বস্ত অনলাইন শপ। প্রিজারভেটিভ মুক্ত ১০০% খাঁটি পণ্য ক্যাশ অন ডেলিভারিতে ঘরে বসে নিন।">
    <meta name="keywords"
        content="AcharBari, আচারবাড়ি, deshi achar online, mango pickle BD, আচার কিনুন, homemade pickle Bangladesh, Cash on Delivery.">

    <meta property="og:type" content="website">
    <meta property="og:title" content="আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ">
    <meta property="og:description"
        content="ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি এখন অর্ডার করুন ক্যাশ অন ডেলিভারিতে।">
    <meta property="og:site_name" content="AcharBari">
    <meta property="og:locale" content="bn_BD">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ">
    <meta name="twitter:description" content="খাঁটি দেশি আচার ও প্রিজার্ভ ক্যাশ অন ডেলিভারিতে ঘরে বসে অর্ডার করুন।">
    <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome 6.5.1 (fonts inlined as base64 — works via file:// too) -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome.min.css?v=5') }}">

    <link rel="stylesheet" href="{{ asset('assets/style.css?v=22') }}">
</head>
<body class="text-gray-800 antialiased" data-title-bn="সব প্রোডাক্ট — আচারবাড়ি"
    data-title-en="All Products — AcharBari">

    <!-- Hidden Coupon Form for Backend -->
    <form id="coupon-form" action="/cart/apply-coupon" method="POST" style="display:none;">
        <input type="hidden" name="_token" value="xUCZgiihBezSd99HFloc5A3POiIfMNSLGOVjHPsO" autocomplete="off">
        <input type="hidden" name="coupon_code" id="hidden_coupon_code">
    </form>

    <header class="ds-header-wrap" id="dsHeaderWrap">
        <div class="ds-header-bar" id="dsHeader">
            <!-- Brand Logo -->
            <a class="ds-logo" href="#">
                <span class="ds-logo-ic" data-ab-logo-slot>
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 2.5h8"></path>
                        <path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"></path>
                        <path d="M5 10h14"></path>
                        <path d="M9.5 14.5h5"></path>
                    </svg>
                </span>
                <span class="ds-logo-tx" data-ab-brand-logo>আচার<em>বাড়ি</em></span>
                <span class="ds-logo-pill">খাঁটি</span>
            </a>

            <!-- Central Floating Pill Navigation -->
            <nav class="ds-nav-pill-track">
                <a href="{{ url('/') }}" class="ds-nav-pill" data-en="Home">হোম</a>
                <a href="{{ route('products') }}" class="ds-nav-pill ds-nav-pill-seller active">
                    <span class="ds-beacon-dot"></span>
                    <span data-en="All Products">সব প্রোডাক্ট</span>
                </a>
                <a href="#ds-why" class="ds-nav-pill" data-en="Why Us">কেন আমরা</a>
                <a href="#ds-reviews" class="ds-nav-pill" data-en="Reviews">রিভিউ</a>
                <a href="#ds-faq" class="ds-nav-pill" data-en="FAQ">প্রশ্ন-উত্তর</a>
            </nav>

            <!-- Right Action Buttons -->
            <div class="ds-header-actions">
                <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                    <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাং</button>
                    <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">EN</button>
                </div>
                <a class="ds-btn-seller-glow" href="{{ route('products') }}" style="text-decoration:none">
                    <i class="fa-solid fa-jar"></i>
                    <span data-en="All Products">সব প্রোডাক্ট</span>
                </a>
                <button class="ds-btn-order-shine" aria-label="অর্ডার করুন"
                    onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span data-en="Order Now">অর্ডার করুন</span>
                    <span class="ds-btn-shimmer-fx"></span>
                </button>
                <button class="ds-mobile-nav-toggle" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="মেনু">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Glass Navigation Drawer -->
        <div class="ds-mobile-drawer" id="mobileNavDrawer">
            <div class="ds-mobile-drawer-in">
                <a href="{{ url('/') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                    <i class="fa-solid fa-jar"></i> <span data-en="Products">প্রোডাক্টস</span>
                </a>
                <a href="{{ route('products') }}" class="ds-mob-link ds-mob-seller active" onclick="toggleMobileNav()">
                    <span class="ds-pulse-dot"></span>
                    <span data-en="All Products">সব প্রোডাক্ট</span>
                </a>
                <a href="#ds-why" class="ds-mob-link" onclick="toggleMobileNav()">
                    <i class="fa-solid fa-shield-halved"></i> <span data-en="Why Us">কেন আমরা</span>
                </a>
                <a href="#ds-reviews" class="ds-mob-link" onclick="toggleMobileNav()">
                    <i class="fa-solid fa-star"></i> <span data-en="Customer Reviews">কাস্টমার রিভিউ</span>
                </a>
                <a href="#ds-faq" class="ds-mob-link" onclick="toggleMobileNav()">
                    <i class="fa-solid fa-circle-question"></i> <span data-en="FAQ">সাধারণ প্রশ্ন-উত্তর</span>
                </a>
                <div class="ds-mob-lang">
                    <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                        <button type="button" class="ds-lang-btn on" data-lang-btn="bn"
                            onclick="AB.setLang('bn')">বাংলা</button>
                        <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">English</button>
                    </div>
                </div>
                <div class="ds-mob-actions">
                    <a class="ds-btn ds-btn-block ds-btn-ghost mb-2" href="{{ route('products') }}" style="text-decoration:none"
                        onclick="toggleMobileNav();">
                        <i class="fa-solid fa-jar"></i> <span data-en="Browse All Products">সব প্রোডাক্ট দেখুন</span>
                    </a>
                    <button class="ds-btn ds-btn-block"
                        onclick="toggleMobileNav(); document.getElementById('order-form').scrollIntoView({behavior:'smooth'});">
                        <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now (COD)">অর্ডার করুন (COD)</span>
                    </button>
                </div>
            </div>
        </div>
    </header>


    <!-- ================= PAGE HERO ================= -->
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

<footer class="lp-footer">
        <div class="lp-footer-glow"></div>
        <div class="lp-footer-in">
            <div class="lp-f-brand">
                <a class="lp-f-logo" href="#">
                    <span class="lp-f-logo-ic" data-ab-logo-slot>
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 2.5h8"></path>
                            <path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"></path>
                            <path d="M5 10h14"></path>
                            <path d="M9.5 14.5h5"></path>
                        </svg>
                    </span>
                    <span class="lp-f-logo-tx" data-ab-brand-logo>আচার<em>বাড়ি</em></span>
                </a>
                <p class="lp-f-tag" data-en="Homemade deshi pickles, honey &amp; ghee — delivered to your home across Bangladesh with Cash on Delivery.">
                    ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি — সারা বাংলাদেশে ক্যাশ অন ডেলিভারিতে হোম ডেলিভারি।</p>
                <div class="lp-f-social">
                    <a href="https://facebook.com/" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://m.me/AcharBari" target="_blank" rel="noopener" aria-label="Messenger"><i class="fa-brands fa-facebook-messenger"></i></a>
                    <a href="https://wa.me/8801707373692" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="tel:01707373692" aria-label="Hotline"><i class="fa-solid fa-phone"></i></a>
                </div>
                <div class="lp-f-pay">
                    <span class="img-chip"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
                    <span class="img-chip"><img src="{{ asset('assets/img/pay/nagad.svg') }}" alt="Nagad"></span>
                    <span>Rocket</span>
                    <span>Upay</span>
                    <span data-en="Cash on Delivery">ক্যাশ অন ডেলিভারি</span>
                </div>
            </div>

            <div class="lp-f-col">
                <h4 data-en="Quick Links">কুইক লিংক</h4>
                <a href="#ds-products"><i class="fa-solid fa-jar"></i> <span data-en="Products">প্রোডাক্টস</span></a>
                <a href="{{ route('products') }}"><i class="fa-solid fa-jar"></i> <span data-en="All Products">সব প্রোডাক্ট</span></a>
                <a href="#ds-why"><i class="fa-solid fa-shield-halved"></i> <span data-en="Why Us">কেন আমরা</span></a>
                <a href="#ds-faq"><i class="fa-solid fa-circle-question"></i> <span data-en="FAQ">প্রশ্ন-উত্তর</span></a>
            </div>

            <div class="lp-f-col">
                <h4 data-en="Contact &amp; Support">যোগাযোগ ও সাপোর্ট</h4>
                <a href="tel:01707373692"><i class="fa-solid fa-phone"></i> 01707373692</a>
                <a href="https://wa.me/8801707373692" target="_blank" rel="noopener"><i
                        class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                <a href="https://facebook.com/" target="_blank" rel="noopener"><i class="fa-brands fa-facebook"></i>
                    <span data-en="Facebook Page">ফেসবুক পেজ</span></a>
                <a href="{{ route('admin.login') }}"><i class="fa-solid fa-user-shield"></i> <span data-en="Admin Demo">অ্যাডমিন ডেমো</span></a>
            </div>
        </div>

        <div class="lp-f-bar">
            <span>© 2026 <strong data-ab-brand-name>আচারবাড়ি</strong>. <span data-en="All rights reserved">All rights
                    reserved</span></span>
            <span><span data-en="Made with love by">Made with love by</span> <strong
                    data-ab-brand-name>আচারবাড়ি</strong> 🧡</span>
        </div>
    </footer>

<div class="chat-widget">
        <div class="chat-toggle" id="chatToggle" title="সাপোর্ট চ্যাট">
            <i class="fas fa-comment-dots"></i>
        </div>
        <div class="chat-options" id="chatOptions">
            <a href="https://m.me/AcharBari" target="_blank" class="chat-btn messenger" title="Messenger">
                <i class="fab fa-facebook-messenger"></i>
            </a>
            <a href="https://wa.me/8801707373692" target="_blank" class="chat-btn whatsapp" title="WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="tel:01707373692" class="chat-btn hotline" title="Hotline">
                <i class="fas fa-phone"></i>
            </a>
        </div>
    </div>

    <!-- ================= STICKY MOBILE BOTTOM CTA ================= -->
    <div id="stickyCta">
        <a href="tel:01707373692" class="cta-call">
            <i class="fa-solid fa-phone"></i> <span data-en="Call">কল করুন</span>
        </a>
        <button class="cta-order" onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
            <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">অর্ডার করুন</span>
        </button>
    </div>

    
    <!-- ================= MODAL: PRODUCT QUICK VIEW ================= -->
    <div id="quickViewModal" class="ds-modal-overlay" onclick="if(event.target===this)closeQuickViewModal()">
        <div class="ds-modal-card max-w-2xl">
            <div class="ds-modal-header">
                <div class="ds-modal-title" id="qvModalTitle">
                    <i class="fa-solid fa-circle-info"></i> <span data-en="Product Details">প্রোডাক্ট বিবরণ</span>
                </div>
                <button class="ds-modal-close" onclick="closeQuickViewModal()">×</button>
            </div>
            <div class="ds-modal-body">
                <div class="ds-qv-grid">
                    <div class="ds-qv-img">
                        <img id="qvModalImg" src="{{ asset('assets/img/prod_mango.jpg') }}" alt="Product Preview">
                    </div>
                    <div class="flex flex-col justify-between">
                        <div>
                            <span id="qvModalCategory"
                                class="ds-badge-category !static inline-block mb-2"><span data-en="Category">ক্যাটাগরি</span></span>
                            <h3 id="qvModalName" class="text-xl font-bold text-gray-900 mb-2" data-en="Product Name">প্রোডাক্টের নাম</h3>
                            <div class="flex items-center gap-2 mb-3">
                                <span id="qvModalPrice" class="text-2xl font-extrabold text-emerald-600">৳০</span>
                                <del id="qvModalOldPrice" class="text-sm text-gray-400">৳০</del>
                                <span id="qvModalDiscount" class="ds-badge-discount !static ml-auto">-০%</span>
                            </div>
                            <p id="qvModalDesc" class="text-sm text-gray-600 mb-4 leading-relaxed" data-en="100% authentic product with the fastest delivery and easy Cash on Delivery.">
                                ১০০% খাঁটি অথেনটিক প্রোডাক্ট। দ্রুততম ডেলিভারি এবং সহজ ক্যাশ অন ডেলিভারি সুবিধাসহ।
                            </p>
                            <div class="space-y-1 text-xs text-gray-700 mb-4">
                                <div><i class="fa-solid fa-check text-emerald-600 mr-1.5"></i> <span data-en="Home delivery across Bangladesh">সারা বাংলাদেশে হোম ডেলিভারি</span></div>
                                <div><i class="fa-solid fa-check text-emerald-600 mr-1.5"></i> <span data-en="Check the sealed jar, then pay">সিল করা জার চেক করে মূল্য পরিশোধ</span></div>
                                <div><i class="fa-solid fa-check text-emerald-600 mr-1.5"></i> <span data-en="Free replacement on broken jars">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি</span></div>
                            </div>
                        </div>

                        <button id="qvOrderBtn" class="ds-btn ds-btn-block ds-btn-lg" onclick="orderFromQuickView()">
                            <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now (Cash on Delivery)">অর্ডার করুন (ক্যাশ অন ডেলিভারি)</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>window.quickViewProducts = @json($qv);</script>
    <script src="{{ asset('assets/brand.js?v=5') }}"></script>
    <script src="{{ asset('assets/script.js?v=21') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AB.init();
            });
    </script>
</body>

</html>
