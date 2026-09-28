{{-- Section: hero | Design 4 — Centered Editorial + Wide Image Strip (scoped: hero-v4)
     Preserves slider hooks: #heroH1Slider .hslide, #heroImgSlider .himg, #heroImgDots, .hero-arrow-* --}}
@php
    $v4chip = ab_t('hero_chip', 'গ্রামবাংলার সেরা স্বাদ — ক্যাশ অন ডেলিভারিতে', 'Finest village-made taste — Cash on Delivery');
    $v4s1 = ab_t('hero_s1_main', 'ঘরে তৈরি খাঁটি দেশি আচার —', 'Homemade authentic deshi pickles —');
    $v4s1g = ab_t('hero_s1_grad', 'স্বাদ ও ভালোবাসার বন্ধন', 'a bond of taste & love');
    $v4s2 = ab_t('hero_s2_main', 'ঠাকুমার রেসিপিতে, ঘরে তৈরি —', "Thakumar's recipe, made at home —");
    $v4s2g = ab_t('hero_s2_grad', '১০০% প্রিজারভেটিভ মুক্ত', '100% preservative free');
    $v4s3 = ab_t('hero_s3_main', 'আজই অর্ডার করুন ক্যাশ অন ডেলিভারিতে —', 'Order today on Cash on Delivery —');
    $v4s3g = ab_t('hero_s3_grad', '৬৪ জেলায় হোম ডেলিভারি', 'home delivery in 64 districts');
    $v4lead = ab_t('hero_lead', 'মৌসুমি কাঁচা আম, জলপাই, তেঁতুল আর সরিষার তেলে তৈরি প্রতিটি জার — কোনো প্রিজারভেটিভ ছাড়াই।', 'Seasonal mango, olive and tamarind in pure mustard oil — preservative free.');
    $v4cta1 = ab_t('hero_cta1', 'এখনই অর্ডার করুন', 'Order Now');
    $v4cta2 = ab_t('hero_cta2', 'সব প্রোডাক্ট দেখুন', 'Browse All Products');
    $v4stats = [
        ['n' => ab_t('hero_stat1_n', '১৫,০০০+', '15,000+'), 'l' => ab_t('hero_stat1', 'সন্তুষ্ট গ্রাহক', 'Happy Customers')],
        ['n' => ab_t('hero_stat2_n', '৪.৯', '4.9'), 'l' => ab_t('hero_stat2', 'কাস্টমার রেটিং', 'Customer Rating')],
        ['n' => ab_t('hero_stat3_n', '৬৪', '64'), 'l' => ab_t('hero_stat3', 'জেলায় হোম ডেলিভারি', 'District Home Delivery')],
        ['n' => ab_t('hero_stat4_n', '১০০%', '100%'), 'l' => ab_t('hero_stat4', 'প্রিজারভেটিভ ফ্রি', 'Preservative Free')],
    ];
@endphp
<section class="hero-v4">
    <div class="hero-v4__top">
        <span class="hero-v4__chip" data-en="{{ $v4chip['en'] }}">{{ $v4chip['bn'] }}</span>
        <h2 id="heroH1Slider" class="hero-v4__h1">
            <span class="hslide active"><span data-en="{{ $v4s1['en'] }}">{{ $v4s1['bn'] }}</span> <em data-en="{{ $v4s1g['en'] }}">{{ $v4s1g['bn'] }}</em></span>
            <span class="hslide"><span data-en="{{ $v4s2['en'] }}">{{ $v4s2['bn'] }}</span> <em data-en="{{ $v4s2g['en'] }}">{{ $v4s2g['bn'] }}</em></span>
            <span class="hslide"><span data-en="{{ $v4s3['en'] }}">{{ $v4s3['bn'] }}</span> <em data-en="{{ $v4s3g['en'] }}">{{ $v4s3g['bn'] }}</em></span>
        </h2>
        <p class="hero-v4__lead" data-en="{{ $v4lead['en'] }}">{{ $v4lead['bn'] }}</p>
        <div class="hero-v4__cta">
            <button onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})" data-en="{{ $v4cta1['en'] }}">{{ $v4cta1['bn'] }}</button>
            <a href="{{ route('products') }}" data-en="{{ $v4cta2['en'] }}">{{ $v4cta2['bn'] }}</a>
        </div>
        <div class="hero-v4__stats">
            @foreach ($v4stats as $s)
                <div><strong data-en="{{ $s['n']['en'] }}">{{ $s['n']['bn'] }}</strong><span data-en="{{ $s['l']['en'] }}">{{ $s['l']['bn'] }}</span></div>
            @endforeach
        </div>
    </div>

    <div class="hero-v4__strip" id="heroImgSlider">
        <img class="himg active" src="{{ ab_img_setting('hero_img1', 'assets/img/hero_achar.jpg') }}" alt="আচারবাড়ি" fetchpriority="high">
        <img class="himg" src="{{ ab_img_setting('hero_img2', 'assets/img/prod_mix.jpg') }}" alt="আচারবাড়ি" loading="lazy">
        <img class="himg" src="{{ ab_img_setting('hero_img3', 'assets/img/prod_honey.jpg') }}" alt="আচারবাড়ি" loading="lazy">
        <img class="himg" src="{{ ab_img_setting('hero_img4', 'assets/img/spice_box.jpg') }}" alt="আচারবাড়ি" loading="lazy">
        <div class="hero-img-dots" id="heroImgDots">
            <button class="active" aria-label="Slide 1" onclick="goHeroImg(0)"></button>
            <button aria-label="Slide 2" onclick="goHeroImg(1)"></button>
            <button aria-label="Slide 3" onclick="goHeroImg(2)"></button>
            <button aria-label="Slide 4" onclick="goHeroImg(3)"></button>
        </div>
    </div>
</section>
<style>
    .hero-v4 { padding-top: 46px; }
    .hero-v4__top { max-width: 760px; margin: 0 auto; text-align: center; padding: 0 20px; }
    .hero-v4__chip {
        display: inline-block; font-size: 12px; font-weight: 800; color: var(--ds-primary);
        border: 1.5px solid rgba(var(--ds-primary-rgb, 5,150,105), .3); border-radius: 999px;
        padding: 7px 16px; margin-bottom: 16px; background: #fff;
    }
    .hero-v4__h1 { margin: 0 0 14px; font-size: clamp(26px, 4vw, 44px); font-weight: 800; line-height: 1.22; color: #12261d; }
    .hero-v4__h1 em { font-style: normal; color: var(--ds-accent); }
    .hero-v4__lead { margin: 0 auto 24px; font-size: 15px; line-height: 1.7; color: #4b6357; max-width: 560px; }
    .hero-v4__cta { display: flex; justify-content: center; flex-wrap: wrap; gap: 12px; }
    .hero-v4__cta button, .hero-v4__cta a {
        font-family: inherit; font-size: 14.5px; font-weight: 800; cursor: pointer; text-decoration: none;
        padding: 13px 30px; border-radius: 999px; transition: transform .18s;
    }
    .hero-v4__cta button { border: none; color: #fff; background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); box-shadow: 0 14px 30px -12px rgba(var(--ds-primary-rgb, 5,150,105), .6); }
    .hero-v4__cta a { color: #12261d; background: #fff; border: 1.5px solid rgba(18,38,29,.15); }
    .hero-v4__cta button:hover, .hero-v4__cta a:hover { transform: translateY(-2px); }
    .hero-v4__stats {
        margin-top: 28px; display: flex; justify-content: center; flex-wrap: wrap; gap: 12px 38px;
    }
    .hero-v4__stats div { text-align: center; }
    .hero-v4__stats strong { display: block; font-size: 20px; font-weight: 800; color: var(--ds-primary); }
    .hero-v4__stats span { font-size: 10.5px; color: #8b7355; }
    .hero-v4__strip {
        position: relative; margin-top: 34px; height: 300px; overflow: hidden;
    }
    .hero-v4__strip .himg {
        position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
        opacity: 0; transition: opacity .6s ease;
    }
    .hero-v4__strip .himg.active { opacity: 1; }
    .hero-v4 .hero-img-dots {
        position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px;
    }
    .hero-v4 .hero-img-dots button {
        width: 9px; height: 9px; border-radius: 999px; border: none; cursor: pointer;
        background: rgba(255,255,255,.6); padding: 0;
    }
    .hero-v4 .hero-img-dots button.active { background: #fff; width: 22px; }
    @media (prefers-reduced-motion: reduce) {
        .hero-v4__cta button, .hero-v4__cta a, .hero-v4__strip .himg { transition: none; }
    }
</style>
