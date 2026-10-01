{{-- Section: reviews | Design 4 — Soft Light Quote Cards (scoped: rv-v4, static grid, no swiper)
     Same content keys as design-1/3: reviews_eyebrow, reviews_h2a/b, reviews_items --}}
@php
    $rv4head = ab_t('reviews_eyebrow', 'গ্রাহকদের মতামত', 'Customer Opinions');
    $rv4tbn = ab_t('reviews_h2a', 'কাস্টমারদের ', "Our customers' ")['bn'] . ab_t('reviews_h2b', 'সন্তুষ্টির রিভিউ', 'Satisfaction Reviews')['bn'];
    $rv4ten = ab_t('reviews_h2a', 'কাস্টমারদের ', "Our customers' ")['en'] . ab_t('reviews_h2b', 'সন্তুষ্টির রিভিউ', 'Satisfaction Reviews')['en'];
    $rv4cards = ab_json('reviews_items', ab_reviews_default());
    $rv4star = '<svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
@endphp
<section id="ds-reviews" class="rv-v4">
    <div class="rv-v4__in">
        <span class="rv-v4__eyebrow" data-en="{{ $rv4head['en'] }}">{{ $rv4head['bn'] }}</span>
        <h2 class="rv-v4__h2"><span data-en="{{ $rv4tbn }}">{{ $rv4tbn }}</span></h2>
        <div class="rv-v4__grid">
            @foreach ($rv4cards as $rev)
                <article class="rv-v4__card">
                    <span class="rv-v4__mark">"</span>
                    <div class="rv-v4__stars">{!! str_repeat($rv4star, (int) ($rev['stars'] ?? 5)) !!}</div>
                    <p data-en="{{ $rev['text_en'] ?? '' }}">{{ $rev['text_bn'] ?? '' }}</p>
                    <div class="rv-v4__who">
                        <span class="rv-v4__ava">{{ mb_substr(trim($rev['name'] ?? ''), 0, 1) }}</span>
                        <div>
                            <b>{{ $rev['name'] ?? '' }}</b>
                            <small data-en="{{ $rev['loc_en'] ?? '' }}">{{ $rev['loc_bn'] ?? '' }}</small>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
<style>
    .rv-v4 { padding: 56px 20px; background: linear-gradient(180deg, #fff, #f4faf6); }
    .rv-v4__in { max-width: 1120px; margin: 0 auto; }
    .rv-v4__eyebrow { display: block; text-align: center; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .rv-v4__h2 { margin: 0 auto 30px; text-align: center; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; }
    .rv-v4__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr)); gap: 16px; }
    .rv-v4__card {
        position: relative; background: #fff; border: 1.5px solid rgba(5,150,105,.13);
        border-radius: 18px; padding: 22px 20px 18px; box-shadow: 0 14px 30px -24px rgba(6,78,59,.35);
        transition: transform .18s ease, box-shadow .25s ease;
    }
    .rv-v4__card:hover { transform: translateY(-4px); box-shadow: 0 26px 44px -28px rgba(6,78,59,.45); }
    .rv-v4__mark {
        position: absolute; top: 2px; right: 16px; font-size: 64px; line-height: 1;
        color: rgba(5,150,105,.16); font-family: Georgia, serif;
    }
    .rv-v4__stars { color: #f59e0b; letter-spacing: 2px; margin-bottom: 10px; }
    .rv-v4__card p { margin: 0 0 16px; font-size: 13px; line-height: 1.75; color: #41564b; }
    .rv-v4__who { display: flex; align-items: center; gap: 10px; }
    .rv-v4__ava {
        width: 38px; height: 38px; border-radius: 50%; display: grid; place-items: center;
        font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent));
    }
    .rv-v4__who b { display: block; font-size: 12.5px; color: #12261d; }
    .rv-v4__who small { font-size: 10.5px; color: #8b7355; }
</style>
