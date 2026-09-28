{{-- Section: hero | Design 2 — Modern Glass Full-Screen Hero (scoped: hero-v2)
     Preserves slider hooks: #heroH1Slider .hslide, #heroImgSlider .himg, #heroImgDots, .hero-arrow-* --}}
@php
    $v2chip = ab_t('hero_chip', 'গ্রামবাংলার সেরা স্বাদ — ক্যাশ অন ডেলিভারিতে', 'Finest village-made taste — Cash on Delivery');
    $v2s1 = ab_t('hero_s1_main', 'ঘরে তৈরি খাঁটি দেশি আচার —', 'Homemade authentic deshi pickles —');
    $v2s1g = ab_t('hero_s1_grad', 'স্বাদ ও ভালোবাসার বন্ধন', 'a bond of taste & love');
    $v2s2 = ab_t('hero_s2_main', 'ঠাকুমার রেসিপিতে, ঘরে তৈরি —', "Thakumar's recipe, made at home —");
    $v2s2g = ab_t('hero_s2_grad', '১০০% প্রিজারভেটিভ মুক্ত', '100% preservative free');
    $v2s3 = ab_t('hero_s3_main', 'আজই অর্ডার করুন ক্যাশ অন ডেলিভারিতে —', 'Order today on Cash on Delivery —');
    $v2s3g = ab_t('hero_s3_grad', '৬৪ জেলায় হোম ডেলিভারি', 'home delivery in 64 districts');
    $v2lead = ab_t('hero_lead', 'মৌসুমি কাঁচা আম, জলপাই, তেঁতুল আর সরিষার তেলে ঘরে তৈরি আচারবাড়ির প্রতিটি জার।', 'Seasonal mango, olive, tamarind in pure mustard oil — every jar handmade.');
    $v2cta1 = ab_t('hero_cta1', 'এখনই অর্ডার করুন', 'Order Now');
    $v2cta2 = ab_t('hero_cta2', 'সব প্রোডাক্ট দেখুন', 'Browse All Products');
    $v2flash = ab_t('hero_flash', 'নতুন ব্যাচ এসেছে', 'Fresh Batch Live');
    $v2stats = [
        ['n' => ab_t('hero_stat1_n', '১৫,০০০+', '15,000+'), 'l' => ab_t('hero_stat1', 'সন্তুষ্ট গ্রাহক', 'Happy Customers')],
        ['n' => ab_t('hero_stat2_n', '৪.৯', '4.9'), 'l' => ab_t('hero_stat2', 'কাস্টমার রেটিং', 'Customer Rating')],
        ['n' => ab_t('hero_stat3_n', '৬৪', '64'), 'l' => ab_t('hero_stat3', 'জেলায় হোম ডেলিভারি', 'District Home Delivery')],
        ['n' => ab_t('hero_stat4_n', '১০০%', '100%'), 'l' => ab_t('hero_stat4', 'প্রিজারভেটিভ ফ্রি', 'Preservative Free')],
    ];
@endphp
<section class="hero-v2">
    <img class="hero-v2__bg" src="{{ ab_img_setting('hero_img1', 'assets/img/hero_achar.jpg') }}" alt="" aria-hidden="true">
    <div class="hero-v2__tint"></div>

    <div class="hero-v2__grid">
        {{-- glass content panel --}}
        <div class="hero-v2__panel">
            <span class="hero-v2__chip">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                <span data-en="{{ $v2chip['en'] }}">{{ $v2chip['bn'] }}</span>
            </span>

            <h2 id="heroH1Slider" class="hero-v2__h1">
                <span class="hslide active"><span data-en="{{ $v2s1['en'] }}">{{ $v2s1['bn'] }}</span> <em data-en="{{ $v2s1g['en'] }}">{{ $v2s1g['bn'] }}</em></span>
                <span class="hslide"><span data-en="{{ $v2s2['en'] }}">{{ $v2s2['bn'] }}</span> <em data-en="{{ $v2s2g['en'] }}">{{ $v2s2g['bn'] }}</em></span>
                <span class="hslide"><span data-en="{{ $v2s3['en'] }}">{{ $v2s3['bn'] }}</span> <em data-en="{{ $v2s3g['en'] }}">{{ $v2s3g['bn'] }}</em></span>
            </h2>

            <p class="hero-v2__lead" data-en="{{ $v2lead['en'] }}">{{ $v2lead['bn'] }}</p>

            <div class="hero-v2__cta">
                <button class="hero-v2__btn-main" onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
                    <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    <span data-en="{{ $v2cta1['en'] }}">{{ $v2cta1['bn'] }}</span>
                </button>
                <a class="hero-v2__btn-ghost" href="{{ route('products') }}" data-en="{{ $v2cta2['en'] }}">{{ $v2cta2['bn'] }}</a>
            </div>

            <div class="hero-v2__stats">
                @foreach ($v2stats as $s)
                    <div><strong data-en="{{ $s['n']['en'] }}">{{ $s['n']['bn'] }}</strong><span data-en="{{ $s['l']['en'] }}">{{ $s['l']['bn'] }}</span></div>
                @endforeach
            </div>
        </div>

        {{-- image slider panel (same hooks as design-1) --}}
        <div class="hero-v2__visual">
            <div class="hero-v2__img-wrap" id="heroImgSlider">
                <img class="himg active" src="{{ ab_img_setting('hero_img1', 'assets/img/hero_achar.jpg') }}" alt="আচারবাড়ি — মসলার বাটি" fetchpriority="high">
                <img class="himg" src="{{ ab_img_setting('hero_img2', 'assets/img/prod_mix.jpg') }}" alt="আচারবাড়ি — আচারের জার সমূহ" loading="lazy">
                <img class="himg" src="{{ ab_img_setting('hero_img3', 'assets/img/prod_honey.jpg') }}" alt="আচারবাড়ি — সুন্দরবনের মধু" loading="lazy">
                <img class="himg" src="{{ ab_img_setting('hero_img4', 'assets/img/spice_box.jpg') }}" alt="আচারবাড়ি — মসলার ডাব্বা" loading="lazy">
                <span class="hero-v2__flash" data-en="{{ $v2flash['en'] }}">{{ $v2flash['bn'] }}</span>
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
        </div>
    </div>
</section>
<style>
    .hero-v2 { position: relative; overflow: hidden; isolation: isolate; }
    .hero-v2__bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2; }
    .hero-v2__tint {
        position: absolute; inset: 0; z-index: -1;
        background: linear-gradient(120deg, rgba(2,44,34,.92) 0%, rgba(6,78,59,.78) 46%, rgba(2,44,34,.42) 100%);
    }
    .hero-v2__grid {
        max-width: 1200px; margin: 0 auto; padding: 64px 20px 70px;
        display: grid; grid-template-columns: 1.15fr .85fr; gap: 46px; align-items: center;
    }
    .hero-v2__panel {
        background: rgba(255,255,255,.09); border: 1px solid rgba(255,255,255,.22);
        backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
        border-radius: 26px; padding: 30px 30px 26px; color: #fff;
        box-shadow: 0 30px 60px -30px rgba(0,0,0,.6);
    }
    .hero-v2__chip {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 12px; font-weight: 800; color: #d9f99d;
        border: 1px solid rgba(217,249,157,.4); border-radius: 999px; padding: 6px 14px; margin-bottom: 16px;
    }
    .hero-v2__h1 { margin: 0 0 14px; font-size: clamp(24px, 3.6vw, 40px); font-weight: 800; line-height: 1.25; }
    .hero-v2__h1 em { font-style: normal; color: var(--ds-lime-neon); }
    .hero-v2__lead { margin: 0 0 22px; font-size: 14.5px; line-height: 1.7; color: rgba(255,255,255,.85); }
    .hero-v2__cta { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 26px; }
    .hero-v2__btn-main {
        display: inline-flex; align-items: center; gap: 9px; cursor: pointer; font-family: inherit;
        background: var(--ds-lime-neon); color: #14320f; border: none;
        font-size: 15px; font-weight: 800; padding: 13px 28px; border-radius: 999px;
        box-shadow: 0 14px 30px -10px rgba(163,230,53,.55); transition: transform .18s;
    }
    .hero-v2__btn-main:hover { transform: translateY(-2px); }
    .hero-v2__btn-ghost {
        display: inline-flex; align-items: center; text-decoration: none;
        color: #fff; border: 1.5px solid rgba(255,255,255,.45); border-radius: 999px;
        font-size: 15px; font-weight: 800; padding: 12px 26px; transition: background .2s;
    }
    .hero-v2__btn-ghost:hover { background: rgba(255,255,255,.12); }
    .hero-v2__stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; border-top: 1px solid rgba(255,255,255,.18); padding-top: 18px; }
    .hero-v2__stats strong { display: block; font-size: 18px; font-weight: 800; color: var(--ds-lime-neon); }
    .hero-v2__stats span { font-size: 10.5px; color: rgba(255,255,255,.75); }
    .hero-v2__img-wrap { position: relative; border-radius: 24px; overflow: hidden; aspect-ratio: 4/4.6; box-shadow: 0 40px 80px -30px rgba(0,0,0,.7); border: 1px solid rgba(255,255,255,.2); }
    .hero-v2__img-wrap .himg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity .6s ease; }
    .hero-v2__img-wrap .himg.active { opacity: 1; }
    .hero-v2__flash {
        position: absolute; top: 14px; left: 14px;
        background: rgba(2,44,34,.75); backdrop-filter: blur(8px); color: var(--ds-lime-neon);
        font-size: 11.5px; font-weight: 800; border-radius: 999px; padding: 6px 13px;
    }
    .hero-v2 .hero-img-dots { position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; }
    .hero-v2 .hero-img-dots button { width: 9px; height: 9px; border-radius: 999px; border: none; cursor: pointer; background: rgba(255,255,255,.5); padding: 0; }
    .hero-v2 .hero-img-dots button.active { background: var(--ds-lime-neon); width: 22px; }
    .hero-v2 .hero-arrow {
        position: absolute; top: 50%; transform: translateY(-50%); width: 36px; height: 36px;
        border-radius: 50%; border: none; cursor: pointer; display: grid; place-items: center;
        background: rgba(255,255,255,.85); color: #14320f;
    }
    .hero-v2 .hero-arrow-prev { left: 12px; }
    .hero-v2 .hero-arrow-next { right: 12px; }
    @media (max-width: 960px) {
        .hero-v2__grid { grid-template-columns: 1fr; gap: 30px; padding: 44px 16px 54px; }
        .hero-v2__stats { grid-template-columns: repeat(2, 1fr); }
    }
    @media (prefers-reduced-motion: reduce) {
        .hero-v2__btn-main, .hero-v2__btn-ghost, .hero-v2__img-wrap .himg { transition: none; }
    }
</style>
