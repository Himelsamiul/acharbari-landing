{{-- Section: hero | Design 3 — Editorial Split (scoped: hero-v3)
     Preserves slider hooks: #heroH1Slider .hslide, #heroImgSlider .himg, #heroImgDots, .hero-arrow-* --}}
@php
    $v3chip = ab_t('hero_chip', 'গ্রামবাংলার সেরা স্বাদ — ক্যাশ অন ডেলিভারিতে', 'Finest village-made taste — Cash on Delivery');
    $v3s1 = ab_t('hero_s1_main', 'ঘরে তৈরি খাঁটি দেশি আচার —', 'Homemade authentic deshi pickles —');
    $v3s1g = ab_t('hero_s1_grad', 'স্বাদ ও ভালোবাসার বন্ধন', 'a bond of taste & love');
    $v3s2 = ab_t('hero_s2_main', 'ঠাকুমার রেসিপিতে, ঘরে তৈরি —', "Thakumar's recipe, made at home —");
    $v3s2g = ab_t('hero_s2_grad', '১০০% প্রিজারভেটিভ মুক্ত', '100% preservative free');
    $v3s3 = ab_t('hero_s3_main', 'আজই অর্ডার করুন ক্যাশ অন ডেলিভারিতে —', 'Order today on Cash on Delivery —');
    $v3s3g = ab_t('hero_s3_grad', '৬৪ জেলায় হোম ডেলিভারি', 'home delivery in 64 districts');
    $v3lead = ab_t('hero_lead', 'মৌসুমি কাঁচা আম, জলপাই, তেঁতুল আর সরিষার তেলে তৈরি প্রতিটি জার — কোনো প্রিজারভেটিভ ছাড়াই।', 'Seasonal mango, olive and tamarind in pure mustard oil — preservative free.');
    $v3cta1 = ab_t('hero_cta1', 'এখনই অর্ডার করুন', 'Order Now');
    $v3cta2 = ab_t('hero_cta2', 'সব প্রোডাক্ট দেখুন', 'Browse All Products');
    $v3flash = ab_t('hero_flash', 'নতুন ব্যাচ এসেছে', 'Fresh Batch Live');
    $v3stats = [
        ['n' => ab_t('hero_stat1_n', '১৫,০০০+', '15,000+'), 'l' => ab_t('hero_stat1', 'সন্তুষ্ট গ্রাহক', 'Happy Customers')],
        ['n' => ab_t('hero_stat2_n', '৪.৯', '4.9'), 'l' => ab_t('hero_stat2', 'কাস্টমার রেটিং', 'Customer Rating')],
        ['n' => ab_t('hero_stat3_n', '৬৪', '64'), 'l' => ab_t('hero_stat3', 'জেলায় হোম ডেলিভারি', 'District Home Delivery')],
        ['n' => ab_t('hero_stat4_n', '১০০%', '100%'), 'l' => ab_t('hero_stat4', 'প্রিজারভেটিভ ফ্রি', 'Preservative Free')],
    ];
@endphp
<section class="hero-v3">
    <div class="hero-v3__grid">
        <div class="hero-v3__copy">
            <span class="hero-v3__chip" data-en="{{ $v3chip['en'] }}">{{ $v3chip['bn'] }}</span>
            <h1 id="heroH1Slider" class="hero-v3__h1">
                <span class="hslide active"><span data-en="{{ $v3s1['en'] }}">{{ $v3s1['bn'] }}</span> <em data-en="{{ $v3s1g['en'] }}">{{ $v3s1g['bn'] }}</em></span>
                <span class="hslide"><span data-en="{{ $v3s2['en'] }}">{{ $v3s2['bn'] }}</span> <em data-en="{{ $v3s2g['en'] }}">{{ $v3s2g['bn'] }}</em></span>
                <span class="hslide"><span data-en="{{ $v3s3['en'] }}">{{ $v3s3['bn'] }}</span> <em data-en="{{ $v3s3g['en'] }}">{{ $v3s3g['bn'] }}</em></span>
            </h1>
            <p class="hero-v3__lead" data-en="{{ $v3lead['en'] }}">{{ $v3lead['bn'] }}</p>
            <div class="hero-v3__cta">
                <button class="hero-v3__main" onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
                    <span data-en="{{ $v3cta1['en'] }}">{{ $v3cta1['bn'] }}</span>
                </button>
                <a class="hero-v3__ghost" href="{{ route('products') }}" data-en="{{ $v3cta2['en'] }}">{{ $v3cta2['bn'] }}</a>
            </div>
            <div class="hero-v3__stats">
                @foreach ($v3stats as $s)
                    <div><strong data-en="{{ $s['n']['en'] }}">{{ $s['n']['bn'] }}</strong><span data-en="{{ $s['l']['en'] }}">{{ $s['l']['bn'] }}</span></div>
                @endforeach
            </div>
        </div>

        <div class="hero-v3__visual">
            <div class="hero-v3__frame" id="heroImgSlider">
                <img class="himg active" src="{{ ab_img_setting('hero_img1', 'assets/img/hero_achar.jpg') }}" alt="আচারবাড়ি" fetchpriority="high">
                <img class="himg" src="{{ ab_img_setting('hero_img2', 'assets/img/prod_mix.jpg') }}" alt="আচারবাড়ি" loading="lazy">
                <img class="himg" src="{{ ab_img_setting('hero_img3', 'assets/img/prod_honey.jpg') }}" alt="আচারবাড়ি" loading="lazy">
                <img class="himg" src="{{ ab_img_setting('hero_img4', 'assets/img/spice_box.jpg') }}" alt="আচারবাড়ি" loading="lazy">
                <span class="hero-v3__flash" data-en="{{ $v3flash['en'] }}">{{ $v3flash['bn'] }}</span>
                <div class="hero-img-dots" id="heroImgDots">
                    <button class="active" aria-label="Slide 1" onclick="goHeroImg(0)"></button>
                    <button aria-label="Slide 2" onclick="goHeroImg(1)"></button>
                    <button aria-label="Slide 3" onclick="goHeroImg(2)"></button>
                    <button aria-label="Slide 4" onclick="goHeroImg(3)"></button>
                </div>
            </div>
            <div class="hero-v3__arch" aria-hidden="true"></div>
        </div>
    </div>
</section>
<style>
    .hero-v3 { overflow: hidden; background:
        radial-gradient(60% 80% at 100% 0%, rgba(163,230,53,.14), transparent 60%),
        linear-gradient(180deg, #fff, var(--ds-section-alt-bg, #f8fbf9)); }
    .hero-v3__grid {
        max-width: 1200px; margin: 0 auto; padding: 60px 20px;
        display: grid; grid-template-columns: 1.05fr .95fr; gap: 56px; align-items: center;
    }
    .hero-v3__chip {
        display: inline-block; font-size: 12px; font-weight: 800; color: var(--ds-primary);
        background: rgba(var(--ds-primary-rgb, 5,150,105), .08); border-radius: 999px; padding: 7px 16px; margin-bottom: 18px;
    }
    .hero-v3__h1 { margin: 0 0 16px; font-size: clamp(26px, 3.8vw, 44px); font-weight: 800; line-height: 1.22; color: #12261d; }
    .hero-v3__h1 em { font-style: normal;
        background: linear-gradient(90deg, var(--ds-primary), var(--ds-accent));
        -webkit-background-clip: text; background-clip: text; color: transparent; }
    .hero-v3__lead { margin: 0 0 24px; font-size: 15px; line-height: 1.75; color: #4b6357; max-width: 520px; }
    .hero-v3__cta { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 30px; }
    .hero-v3__main {
        cursor: pointer; font-family: inherit; font-size: 15px; font-weight: 800; border: none;
        color: #fff; background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent));
        padding: 14px 30px; border-radius: 14px;
        box-shadow: 0 16px 32px -12px rgba(var(--ds-primary-rgb, 5,150,105), .55); transition: transform .18s;
    }
    .hero-v3__main:hover { transform: translateY(-2px); }
    .hero-v3__ghost {
        display: inline-flex; align-items: center; text-decoration: none; color: #12261d;
        border: 1.5px solid rgba(18,38,29,.25); border-radius: 14px; padding: 13px 26px;
        font-size: 15px; font-weight: 800; transition: border-color .2s, color .2s;
    }
    .hero-v3__ghost:hover { border-color: var(--ds-primary); color: var(--ds-primary); }
    .hero-v3__stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; border-top: 1.5px dashed rgba(18,38,29,.15); padding-top: 18px; }
    .hero-v3__stats strong { display: block; font-size: 19px; font-weight: 800; color: #12261d; }
    .hero-v3__stats span { font-size: 10.5px; color: #8b7355; }
    .hero-v3__visual { position: relative; }
    .hero-v3__arch { position: absolute; inset: 26px -18px -18px 26px; border-radius: 30px; background: linear-gradient(135deg, var(--ds-accent), var(--ds-lime)); opacity: .25; z-index: 0; }
    .hero-v3__frame {
        position: relative; z-index: 1; border-radius: 28px; overflow: hidden; aspect-ratio: 4/4.4;
        box-shadow: 0 36px 70px -30px rgba(6,78,59,.55); border: 6px solid #fff;
    }
    .hero-v3__frame .himg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity .6s ease; }
    .hero-v3__frame .himg.active { opacity: 1; }
    .hero-v3__flash {
        position: absolute; top: 14px; left: 14px; z-index: 2;
        background: #fff; color: var(--ds-primary); font-size: 11.5px; font-weight: 800;
        border-radius: 999px; padding: 6px 14px; box-shadow: 0 8px 18px -8px rgba(6,78,59,.4);
    }
    .hero-v3 .hero-img-dots { position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; }
    .hero-v3 .hero-img-dots button { width: 9px; height: 9px; border-radius: 999px; border: none; cursor: pointer; background: rgba(255,255,255,.55); padding: 0; }
    .hero-v3 .hero-img-dots button.active { background: #fff; width: 22px; }
    @media (max-width: 960px) {
        .hero-v3__grid { grid-template-columns: 1fr; gap: 34px; padding: 44px 16px; }
        .hero-v3__stats { grid-template-columns: repeat(2, 1fr); }
    }
    @media (prefers-reduced-motion: reduce) {
        .hero-v3__main, .hero-v3__frame .himg { transition: none; }
    }
</style>
