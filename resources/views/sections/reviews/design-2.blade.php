{{-- Section: reviews | Design 2 — Modern Static Grid (scoped: rv-v2, no swiper) --}}
@php
    $rv2head = ab_t('reviews_eyebrow', 'গ্রাহকদের মতামত', 'Customer Opinions');
    $rv2tbn = ab_t('reviews_h2a', 'কাস্টমারদের ', "Our customers' ")['bn'] . ab_t('reviews_h2b', 'সন্তুষ্টির রিভিউ', 'Satisfaction Reviews')['bn'];
    $rv2ten = ab_t('reviews_h2a', 'কাস্টমারদের ', "Our customers' ")['en'] . ab_t('reviews_h2b', 'সন্তুষ্টির রিভিউ', 'Satisfaction Reviews')['en'];
    $rv2sub = ab_t('reviews_sub', 'সারা বাংলাদেশ থেকে আমাদের মূল্যবান গ্রাহকদের অভিজ্ঞতা', 'Experiences of our valued customers from all over Bangladesh');
    $rv2score = ab_t('rating_score', '৪.৯', '4.9');
    $rv2total = ab_t('rating_total', '৫৩২টি ভেরিফাইড রিভিউ', 'Based on 532 verified reviews');
    $rv2bars = ab_json('rating_items', [
        ['star' => 5, 'pct' => 89, 'count_bn' => '৪৭২', 'count_en' => '472'],
        ['star' => 4, 'pct' => 8, 'count_bn' => '৪১', 'count_en' => '41'],
        ['star' => 3, 'pct' => 2, 'count_bn' => '১২', 'count_en' => '12'],
        ['star' => 2, 'pct' => 0.8, 'count_bn' => '৪', 'count_en' => '4'],
        ['star' => 1, 'pct' => 0.6, 'count_bn' => '৩', 'count_en' => '3'],
    ]);
    $rv2cards = ab_json('reviews_items', ab_reviews_default());
    $rv2full = '<svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
@endphp
<section id="ds-reviews" class="rv-v2">
    <div class="rv-v2__in">
        <div class="rv-v2__summary">
            <div class="rv-v2__score">
                <b>{{ $rv2score['bn'] }}<span data-en="/5">/৫</span></b>
                <span class="rv-v2__total" data-en="{{ $rv2total['en'] }}">{{ $rv2total['bn'] }}</span>
            </div>
            <div class="rv-v2__bars">
                @foreach ($rv2bars as $bar)
                    <div class="rv-v2__bar">
                        <span class="rv-v2__star">{{ bn_num($bar['star'] ?? 0) }}</span>
                        <span class="rv-v2__track"><span class="rs-fill" data-w="{{ $bar['pct'] ?? 0 }}"></span></span>
                        <span class="rv-v2__n">{{ $bar['count_bn'] ?? '' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rv-v2__head">
            <span class="rv-v2__eyebrow" data-en="{{ $rv2head['en'] }}">{{ $rv2head['bn'] }}</span>
            <h2 data-en="{{ $rv2ten }}">{{ $rv2tbn }}</h2>
            <p data-en="{{ $rv2sub['en'] }}">{{ $rv2sub['bn'] }}</p>
        </div>

        <div class="rv-v2__grid">
            @foreach ($rv2cards as $rev)
                <article class="rv-v2__card">
                    <div class="rv-v2__top">
                        <img src="{{ asset($rev['img'] ?: 'assets/img/rev1.jpg') }}" alt="{{ $rev['name'] ?? '' }}" loading="lazy">
                        <div>
                            <h4>{{ $rev['name'] ?? '' }} <i class="rv-v2__ok">✔</i></h4>
                            <p data-en="{{ $rev['loc_en'] ?? '' }}">{{ $rev['loc_bn'] ?? '' }}</p>
                        </div>
                        <span class="rv-v2__stars">{!! str_repeat($rv2full, (int) ($rev['stars'] ?? 5)) !!}</span>
                    </div>
                    <p class="rv-v2__text" data-en="{{ $rev['text_en'] ?? '' }}">{{ $rev['text_bn'] ?? '' }}</p>
                    <div class="rv-v2__foot">
                        <span data-en="{{ $rev['likes_en'] ?? '' }}">{{ $rev['likes_bn'] ?? '' }}</span>
                        <span data-en="Reply">Reply</span>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
<style>
    .rv-v2 { padding: 56px 20px; background: #fff; }
    .rv-v2__in { max-width: 1180px; margin: 0 auto; }
    .rv-v2__summary {
        display: flex; flex-wrap: wrap; gap: 20px 44px; align-items: center;
        background: linear-gradient(135deg, rgba(5,150,105,.07), rgba(163,230,53,.1));
        border: 1.5px solid rgba(5,150,105,.16); border-radius: 20px;
        padding: 20px 26px; margin-bottom: 28px;
    }
    .rv-v2__score b { display: block; font-size: 38px; font-weight: 800; color: #12261d; line-height: 1; }
    .rv-v2__score b span { font-size: 16px; color: #8b7355; }
    .rv-v2__total { display: block; margin-top: 4px; font-size: 11.5px; color: #8b7355; font-weight: 700; }
    .rv-v2__bars { flex: 1; min-width: 240px; display: flex; flex-direction: column; gap: 6px; }
    .rv-v2__bar { display: grid; grid-template-columns: 30px 1fr 40px; gap: 10px; align-items: center; font-size: 11.5px; color: #4b6357; font-weight: 700; }
    .rv-v2__track { height: 8px; border-radius: 999px; background: rgba(5,150,105,.12); overflow: hidden; }
    .rv-v2__track .rs-fill { display: block; height: 100%; border-radius: 999px; background: linear-gradient(90deg, var(--ds-primary), var(--ds-lime)); }
    .rv-v2__n { text-align: right; }
    .rv-v2__head { text-align: center; margin: 6px auto 26px; max-width: 620px; }
    .rv-v2__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .rv-v2__head h2 { margin: 0 0 8px; font-size: clamp(22px, 3vw, 31px); font-weight: 800; color: #12261d; }
    .rv-v2__head p { margin: 0; font-size: 13.5px; color: #4b6357; }
    .rv-v2__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr)); gap: 16px; }
    .rv-v2__card {
        display: flex; flex-direction: column;
        background: #fff; border: 1.5px solid rgba(5,150,105,.16); border-radius: 18px; padding: 18px;
        box-shadow: 0 16px 34px -26px rgba(6,78,59,.45);
        transition: transform .18s, box-shadow .25s;
    }
    .rv-v2__card:hover { transform: translateY(-4px); box-shadow: 0 24px 44px -26px rgba(6,78,59,.5); }
    .rv-v2__top { display: flex; gap: 11px; align-items: center; margin-bottom: 10px; }
    .rv-v2__top img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; }
    .rv-v2__top h4 { margin: 0; font-size: 13.5px; font-weight: 800; color: #b45309; }
    .rv-v2__top p { margin: 1px 0 0; font-size: 10.5px; color: #8b7355; }
    .rv-v2__ok { color: #10b981; font-style: normal; font-size: 11px; }
    .rv-v2__stars { margin-left: auto; color: #f59e0b; letter-spacing: 1px; font-size: 12px; }
    .rv-v2__text { flex: 1; margin: 0 0 12px; font-size: 13px; color: #3f5d4f; line-height: 1.7; }
    .rv-v2__foot { display: flex; gap: 16px; padding-top: 10px; border-top: 1px dashed rgba(18,38,29,.12); font-size: 11.5px; font-weight: 700; color: #9ca3af; }
    @media (prefers-reduced-motion: reduce) {
        .rv-v2__card { transition: none; }
    }
</style>
