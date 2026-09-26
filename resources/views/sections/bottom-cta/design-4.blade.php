{{-- Section: bottom-cta | Design 4 — Gradient-Border Glass CTA (scoped: cta-v4) --}}
@php
    $c4a = ab_t('cta_h2a', 'আজই অর্ডার করুন — ', 'Order today — on ');
    $c4b = ab_t('cta_h2b', 'ক্যাশ অন ডেলিভারিতে', 'Cash on Delivery');
    $c4s = ab_t('cta_sub', 'আপনার পছন্দের জার এখনই বুক করুন, পণ্য হাতে পেয়ে দেখে মূল্য পরিশোধ করুন।', 'Book your favourite jars now — check them in hand and then pay.');
    $c4btn = ab_t('cta_btn', 'অর্ডার করতে চাই', 'I Want to Order');
@endphp
<section class="cta-v4">
    <div class="cta-v4__card">
        <h2><span data-en="{{ $c4a['en'] }}">{{ $c4a['bn'] }}</span><em data-en="{{ $c4b['en'] }}">{{ $c4b['bn'] }}</em></h2>
        <p data-en="{{ $c4s['en'] }}">{{ $c4s['bn'] }}</p>
        <button onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
            <span data-en="{{ $c4btn['en'] }}">{{ $c4btn['bn'] }}</span>
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>
    </div>
</section>
<style>
    .cta-v4 { padding: 54px 20px; background: var(--ds-section-alt-bg, #f8fbf9); }
    .cta-v4__card {
        max-width: 760px; margin: 0 auto; text-align: center;
        background: rgba(255,255,255,.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 2px solid transparent; border-radius: 26px; padding: 40px 34px;
        background-clip: padding-box;
        position: relative;
        box-shadow: 0 30px 60px -30px rgba(6,78,59,.35);
    }
    .cta-v4__card::before {
        content: ''; position: absolute; inset: -2px; z-index: -1; border-radius: 28px;
        background: linear-gradient(120deg, var(--ds-primary), var(--ds-lime-neon), var(--ds-accent));
    }
    .cta-v4__card h2 { margin: 0 0 10px; font-size: clamp(22px, 3.2vw, 33px); font-weight: 800; color: #12261d; line-height: 1.3; }
    .cta-v4__card em { font-style: normal; color: var(--ds-primary); }
    .cta-v4__card p { margin: 0 0 24px; font-size: 14.5px; color: #4b6357; line-height: 1.7; }
    .cta-v4__card button {
        display: inline-flex; align-items: center; gap: 9px; cursor: pointer; font-family: inherit;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
        font-size: 15px; font-weight: 800; border: none; border-radius: 999px; padding: 14px 34px;
        box-shadow: 0 16px 32px -12px rgba(var(--ds-primary-rgb, 5,150,105), .6);
        transition: transform .18s, box-shadow .25s;
    }
    .cta-v4__card button:hover { transform: translateY(-2px); }
    @media (prefers-reduced-motion: reduce) {
        .cta-v4__card button { transition: none; }
    }
</style>
