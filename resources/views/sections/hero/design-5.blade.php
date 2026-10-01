{{-- Section: hero | Design 5 — Editorial Split, no slider (scoped: hr-v5)
     Same content keys as design-1: hero_chip, hero_s1_main/grad, hero_lead,
     hero_cta1/2, hero_stat1-4 (+_n), hero_img1-2 via ab_img_setting --}}
    <section class="hr-v5" id="ds-hero">
        <div class="hr-v5__in">
            <div class="hr-v5__copy">
                @php
                    $h5chip = ab_t('hero_chip', 'গ্রামবাংলার সেরা স্বাদ — ক্যাশ অন ডেলিভারিতে', 'Finest village-made taste — Cash on Delivery');
                    $h5a = ab_t('hero_s1_main', 'ঘরে তৈরি খাঁটি দেশি আচার —', 'Homemade authentic deshi pickles —');
                    $h5g = ab_t('hero_s1_grad', 'স্বাদ ও ভালোবাসার বন্ধন', 'a bond of taste & love');
                    $h5lead = ab_t('hero_lead', '', '');
                    $h5cta1 = ab_t('hero_cta1', 'এখনই অর্ডার করুন', 'Order Now');
                    $h5cta2 = ab_t('hero_cta2', 'সব প্রোডাক্ট দেখুন', 'Browse All Products');
                    $h5st1 = ab_t('hero_stat1', 'সন্তুষ্ট গ্রাহক', 'Happy Customers'); $h5st1n = ab_t('hero_stat1_n', '১৫,০০০+', '15,000+');
                    $h5st2 = ab_t('hero_stat2', 'কাস্টমার রেটিং', 'Customer Rating'); $h5st2n = ab_t('hero_stat2_n', '৪.৯', '4.9');
                    $h5st3 = ab_t('hero_stat3', 'জেলায় হোম ডেলিভারি', 'District Home Delivery'); $h5st3n = ab_t('hero_stat3_n', '৬৪', '64');
                @endphp
                <span class="hr-v5__chip">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                    <span data-en="{{ $h5chip['en'] }}">{{ $h5chip['bn'] }}</span>
                </span>
                <h1 class="hr-v5__h1">
                    <span data-en="{{ $h5a['en'] }}">{{ $h5a['bn'] }}</span>
                    <span class="hr-v5__grad" data-en="{{ $h5g['en'] }}">{{ $h5g['bn'] }}</span>
                </h1>
                @if (trim($h5lead['bn']) !== '')
                    <p class="hr-v5__lead" @if(trim($h5lead['en'])) data-en="{{ $h5lead['en'] }}" @endif>{{ $h5lead['bn'] }}</p>
                @endif
                <div class="hr-v5__ctas">
                    <button class="hr-v5__btn-main" onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                        <span data-en="{{ $h5cta1['en'] }}">{{ $h5cta1['bn'] }}</span>
                    </button>
                    <a class="hr-v5__btn-ghost" href="{{ route('products') }}" data-en="{{ $h5cta2['en'] }}">{{ $h5cta2['bn'] }}</a>
                </div>
                <div class="hr-v5__stats">
                    <div><strong data-en="{{ $h5st1n['en'] }}">{{ $h5st1n['bn'] }}</strong><span data-en="{{ $h5st1['en'] }}">{{ $h5st1['bn'] }}</span></div>
                    <div><strong data-en="{{ $h5st2n['en'] }}">{{ $h5st2n['bn'] }}</strong><span data-en="{{ $h5st2['en'] }}">{{ $h5st2['bn'] }}</span></div>
                    <div><strong data-en="{{ $h5st3n['en'] }}">{{ $h5st3n['bn'] }}</strong><span data-en="{{ $h5st3['en'] }}">{{ $h5st3['bn'] }}</span></div>
                </div>
            </div>

            <div class="hr-v5__visual">
                <img class="hr-v5__img-main" src="{{ ab_img_setting('hero_img1', 'assets/img/hero_achar.jpg') }}" alt="hero" fetchpriority="high">
                <img class="hr-v5__img-mini" src="{{ ab_img_setting('hero_img2', 'assets/img/prod_mix.jpg') }}" alt="hero detail" loading="lazy">
                <span class="hr-v5__badge">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                    <span data-en="100% Natural">১০০% প্রাকৃতিক</span>
                </span>
            </div>
        </div>
    </section>
<style>
    .hr-v5 { padding: 46px 20px 40px; background: linear-gradient(180deg, #f6fbf7, #fff); overflow: hidden; }
    .hr-v5__in {
        max-width: 1160px; margin: 0 auto; display: grid; grid-template-columns: 1.05fr .95fr;
        gap: 40px; align-items: center;
    }
    .hr-v5__chip {
        display: inline-flex; align-items: center; gap: 6px; font-size: 11.5px; font-weight: 800;
        color: #b45309; background: #fef3c7; border: 1px solid #fde68a; border-radius: 999px; padding: 6px 13px;
    }
    .hr-v5__h1 { font-size: clamp(26px, 4vw, 42px); font-weight: 800; line-height: 1.2; margin: 14px 0 12px; color: #12261d; }
    .hr-v5__grad {
        display: block; background: linear-gradient(90deg, var(--ds-primary), var(--ds-accent));
        -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .hr-v5__lead { font-size: 14px; line-height: 1.8; color: #5b6b60; margin: 0 0 18px; max-width: 480px; }
    .hr-v5__ctas { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 22px; }
    .hr-v5__btn-main {
        display: inline-flex; align-items: center; gap: 8px; border: 0; cursor: pointer; font-family: inherit;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
        font-size: 13.5px; font-weight: 800; padding: 13px 24px; border-radius: 14px;
        box-shadow: 0 16px 30px -12px rgba(5,150,105,.6); transition: transform .18s, box-shadow .25s;
    }
    .hr-v5__btn-main:hover { transform: translateY(-2px); box-shadow: 0 20px 36px -12px rgba(5,150,105,.7); }
    .hr-v5__btn-ghost {
        display: inline-flex; align-items: center; text-decoration: none; font-size: 13.5px; font-weight: 800;
        color: #1f4234; background: #fff; border: 1.5px solid rgba(5,150,105,.3); padding: 13px 24px; border-radius: 14px;
        transition: border-color .2s, color .2s;
    }
    .hr-v5__btn-ghost:hover { border-color: var(--ds-primary); color: var(--ds-primary); }
    .hr-v5__stats { display: flex; gap: 26px; flex-wrap: wrap; border-top: 1px dashed rgba(5,150,105,.3); padding-top: 16px; }
    .hr-v5__stats div { display: flex; flex-direction: column; }
    .hr-v5__stats strong { font-size: 18px; font-weight: 800; color: #065f46; }
    .hr-v5__stats span { font-size: 11px; color: #8b7355; font-weight: 700; }
    .hr-v5__visual { position: relative; }
    .hr-v5__img-main {
        width: 100%; aspect-ratio: 4 / 3.2; object-fit: cover; border-radius: 22px;
        border: 4px solid #fff; box-shadow: 0 30px 60px -30px rgba(6,78,59,.5);
    }
    .hr-v5__img-mini {
        position: absolute; bottom: -18px; left: -18px; width: 130px; height: 130px; object-fit: cover;
        border-radius: 18px; border: 4px solid #fff; box-shadow: 0 18px 36px -18px rgba(6,78,59,.55);
    }
    .hr-v5__badge {
        position: absolute; top: 14px; right: 14px; display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,.94); color: #047857; font-size: 11px; font-weight: 800;
        border-radius: 999px; padding: 7px 13px; box-shadow: 0 8px 18px -8px rgba(6,78,59,.4);
    }
    @media (max-width: 900px) {
        .hr-v5__in { grid-template-columns: 1fr; gap: 30px; }
        .hr-v5__img-mini { width: 100px; height: 100px; left: -8px; }
    }
</style>
