<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ')</title>

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

<body class="text-gray-800 antialiased" data-title-bn="আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ"
    data-title-en="AcharBari — Homemade Deshi Pickles &amp; Preserves">

    
    <!-- ================= FLOATING GLASS HEADER ================= -->
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
                <a href="#" class="ds-nav-pill active" data-en="Home"
                    onclick="window.scrollTo({top:0,behavior:'smooth'});return false;">হোম</a>
                <a href="{{ route('products') }}" class="ds-nav-pill ds-nav-pill-seller">
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
                <button class="ds-btn-order-shine" aria-label="অর্ডার করুন"
                    onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span data-en="Order Now">অর্ডার করুন</span>
                    <span class="ds-btn-shimmer-fx"></span>
                </button>
                <button class="ds-mobile-nav-toggle" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="মেনู">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Glass Navigation Drawer -->
        <div class="ds-mobile-drawer" id="mobileNavDrawer">
            <div class="ds-mobile-drawer-in">
                <a href="#" class="ds-mob-link active" onclick="toggleMobileNav(); window.scrollTo({top:0,behavior:'smooth'});return false;">
                    <i class="fa-solid fa-house"></i> <span data-en="Home">হোম</span>
                </a>
                <a href="{{ route('products') }}" class="ds-mob-link ds-mob-seller" onclick="toggleMobileNav()">
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

    <!-- ================= HERO ================= -->
    <section class="ds-hero">
        <div class="ds-container ds-hero-grid">
            <div class="ds-hero-copy">
                <span class="ds-chip-hero">
                    🌶️ <span data-en="Finest village-made taste — Cash on Delivery">গ্রামবাংলার সেরা স্বাদ — ক্যাশ অন ডেলিভারিতে</span>
                </span>
                <h1 class="ds-h1" id="heroH1Slider">
                    <span class="hslide active">
                        <span data-en="Homemade authentic deshi pickles —">ঘরে তৈরি খাঁটি দেশি আচার —</span><br>
                        <span class="ds-grad" data-en="a bond of taste &amp; love">স্বাদ ও ভালোবাসার বন্ধন</span>
                    </span>
                    <span class="hslide">
                        <span data-en="Thakumar's recipe, made at home —">ঠাকুমার রেসিপিতে, ঘরে তৈরি —</span><br>
                        <span class="ds-grad" data-en="100% preservative free">১০০% প্রিজারভেটিভ মুক্ত</span>
                    </span>
                    <span class="hslide">
                        <span data-en="Order today on Cash on Delivery —">আজই অর্ডার করুন ক্যাশ অন ডেলিভারিতে —</span><br>
                        <span class="ds-grad" data-en="home delivery in 64 districts">৬৪ জেলায় হোম ডেলিভারি</span>
                    </span>
                </h1>
                <p class="ds-lead">
                    মৌসুমি কাঁচা আম, জলপাই, তেঁতুল আর সরিষার তেলে ঘরে তৈরি আচারবাড়ির প্রতিটি জার। কোনো প্রিজারভেটিভ বা
                    কেমিক্যাল নেই — সারা বাংলাদেশে দ্রুত হোম ডেলিভারিতে পৌঁছে যায় মায়ের হাতের সেই চেনা স্বাদ।
                </p>

                <div class="ds-hero-cta">
                    <button class="ds-btn ds-btn-lg"
                        onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
                        <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">এখনই অর্ডার করুন</span>
                    </button>
                    <a class="ds-btn ds-btn-ghost ds-btn-lg" href="{{ route('products') }}">
                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="Browse All Products">সব প্রোডাক্ট দেখুন</span>
                    </a>
                </div>

                <div class="ds-stats">
                    <div>
                        <strong data-en="15,000+">১৫,০০০+</strong>
                        <span data-en="Happy Customers">সন্তুষ্ট গ্রাহক</span>
                    </div>
                    <div>
                        <strong>৪.৯ <i class="fa-solid fa-star"></i></strong>
                        <span data-en="Customer Rating">কাস্টমার রেটিং</span>
                    </div>
                    <div>
                        <strong>৬৪</strong>
                        <span data-en="District Home Delivery">জেলায় হোম ডেলিভারি</span>
                    </div>
                    <div>
                        <strong data-en="100%">১০০%</strong>
                        <span data-en="Preservative Free">প্রিজারভেটিভ ফ্রি</span>
                    </div>
                </div>
            </div>

            <div class="ds-hero-visual">
                <div class="ds-hero-card">
                    <div class="ds-hero-img-wrap" id="heroImgSlider">
                        <img class="himg active" src="{{ asset('assets/img/hero_achar.jpg') }}"
                            alt="আচারবাড়ি — মসলার বাটি" fetchpriority="high">
                        <img class="himg" src="{{ asset('assets/img/prod_mix.jpg') }}" alt="আচারবাড়ি — আচারের জার সমূহ" loading="lazy">
                        <img class="himg" src="{{ asset('assets/img/prod_honey.jpg') }}" alt="আচারবাড়ি — সুন্দরবনের মধু" loading="lazy">
                        <img class="himg" src="{{ asset('assets/img/spice_box.jpg') }}" alt="আচারবাড়ি — মসলার ডাব্বা" loading="lazy">
                        <span class="ds-tag-flash">
                            <i class="fa-solid fa-fire text-amber-400"></i> <span data-en="Fresh Batch Live">নতুন ব্যাচ এসেছে</span>
                        </span>
                        <div class="hero-img-dots" id="heroImgDots">
                            <button class="active" aria-label="Slide 1" onclick="goHeroImg(0)"></button>
                            <button aria-label="Slide 2" onclick="goHeroImg(1)"></button>
                            <button aria-label="Slide 3" onclick="goHeroImg(2)"></button>
                            <button aria-label="Slide 4" onclick="goHeroImg(3)"></button>
                        </div>
                    </div>
                    <!-- Floating Trust Badges -->
                    <div class="ds-float-badge ds-float-badge-top">
                        <i class="fa-solid fa-truck-fast"></i>
                        <div>
                            <strong data-en="In 24-72 Hours">২৪-৭২ ঘণ্টায়</strong>
                            <span data-en="Home Delivery">হোম ডেলিভারি</span>
                        </div>
                    </div>
                    <div class="ds-float-badge ds-float-badge-bottom">
                        <i class="fa-solid fa-shield-halved"></i>
                        <div>
                            <strong data-en="100% Authentic">১০০% খাঁটি</strong>
                            <span data-en="Check before you pay">দেখে বুঝে পেমেন্ট</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= TRUST MARQUEE ================= -->
    <div class="ds-marquee" aria-hidden="true">
        <div class="ds-marquee-track">
            <span class="ds-marquee-item"><i class="fa-solid fa-truck"></i> <span data-en="Home delivery across Bangladesh">সারা বাংলাদেশে হোম ডেলিভারি</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-money-bill-wave"></i> <span data-en="Pay after checking the parcel (Cash on Delivery)">পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-jar"></i> <span data-en="Broken jar? Free replacement guarantee">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-leaf"></i> <span data-en="100% natural — no preservatives or chemicals">১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-heart"></i> <span data-en="Handcrafted in small batches with love">ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-headset"></i> <span data-en="24/7 dedicated customer support">২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট</span></span>
            <!-- Duplicate for infinite seamless scroll -->
            <span class="ds-marquee-item"><i class="fa-solid fa-truck"></i> <span data-en="Home delivery across Bangladesh">সারা বাংলাদেশে হোম ডেলিভারি</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-money-bill-wave"></i> <span data-en="Pay after checking the parcel (Cash on Delivery)">পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-jar"></i> <span data-en="Broken jar? Free replacement guarantee">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-leaf"></i> <span data-en="100% natural — no preservatives or chemicals">১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-heart"></i> <span data-en="Handcrafted in small batches with love">ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি</span></span>
            <span class="ds-marquee-item"><i class="fa-solid fa-headset"></i> <span data-en="24/7 dedicated customer support">২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট</span></span>
        </div>
    </div>

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
                            <button class="ds-btn ds-btn-block" onclick="selectProductForOrder({{ $p->id }})">
                                <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now">অর্ডার করুন</span>
                            </button>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ================= OUR PROMISES (4 CARDS) ================= -->
    <section class="ds-seller-section" id="ds-promise">
        <canvas id="neuralCanvas" class="ds-neural-canvas"></canvas>

        <div class="ds-container relative z-10">
            <div class="ds-sec-head text-center">
                <span class="ds-eyebrow" data-en="Our Guarantee">আমাদের গ্যারান্টি</span>
                <h2 class="ds-h2"><span data-en="Order with ">অর্ডার করুন </span><span class="ds-grad-neon" data-en="total peace of mind">সম্পূর্ণ নিশ্চিন্তে</span></h2>
                <p class="ds-sub" data-en="Fee, payment, delivery — transparency and safety at every single step.">ফি, পেমেন্ট, ডেলিভারি — প্রতিটি ধাপে স্বচ্ছতা ও নিরাপত্তা।</p>
            </div>

            <div class="ds-seller-benefits ds-bento-grid">
                <div class="ds-seller-card ds-bento-card">
                    <div class="ds-bento-glow"></div>
                    <div class="ds-seller-card-ic">
                        <i class="fa-solid fa-percent"></i>
                    </div>
                    <h4 data-en="0% Hidden Service Fee">০% হিডেন সার্ভিস ফি</h4>
                    <p data-en="No hidden fees or extra charges ever. What you see at checkout is exactly what you pay — What you see at checkout is exactly what you pay.">কোনো লুকায়িত ফি বা অতিরিক্ত চার্জ নেই। চেকআউটে যা দেখেন, ঠিক তাই পরিশোধ করবেন।</p>
                    <span class="ds-bento-tag" data-en="100% Transparent">১০০% স্বচ্ছ</span>
                </div>
                <div class="ds-seller-card ds-bento-card">
                    <div class="ds-bento-glow"></div>
                    <div class="ds-seller-card-ic">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                    </div>
                    <h4 data-en="48-Hour Guaranteed Payout">৪৮ ঘণ্টায় নিশ্চিত পেআউট</h4>
                    <p data-en="Refund or payout — money reaches your bKash or bank within just 48 hours, guaranteed.">রিফান্ড হোক বা পেআউট — টাকা পৌঁছে যাবে মাত্র ৪৮ ঘণ্টায় আপনার বিকাশ বা ব্যাংকে।</p>
                    <span class="ds-bento-tag" data-en="Instant bKash/Bank">ইনস্ট্যান্ট বিকাশ/ব্যাংক</span>
                </div>
                <div class="ds-seller-card ds-bento-card">
                    <div class="ds-bento-glow"></div>
                    <div class="ds-seller-card-ic">
                        <i class="fa-solid fa-truck-plane"></i>
                    </div>
                    <h4 data-en="Logistics in 64 Districts">৬৪ জেলায় অটো লজিস্টিকস</h4>
                    <p data-en="From your door anywhere in Bangladesh — pickup and delivery handled entirely by AcharBari via trusted courier partners.">আপনার লোকাল বা বাসা থেকে ফিক্সড ও সারা দেশে ডেলিভারি — সব হ্যান্ডেল করে আচারবাড়ি ট্রাস্টেড কুরিয়ার পার্টনারদের মাধ্যমে।</p>
                    <span class="ds-bento-tag">Steadfast + Pathao</span>
                </div>
                <div class="ds-seller-card ds-bento-card">
                    <div class="ds-bento-glow"></div>
                    <div class="ds-seller-card-ic">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h4 data-en="Sealed &amp; Safe Packaging">সিলড ও সেফ প্যাকেজিং</h4>
                    <p data-en="Every jar is air-tight sealed and wrapped in thick bubble layers — breakage risk is practically zero, or we replace it free.">প্রতিটি জার এয়ার-টাইট সিল ও মোটা বাবল-র‍্যাপে সাজানো — ভাঙার ঝুঁকি প্রায় শূন্য, নাহলে ফ্রি রিপ্লেসমেন্ট।</p>
                    <span class="ds-bento-tag" data-en="Sealed &amp; Safe">সিলড অ্যান্ড সেফ</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= HOW IT WORKS ================= -->
    <section class="ds-section">
        <div class="ds-container">
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="Process">প্রসেস</span>
                <h2 class="ds-h2"><span data-en="Order in just ">মাত্র ৩ ধাপে </span><span class="ds-grad" data-en="3 Simple Steps">অর্ডার সম্পন্ন</span></h2>
                <p class="ds-sub" data-en="Simple &amp; secure process — a hassle-free ordering experience">সহজ ও নিরাপদ প্রক্রিয়া — ঝামেলাহীন অর্ডারের অভিজ্ঞতা</p>
            </div>
            <div class="ds-steps">
                <div class="ds-step">
                    <span class="ds-step-n">১</span>
                    <i class="fa-solid fa-jar"></i>
                    <h3 data-en="Pick Your Favourite Jar">পছন্দের জার নির্বাচন</h3>
                    <p data-en="Select your favourite pickle, honey or ghee and fill in the simple form below with your name and address.">আপনার পছন্দের আচার, মধু বা ঘি সিলেক্ট করে নিচের সহজ ফর্মটিতে নাম ও ঠিকানা পূরণ করুন।</p>
                </div>
                <div class="ds-step">
                    <span class="ds-step-n">২</span>
                    <i class="fa-solid fa-phone-volume"></i>
                    <h3 data-en="Phone Confirmation">ফোন কলে কনফার্মেশন</h3>
                    <p data-en="As soon as we receive your order, our support team calls you to confirm the address and details.">অর্ডার পাওয়ার পরই আমাদের সাপোর্ট টিম কল দিয়ে ঠিকানা ও বিবরণ নিশ্চিত করবে।</p>
                </div>
                <div class="ds-step">
                    <span class="ds-step-n">৩</span>
                    <i class="fa-solid fa-box-open"></i>
                    <h3 data-en="Check the Jar, Then Pay">জার বুঝে টাকা দিন</h3>
                    <p data-en="Check the sealed jar in front of the delivery man and pay only when 100% satisfied.">ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে ১০০% সন্তুষ্ট হয়ে টাকা পরিশোধ করুন।</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= WHY US (BENTO GRID) ================= -->
    <section class="ds-section ds-section-alt" id="ds-why">
        <div class="ds-container">
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="Why We Are the Best">কেন আমরা সেরা</span>
                <h2 class="ds-h2"><span data-en="Why choose ">কেন বেছে নেবেন </span><span class="ds-grad" data-ab-brand-name>আচারবাড়ি</span><span>?</span></h2>
                <p class="ds-sub" data-en="We guarantee authentic taste and the fastest service">আমরা দিচ্ছি খাঁটি স্বাদের নিশ্চয়তা ও দ্রুততম সার্ভিস</p>
            </div>
            <div class="ds-bento">
                <div class="ds-bento-big">
                    <div>
                        <i class="fa-solid fa-shield-halved"></i>
                        <h3 data-en="100% Pure &amp; Preservative-Free Guarantee">১০০% খাঁটি ও প্রিজারভেটিভ-মুক্ত গ্যারান্টি</h3>
                        <p data-en="Every jar is handmade in small batches with seasonal fruits, premium mustard oil and pure spices. No preservatives, no colour, no chemicals — laboratory-tested and money-back guaranteed.">
                            প্রতিটি জার মৌসুমি ফল, খাঁটি সরিষার তেল ও বিশুদ্ধ মসলা দিয়ে ছোট ব্যাচে হাতে তৈরি। কোনো প্রিজারভেটিভ, কালার বা কেমিক্যাল নেই — ল্যাব-টেস্টেড এবং নকল প্রমাণিত হলে সম্পূর্ণ টাকা রিটার্নের নিশ্চয়তা।
                        </p>
                    </div>
                    <div class="flex items-center gap-3 text-sm font-bold text-emerald-300">
                        <i class="fa-solid fa-certificate !mb-0 !w-auto !h-auto !bg-transparent !text-emerald-400"></i>
                        <span data-en="Verified Village Kitchens">ভেরিফাইড গ্রামীণ রান্নাঘর</span>
                    </div>
                </div>
                <div class="ds-bento-cell">
                    <i class="fa-solid fa-truck-fast"></i>
                    <h4 data-en="Superfast Delivery">সুপারফাস্ট ডেলিভারি</h4>
                    <p data-en="Within 24 hours in Dhaka and 48-72 hours outside Dhaka — sealed jars reach you safely.">ঢাকায় মাত্র ২৪ ঘণ্টা এবং ঢাকার বাইরে ৪৮-৭২ ঘণ্টার মধ্যে সিল করা জার নিরাপদে পৌঁছে যায়।</p>
                </div>
                <div class="ds-bento-cell">
                    <i class="fa-solid fa-money-bill"></i>
                    <h4 data-en="Cash on Delivery">ক্যাশ অন ডেলিভারি</h4>
                    <p data-en="No advance payment — check the parcel in hand and then pay.">অগ্রিম কোনো টাকা দিতে হবে না — পার্সেল হাতে পেয়ে চেক করে তারপর মূল্য পরিশোধ করুন।</p>
                </div>
                <div class="ds-bento-cell">
                    <i class="fa-solid fa-jar"></i>
                    <h4 data-en="Broken Jar Replacement">ভাঙা জারে রিপ্লেসমেন্ট</h4>
                    <p data-en="If a jar arrives broken or leaked, report within 24 hours with a photo — free replacement, no question asked.">জার ভাঙা বা লিক অবস্থায় পৌঁছালে ২৪ ঘণ্টার মধ্যে ছবি দিয়ে জানালেই সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট।</p>
                </div>
                <div class="ds-bento-cell">
                    <i class="fa-solid fa-headset"></i>
                    <h4 data-en="24/7 Support Helpline">২৪/৭ সাপোর্ট হেল্পলাইন</h4>
                    <p data-en="For any question about taste, storage or bulk orders — call or WhatsApp us anytime.">স্বাদ, সংরক্ষণ বা পাইকারি অর্ডার নিয়ে যেকোনো প্রশ্নে যেকোনো সময় কল বা WhatsApp করুন।</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FAQ ================= -->
    <section class="ds-section" id="ds-faq">
        <div class="ds-container ds-faq-wrap">
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="FAQ">প্রশ্ন-উত্তর</span>
                <h2 class="ds-h2"><span data-en="Common ">সাধারণ </span><span class="ds-grad" data-en="Questions">জিজ্ঞাসা</span></h2>
                <p class="ds-sub" data-en="Find answers to the questions you have in mind">আপনার মনে থাকা সাধারণ প্রশ্নের উত্তর জেনে নিন</p>
            </div>
            <div class="ds-faqs">
                <details class="ds-faq" open>
                    <summary><span data-en="Can I pay cash after receiving the product?">প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া যাবে?</span> <i class="fa-solid fa-chevron-down"></i></summary>
                    <div data-en="Yes, we have 100% Cash on Delivery — check the sealed jar in front of the delivery man and then pay. No advance money is needed.">
                        হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি সুবিধা রয়েছে — ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে টাকা পরিশোধ করতে পারবেন। কোনো অগ্রিম টাকা লাগবে না।</div>
                </details>
                <details class="ds-faq">
                    <summary><span data-en="How long do the pickles last? Any preservatives?">আচার কতদিন ভালো থাকে? প্রিজারভেটিভ আছে কি?</span> <i class="fa-solid fa-chevron-down"></i></summary>
                    <div data-en="Our pickles stay good for 12 months at room temperature — made the traditional way with premium mustard oil, enough salt and pure spices. Completely free of preservatives, colours and chemicals.">
                        সঠিক পদ্ধতিতে তৈরি ও খাঁটি সরিষার তেল, পর্যাপ্ত লবণ ও বিশুদ্ধ মসলার কারণে আমাদের আচার ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত ভালো থাকে। প্রিজারভেটিভ, কালার ও কেমিক্যাল সম্পূর্ণ মুক্ত।</div>
                </details>
                <details class="ds-faq">
                    <summary><span data-en="What is the delivery charge?">ডেলিভারি চার্জ কত টাকা?</span> <i class="fa-solid fa-chevron-down"></i></summary>
                    <div data-en="Delivery charge is ৳80 inside Dhaka and ৳150 outside Dhaka. During special offers many products also get free delivery.">
                        ঢাকার ভেতরের জন্য ডেলিভারি চার্জ ৮০ টাকা এবং ঢাকার বাইরের জন্য ১৫০ টাকা। বিশেষ অফার চলাকালীন অনেক প্রোডাক্টে ফ্রি ডেলিভারিও থাকে।</div>
                </details>
                <details class="ds-faq">
                    <summary><span data-en="What if the jar arrives broken or leaked?">জার ভেঙে বা লিক হয়ে এলে কী করব?</span> <i class="fa-solid fa-chevron-down"></i></summary>
                    <div data-en="Just inform our helpline with a photo within 24 hours of receiving the parcel — we will replace it completely free of charge.">
                        পার্সেল পাওয়ার ২৪ ঘণ্টার মধ্যে ছবি দিয়ে আমাদের হেল্পলাইনে জানালেই আমরা সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট করে দেব।</div>
                </details>
                <details class="ds-faq">
                    <summary><span data-en="How do I track my order?">অর্ডার কীভাবে ট্র্যাক করব?</span> <i class="fa-solid fa-chevron-down"></i></summary>
                    <div data-en="You can see live status from the &quot;Order Track&quot; button on the website using your mobile number or invoice ID.">
                        আপনার মোবাইল নম্বর অথবা ইনভয়েস আইডি দিয়ে ওয়েবসাইটের "অর্ডার ট্র্যাক" বাটন থেকে লাইভ স্ট্যাটাস দেখতে পারবেন।</div>
                </details>
            </div>
        </div>
    </section>

    <!-- ================= CHECKOUT ORDER FORM SECTION ================= -->
    <section id="order-form" class="py-12 px-4">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl border border-emerald-200 overflow-hidden">
            <div class="text-center p-6 border-b border-green-100 bg-white">
                <div class="lp-order-head-ic mx-auto">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900"
                    data-en-html='Fill in the <span class="text-emerald-600">form correctly</span> to order on Cash on Delivery'>
                    ক্যাশ অন ডেলিভারিতে অর্ডার করতে <span class="text-emerald-600">ফর্মটি সঠিকভাবে</span> পূরণ করুন
                </h2>
                <p class="text-xs text-gray-500 mt-1" data-en="After you submit your details, our call centre will phone you to confirm the order.">আপনার তথ্য দেওয়ার পর আমাদের কল সেন্টার থেকে ফোন করে অর্ডার কনফার্ম করা হবে।</p>
            </div>

            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                    <!-- Left: Cart Summary & Coupon -->
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="p-4 border-b bg-gray-50 flex items-center justify-between">
                            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                                <i class="fa-solid fa-basket-shopping text-emerald-600 mr-1"></i> <span data-en="Your Cart">আপনার কার্ট</span>
                            </h3>
                            <span class="text-xs text-gray-500 font-semibold" id="cart-item-count-label">0
                                item(s)</span>
                        </div>

                        <div class="p-4 border-b bg-white">
                            <div class="flex gap-2">
                                <input id="coupon_input" name="coupon_code" type="text"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 outline-none"
                                    placeholder="কুপন কোড লিখুন (যেমন: ACHAR10)" data-en-ph="Enter coupon code (e.g. ACHAR10)">
                                <button type="button" onclick="submitCoupon()"
                                    class="bg-emerald-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-emerald-700 transition whitespace-nowrap">
                                    <span data-en="Apply">প্রয়োগ করুন</span>
                                </button>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-2" data-en="If you have a coupon, apply it — discount is calculated automatically.">কুপন থাকলে প্রয়োগ করুন, ডিসকাউন্ট অটো ক্যালকুলেট হবে।</p>
                            <p class="lp-coupon-msg" id="couponMsg" hidden></p>
                        </div>

                        <div class="cartlist p-4">
                            <div class="lp-cart-wrapper" data-cart-items="[]" data-subtotal="0" data-grand="80"
                                data-has-all-free-delivery="0" data-has-digital-only="0" data-cart-empty="1">

                                <div class="lp-cart-header">
                                    <div class="text-center" data-en="Mark">মার্ক</div>
                                    <div data-en="Product">প্রোডাক্ট</div>
                                    <div class="text-center" data-en="Qty">পরিমাণ</div>
                                    <div class="text-end" data-en="Price">মূল্য</div>
                                </div>

                                <div class="lp-cart-totals">
                                    <div class="lp-cart-total-row">
                                        <span data-en="Subtotal">মোট</span>
                                        <span id="net_total">৳ <strong>0</strong></span>
                                    </div>
                                    <div class="lp-cart-total-row">
                                        <span data-en="Delivery Charge">ডেলিভারি চার্জ</span>
                                        <span id="cart_shipping_cost">৳ <strong>80</strong></span>
                                    </div>
                                    <div class="lp-cart-total-row final">
                                        <span data-en="Grand Total">সর্বমোট</span>
                                        <span id="grand_total">৳ <strong>80</strong></span>
                                    </div>
                                </div>
                            </div>

                            <div class="lp-cart-empty" id="lpCartEmpty">
                                <i class="fa-solid fa-basket-shopping"></i>
                                <span data-en="Cart is empty now — click the &quot;Order Now&quot; button on a product card above and your favourite jars will be added here.">
                                    কার্ট এখন খালি — উপরের প্রোডাক্ট কার্ডের <strong>অর্ডার করুন</strong> বাটনে চাপ দিলে পছন্দের পণ্য এখানে যোগ হবে।</span>
                            </div>
                        </div>

                        <div id="landing-advance-box" class="p-4 border-t bg-yellow-50 hidden">
                            <div class="text-sm font-bold text-yellow-800" data-en="Advance Payment Required">অগ্রিম পেমেন্ট প্রয়োজন</div>
                            <div class="mt-2 text-sm flex justify-between">
                                <span class="text-green-700 font-semibold" data-en="Payable Now">Payable Now</span>
                                <span id="landing-advance-amount" class="font-bold text-green-700">৳ 0.00</span>
                            </div>
                            <div class="mt-1 text-sm flex justify-between">
                                <span class="text-red-700 font-semibold" data-en="Due">Due</span>
                                <span id="landing-due-amount" class="font-bold text-red-700">৳ 0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Checkout Form -->
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="p-4 border-b bg-gray-50">
                            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                                <i class="fa-solid fa-address-card text-emerald-600 mr-1"></i> <span data-en="Enter Delivery Info">ডেলিভারি তথ্য দিন</span>
                            </h3>
                        </div>

                        <form id="landing-checkout-form" action="{{ route('order.store') }}" method="POST" class="p-6">
                            @csrf
                            <input type="hidden" name="items" id="cart_items_input">
                            <input type="hidden" name="landing_checkout" value="1">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="name">
                                        <span data-en="Your Full Name">আপনার সম্পূর্ণ নাম</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="name" type="text" name="name" required="" value=""
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"
                                        placeholder="যেমন: মোঃ কামরুল হাসান" data-en-ph="e.g. Md. Kamrul Hasan">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="phone">
                                        <span data-en="Mobile Number">মোবাইল নাম্বার</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="phone" type="number" name="phone" required="" value=""
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"
                                        placeholder="০১xxxxxxxxx (১১ সংখ্যা)" data-en-ph="01xxxxxxxxx (11 digits)">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="address">
                                        <span data-en="Full Delivery Address">সম্পূর্ণ ডেলিভারি ঠিকানা</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="address" type="text" name="address" required="" value=""
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"
                                        placeholder="বাসা নং, রোড, এলাকা, থানা ও জেলা" data-en-ph="House no., road, area, thana &amp; district">
                                </div>

                                <div id="landing-area-wrapper">
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="area"><span
                                            data-en="Delivery Area">ডেলিভারি এরিয়া</span></label>
                                    <input type="hidden" name="area" id="landing_area_input" value="free_shipping">

                                    <div id="landing-area-empty" class="">
                                        <input type="text"
                                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-gray-100 cursor-not-allowed"
                                            value="প্রোডাক্ট সিলেক্ট করুন" data-en-val="Select a product" readonly="">
                                    </div>

                                    <div id="landing-area-digital" class="hidden">
                                        <input type="text"
                                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-gray-100"
                                            value="Digital Product (No Shipping Charge)" readonly="">
                                    </div>

                                    <div id="landing-area-physical-wrap" class="hidden">
                                        <div id="landing-area-select-wrap" class="">
                                            <select id="area"
                                                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none bg-white"
                                                required="">
                                                <option value="inside" data-charge="80" selected>ঢাকার ভিতরে ৮০ টাকা (৳80)</option>
                                                <option value="outside" data-charge="150">ঢাকার বাহিরে ১৫০ টাকা (৳150)</option>
                                                <!-- options swapped by script.js per language -->
                                            </select>
                                        </div>
                                        <div id="landing-free-delivery-wrap" class="hidden">
                                            <input type="text"
                                                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-green-50 text-green-800 font-semibold"
                                                value="ফ্রি ডেলিভারি - কোন চার্জ নেই" data-en-val="Free Delivery — No Charge" readonly="">
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-xl p-3 bg-white">
                                    <div class="text-sm font-bold text-gray-800 mb-2" data-en="Payment Method">পেমেন্ট মেথড</div>

                                    <div id="landing-advance-note"
                                        class="mb-3 p-3 rounded-lg border border-yellow-200 bg-yellow-50 text-sm text-yellow-900 hidden">
                                        <span data-en="This order requires an advance payment of ">এই অর্ডারে </span><b id="landing-advance-note-amount">৳ 0.00</b><span data-en=". COD is not available."> অগ্রিম পেমেন্ট করতে হবে। COD পাওয়া যাবে না।</span>
                                    </div>

                                    <div id="payment-methods-grid" class="space-y-2">
                                        <div id="cod-option-wrapper">
                                            <label class="pay-opt sel" style="--pbc:var(--ds-primary)">
                                                <span class="pay-ic"><i class="fa-solid fa-truck"></i></span>
                                                <span class="pay-tx">
                                                    <b data-en="Cash On Delivery">ক্যাশ অন ডেলিভারি</b>
                                                    <small data-en="Check the parcel first, then pay">আগে পার্সেল দেখুন, তারপর টাকা দিন</small>
                                                </span>
                                                <input type="radio" name="payment_method" id="payment_cod" value="cod"
                                                    checked="" class="accent-emerald-600">
                                            </label>
                                        </div>
                                        <button type="button" class="pay-toggle" id="onlinePayToggle"
                                            onclick="toggleOnlinePay()">
                                            <span class="pay-toggle-l">
                                                <i class="fa-solid fa-mobile-screen-button"></i>
                                                <span data-en="Online Payment — bKash / Nagad / Rocket / Upay">অনলাইন পেমেন্ট — বিকাশ / নগদ / রকেট / উপায়</span>
                                            </span>
                                            <i class="fa-solid fa-chevron-down pay-toggle-chev"></i>
                                        </button>
                                        <div class="pay-collapse" id="onlinePayWrap">
                                            <div class="pay-collapse-in">
                                                <div class="grid grid-cols-2 gap-2">
                                                    <label class="pay-opt" style="--pbc:#e2136e">
                                                        <span class="pay-ic"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
                                                        <span class="pay-tx"><b>bKash</b><small data-en="Send money">সেন্ড মানি</small></span>
                                                        <input type="radio" name="payment_method" value="bkash">
                                                    </label>
                                                    <label class="pay-opt" style="--pbc:#f6921e">
                                                        <span class="pay-ic"><img src="{{ asset('assets/img/pay/nagad.svg') }}" alt="Nagad"></span>
                                                        <span class="pay-tx"><b>Nagad</b><small data-en="Send money">সেন্ড মানি</small></span>
                                                        <input type="radio" name="payment_method" value="nagad">
                                                    </label>
                                                    <label class="pay-opt" style="--pbc:#8c3494">
                                                        <span class="pay-ic">Rk</span>
                                                        <span class="pay-tx"><b>Rocket</b><small data-en="Send money">সেন্ড মানি</small></span>
                                                        <input type="radio" name="payment_method" value="rocket">
                                                    </label>
                                                    <label class="pay-opt" style="--pbc:#d1202f">
                                                        <span class="pay-ic">Up</span>
                                                        <span class="pay-tx"><b>Upay</b><small data-en="Send money">সেন্ড মানি</small></span>
                                                        <input type="radio" name="payment_method" value="upay">
                                                    </label>
                                                </div>
                                                <div id="payOnlineNote">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                    <span data-en="Our agent will call you after confirming the order with send-money instructions to 01707-373692.">
                                                        অর্ডার কনফার্ম হওয়ার পর আমাদের প্রতিনিধি কল দিয়ে 01707-373692 নম্বরে সেন্ড মানির বিস্তারিত জানিয়ে দেবেন।</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="payment-error" class="hidden mt-2 text-sm font-bold text-red-600">
                                        <span data-en="Please select a payment method.">অনুগ্রহ করে একটি পেমেন্ট মেথড সিলেক্ট করুন।</span>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full bg-emerald-600 text-white font-bold text-lg px-4 py-3.5 rounded-xl shadow-lg hover:bg-emerald-700 transition flex justify-center items-center gap-2">
                                    <i class="fa-solid fa-lock"></i> <span data-en="Confirm Order">অর্ডার কনফার্ম করুন</span>
                                </button>

                                <div class="lp-trust-row">
                                    <span><i class="fa-solid fa-shield-halved"></i> <span data-en="Secure order">নিরাপদ অর্ডার</span></span>
                                    <span><i class="fa-solid fa-money-bill-wave"></i> <span data-en="Pay after checking">দেখে টাকা দিন</span></span>
                                    <span><i class="fa-solid fa-jar"></i> <span data-en="Broken jar? Free replacement">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট</span></span>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ================= CUSTOMER REVIEWS ================= -->
    <section id="ds-reviews" class="py-16 bg-white overflow-hidden w-full">
        <div class="ds-sec-head">
            <span class="ds-eyebrow" data-en="Customer Opinions">গ্রাহকদের মতামত</span>
            <h2 class="ds-h2"><span data-en="Our customers' ">কাস্টমারদের </span><span class="ds-grad" data-en="Satisfaction Reviews">সন্তুষ্টির রিভিউ</span></h2>
            <p class="ds-sub" data-en="Experiences of our valued customers from all over Bangladesh">সারা বাংলাদেশ থেকে আমাদের মূল্যবান গ্রাহকদের অভিজ্ঞতা</p>
        </div>

        <div class="rating-summary">
            <div class="rs-score">
                <div class="rs-big">৪.৯<span data-en="/5">/৫</span></div>
                <div class="rs-stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                </div>
                <div class="rs-total" data-en="Based on 532 verified reviews">৫৩২টি ভেরিফাইড রিভিউ</div>
            </div>
            <div class="rs-bars">
                <div class="rs-bar">
                    <span class="rs-l">৫ <i class="fa-solid fa-star"></i></span>
                    <span class="rs-track"><span class="rs-fill" data-w="89"></span></span>
                    <span class="rs-n">৪৭২</span>
                </div>
                <div class="rs-bar">
                    <span class="rs-l">৪ <i class="fa-solid fa-star"></i></span>
                    <span class="rs-track"><span class="rs-fill" data-w="8"></span></span>
                    <span class="rs-n">৪১</span>
                </div>
                <div class="rs-bar">
                    <span class="rs-l">৩ <i class="fa-solid fa-star"></i></span>
                    <span class="rs-track"><span class="rs-fill" data-w="2"></span></span>
                    <span class="rs-n">১২</span>
                </div>
                <div class="rs-bar">
                    <span class="rs-l">২ <i class="fa-solid fa-star"></i></span>
                    <span class="rs-track"><span class="rs-fill" data-w="0.8"></span></span>
                    <span class="rs-n">৪</span>
                </div>
                <div class="rs-bar">
                    <span class="rs-l">১ <i class="fa-solid fa-star"></i></span>
                    <span class="rs-track"><span class="rs-fill" data-w="0.6"></span></span>
                    <span class="rs-n">৩</span>
                </div>
            </div>
        </div>

        <div class="reviews-swiper swiper w-full !overflow-hidden">
            <div class="swiper-wrapper">

                <div class="swiper-slide px-2 md:px-3">
                    <div
                        class="border border-gray-200 rounded-2xl p-5 bg-white shadow-sm flex flex-col h-full min-h-[190px]">
                        <div class="flex items-center gap-3 mb-2">
                            <img src="{{ asset('assets/img/rev1.jpg') }}" alt="নুসরাত জাহান"
                                class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-sm text-[#d97706]">নুসরাত জাহান <i
                                        class="fa-solid fa-circle-check text-emerald-500 text-xs"></i></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Dhaka">ভেরিফাইড পারচেজ • ঢাকা</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;The mango kuchi achar tastes exactly like my grandmother used to make! Not too oily, perfectly spiced. Delivery arrived within a day in Dhaka!&quot;">
                            "আমের কুচি আচারটা একদম ঠাকুমার বানানো আচারের মতোই লেগেছে! তেল বেশি না, ঝাল-নোনতা পারফেক্ট ব্যালেন্স। ঢাকায় একদিনের মধ্যেই ডেলিভারি পেয়েছি!"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><i class="fa-regular fa-thumbs-up"></i> <span data-en="Like (24)">Like (২৪)</span></span>
                            <span data-en="Reply">Reply</span>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide px-2 md:px-3">
                    <div
                        class="border border-gray-200 rounded-2xl p-5 bg-white shadow-sm flex flex-col h-full min-h-[190px]">
                        <div class="flex items-center gap-3 mb-2">
                            <img src="{{ asset('assets/img/rev2.jpg') }}" alt="ফারহানা ইয়াসমিন"
                                class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-sm text-[#d97706]">ফারহানা ইয়াসমিন <i
                                        class="fa-solid fa-circle-check text-emerald-500 text-xs"></i></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Chattogram">ভেরিফাইড পারচেজ • চট্টগ্রাম</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;The mixed pack packaging was amazing — three sealed jars, not a drop leaked. The olive pickle is the best I have had in years!&quot;">
                            "মিক্সড প্যাকের প্যাকেজিং দেখে মুগ্ধ! তিনটা আলাদা সিল করা জার, এক ফোঁটাও লিক হয়নি। জলপাই আচারটা বছরের পর বছর ধরে খাওয়া সেরা আচার!"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><i class="fa-regular fa-thumbs-up"></i> <span data-en="Like (18)">Like (১৮)</span></span>
                            <span data-en="Reply">Reply</span>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide px-2 md:px-3">
                    <div
                        class="border border-gray-200 rounded-2xl p-5 bg-white shadow-sm flex flex-col h-full min-h-[190px]">
                        <div class="flex items-center gap-3 mb-2">
                            <img src="{{ asset('assets/img/rev3.jpg') }}" alt="তানজিনা আক্তার"
                                class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-sm text-[#d97706]">তানজিনা আক্তার <i
                                        class="fa-solid fa-circle-check text-emerald-500 text-xs"></i></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Rajshahi">ভেরিফাইড পারচেজ • রাজশাহী</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;Finally found pure raw Sundarban honey! It crystallised naturally in winter — proof that it is real. The whole family loves it.&quot;">
                            "অবশেষে খাঁটি কাঁচা মধু পেলাম! শীতে প্রাকৃতিকভাবে সেট হয়ে গেছে — খাঁটি হওয়ার সবচেয়ে বড় প্রমাণ। পুরো পরিবারের সবাই খুব পছন্দ করেছে।"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><i class="fa-regular fa-thumbs-up"></i> <span data-en="Like (31)">Like (৩১)</span></span>
                            <span data-en="Reply">Reply</span>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide px-2 md:px-3">
                    <div
                        class="border border-gray-200 rounded-2xl p-5 bg-white shadow-sm flex flex-col h-full min-h-[190px]">
                        <div class="flex items-center gap-3 mb-2">
                            <img src="{{ asset('assets/img/rev4.jpg') }}" alt="মেহেজাবীন চৌধুরী"
                                class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-sm text-[#d97706]">মেহেজাবীন চৌধুরী <i
                                        class="fa-solid fa-circle-check text-emerald-500 text-xs"></i></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Sylhet">ভেরিফাইড পারচেজ • সিলেট</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;The ghee aroma fills the whole kitchen! One spoon on hot rice and you are in heaven. Ordered 3 more jars for my sister.&quot;">
                            "ঘি খুলতেই পুরো রান্নাঘর ঘ্রাণে ভরে গেল! গরম ভাতে এক চামচ ঘি মানেই আসল স্বাদ। আপনার বোনের জন্য আরও ৩টা অর্ডার দিয়েছি।"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><i class="fa-regular fa-thumbs-up"></i> <span data-en="Like (15)">Like (১৫)</span></span>
                            <span data-en="Reply">Reply</span>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide px-2 md:px-3">
                    <div
                        class="border border-gray-200 rounded-2xl p-5 bg-white shadow-sm flex flex-col h-full min-h-[190px]">
                        <div class="flex items-center gap-3 mb-2">
                            <img src="{{ asset('assets/img/rev5.jpg') }}" alt="সাবরিনা ইসলাম"
                                class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-sm text-[#d97706]">সাবরিনা ইসলাম <i
                                        class="fa-solid fa-circle-check text-emerald-500 text-xs"></i></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Khulna">ভেরিফাইড পারচেজ • খুলনা</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;First time ordering pickles online and the experience was great! Checked the parcel in front of the delivery man and then paid. Recommended shop.&quot;">
                            "প্রথমবার অনলাইনে আচার অর্ডার করলাম এবং অভিজ্ঞতা দারুণ! ডেলিভারি ম্যানের সামনে চেক করে টাকা দিলাম। রিকমেন্ডেড শপ।"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><i class="fa-regular fa-thumbs-up"></i> <span data-en="Like (29)">Like (২৯)</span></span>
                            <span data-en="Reply">Reply</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-pagination mt-8"></div>
        </div>
    </section>

    <!-- ================= BOTTOM CTA ================= -->
    <section class="ds-cta">
        <div>
            <h2><span data-en="Order today — on ">আজই অর্ডার করুন — </span><span style="color:var(--ds-lime-neon)" data-en="Cash on Delivery">ক্যাশ অন ডেলিভারিতে</span></h2>
            <p data-en="Book your favourite jars now — check them in hand and then pay.">আপনার পছন্দের জার এখনই বুক করুন, পণ্য হাতে পেয়ে দেখে মূল্য পরিশোধ করুন।</p>
            <button onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})"
                class="ds-btn ds-btn-lg">
                <i class="fa-solid fa-cart-shopping"></i> <span data-en="I Want to Order">অর্ডার করতে চাই</span>
            </button>
            <div class="ds-cta-links">
                <a href="tel:01707373692"><i class="fa-solid fa-phone"></i> 01707373692</a>
                <a href="https://wa.me/8801707373692" target="_blank" rel="noopener"><i
                        class="fa-brands fa-whatsapp text-lg"></i> WhatsApp</a>
                <a href="https://facebook.com/" target="_blank" rel="noopener"><i
                        class="fa-brands fa-facebook text-lg"></i> <span data-en="Facebook Page">Facebook Page</span></a>
                <button onclick="openTrackModal()"><i class="fa-solid fa-magnifying-glass-location text-lg"></i> <span
                        data-en="Order Track">অর্ডার ট্র্যাক</span></button>
                <button onclick="openComplaintModal()"><i class="fa-solid fa-triangle-exclamation text-lg"></i>
                    <span data-en="Complaint">কমপ্লেইন</span></button>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
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

    <!-- ================= MODAL: ORDER TRACKING ================= -->
    <div id="trackModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 px-4"
        onclick="if(event.target===this)closeTrackModal()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4" style="background:var(--ds-primary-dark);">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass-location"></i> <span data-en="Track Your Order">অর্ডার ট্র্যাক করুন</span>
                </h3>
                <button onclick="closeTrackModal()"
                    class="text-white text-2xl leading-none hover:text-emerald-400 transition">×</button>
            </div>
            <div class="p-6">
                <p class="text-gray-500 text-sm mb-5" data-en="Check the current status of your order by mobile number OR invoice ID.">
                    মোবাইল নাম্বার <strong>অথবা</strong> ইনভয়েস আইডি দিয়ে আপনার অর্ডারের বর্তমান অবস্থা জানুন।</p>
                <div id="trackFormError"
                    class="hidden bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-4"></div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" data-en="Mobile Number">মোবাইল নাম্বার</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </span>
                            <input id="trackPhone" type="number" placeholder="017xxxxxxxx"
                                class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-green-400">
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-gray-400 text-xs font-semibold">
                        <div class="flex-1 h-px bg-gray-200"></div><span data-en="OR">অথবা</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" data-en="Invoice ID">ইনভয়েস আইডি</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fa-solid fa-receipt"></i>
                            </span>
                            <input id="trackInvoice" type="text" placeholder="যেমন: 54321" data-en-ph="e.g. 54321"
                                class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-green-400">
                        </div>
                    </div>
                </div>
                <button onclick="doTrack()" id="trackBtn"
                    class="mt-6 w-full py-3 rounded-lg font-bold text-base text-gray-900 transition hover:opacity-90 flex items-center justify-center gap-2"
                    style="background:var(--ds-lime-neon);">
                    <i class="fa-solid fa-magnifying-glass"></i> <span data-en="Track Now">ট্র্যাক করুন</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Tracking Result Modal -->
    <div id="trackResultModal" class="fixed inset-0 z-[61] hidden items-center justify-center bg-black/70 px-4 py-6"
        onclick="if(event.target===this)closeTrackResult()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
            onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 sticky top-0 z-10" style="background:var(--ds-primary-dark);">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                    <i class="fa-solid fa-box-open"></i> <span data-en="Order Details">অর্ডারের বিস্তারিত</span>
                </h3>
                <button onclick="closeTrackResult()"
                    class="text-white text-2xl leading-none hover:text-emerald-400 transition">×</button>
            </div>
            <div id="trackResultBody" class="p-4 space-y-4"></div>
        </div>
    </div>

    <!-- ================= MODAL: COMPLAINT ================= -->
    <div id="complaintModal" class="fixed inset-0 z-[62] hidden items-center justify-center bg-black/70 px-4 py-6"
        onclick="if(event.target===this)closeComplaintModal()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[92vh] overflow-y-auto"
            onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 sticky top-0 z-10 bg-red-600">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i> <span data-en="Submit a Complaint">কমপ্লেইন জমা দিন</span>
                </h3>
                <button onclick="closeComplaintModal()"
                    class="text-white text-2xl leading-none hover:text-emerald-300 transition">×</button>
            </div>
            <div class="p-6">
                <div id="complaintSuccess"
                    class="hidden mb-4 bg-green-50 border border-emerald-200 rounded-xl p-4 text-center">
                    <div class="text-emerald-600 text-3xl mb-2"><i class="fa-solid fa-circle-check"></i></div>
                    <p class="text-green-700 font-semibold" data-en="Your complaint has been submitted successfully!">আপনার কমপ্লেইন সফলভাবে জমা হয়েছে!</p>
                    <p class="text-sm text-gray-500 mt-1" data-en="Our support team will contact you within 24-48 hours.">২৪-৪৮ ঘণ্টার মধ্যে আমাদের সাপোর্ট টিম আপনার সাথে যোগাযোগ করবে।
                    </p>
                    <button onclick="closeComplaintModal()"
                        class="mt-3 bg-red-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition"><span
                            data-en="Okay">ঠিক আছে</span></button>
                </div>
                <div id="complaintError"
                    class="hidden mb-4 bg-red-50 border border-red-200 rounded-xl p-3 text-sm text-red-700"></div>

                <form id="complaintForm" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                        data-en="Your Name">আপনার নাম</span> <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" id="c_name"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                    placeholder="নাম লিখুন" data-en-ph="Enter your name" required="">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                        data-en="Mobile Number">মোবাইল নম্বর</span> <span
                                        class="text-red-500">*</span></label>
                                <input type="tel" name="phone" id="c_phone"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                    placeholder="০১xxx-xxxxxx" data-en-ph="01xxx-xxxxxx" required="" maxlength="11"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                    data-en="Order ID">অর্ডার আইডি</span> <span
                                    class="text-gray-400 font-normal" data-en="(optional)">(ঐচ্ছিক)</span></label>
                            <input type="text" name="order_id" id="c_order_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                placeholder="যেমন: 12345" data-en-ph="e.g. 12345"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                    data-en="Complaint Details">কমপ্লেইনের বিবরণ</span> <span
                                    class="text-red-500">*</span></label>
                            <textarea name="description" id="c_description" rows="4"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 resize-none"
                                placeholder="আপনার সমস্যাটি বিস্তারিত লিখুন..." data-en-ph="Describe your problem in detail..." required=""></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                    data-en="Proof Photo">প্রমাণের ছবি</span> <span
                                    class="text-gray-400 font-normal" data-en="(optional)">(ঐচ্ছিক)</span></label>
                            <input type="file" name="image" id="c_image" accept="image/jpg,image/jpeg,image/png"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none">
                            <p class="text-xs text-gray-400 mt-1">jpg/jpeg/png, <span data-en="max 2MB">সর্বোচ্চ 2MB</span></p>
                        </div>
                        <button type="button" onclick="submitComplaint()" id="complaintSubmitBtn"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span id="complaintBtnText" data-en="Send Complaint">কমপ্লেইন পাঠান</span>
                        </button>
                    </div>
                </form>

                <div class="flex gap-6 mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                    <span class="flex items-center gap-1"><i class="fa-solid fa-shield-halved text-red-400"></i> <span
                            data-en="Secure data">নিরাপদ ডাটা</span></span>
                    <span class="flex items-center gap-1"><i class="fa-solid fa-clock text-red-400"></i> <span
                            data-en="Solution within 24-48 hours">২৪-৪৮ ঘণ্টার মধ্যে সমাধান</span></span>
                </div>
            </div>
        </div>
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

    <!-- ================= FLOATING CHAT WIDGET ================= -->
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

    <script>window.quickViewProducts = @json($qv);</script>
    <script src="{{ asset('assets/brand.js?v=5') }}"></script>
    <script src="{{ asset('assets/script.js?v=21') }}" defer></script>
    <script>
        // init brand (theme + logo + language) as soon as DOM is ready
        document.addEventListener('DOMContentLoaded', function () { AB.init(); });
    </script>
</body>

</html>
