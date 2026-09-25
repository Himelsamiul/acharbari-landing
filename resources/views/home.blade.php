@extends('layouts.landing')

@section('nav', 'home')

@section('title', 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ')

@section('content')
<!-- ================= HERO ================= -->
    <section class="ds-hero">
        <div class="ds-container ds-hero-grid">
            <div class="ds-hero-copy">
                <span class="ds-chip-hero">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg> <span data-en="Finest village-made taste — Cash on Delivery">গ্রামবাংলার সেরা স্বাদ — ক্যাশ অন ডেলিভারিতে</span>
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
                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="Order Now">এখনই অর্ডার করুন</span>
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
                        <strong>৪.৯ <svg class="ds-star" viewBox="0 0 24 24" width="16" height="16" fill="currentColor" stroke="currentColor" stroke-width="1" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></strong>
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
                        <img class="himg active" src="{{ asset(ab_img('assets/img/hero_achar.jpg')) }}"
                            alt="আচারবাড়ি — মসলার বাটি" fetchpriority="high">
                        <img class="himg" src="{{ asset(ab_img('assets/img/prod_mix.jpg')) }}" alt="আচারবাড়ি — আচারের জার সমূহ" loading="lazy">
                        <img class="himg" src="{{ asset(ab_img('assets/img/prod_honey.jpg')) }}" alt="আচারবাড়ি — সুন্দরবনের মধু" loading="lazy">
                        <img class="himg" src="{{ asset(ab_img('assets/img/spice_box.jpg')) }}" alt="আচারবাড়ি — মসলার ডাব্বা" loading="lazy">
                        <span class="ds-tag-flash">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg> <span data-en="Fresh Batch Live">নতুন ব্যাচ এসেছে</span>
                        </span>
                        <div class="hero-img-dots" id="heroImgDots">
                            <button class="active" aria-label="Slide 1" onclick="goHeroImg(0)"></button>
                            <button aria-label="Slide 2" onclick="goHeroImg(1)"></button>
                            <button aria-label="Slide 3" onclick="goHeroImg(2)"></button>
                            <button aria-label="Slide 4" onclick="goHeroImg(3)"></button>
                        </div>
                        <button type="button" class="hero-arrow hero-arrow-prev" aria-label="Previous slide">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <button type="button" class="hero-arrow hero-arrow-next" aria-label="Next slide">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    </div>
                    <!-- Floating Trust Badges -->
                    <div class="ds-float-badge ds-float-badge-top">
                        <span class="ds-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></span>
                        <div>
                            <strong data-en="In 24-72 Hours">২৪-৭২ ঘণ্টায়</strong>
                            <span data-en="Home Delivery">হোম ডেলিভারি</span>
                        </div>
                    </div>
                    <div class="ds-float-badge ds-float-badge-bottom">
                        <span class="ds-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg></span>
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
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> <span data-en="Home delivery across Bangladesh">সারা বাংলাদেশে হোম ডেলিভারি</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg> <span data-en="Pay after checking the parcel (Cash on Delivery)">পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="Broken jar? Free replacement guarantee">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg> <span data-en="100% natural — no preservatives or chemicals">১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg> <span data-en="Handcrafted in small batches with love">ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3v-5a9 9 0 0 1 18 0v5h-3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/></svg> <span data-en="24/7 dedicated customer support">২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট</span></span>
            <!-- Duplicate for infinite seamless scroll -->
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> <span data-en="Home delivery across Bangladesh">সারা বাংলাদেশে হোম ডেলিভারি</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg> <span data-en="Pay after checking the parcel (Cash on Delivery)">পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="Broken jar? Free replacement guarantee">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg> <span data-en="100% natural — no preservatives or chemicals">১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg> <span data-en="Handcrafted in small batches with love">ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি</span></span>
            <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3v-5a9 9 0 0 1 18 0v5h-3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/></svg> <span data-en="24/7 dedicated customer support">২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট</span></span>
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
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="14" rx="1.5"/><rect width="7" height="7" x="3" y="14" rx="1.5"/></svg> <span data-en="All Items">সব প্রোডাক্ট</span> <span class="ds-filter-count">৬</span>
                </button>
                <button class="ds-filter-btn" data-filter="pickle">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="Pickles">আচার</span> <span class="ds-filter-count">৩</span>
                </button>
                <button class="ds-filter-btn" data-filter="pure">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg> <span data-en="Honey &amp; Ghee">মধু ও ঘি</span> <span class="ds-filter-count">২</span>
                </button>
                <button class="ds-filter-btn" data-filter="chaatni">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11h16"/><path d="M5.5 11a6.5 6.5 0 0 0 13 0"/><path d="M9.5 7.5V6"/><path d="M12 7.5V5"/><path d="M14.5 7.5V6"/></svg> <span data-en="Chutney">চাটনি</span> <span class="ds-filter-count">১</span>
                </button>
            </div>

            <!-- Products Grid -->
            <div class="ds-product-grid" id="productGridContainer">

                @foreach ($products as $p)
                <article class="ds-product-card product-card" data-category="{{ $p->category_key }}" data-product-id="{{ $p->id }}" data-advance="0">
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
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" x2="5" y1="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                    </div>
                    <h4 data-en="0% Hidden Service Fee">০% হিডেন সার্ভিস ফি</h4>
                    <p data-en="No hidden fees or extra charges ever. What you see at checkout is exactly what you pay — What you see at checkout is exactly what you pay.">কোনো লুকায়িত ফি বা অতিরিক্ত চার্জ নেই। চেকআউটে যা দেখেন, ঠিক তাই পরিশোধ করবেন।</p>
                    <span class="ds-bento-tag" data-en="100% Transparent">১০০% স্বচ্ছ</span>
                </div>
                <div class="ds-seller-card ds-bento-card">
                    <div class="ds-bento-glow"></div>
                    <div class="ds-seller-card-ic">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg>
                    </div>
                    <h4 data-en="48-Hour Guaranteed Payout">৪৮ ঘণ্টায় নিশ্চিত পেআউট</h4>
                    <p data-en="Refund or payout — money reaches your bKash or bank within just 48 hours, guaranteed.">রিফান্ড হোক বা পেআউট — টাকা পৌঁছে যাবে মাত্র ৪৮ ঘণ্টায় আপনার বিকাশ বা ব্যাংকে।</p>
                    <span class="ds-bento-tag" data-en="Instant bKash/Bank">ইনস্ট্যান্ট বিকাশ/ব্যাংক</span>
                </div>
                <div class="ds-seller-card ds-bento-card">
                    <div class="ds-bento-glow"></div>
                    <div class="ds-seller-card-ic">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                    </div>
                    <h4 data-en="Logistics in 64 Districts">৬৪ জেলায় অটো লজিস্টিকস</h4>
                    <p data-en="From your door anywhere in Bangladesh — pickup and delivery handled entirely by AcharBari via trusted courier partners.">আপনার লোকাল বা বাসা থেকে ফিক্সড ও সারা দেশে ডেলিভারি — সব হ্যান্ডেল করে আচারবাড়ি ট্রাস্টেড কুরিয়ার পার্টনারদের মাধ্যমে।</p>
                    <span class="ds-bento-tag">Steadfast + Pathao</span>
                </div>
                <div class="ds-seller-card ds-bento-card">
                    <div class="ds-bento-glow"></div>
                    <div class="ds-seller-card-ic">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
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
                    <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                    <h3 data-en="Pick Your Favourite Jar">পছন্দের জার নির্বাচন</h3>
                    <p data-en="Select your favourite pickle, honey or ghee and fill in the simple form below with your name and address.">আপনার পছন্দের আচার, মধু বা ঘি সিলেক্ট করে নিচের সহজ ফর্মটিতে নাম ও ঠিকানা পূরণ করুন।</p>
                </div>
                <div class="ds-step">
                    <span class="ds-step-n">২</span>
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg>
                    <h3 data-en="Phone Confirmation">ফোন কলে কনফার্মেশন</h3>
                    <p data-en="As soon as we receive your order, our support team calls you to confirm the address and details.">অর্ডার পাওয়ার পরই আমাদের সাপোর্ট টিম কল দিয়ে ঠিকানা ও বিবরণ নিশ্চিত করবে।</p>
                </div>
                <div class="ds-step">
                    <span class="ds-step-n">৩</span>
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
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
                        <span class="ds-ic ds-ic-glass"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg></span>
                        <h3 data-en="100% Pure &amp; Preservative-Free Guarantee">১০০% খাঁটি ও প্রিজারভেটিভ-মুক্ত গ্যারান্টি</h3>
                        <p data-en="Every jar is handmade in small batches with seasonal fruits, premium mustard oil and pure spices. No preservatives, no colour, no chemicals — laboratory-tested and money-back guaranteed.">
                            প্রতিটি জার মৌসুমি ফল, খাঁটি সরিষার তেল ও বিশুদ্ধ মসলা দিয়ে ছোট ব্যাচে হাতে তৈরি। কোনো প্রিজারভেটিভ, কালার বা কেমিক্যাল নেই — ল্যাব-টেস্টেড এবং নকল প্রমাণিত হলে সম্পূর্ণ টাকা রিটার্নের নিশ্চয়তা।
                        </p>
                    </div>
                    <div class="flex items-center gap-3 text-sm font-bold text-emerald-300">
                        <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>
                        <span data-en="Verified Village Kitchens">ভেরিফাইড গ্রামীণ রান্নাঘর</span>
                    </div>
                </div>
                <div class="ds-bento-cell">
                    <span class="ds-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></span>
                    <h4 data-en="Superfast Delivery">সুপারফাস্ট ডেলিভারি</h4>
                    <p data-en="Within 24 hours in Dhaka and 48-72 hours outside Dhaka — sealed jars reach you safely.">ঢাকায় মাত্র ২৪ ঘণ্টা এবং ঢাকার বাইরে ৪৮-৭২ ঘণ্টার মধ্যে সিল করা জার নিরাপদে পৌঁছে যায়।</p>
                </div>
                <div class="ds-bento-cell">
                    <span class="ds-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg></span>
                    <h4 data-en="Cash on Delivery">ক্যাশ অন ডেলিভারি</h4>
                    <p data-en="No advance payment — check the parcel in hand and then pay.">অগ্রিম কোনো টাকা দিতে হবে না — পার্সেল হাতে পেয়ে চেক করে তারপর মূল্য পরিশোধ করুন।</p>
                </div>
                <div class="ds-bento-cell">
                    <span class="ds-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="m9.5 15.2 1.9 1.9 3.1-3.7"/></svg></span>
                    <h4 data-en="Broken Jar Replacement">ভাঙা জারে রিপ্লেসমেন্ট</h4>
                    <p data-en="If a jar arrives broken or leaked, report within 24 hours with a photo — free replacement, no question asked.">জার ভাঙা বা লিক অবস্থায় পৌঁছালে ২৪ ঘণ্টার মধ্যে ছবি দিয়ে জানালেই সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট।</p>
                </div>
                <div class="ds-bento-cell">
                    <span class="ds-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3v-5a9 9 0 0 1 18 0v5h-3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/></svg></span>
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
                    <summary><span data-en="Can I pay cash after receiving the product?">প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া যাবে?</span> <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></summary>
                    <div data-en="Yes, we have 100% Cash on Delivery — check the sealed jar in front of the delivery man and then pay. No advance money is needed.">
                        হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি সুবিধা রয়েছে — ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে টাকা পরিশোধ করতে পারবেন। কোনো অগ্রিম টাকা লাগবে না।</div>
                </details>
                <details class="ds-faq">
                    <summary><span data-en="How long do the pickles last? Any preservatives?">আচার কতদিন ভালো থাকে? প্রিজারভেটিভ আছে কি?</span> <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></summary>
                    <div data-en="Our pickles stay good for 12 months at room temperature — made the traditional way with premium mustard oil, enough salt and pure spices. Completely free of preservatives, colours and chemicals.">
                        সঠিক পদ্ধতিতে তৈরি ও খাঁটি সরিষার তেল, পর্যাপ্ত লবণ ও বিশুদ্ধ মসলার কারণে আমাদের আচার ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত ভালো থাকে। প্রিজারভেটিভ, কালার ও কেমিক্যাল সম্পূর্ণ মুক্ত।</div>
                </details>
                <details class="ds-faq">
                    <summary><span data-en="What is the delivery charge?">ডেলিভারি চার্জ কত টাকা?</span> <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></summary>
                    <div data-en="Delivery charge is ৳80 inside Dhaka and ৳150 outside Dhaka. During special offers many products also get free delivery.">
                        ঢাকার ভেতরের জন্য ডেলিভারি চার্জ ৮০ টাকা এবং ঢাকার বাইরের জন্য ১৫০ টাকা। বিশেষ অফার চলাকালীন অনেক প্রোডাক্টে ফ্রি ডেলিভারিও থাকে।</div>
                </details>
                <details class="ds-faq">
                    <summary><span data-en="What if the jar arrives broken or leaked?">জার ভেঙে বা লিক হয়ে এলে কী করব?</span> <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></summary>
                    <div data-en="Just inform our helpline with a photo within 24 hours of receiving the parcel — we will replace it completely free of charge.">
                        পার্সেল পাওয়ার ২৪ ঘণ্টার মধ্যে ছবি দিয়ে আমাদের হেল্পলাইনে জানালেই আমরা সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট করে দেব।</div>
                </details>
                <details class="ds-faq">
                    <summary><span data-en="How do I track my order?">অর্ডার কীভাবে ট্র্যাক করব?</span> <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></summary>
                    <div data-en="You can see live status from the &quot;Order Track&quot; button on the website using your mobile number or invoice ID.">
                        আপনার মোবাইল নম্বর অথবা ইনভয়েস আইডি দিয়ে ওয়েবসাইটের "অর্ডার ট্র্যাক" বাটন থেকে লাইভ স্ট্যাটাস দেখতে পারবেন।</div>
                </details>
            </div>
        </div>
    </section>

    <!-- ================= CHECKOUT ORDER FORM SECTION ================= -->
    {{-- live product data for cart + quick view (single source of truth: DB) --}}
    <script>
        window.quickViewProducts = @json($qv);
        window.AB_COUPONS = @json(\App\Models\Coupon::activeMap());
    </script>
    {{-- Structured data: product catalog for rich results --}}
    @php
        $ldProducts = $products->map(fn ($p, $i) => [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'item' => [
                '@type' => 'Product',
                'name' => $p->name_en ?: $p->name,
                'image' => url(asset(ab_img($p->image))),
                'description' => $p->description_en ?: $p->description,
                'offers' => [
                    '@type' => 'Offer',
                    'price' => $p->price,
                    'priceCurrency' => 'BDT',
                    'availability' => $p->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                ],
            ],
        ])->all();
    @endphp
    <script type="application/ld+json">
        @json(['@context' => 'https://schema.org', '@type' => 'ItemList', 'itemListElement' => $ldProducts])
    </script>
    <section id="order-form" class="py-12 px-4">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl border border-emerald-200 overflow-hidden">
            <div class="text-center p-6 border-b border-green-100 bg-white">
                <div class="lp-order-head-ic mx-auto">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
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
                                <svg class="text-emerald-600 mr-1" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 11-1 9"/><path d="m19 11-4-7"/><path d="M2 11h20"/><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"/><path d="M4.5 15.5h15"/><path d="m5 11 4-7"/><path d="m9 11 1 9"/></svg> <span data-en="Your Cart">আপনার কার্ট</span>
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
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 11-1 9"/><path d="m19 11-4-7"/><path d="M2 11h20"/><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"/><path d="M4.5 15.5h15"/><path d="m5 11 4-7"/><path d="m9 11 1 9"/></svg>
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
                                <svg class="text-emerald-600 mr-1" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><path d="M16 10h2"/><path d="M16 14h2"/></svg> <span data-en="Enter Delivery Info">ডেলিভারি তথ্য দিন</span>
                            </h3>
                        </div>

                        <form id="landing-checkout-form" action="{{ route('order.store') }}" method="POST" class="p-6">
                            @csrf
                            <input type="hidden" name="items" id="cart_items_input">
                            <input type="hidden" name="coupon_code" id="coupon_hidden_code" value="">
                            <input type="hidden" name="landing_checkout" value="1">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="name">
                                        <span data-en="Your Full Name">আপনার সম্পূর্ণ নাম</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="name" type="text" name="customer_name" required="" value=""
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"
                                        placeholder="যেমন: মোঃ কামরুল হাসান" data-en-ph="e.g. Md. Kamrul Hasan">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="phone">
                                        <span data-en="Mobile Number">মোবাইল নাম্বার</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="phone" type="tel" inputmode="numeric" maxlength="15" name="phone" required="" value=""
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
                                    <input type="hidden" name="area" id="landing_area_input" value="inside">

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
                                                <span class="pay-ic"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></span>
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
                                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/></svg>
                                                <span data-en="Online Payment — bKash / Nagad / Rocket / Upay">অনলাইন পেমেন্ট — বিকাশ / নগদ / রকেট / উপায়</span>
                                            </span>
                                            <svg class="pay-toggle-chev" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
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
                                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                                                    <span data-en="Our agent will call you after confirming the order with send-money instructions to {{ ab_contact('phone') }}.">
                                                        অর্ডার কনফার্ম হওয়ার পর আমাদের প্রতিনিধি কল দিয়ে {{ ab_contact('phone') }} নম্বরে সেন্ড মানির বিস্তারিত জানিয়ে দেবেন।</span>
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
                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> <span data-en="Confirm Order">অর্ডার কনফার্ম করুন</span>
                                </button>

                                <div class="lp-trust-row">
                                    <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> <span data-en="Secure order">নিরাপদ অর্ডার</span></span>
                                    <span><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg> <span data-en="Pay after checking">দেখে টাকা দিন</span></span>
                                    <span><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="Broken jar? Free replacement">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট</span></span>
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
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path fill="currentColor" stroke="none" d="M12 2 8.91 8.26 2 9.27 7 14.14 5.82 21.02 12 17.77Z"/><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div class="rs-total" data-en="Based on 532 verified reviews">৫৩২টি ভেরিফাইড রিভিউ</div>
            </div>
            <div class="rs-bars">
                <div class="rs-bar">
                    <span class="rs-l">৫ <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></span>
                    <span class="rs-track"><span class="rs-fill" data-w="89"></span></span>
                    <span class="rs-n">৪৭২</span>
                </div>
                <div class="rs-bar">
                    <span class="rs-l">৪ <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></span>
                    <span class="rs-track"><span class="rs-fill" data-w="8"></span></span>
                    <span class="rs-n">৪১</span>
                </div>
                <div class="rs-bar">
                    <span class="rs-l">৩ <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></span>
                    <span class="rs-track"><span class="rs-fill" data-w="2"></span></span>
                    <span class="rs-n">১২</span>
                </div>
                <div class="rs-bar">
                    <span class="rs-l">২ <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></span>
                    <span class="rs-track"><span class="rs-fill" data-w="0.8"></span></span>
                    <span class="rs-n">৪</span>
                </div>
                <div class="rs-bar">
                    <span class="rs-l">১ <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></span>
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
                                <h4 class="font-bold text-sm text-[#d97706]">নুসরাত জাহান <svg class="text-emerald-500 text-xs" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Dhaka">ভেরিফাইড পারচেজ • ঢাকা</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;The mango kuchi achar tastes exactly like my grandmother used to make! Not too oily, perfectly spiced. Delivery arrived within a day in Dhaka!&quot;">
                            "আমের কুচি আচারটা একদম ঠাকুমার বানানো আচারের মতোই লেগেছে! তেল বেশি না, ঝাল-নোনতা পারফেক্ট ব্যালেন্স। ঢাকায় একদিনের মধ্যেই ডেলিভারি পেয়েছি!"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"/></svg> <span data-en="Like (24)">Like (২৪)</span></span>
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
                                <h4 class="font-bold text-sm text-[#d97706]">ফারহানা ইয়াসমিন <svg class="text-emerald-500 text-xs" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Chattogram">ভেরিফাইড পারচেজ • চট্টগ্রাম</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;The mixed pack packaging was amazing — three sealed jars, not a drop leaked. The olive pickle is the best I have had in years!&quot;">
                            "মিক্সড প্যাকের প্যাকেজিং দেখে মুগ্ধ! তিনটা আলাদা সিল করা জার, এক ফোঁটাও লিক হয়নি। জলপাই আচারটা বছরের পর বছর ধরে খাওয়া সেরা আচার!"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"/></svg> <span data-en="Like (18)">Like (১৮)</span></span>
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
                                <h4 class="font-bold text-sm text-[#d97706]">তানজিনা আক্তার <svg class="text-emerald-500 text-xs" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Rajshahi">ভেরিফাইড পারচেজ • রাজশাহী</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;Finally found pure raw Sundarban honey! It crystallised naturally in winter — proof that it is real. The whole family loves it.&quot;">
                            "অবশেষে খাঁটি কাঁচা মধু পেলাম! শীতে প্রাকৃতিকভাবে সেট হয়ে গেছে — খাঁটি হওয়ার সবচেয়ে বড় প্রমাণ। পুরো পরিবারের সবাই খুব পছন্দ করেছে।"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"/></svg> <span data-en="Like (31)">Like (৩১)</span></span>
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
                                <h4 class="font-bold text-sm text-[#d97706]">মেহেজাবীন চৌধুরী <svg class="text-emerald-500 text-xs" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Sylhet">ভেরিফাইড পারচেজ • সিলেট</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;The ghee aroma fills the whole kitchen! One spoon on hot rice and you are in heaven. Ordered 3 more jars for my sister.&quot;">
                            "ঘি খুলতেই পুরো রান্নাঘর ঘ্রাণে ভরে গেল! গরম ভাতে এক চামচ ঘি মানেই আসল স্বাদ। আপনার বোনের জন্য আরও ৩টা অর্ডার দিয়েছি।"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"/></svg> <span data-en="Like (15)">Like (১৫)</span></span>
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
                                <h4 class="font-bold text-sm text-[#d97706]">সাবরিনা ইসলাম <svg class="text-emerald-500 text-xs" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></h4>
                                <p class="text-[10px] text-gray-500" data-en="Verified Purchase • Khulna">ভেরিফাইড পারচেজ • খুলনা</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3 flex-1" data-en="&quot;First time ordering pickles online and the experience was great! Checked the parcel in front of the delivery man and then paid. Recommended shop.&quot;">
                            "প্রথমবার অনলাইনে আচার অর্ডার করলাম এবং অভিজ্ঞতা দারুণ! ডেলিভারি ম্যানের সামনে চেক করে টাকা দিলাম। রিকমেন্ডেড শপ।"
                        </p>
                        <div class="flex items-center text-xs text-yellow-500 mb-2">
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="ml-2 text-gray-600 font-semibold" data-en="5/5">৫/৫</span>
                        </div>
                        <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                            <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"/></svg> <span data-en="Like (29)">Like (২৯)</span></span>
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
                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="I Want to Order">অর্ডার করতে চাই</span>
            </button>
            <div class="ds-cta-links">
                <a href="tel:{{ ab_contact('phone') }}"><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg> {{ ab_contact('phone') }}</a>
                <a href="https://wa.me/{{ ab_contact('whatsapp') }}" target="_blank" rel="noopener"><svg class="text-lg" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg> WhatsApp</a>
                <a href="{{ ab_contact('facebook') }}" target="_blank" rel="noopener"><svg class="text-lg" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg> <span data-en="Facebook Page">Facebook Page</span></a>
                <a href="{{ route('track') }}" style="text-decoration:none;color:inherit"><svg class="text-lg" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/><path d="M11 8a3 3 0 0 1 3 3"/></svg> <span
                        data-en="Order Track">অর্ডার ট্র্যাক</span></a>
                <button onclick="openComplaintModal()"><svg class="text-lg" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                    <span data-en="Complaint">কমপ্লেইন</span></button>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    @endsection
