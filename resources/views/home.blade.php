@extends('layouts.landing')

@section('nav', 'home')

@section('title', 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ')

@section('content')
<!-- ================= HERO ================= -->
    <section class="ds-hero">
        <div class="ds-container ds-hero-grid">
            <div class="ds-hero-copy">
                @php $t = ab_t('hero_chip', 'গ্রামবাংলার সেরা স্বাদ — ক্যাশ অন ডেলিভারিতে', 'Finest village-made taste — Cash on Delivery'); @endphp
                <span class="ds-chip-hero">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg> <span data-en="{{ $t['en'] }}">{{ $t['bn'] }}</span>
                </span>
                @php
                    $s1 = ab_t('hero_s1_main', 'ঘরে তৈরি খাঁটি দেশি আচার —', 'Homemade authentic deshi pickles —');
                    $s1g = ab_t('hero_s1_grad', 'স্বাদ ও ভালোবাসার বন্ধন', 'a bond of taste & love');
                    $s2 = ab_t('hero_s2_main', 'ঠাকুমার রেসিপিতে, ঘরে তৈরি —', "Thakumar's recipe, made at home —");
                    $s2g = ab_t('hero_s2_grad', '১০০% প্রিজারভেটিভ মুক্ত', '100% preservative free');
                    $s3 = ab_t('hero_s3_main', 'আজই অর্ডার করুন ক্যাশ অন ডেলিভারিতে —', 'Order today on Cash on Delivery —');
                    $s3g = ab_t('hero_s3_grad', '৬৪ জেলায় হোম ডেলিভারি', 'home delivery in 64 districts');
                    $lead = ab_t('hero_lead', 'মৌসুমি কাঁচা আম, জলপাই, তেঁতুল আর সরিষার তেলে ঘরে তৈরি আচারবাড়ির প্রতিটি জার। কোনো প্রিজারভেটিভ বা কেমিক্যাল নেই — সারা বাংলাদেশে দ্রুত হোম ডেলিভারিতে পৌঁছে যায় মায়ের হাতের সেই চেনা স্বাদ।', '');
                @endphp
                <h1 class="ds-h1" id="heroH1Slider">
                    <span class="hslide active">
                        <span data-en="{{ $s1['en'] }}">{{ $s1['bn'] }}</span><br>
                        <span class="ds-grad" data-en="{{ $s1g['en'] }}">{{ $s1g['bn'] }}</span>
                    </span>
                    <span class="hslide">
                        <span data-en="{{ $s2['en'] }}">{{ $s2['bn'] }}</span><br>
                        <span class="ds-grad" data-en="{{ $s2g['en'] }}">{{ $s2g['bn'] }}</span>
                    </span>
                    <span class="hslide">
                        <span data-en="{{ $s3['en'] }}">{{ $s3['bn'] }}</span><br>
                        <span class="ds-grad" data-en="{{ $s3g['en'] }}">{{ $s3g['bn'] }}</span>
                    </span>
                </h1>
                <p class="ds-lead" @if(trim($lead['en'])) data-en="{{ $lead['en'] }}" @endif>{{ $lead['bn'] }}</p>

                <div class="ds-hero-cta">
                    @php $cta1 = ab_t('hero_cta1', 'এখনই অর্ডার করুন', 'Order Now'); $cta2 = ab_t('hero_cta2', 'সব প্রোডাক্ট দেখুন', 'Browse All Products'); @endphp
                    <button class="ds-btn ds-btn-lg"
                        onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="{{ $cta1['en'] }}">{{ $cta1['bn'] }}</span>
                    </button>
                    <a class="ds-btn ds-btn-ghost ds-btn-lg" href="{{ route('products') }}">
                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="{{ $cta2['en'] }}">{{ $cta2['bn'] }}</span>
                    </a>
                </div>

                @php
                    $st1 = ab_t('hero_stat1', 'সন্তুষ্ট গ্রাহক', 'Happy Customers');
                    $st2 = ab_t('hero_stat2', 'কাস্টমার রেটিং', 'Customer Rating');
                    $st3 = ab_t('hero_stat3', 'জেলায় হোম ডেলিভারি', 'District Home Delivery');
                    $st4 = ab_t('hero_stat4', 'প্রিজারভেটিভ ফ্রি', 'Preservative Free');
                    $st1n = ab_t('hero_stat1_n', '১৫,০০০+', '15,000+');
                    $st2n = ab_t('hero_stat2_n', '৪.৯', '4.9');
                    $st3n = ab_t('hero_stat3_n', '৬৪', '64');
                    $st4n = ab_t('hero_stat4_n', '১০০%', '100%');
                @endphp
                <div class="ds-stats">
                    <div>
                        <strong data-en="{{ $st1n['en'] }}">{{ $st1n['bn'] }}</strong>
                        <span data-en="{{ $st1['en'] }}">{{ $st1['bn'] }}</span>
                    </div>
                    <div>
                        <strong>{{ $st2n['bn'] }} <svg class="ds-star" viewBox="0 0 24 24" width="16" height="16" fill="currentColor" stroke="currentColor" stroke-width="1" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></strong>
                        <span data-en="{{ $st2['en'] }}">{{ $st2['bn'] }}</span>
                    </div>
                    <div>
                        <strong>{{ $st3n['bn'] }}</strong>
                        <span data-en="{{ $st3['en'] }}">{{ $st3['bn'] }}</span>
                    </div>
                    <div>
                        <strong data-en="{{ $st4n['en'] }}">{{ $st4n['bn'] }}</strong>
                        <span data-en="{{ $st4['en'] }}">{{ $st4['bn'] }}</span>
                    </div>
                </div>
            </div>

            <div class="ds-hero-visual">
                <div class="ds-hero-card">
                    <div class="ds-hero-img-wrap" id="heroImgSlider">
                        <img class="himg active" src="{{ ab_img_setting('hero_img1', 'assets/img/hero_achar.jpg') }}"
                            alt="আচারবাড়ি — মসলার বাটি" fetchpriority="high">
                        <img class="himg" src="{{ ab_img_setting('hero_img2', 'assets/img/prod_mix.jpg') }}" alt="আচারবাড়ি — আচারের জার সমূহ" loading="lazy">
                        <img class="himg" src="{{ ab_img_setting('hero_img3', 'assets/img/prod_honey.jpg') }}" alt="আচারবাড়ি — সুন্দরবনের মধু" loading="lazy">
                        <img class="himg" src="{{ ab_img_setting('hero_img4', 'assets/img/spice_box.jpg') }}" alt="আচারবাড়ি — মসলার ডাব্বা" loading="lazy">
                        @php $flash = ab_t('hero_flash', 'নতুন ব্যাচ এসেছে', 'Fresh Batch Live'); @endphp
                        <span class="ds-tag-flash">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg> <span data-en="{{ $flash['en'] }}">{{ $flash['bn'] }}</span>
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
                    @php
                        $fb1t = ab_t('hero_badge1_t', '২৪-৭২ ঘণ্টায়', 'In 24-72 Hours');
                        $fb1s = ab_t('hero_badge1_s', 'হোম ডেলিভারি', 'Home Delivery');
                        $fb2t = ab_t('hero_badge2_t', '১০০% খাঁটি', '100% Authentic');
                        $fb2s = ab_t('hero_badge2_s', 'দেখে বুঝে পেমেন্ট', 'Check before you pay');
                    @endphp
                    <div class="ds-float-badge ds-float-badge-top">
                        <span class="ds-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></span>
                        <div>
                            <strong data-en="{{ $fb1t['en'] }}">{{ $fb1t['bn'] }}</strong>
                            <span data-en="{{ $fb1s['en'] }}">{{ $fb1s['bn'] }}</span>
                        </div>
                    </div>
                    <div class="ds-float-badge ds-float-badge-bottom">
                        <span class="ds-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg></span>
                        <div>
                            <strong data-en="{{ $fb2t['en'] }}">{{ $fb2t['bn'] }}</strong>
                            <span data-en="{{ $fb2s['en'] }}">{{ $fb2s['bn'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= TRUST MARQUEE ================= -->
    @php
        $marqueeItems = ab_json('marquee_items', [
            ['bn' => 'সারা বাংলাদেশে হোম ডেলিভারি', 'en' => 'Home delivery across Bangladesh'],
            ['bn' => 'পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)', 'en' => 'Pay after checking the parcel (Cash on Delivery)'],
            ['bn' => 'ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি', 'en' => 'Broken jar? Free replacement guarantee'],
            ['bn' => '১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত', 'en' => '100% natural — no preservatives or chemicals'],
            ['bn' => 'ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি', 'en' => 'Handcrafted in small batches with love'],
            ['bn' => '২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট', 'en' => '24/7 dedicated customer support'],
        ]);
    @endphp
    <div class="ds-marquee" aria-hidden="true">
        <div class="ds-marquee-track">
            @foreach (array_merge($marqueeItems, $marqueeItems) as $item)
                <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> <span data-en="{{ $item['en'] ?? '' }}">{{ $item['bn'] ?? '' }}</span></span>
            @endforeach
        </div>
    </div>

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

            <!-- Dynamic Category Filter Pills -->
            @php
                $cntAll = $products->count();
                $cntPickle = $products->where('category_key', 'pickle')->count();
                $cntPure = $products->where('category_key', 'pure')->count();
                $cntChaatni = $products->where('category_key', 'chaatni')->count();
                $fAll = ab_t('filter_all', 'সব প্রোডাক্ট', 'All Items');
                $fPickle = ab_t('filter_pickle', 'আচার', 'Pickles');
                $fPure = ab_t('filter_pure', 'মধু ও ঘি', 'Honey & Ghee');
                $fChaatni = ab_t('filter_chaatni', 'চাটনি', 'Chutney');
            @endphp
            <div class="ds-filter-wrap">
                <button class="ds-filter-btn active" data-filter="all">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="14" rx="1.5"/><rect width="7" height="7" x="3" y="14" rx="1.5"/></svg> <span data-en="{{ $fAll['en'] }}">{{ $fAll['bn'] }}</span> <span class="ds-filter-count">{{ bn_num($cntAll) }}</span>
                </button>
                <button class="ds-filter-btn" data-filter="pickle">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="{{ $fPickle['en'] }}">{{ $fPickle['bn'] }}</span> <span class="ds-filter-count">{{ bn_num($cntPickle) }}</span>
                </button>
                <button class="ds-filter-btn" data-filter="pure">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg> <span data-en="{{ $fPure['en'] }}">{{ $fPure['bn'] }}</span> <span class="ds-filter-count">{{ bn_num($cntPure) }}</span>
                </button>
                <button class="ds-filter-btn" data-filter="chaatni">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11h16"/><path d="M5.5 11a6.5 6.5 0 0 0 13 0"/><path d="M9.5 7.5V6"/><path d="M12 7.5V5"/><path d="M14.5 7.5V6"/></svg> <span data-en="{{ $fChaatni['en'] }}">{{ $fChaatni['bn'] }}</span> <span class="ds-filter-count">{{ bn_num($cntChaatni) }}</span>
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
            @php
                $pmh = ab_t('promise_eyebrow', 'আমাদের গ্যারান্টি', 'Our Guarantee');
                $pm2a = ab_t('promise_h2a', 'অর্ডার করুন ', 'Order with ');
                $pm2b = ab_t('promise_h2b', 'সম্পূর্ণ নিশ্চিন্তে', 'total peace of mind');
                $pmsub = ab_t('promise_sub', 'ফি, পেমেন্ট, ডেলিভারি — প্রতিটি ধাপে স্বচ্ছতা ও নিরাপত্তা।', 'Fee, payment, delivery — transparency and safety at every single step.');
                $promiseCards = [
                    ['icon' => 'percent', 't' => ab_t('promise_c1_t', '০% হিডেন সার্ভিস ফি', '0% Hidden Service Fee'), 'd' => ab_t('promise_c1_d', 'কোনো লুকায়িত ফি বা অতিরিক্ত চার্জ নেই। চেকআউটে যা দেখেন, ঠিক তাই পরিশোধ করবেন।', 'No hidden fees or extra charges ever. What you see at checkout is exactly what you pay.'), 'tag' => ab_t('promise_c1_tag', '১০০% স্বচ্ছ', '100% Transparent')],
                    ['icon' => 'banknote', 't' => ab_t('promise_c2_t', '৪৮ ঘণ্টায় নিশ্চিত পেআউট', '48-Hour Guaranteed Payout'), 'd' => ab_t('promise_c2_d', 'রিফান্ড হোক বা পেআউট — টাকা পৌঁছে যাবে মাত্র ৪৮ ঘণ্টায় আপনার বিকাশ বা ব্যাংকে।', 'Refund or payout — money reaches your bKash or bank within just 48 hours, guaranteed.'), 'tag' => ab_t('promise_c2_tag', 'ইনস্ট্যান্ট বিকাশ/ব্যাংক', 'Instant bKash/Bank')],
                    ['icon' => 'truck', 't' => ab_t('promise_c3_t', '৬৪ জেলায় অটো লজিস্টিকস', 'Logistics in 64 Districts'), 'd' => ab_t('promise_c3_d', 'আপনার লোকাল বা বাসা থেকে ফিক্সড ও সারা দেশে ডেলিভারি — সব হ্যান্ডেল করে আচারবাড়ি ট্রাস্টেড কুরিয়ার পার্টনারদের মাধ্যমে।', 'From your door anywhere in Bangladesh — pickup and delivery handled entirely by AcharBari via trusted courier partners.'), 'tag' => ab_t('promise_c3_tag', 'Steadfast + Pathao', 'Steadfast + Pathao')],
                    ['icon' => 'package', 't' => ab_t('promise_c4_t', 'সিলড ও সেফ প্যাকেজিং', 'Sealed & Safe Packaging'), 'd' => ab_t('promise_c4_d', 'প্রতিটি জার এয়ার-টাইট সিল ও মোটা বাবল-র‍্যাপে সাজানো — ভাঙার ঝুঁকি প্রায় শূন্য, নাহলে ফ্রি রিপ্লেসমেন্ট।', 'Every jar is air-tight sealed and wrapped in thick bubble layers — breakage risk is practically zero, or we replace it free.'), 'tag' => ab_t('promise_c4_tag', 'সিলড অ্যান্ড সেফ', 'Sealed & Safe')],
                ];
            @endphp
            <div class="ds-sec-head text-center">
                <span class="ds-eyebrow" data-en="{{ $pmh['en'] }}">{{ $pmh['bn'] }}</span>
                <h2 class="ds-h2"><span data-en="{{ $pm2a['en'] }}">{{ $pm2a['bn'] }}</span><span class="ds-grad-neon" data-en="{{ $pm2b['en'] }}">{{ $pm2b['bn'] }}</span></h2>
                <p class="ds-sub" data-en="{{ $pmsub['en'] }}">{{ $pmsub['bn'] }}</p>
            </div>

            <div class="ds-seller-benefits ds-bento-grid">
                @foreach ($promiseCards as $pc)
                    <div class="ds-seller-card ds-bento-card">
                        <div class="ds-bento-glow"></div>
                        <div class="ds-seller-card-ic">
                            @if ($pc['icon'] === 'percent')
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" x2="5" y1="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                            @elseif ($pc['icon'] === 'banknote')
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg>
                            @elseif ($pc['icon'] === 'truck')
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                            @endif
                        </div>
                        <h4 data-en="{{ $pc['t']['en'] }}">{{ $pc['t']['bn'] }}</h4>
                        <p data-en="{{ $pc['d']['en'] }}">{{ $pc['d']['bn'] }}</p>
                        <span class="ds-bento-tag" data-en="{{ $pc['tag']['en'] }}">{{ $pc['tag']['bn'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ================= HOW IT WORKS ================= -->
    <section class="ds-section">
        <div class="ds-container">
            @php
                $sth = ab_t('steps_eyebrow', 'প্রসেস', 'Process');
                $st2a = ab_t('steps_h2a', 'মাত্র ৩ ধাপে ', 'Order in just ');
                $st2b = ab_t('steps_h2b', 'অর্ডার সম্পন্ন', '3 Simple Steps');
                $stsub = ab_t('steps_sub', 'সহজ ও নিরাপদ প্রক্রিয়া — ঝামেলাহীন অর্ডারের অভিজ্ঞতা', 'Simple & secure process — a hassle-free ordering experience');
                $steps = [
                    ['n' => '১', 't' => ab_t('step1_t', 'পছন্দের জার নির্বাচন', 'Pick Your Favourite Jar'), 'd' => ab_t('step1_d', 'আপনার পছন্দের আচার, মধু বা ঘি সিলেক্ট করে নিচের সহজ ফর্মটিতে নাম ও ঠিকানা পূরণ করুন।', 'Select your favourite pickle, honey or ghee and fill in the simple form below with your name and address.'), 'icon' => 'jar'],
                    ['n' => '২', 't' => ab_t('step2_t', 'ফোন কলে কনফার্মেশন', 'Phone Confirmation'), 'd' => ab_t('step2_d', 'অর্ডার পাওয়ার পরই আমাদের সাপোর্ট টিম কল দিয়ে ঠিকানা ও বিবরণ নিশ্চিত করবে।', 'As soon as we receive your order, our support team calls you to confirm the address and details.'), 'icon' => 'phone'],
                    ['n' => '৩', 't' => ab_t('step3_t', 'জার বুঝে টাকা দিন', 'Check the Jar, Then Pay'), 'd' => ab_t('step3_d', 'ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে ১০০% সন্তুষ্ট হয়ে টাকা পরিশোধ করুন।', 'Check the sealed jar in front of the delivery man and pay only when 100% satisfied.'), 'icon' => 'package'],
                ];
            @endphp
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="{{ $sth['en'] }}">{{ $sth['bn'] }}</span>
                <h2 class="ds-h2"><span data-en="{{ $st2a['en'] }}">{{ $st2a['bn'] }}</span><span class="ds-grad" data-en="{{ $st2b['en'] }}">{{ $st2b['bn'] }}</span></h2>
                <p class="ds-sub" data-en="{{ $stsub['en'] }}">{{ $stsub['bn'] }}</p>
            </div>
            <div class="ds-steps">
                @foreach ($steps as $step)
                    <div class="ds-step">
                        <span class="ds-step-n">{{ $step['n'] }}</span>
                        @if ($step['icon'] === 'jar')
                            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                        @elseif ($step['icon'] === 'phone')
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg>
                        @else
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                        @endif
                        <h3 data-en="{{ $step['t']['en'] }}">{{ $step['t']['bn'] }}</h3>
                        <p data-en="{{ $step['d']['en'] }}">{{ $step['d']['bn'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ================= WHY US (BENTO GRID) ================= -->
    @php
        $wh = ab_t('why_eyebrow', 'কেন আমরা সেরা', 'Why We Are the Best');
        $wh2a = ab_t('why_h2a', 'কেন বেছে নেবেন ', 'Why choose ');
        $brandBn = trim(($settings['brand_bn1'] ?? '') . ($settings['brand_bn2'] ?? '')) ?: 'আচারবাড়ি';
        $brandEn = trim(($settings['brand_en1'] ?? '') . ($settings['brand_en2'] ?? '')) ?: 'AcharBari';
        $wh2b = ab_t('why_h2b', $brandBn, $brandEn);
        $whsub = ab_t('why_sub', 'আমরা দিচ্ছি খাঁটি স্বাদের নিশ্চয়তা ও দ্রুততম সার্ভিস', 'We guarantee authentic taste and the fastest service');
        $bigT = ab_t('why_big_t', '১০০% খাঁটি ও প্রিজারভেটিভ-মুক্ত গ্যারান্টি', '100% Pure & Preservative-Free Guarantee');
        $bigD = ab_t('why_big_d', 'প্রতিটি জার মৌসুমি ফল, খাঁটি সরিষার তেল ও বিশুদ্ধ মসলা দিয়ে ছোট ব্যাচে হাতে তৈরি। কোনো প্রিজারভেটিভ, কালার বা কেমিক্যাল নেই — ল্যাব-টেস্টেড এবং নকল প্রমাণিত হলে সম্পূর্ণ টাকা রিটার্নের নিশ্চয়তা।', 'Every jar is handmade in small batches with seasonal fruits, premium mustard oil and pure spices. No preservatives, no colour, no chemicals — laboratory-tested and money-back guaranteed.');
        $verB = ab_t('why_verified', 'ভেরিফাইড গ্রামীণ রান্নাঘর', 'Verified Village Kitchens');
        $whyCells = [
            ['icon' => 'truck', 't' => ab_t('why_c1_t', 'সুপারফাস্ট ডেলিভারি', 'Superfast Delivery'), 'd' => ab_t('why_c1_d', 'ঢাকায় মাত্র ২৪ ঘণ্টা এবং ঢাকার বাইরে ৪৮-৭২ ঘণ্টার মধ্যে সিল করা জার নিরাপদে পৌঁছে যায়।', 'Within 24 hours in Dhaka and 48-72 hours outside Dhaka — sealed jars reach you safely.')],
            ['icon' => 'banknote', 't' => ab_t('why_c2_t', 'ক্যাশ অন ডেলিভারি', 'Cash on Delivery'), 'd' => ab_t('why_c2_d', 'অগ্রিম কোনো টাকা দিতে হবে না — পার্সেল হাতে পেয়ে চেক করে তারপর মূল্য পরিশোধ করুন।', 'No advance payment — check the parcel in hand and then pay.')],
            ['icon' => 'jarcheck', 't' => ab_t('why_c3_t', 'ভাঙা জারে রিপ্লেসমেন্ট', 'Broken Jar Replacement'), 'd' => ab_t('why_c3_d', 'জার ভাঙা বা লিক অবস্থায় পৌঁছালে ২৪ ঘণ্টার মধ্যে ছবি দিয়ে জানালেই সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট।', 'If a jar arrives broken or leaked, report within 24 hours with a photo — free replacement, no question asked.')],
            ['icon' => 'headset', 't' => ab_t('why_c4_t', '২৪/৭ সাপোর্ট হেল্পলাইন', '24/7 Support Helpline'), 'd' => ab_t('why_c4_d', 'স্বাদ, সংরক্ষণ বা পাইকারি অর্ডার নিয়ে যেকোনো প্রশ্নে যেকোনো সময় কল বা WhatsApp করুন।', 'For any question about taste, storage or bulk orders — call or WhatsApp us anytime.')],
        ];
    @endphp
    <section class="ds-section ds-section-alt" id="ds-why">
        <div class="ds-container">
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="{{ $wh['en'] }}">{{ $wh['bn'] }}</span>
                <h2 class="ds-h2"><span data-en="{{ $wh2a['en'] }}">{{ $wh2a['bn'] }}</span><span class="ds-grad" data-en="{{ $wh2b['en'] }}">{{ $wh2b['bn'] }}</span><span>?</span></h2>
                <p class="ds-sub" data-en="{{ $whsub['en'] }}">{{ $whsub['bn'] }}</p>
            </div>
            <div class="ds-bento">
                <div class="ds-bento-big">
                    <div>
                        <span class="ds-ic ds-ic-glass"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg></span>
                        <h3 data-en="{{ $bigT['en'] }}">{{ $bigT['bn'] }}</h3>
                        <p data-en="{{ $bigD['en'] }}">{{ $bigD['bn'] }}</p>
                    </div>
                    <div class="flex items-center gap-3 text-sm font-bold text-emerald-300">
                        <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>
                        <span data-en="{{ $verB['en'] }}">{{ $verB['bn'] }}</span>
                    </div>
                </div>
                @foreach ($whyCells as $wc)
                    <div class="ds-bento-cell">
                        <span class="ds-ic">
                            @if ($wc['icon'] === 'truck')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                            @elseif ($wc['icon'] === 'banknote')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg>
                            @elseif ($wc['icon'] === 'jarcheck')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="m9.5 15.2 1.9 1.9 3.1-3.7"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3v-5a9 9 0 0 1 18 0v5h-3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/></svg>
                            @endif
                        </span>
                        <h4 data-en="{{ $wc['t']['en'] }}">{{ $wc['t']['bn'] }}</h4>
                        <p data-en="{{ $wc['d']['en'] }}">{{ $wc['d']['bn'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ================= FAQ ================= -->
    @php
        $fqh = ab_t('faq_eyebrow', 'প্রশ্ন-উত্তর', 'FAQ');
        $fq2a = ab_t('faq_h2a', 'সাধারণ ', 'Common ');
        $fq2b = ab_t('faq_h2b', 'জিজ্ঞাসা', 'Questions');
        $fqsub = ab_t('faq_sub', 'আপনার মনে থাকা সাধারণ প্রশ্নের উত্তর জেনে নিন', 'Find answers to the questions you have in mind');
        $faqItems = ab_json('faq_items', [
            ['q_bn' => 'প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া যাবে?', 'q_en' => 'Can I pay cash after receiving the product?', 'a_bn' => 'হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি সুবিধা রয়েছে — ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে টাকা পরিশোধ করতে পারবেন। কোনো অগ্রিম টাকা লাগবে না।', 'a_en' => 'Yes, we have 100% Cash on Delivery — check the sealed jar in front of the delivery man and then pay. No advance money is needed.'],
            ['q_bn' => 'আচার কতদিন ভালো থাকে? প্রিজারভেটিভ আছে কি?', 'q_en' => 'How long do the pickles last? Any preservatives?', 'a_bn' => 'সঠিক পদ্ধতিতে তৈরি ও খাঁটি সরিষার তেল, পর্যাপ্ত লবণ ও বিশুদ্ধ মসলার কারণে আমাদের আচার ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত ভালো থাকে। প্রিজারভেটিভ, কালার ও কেমিক্যাল সম্পূর্ণ মুক্ত।', 'a_en' => 'Our pickles stay good for 12 months at room temperature — made the traditional way with premium mustard oil, enough salt and pure spices. Completely free of preservatives, colours and chemicals.'],
            ['q_bn' => 'ডেলিভারি চার্জ কত টাকা?', 'q_en' => 'What is the delivery charge?', 'a_bn' => 'ঢাকার ভেতরের জন্য ডেলিভারি চার্জ ৮০ টাকা এবং ঢাকার বাইরের জন্য ১৫০ টাকা। বিশেষ অফার চলাকালীন অনেক প্রোডাক্টে ফ্রি ডেলিভারিও থাকে।', 'a_en' => 'Delivery charge is ৳80 inside Dhaka and ৳150 outside Dhaka. During special offers many products also get free delivery.'],
            ['q_bn' => 'জার ভেঙে বা লিক হয়ে এলে কী করব?', 'q_en' => 'What if the jar arrives broken or leaked?', 'a_bn' => 'পার্সেল পাওয়ার ২৪ ঘণ্টার মধ্যে ছবি দিয়ে আমাদের হেল্পলাইনে জানালেই আমরা সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট করে দেব।', 'a_en' => 'Just inform our helpline with a photo within 24 hours of receiving the parcel — we will replace it completely free of charge.'],
            ['q_bn' => 'অর্ডার কীভাবে ট্র্যাক করব?', 'q_en' => 'How do I track my order?', 'a_bn' => 'অর্ডার দেওয়ার পর ওয়েবসাইটের "অর্ডার ট্র্যাক" বাটন থেকে আপনার মোবাইল নম্বর অথবা ইনভয়েস আইডি দিয়ে লাইভ স্ট্যাটাস দেখতে পারবেন।', 'a_en' => 'You can see live status from the "Order Track" button on the website using your mobile number or invoice ID.'],
        ]);
    @endphp
    <section class="ds-section" id="ds-faq">
        <div class="ds-container ds-faq-wrap">
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="{{ $fqh['en'] }}">{{ $fqh['bn'] }}</span>
                <h2 class="ds-h2"><span data-en="{{ $fq2a['en'] }}">{{ $fq2a['bn'] }}</span><span class="ds-grad" data-en="{{ $fq2b['en'] }}">{{ $fq2b['bn'] }}</span></h2>
                <p class="ds-sub" data-en="{{ $fqsub['en'] }}">{{ $fqsub['bn'] }}</p>
            </div>
            <div class="ds-faqs">
                @foreach ($faqItems as $i => $fi)
                    <details class="ds-faq" {{ $i === 0 ? 'open' : '' }}>
                        <summary><span data-en="{{ $fi['q_en'] ?? '' }}">{{ $fi['q_bn'] ?? '' }}</span> <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></summary>
                        <div data-en="{{ $fi['a_en'] ?? '' }}">{{ $fi['a_bn'] ?? '' }}</div>
                    </details>
                @endforeach
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
                @php
                    $ohA = ab_t('order_head_a', 'ক্যাশ অন ডেলিভারিতে অর্ডার করতে ', 'Fill in the ');
                    $ohB = ab_t('order_head_b', 'ফর্মটি সঠিকভাবে', 'form correctly');
                    $ohC = ab_t('order_head_c', ' পূরণ করুন', ' to order on Cash on Delivery');
                    $ohSub = ab_t('order_head_sub', 'আপনার তথ্য দেওয়ার পর আমাদের কল সেন্টার থেকে ফোন করে অর্ডার কনফার্ম করা হবে।', 'After you submit your details, our call centre will phone you to confirm the order.');
                @endphp
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                    <span data-en="{{ $ohA['en'] }}">{{ $ohA['bn'] }}</span><span class="text-emerald-600" data-en="{{ $ohB['en'] }}">{{ $ohB['bn'] }}</span><span data-en="{{ $ohC['en'] }}">{{ $ohC['bn'] }}</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1" data-en="{{ $ohSub['en'] }}">{{ $ohSub['bn'] }}</p>
            </div>

            <div class="p-6 md:p-8">
                @php
                    $dIn = ab_charge('delivery_inside', 80);
                    $dOut = ab_charge('delivery_outside', 150);
                    $cartT = ab_t('cart_title', 'আপনার কার্ট', 'Your Cart');
                    $couponPh = ab_t('cart_coupon_ph', 'কুপন কোড লিখুন (যেমন: ACHAR10)', 'Enter coupon code (e.g. ACHAR10)');
                    $couponNote = ab_t('cart_coupon_note', 'কুপন থাকলে প্রয়োগ করুন, ডিসকাউন্ট অটো ক্যালকুলেট হবে।', 'If you have a coupon, apply it — discount is calculated automatically.');
                    $colM = ab_t('cart_col_mark', 'মার্ক', 'Mark');
                    $colP = ab_t('cart_col_product', 'প্রোডাক্ট', 'Product');
                    $colQ = ab_t('cart_col_qty', 'পরিমাণ', 'Qty');
                    $colPr = ab_t('cart_col_price', 'মূল্য', 'Price');
                    $totSub = ab_t('cart_total_sub', 'মোট', 'Subtotal');
                    $totDel = ab_t('cart_total_delivery', 'ডেলিভারি চার্জ', 'Delivery Charge');
                    $totGrand = ab_t('cart_total_grand', 'সর্বমোট', 'Grand Total');
                    $cartEmpty = ab_t('cart_empty', 'কার্ট এখন খালি — উপরের প্রোডাক্ট কার্ডের অর্ডার করুন বাটনে চাপ দিলে পছন্দের পণ্য এখানে যোগ হবে।', 'Cart is empty now — click the "Order Now" button on a product card above and your favourite jars will be added here.');
                    $advT = ab_t('advance_title', 'অগ্রিম পেমেন্ট প্রয়োজন', 'Advance Payment Required');
                    $advPay = ab_t('advance_payable', 'Payable Now', 'এখনই পরিশোধ');
                    $advDue = ab_t('advance_due', 'Due', 'বাকি');
                    $chkT = ab_t('checkout_title', 'ডেলিভারি তথ্য দিন', 'Enter Delivery Info');
                    $phName = ab_t('f_name_ph', 'যেমন: মোঃ কামরুল হাসান', 'e.g. Md. Kamrul Hasan');
                    $phPhone = ab_t('f_phone_ph', '০১xxxxxxxxx (১১ সংখ্যা)', '01xxxxxxxxx (11 digits)');
                    $phAddr = ab_t('f_address_ph', 'বাসা নং, রোড, এলাকা, থানা ও জেলা', 'House no., road, area, thana & district');
                    $fArea = ab_t('f_area', 'ডেলিভারি এরিয়া', 'Delivery Area');
                    $areaPick = ab_t('area_pick', 'প্রোডাক্ট সিলেক্ট করুন', 'Select a product');
                    $areaIn = ab_t('area_inside', 'ঢাকার ভিতরে', 'Inside Dhaka');
                    $areaOut = ab_t('area_outside', 'ঢাকার বাহিরে', 'Outside Dhaka');
                    $areaFree = ab_t('area_free', 'ফ্রি ডেলিভারি - কোন চার্জ নেই', 'Free Delivery — No Charge');
                    $payT = ab_t('pay_method', 'পেমেন্ট মেথড', 'Payment Method');
                    $codT = ab_t('pay_cod', 'ক্যাশ অন ডেলিভারি', 'Cash On Delivery');
                    $codS = ab_t('pay_cod_sub', 'আগে পার্সেল দেখুন, তারপর টাকা দিন', 'Check the parcel first, then pay');
                    $onlT = ab_t('pay_online', 'অনলাইন পেমেন্ট — বিকাশ / নগদ / রকেট / উপায়', 'Online Payment — bKash / Nagad / Rocket / Upay');
                    $onlNA = ab_t('pay_online_note_a', 'অর্ডার কনফার্ম হওয়ার পর আমাদের প্রতিনিধি কল দিয়ে ', 'Our agent will call you after confirming the order with send-money instructions to ');
                    $onlNB = ab_t('pay_online_note_b', ' নম্বরে সেন্ড মানির বিস্তারিত জানিয়ে দেবেন।', '.');
                    $confirmBtn = ab_t('confirm_order', 'অর্ডার কনফার্ম করুন', 'Confirm Order');
                    $tr1 = ab_t('trust_1', 'নিরাপদ অর্ডার', 'Secure order');
                    $tr2 = ab_t('trust_2', 'দেখে টাকা দিন', 'Pay after checking');
                    $tr3 = ab_t('trust_3', 'ভাঙা জারে ফ্রি রিপ্লেসমেন্ট', 'Broken jar? Free replacement');
                @endphp
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                    <!-- Left: Cart Summary & Coupon -->
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="p-4 border-b bg-gray-50 flex items-center justify-between">
                            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                                <svg class="text-emerald-600 mr-1" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 11-1 9"/><path d="m19 11-4-7"/><path d="M2 11h20"/><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"/><path d="M4.5 15.5h15"/><path d="m5 11 4-7"/><path d="m9 11 1 9"/></svg> <span data-en="{{ $cartT['en'] }}">{{ $cartT['bn'] }}</span>
                            </h3>
                            <span class="text-xs text-gray-500 font-semibold" id="cart-item-count-label">0
                                item(s)</span>
                        </div>

                        <div class="p-4 border-b bg-white">
                            <div class="flex gap-2">
                                <input id="coupon_input" name="coupon_code" type="text"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 outline-none"
                                    placeholder="{{ $couponPh['bn'] }}" data-en-ph="{{ $couponPh['en'] }}">
                                <button type="button" onclick="submitCoupon()"
                                    class="bg-emerald-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-emerald-700 transition whitespace-nowrap">
                                    <span data-en="Apply">প্রয়োগ করুন</span>
                                </button>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-2" data-en="{{ $couponNote['en'] }}">{{ $couponNote['bn'] }}</p>
                            <p class="lp-coupon-msg" id="couponMsg" hidden></p>
                        </div>

                        <div class="cartlist p-4">
                            <div class="lp-cart-wrapper" data-cart-items="[]" data-subtotal="0" data-grand="{{ $dIn }}"
                                data-has-all-free-delivery="0" data-has-digital-only="0" data-cart-empty="1">

                                <div class="lp-cart-header">
                                    <div class="text-center" data-en="{{ $colM['en'] }}">{{ $colM['bn'] }}</div>
                                    <div data-en="{{ $colP['en'] }}">{{ $colP['bn'] }}</div>
                                    <div class="text-center" data-en="{{ $colQ['en'] }}">{{ $colQ['bn'] }}</div>
                                    <div class="text-end" data-en="{{ $colPr['en'] }}">{{ $colPr['bn'] }}</div>
                                </div>

                                <div class="lp-cart-totals">
                                    <div class="lp-cart-total-row">
                                        <span data-en="{{ $totSub['en'] }}">{{ $totSub['bn'] }}</span>
                                        <span id="net_total">৳ <strong>0</strong></span>
                                    </div>
                                    <div class="lp-cart-total-row">
                                        <span data-en="{{ $totDel['en'] }}">{{ $totDel['bn'] }}</span>
                                        <span id="cart_shipping_cost">৳ <strong>{{ $dIn }}</strong></span>
                                    </div>
                                    <div class="lp-cart-total-row final">
                                        <span data-en="{{ $totGrand['en'] }}">{{ $totGrand['bn'] }}</span>
                                        <span id="grand_total">৳ <strong>{{ $dIn }}</strong></span>
                                    </div>
                                </div>
                            </div>

                            <div class="lp-cart-empty" id="lpCartEmpty">
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 11-1 9"/><path d="m19 11-4-7"/><path d="M2 11h20"/><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"/><path d="M4.5 15.5h15"/><path d="m5 11 4-7"/><path d="m9 11 1 9"/></svg>
                                <span data-en="{{ $cartEmpty['en'] }}">{{ $cartEmpty['bn'] }}</span>
                            </div>
                        </div>

                        <div id="landing-advance-box" class="p-4 border-t bg-yellow-50 hidden">
                            <div class="text-sm font-bold text-yellow-800" data-en="{{ $advT['en'] }}">{{ $advT['bn'] }}</div>
                            <div class="mt-2 text-sm flex justify-between">
                                <span class="text-green-700 font-semibold" data-en="{{ $advPay['en'] }}">{{ $advPay['bn'] }}</span>
                                <span id="landing-advance-amount" class="font-bold text-green-700">৳ 0.00</span>
                            </div>
                            <div class="mt-1 text-sm flex justify-between">
                                <span class="text-red-700 font-semibold" data-en="{{ $advDue['en'] }}">{{ $advDue['bn'] }}</span>
                                <span id="landing-due-amount" class="font-bold text-red-700">৳ 0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Checkout Form -->
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="p-4 border-b bg-gray-50">
                            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                                <svg class="text-emerald-600 mr-1" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><path d="M16 10h2"/><path d="M16 14h2"/></svg> <span data-en="{{ $chkT['en'] }}">{{ $chkT['bn'] }}</span>
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
                                        placeholder="{{ $phName['bn'] }}" data-en-ph="{{ $phName['en'] }}">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="phone">
                                        <span data-en="Mobile Number">মোবাইল নাম্বার</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="phone" type="tel" inputmode="numeric" maxlength="15" name="phone" required="" value=""
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"
                                        placeholder="{{ $phPhone['bn'] }}" data-en-ph="{{ $phPhone['en'] }}">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="address">
                                        <span data-en="Full Delivery Address">সম্পূর্ণ ডেলিভারি ঠিকানা</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="address" type="text" name="address" required="" value=""
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"
                                        placeholder="{{ $phAddr['bn'] }}" data-en-ph="{{ $phAddr['en'] }}">
                                </div>

                                <div id="landing-area-wrapper">
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="area"><span
                                            data-en="{{ $fArea['en'] }}">{{ $fArea['bn'] }}</span></label>
                                    <input type="hidden" name="area" id="landing_area_input" value="inside">

                                    <div id="landing-area-empty" class="">
                                        <input type="text"
                                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-gray-100 cursor-not-allowed"
                                            value="{{ $areaPick['bn'] }}" data-en-val="{{ $areaPick['en'] }}" readonly="">
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
                                                <option value="inside" data-charge="{{ $dIn }}" selected>{{ $areaIn['bn'] }} {{ bn_num($dIn) }} টাকা (৳{{ $dIn }})</option>
                                                <option value="outside" data-charge="{{ $dOut }}">{{ $areaOut['bn'] }} {{ bn_num($dOut) }} টাকা (৳{{ $dOut }})</option>
                                                <!-- options swapped by script.js per language -->
                                            </select>
                                        </div>
                                        <div id="landing-free-delivery-wrap" class="hidden">
                                            <input type="text"
                                                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-green-50 text-green-800 font-semibold"
                                                value="{{ $areaFree['bn'] }}" data-en-val="{{ $areaFree['en'] }}" readonly="">
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-xl p-3 bg-white">
                                    <div class="text-sm font-bold text-gray-800 mb-2" data-en="{{ $payT['en'] }}">{{ $payT['bn'] }}</div>

                                    <div id="landing-advance-note"
                                        class="mb-3 p-3 rounded-lg border border-yellow-200 bg-yellow-50 text-sm text-yellow-900 hidden">
                                        <span data-en="This order requires an advance payment of ">এই অর্ডারে </span><b id="landing-advance-note-amount">৳ 0.00</b><span data-en=". COD is not available."> অগ্রিম পেমেন্ট করতে হবে। COD পাওয়া যাবে না।</span>
                                    </div>

                                    <div id="payment-methods-grid" class="space-y-2">
                                        <div id="cod-option-wrapper">
                                            <label class="pay-opt sel" style="--pbc:var(--ds-primary)">
                                                <span class="pay-ic"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></span>
                                                <span class="pay-tx">
                                                    <b data-en="{{ $codT['en'] }}">{{ $codT['bn'] }}</b>
                                                    <small data-en="{{ $codS['en'] }}">{{ $codS['bn'] }}</small>
                                                </span>
                                                <input type="radio" name="payment_method" id="payment_cod" value="cod"
                                                    checked="" class="accent-emerald-600">
                                            </label>
                                        </div>
                                        <button type="button" class="pay-toggle" id="onlinePayToggle"
                                            onclick="toggleOnlinePay()">
                                            <span class="pay-toggle-l">
                                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/></svg>
                                                <span data-en="{{ $onlT['en'] }}">{{ $onlT['bn'] }}</span>
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
                                                    <span data-en="{{ $onlNA['en'] }}{{ ab_contact('phone') }}{{ $onlNB['en'] }}">
                                                        {{ $onlNA['bn'] }}{{ ab_contact('phone') }}{{ $onlNB['bn'] }}</span>
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
                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> <span data-en="{{ $confirmBtn['en'] }}">{{ $confirmBtn['bn'] }}</span>
                                </button>

                                <div class="lp-trust-row">
                                    <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> <span data-en="{{ $tr1['en'] }}">{{ $tr1['bn'] }}</span></span>
                                    <span><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg> <span data-en="{{ $tr2['en'] }}">{{ $tr2['bn'] }}</span></span>
                                    <span><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="{{ $tr3['en'] }}">{{ $tr3['bn'] }}</span></span>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ================= CUSTOMER REVIEWS ================= -->
    @php
        $rvEyebrow = ab_t('reviews_eyebrow', 'গ্রাহকদের মতামত', 'Customer Opinions');
        $rvH2a = ab_t('reviews_h2a', 'কাস্টমারদের ', "Our customers' ");
        $rvH2b = ab_t('reviews_h2b', 'সন্তুষ্টির রিভিউ', 'Satisfaction Reviews');
        $rvSub = ab_t('reviews_sub', 'সারা বাংলাদেশ থেকে আমাদের মূল্যবান গ্রাহকদের অভিজ্ঞতা', 'Experiences of our valued customers from all over Bangladesh');
        $rvScore = ab_t('rating_score', '৪.৯', '4.9');
        $rvTotal = ab_t('rating_total', '৫৩২টি ভেরিফাইড রিভিউ', 'Based on 532 verified reviews');
        $ratingBars = ab_json('rating_items', [
            ['star' => 5, 'pct' => 89, 'count_bn' => '৪৭২', 'count_en' => '472'],
            ['star' => 4, 'pct' => 8, 'count_bn' => '৪১', 'count_en' => '41'],
            ['star' => 3, 'pct' => 2, 'count_bn' => '১২', 'count_en' => '12'],
            ['star' => 2, 'pct' => 0.8, 'count_bn' => '৪', 'count_en' => '4'],
            ['star' => 1, 'pct' => 0.6, 'count_bn' => '৩', 'count_en' => '3'],
        ]);
        $reviewCards = ab_json('reviews_items', [
            ['img' => 'assets/img/rev1.jpg', 'name' => 'নুসরাত জাহান', 'loc_bn' => 'ভেরিফাইড পারচেজ • ঢাকা', 'loc_en' => 'Verified Purchase • Dhaka', 'text_bn' => '"আমের কুচি আচারটা একদম ঠাকুমার বানানো আচারের মতোই লেগেছে! তেল বেশি না, ঝাল-নোনতা পারফেক্ট ব্যালেন্স। ঢাকায় একদিনের মধ্যেই ডেলিভারি পেয়েছি!"', 'text_en' => '"The mango kuchi achar tastes exactly like my grandmother used to make! Not too oily, perfectly spiced. Delivery arrived within a day in Dhaka!"', 'stars' => 5, 'likes_bn' => 'Like (২৪)', 'likes_en' => 'Like (24)'],
            ['img' => 'assets/img/rev2.jpg', 'name' => 'ফারহানা ইয়াসমিন', 'loc_bn' => 'ভেরিফাইড পারচেজ • চট্টগ্রাম', 'loc_en' => 'Verified Purchase • Chattogram', 'text_bn' => '"মিক্সড প্যাকের প্যাকেজিং দেখে মুগ্ধ! তিনটা আলাদা সিল করা জার, এক ফোঁটাও লিক হয়নি। জলপাই আচারটা বছরের পর বছর ধরে খাওয়া সেরা আচার!"', 'text_en' => '"The mixed pack packaging was amazing — three sealed jars, not a drop leaked. The olive pickle is the best I have had in years!"', 'stars' => 5, 'likes_bn' => 'Like (১৮)', 'likes_en' => 'Like (18)'],
            ['img' => 'assets/img/rev3.jpg', 'name' => 'তানজিনা আক্তার', 'loc_bn' => 'ভেরিফাইড পারচেজ • রাজশাহী', 'loc_en' => 'Verified Purchase • Rajshahi', 'text_bn' => '"অবশেষে খাঁটি কাঁচা মধু পেলাম! শীতে প্রাকৃতিকভাবে সেট হয়ে গেছে — খাঁটি হওয়ার সবচেয়ে বড় প্রমাণ। পুরো পরিবারের সবাই খুব পছন্দ করেছে।"', 'text_en' => '"Finally found pure raw Sundarban honey! It crystallised naturally in winter — proof that it is real. The whole family loves it."', 'stars' => 5, 'likes_bn' => 'Like (৩১)', 'likes_en' => 'Like (31)'],
            ['img' => 'assets/img/rev4.jpg', 'name' => 'মেহেজাবীন চৌধুরী', 'loc_bn' => 'ভেরিফাইড পারচেজ • সিলেট', 'loc_en' => 'Verified Purchase • Sylhet', 'text_bn' => '"ঘি খুলতেই পুরো রান্নাঘর ঘ্রাণে ভরে গেল! গরম ভাতে এক চামচ ঘি মানেই আসল স্বাদ। আপনার বোনের জন্য আরও ৩টা অর্ডার দিয়েছি।"', 'text_en' => '"The ghee aroma fills the whole kitchen! One spoon on hot rice and you are in heaven. Ordered 3 more jars for my sister."', 'stars' => 5, 'likes_bn' => 'Like (১৫)', 'likes_en' => 'Like (15)'],
            ['img' => 'assets/img/rev5.jpg', 'name' => 'সাবরিনা ইসলাম', 'loc_bn' => 'ভেরিফাইড পারচেজ • খুলনা', 'loc_en' => 'Verified Purchase • Khulna', 'text_bn' => '"প্রথমবার অনলাইনে আচার অর্ডার করলাম এবং অভিজ্ঞতা দারুণ! ডেলিভারি ম্যানের সামনে চেক করে টাকা দিলাম। রিকমেন্ডেড শপ।"', 'text_en' => '"First time ordering pickles online and the experience was great! Checked the parcel in front of the delivery man and then paid. Recommended shop."', 'stars' => 5, 'likes_bn' => 'Like (২৯)', 'likes_en' => 'Like (29)'],
        ]);
        $starSvgFull = '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        $starSvgHalf = '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path fill="currentColor" stroke="none" d="M12 2 8.91 8.26 2 9.27 7 14.14 5.82 21.02 12 17.77Z"/><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
    @endphp
    <section id="ds-reviews" class="py-16 bg-white overflow-hidden w-full">
        <div class="ds-sec-head">
            <span class="ds-eyebrow" data-en="{{ $rvEyebrow['en'] }}">{{ $rvEyebrow['bn'] }}</span>
            <h2 class="ds-h2"><span data-en="{{ $rvH2a['en'] }}">{{ $rvH2a['bn'] }}</span><span class="ds-grad" data-en="{{ $rvH2b['en'] }}">{{ $rvH2b['bn'] }}</span></h2>
            <p class="ds-sub" data-en="{{ $rvSub['en'] }}">{{ $rvSub['bn'] }}</p>
        </div>

        <div class="rating-summary">
            <div class="rs-score">
                <div class="rs-big">{{ $rvScore['bn'] }}<span data-en="/5">/৫</span></div>
                <div class="rs-stars">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path fill="currentColor" stroke="none" d="M12 2 8.91 8.26 2 9.27 7 14.14 5.82 21.02 12 17.77Z"/><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div class="rs-total" data-en="{{ $rvTotal['en'] }}">{{ $rvTotal['bn'] }}</div>
            </div>
            <div class="rs-bars">
                @foreach ($ratingBars as $bar)
                    <div class="rs-bar">
                        <span class="rs-l">{{ bn_num($bar['star'] ?? 0) }} <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></span>
                        <span class="rs-track"><span class="rs-fill" data-w="{{ $bar['pct'] ?? 0 }}"></span></span>
                        <span class="rs-n">{{ $bar['count_bn'] ?? '' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="reviews-swiper swiper w-full !overflow-hidden">
            <div class="swiper-wrapper">

                @foreach ($reviewCards as $rev)
                    <div class="swiper-slide px-2 md:px-3">
                        <div
                            class="border border-gray-200 rounded-2xl p-5 bg-white shadow-sm flex flex-col h-full min-h-[190px]">
                            <div class="flex items-center gap-3 mb-2">
                                <img src="{{ asset($rev['img'] ?: 'assets/img/rev1.jpg') }}" alt="{{ $rev['name'] ?? '' }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h4 class="font-bold text-sm text-[#d97706]">{{ $rev['name'] ?? '' }} <svg class="text-emerald-500 text-xs" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></h4>
                                    <p class="text-[10px] text-gray-500" data-en="{{ $rev['loc_en'] ?? '' }}">{{ $rev['loc_bn'] ?? '' }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 mb-3 flex-1" data-en="{{ $rev['text_en'] ?? '' }}">
                                {{ $rev['text_bn'] ?? '' }}
                            </p>
                            <div class="flex items-center text-xs text-yellow-500 mb-2">
                                @for ($si = 1; $si <= 5; $si++)
                                    {!! ($si <= (int) ($rev['stars'] ?? 5)) ? $starSvgFull : $starSvgHalf !!}
                                @endfor
                                <span class="ml-2 text-gray-600 font-semibold" data-en="{{ $rev['stars'] ?? 5 }}/5">{{ bn_num($rev['stars'] ?? 5) }}/৫</span>
                            </div>
                            <div class="border-t pt-2 mt-auto text-xs font-bold text-gray-400 flex gap-4">
                                <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"/></svg> <span data-en="{{ $rev['likes_en'] ?? '' }}">{{ $rev['likes_bn'] ?? '' }}</span></span>
                                <span data-en="Reply">Reply</span>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="swiper-pagination mt-8"></div>
        </div>
    </section>

<!-- ================= BOTTOM CTA ================= -->
    @php
        $ctaHa = ab_t('cta_h2a', 'আজই অর্ডার করুন — ', 'Order today — on ');
        $ctaHb = ab_t('cta_h2b', 'ক্যাশ অন ডেলিভারিতে', 'Cash on Delivery');
        $ctaS = ab_t('cta_sub', 'আপনার পছন্দের জার এখনই বুক করুন, পণ্য হাতে পেয়ে দেখে মূল্য পরিশোধ করুন।', 'Book your favourite jars now — check them in hand and then pay.');
        $ctaB = ab_t('cta_btn', 'অর্ডার করতে চাই', 'I Want to Order');
    @endphp
    <section class="ds-cta">
        <div>
            <h2><span data-en="{{ $ctaHa['en'] }}">{{ $ctaHa['bn'] }}</span><span style="color:var(--ds-lime-neon)" data-en="{{ $ctaHb['en'] }}">{{ $ctaHb['bn'] }}</span></h2>
            <p data-en="{{ $ctaS['en'] }}">{{ $ctaS['bn'] }}</p>
            <button onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})"
                class="ds-btn ds-btn-lg">
                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="{{ $ctaB['en'] }}">{{ $ctaB['bn'] }}</span>
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
