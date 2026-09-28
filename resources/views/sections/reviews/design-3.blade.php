{{-- Section: reviews | Design 3 — Masonry Testimonial Wall (scoped: rv-v3, no swiper) --}}
@php
    $rv3head = ab_t('reviews_eyebrow', 'গ্রাহকদের মতামত', 'Customer Opinions');
    $rv3tbn = ab_t('reviews_h2a', 'কাস্টমারদের ', "Our customers' ")['bn'] . ab_t('reviews_h2b', 'সন্তুষ্টির রিভিউ', 'Satisfaction Reviews')['bn'];
    $rv3ten = ab_t('reviews_h2a', 'কাস্টমারদের ', "Our customers' ")['en'] . ab_t('reviews_h2b', 'সন্তুষ্টির রিভিউ', 'Satisfaction Reviews')['en'];
    $rv3cards = ab_json('reviews_items', ab_reviews_default());
    $rv3full = '<svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
@endphp
<section id="ds-reviews" class="rv-v3">
    <div class="rv-v3__in">
        <span class="rv-v3__eyebrow" data-en="{{ $rv3head['en'] }}">{{ $rv3head['bn'] }}</span>
        <h2 class="rv-v3__h2"><span data-en="{{ $rv3tbn }}">{{ $rv3tbn }}</span></h2>
        <div class="rv-v3__wall">
            @foreach ($rv3cards as $idx => $rev)
                <article class="rv-v3__card rv-v3__card--{{ $idx % 3 }}">
                    <span class="rv-v3__quote">“</span>
                    <p data-en="{{ $rev['text_en'] ?? '' }}">{{ $rev['text_bn'] ?? '' }}</p>
                    <div class="rv-v3__who">
                        <div class="rv-v3__ava">{{ mb_substr(trim($rev['name'] ?? ''), 0, 1) }}</div>
                        <div>
                            <b>{{ $rev['name'] ?? '' }}</b>
                            <small data-en="{{ $rev['loc_en'] ?? '' }}">{{ $rev['loc_bn'] ?? '' }}</small>
                        </div>
                        <span class="rv-v3__stars">{!! str_repeat($rv3full, (int) ($rev['stars'] ?? 5)) !!}</span>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
<style>
    .rv-v3 { padding: 56px 20px; background: var(--ds-primary-xdark); }
    .rv-v3__in { max-width: 1180px; margin: 0 auto; }
    .rv-v3__eyebrow { display: block; text-align: center; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-lime-neon); margin-bottom: 8px; }
    .rv-v3__h2 { margin: 0 auto 30px; text-align: center; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #fff; }
    .rv-v3__wall { columns: 3 300px; column-gap: 16px; }
    .rv-v3__card {
        break-inside: avoid; margin-bottom: 16px;
        background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.14);
        border-radius: 18px; padding: 20px; position: relative;
        backdrop-filter: blur(4px);
    }
    .rv-v3__card--1 { background: rgba(255,255,255,.09); }
    .rv-v3__quote {
        position: absolute; top: 6px; right: 16px; font-size: 54px; line-height: 1;
        color: var(--ds-lime-neon); opacity: .35; font-family: Georgia, serif;
    }
    .rv-v3__card p { margin: 0 0 14px; font-size: 13.5px; line-height: 1.75; color: rgba(255,255,255,.88); }
    .rv-v3__who { display: flex; align-items: center; gap: 10px; }
    .rv-v3__ava { width: 38px; height: 38px; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-weight:800; color:#047857; background:rgba(5,150,105,.12); border: 2px solid var(--ds-lime-neon); }
    .rv-v3__who b { display: block; font-size: 12.5px; color: #fff; }
    .rv-v3__who small { font-size: 10px; color: rgba(255,255,255,.55); }
    .rv-v3__stars { margin-left: auto; color: var(--ds-lime-neon); letter-spacing: 1px; }
    @media (max-width: 640px) {
        .rv-v3__wall { columns: 1; }
    }
</style>
