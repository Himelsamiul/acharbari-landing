{{-- Section: hero | Design 1 (extracted original) --}}
<!-- ================= HERO ================= -->
    <section class="ds-hero" id="ds-hero">
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
<style>
/* modern polish (scoped, additive) */
.ds-hero-card { box-shadow: 0 34px 70px -34px rgba(6,78,59,.5); border: 1px solid rgba(5,150,105,.14); }
.ds-hero-card .ds-hero-img-wrap { border-radius: 22px; }
.ds-chip-hero { backdrop-filter: blur(6px); }
.ds-btn { transition: transform .18s ease, box-shadow .25s ease; }
.ds-btn:hover { transform: translateY(-2px); }
</style>
