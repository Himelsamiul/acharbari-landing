{{-- Section: bottom-cta | Design 3 — Floating Card CTA (scoped: cta-v3) --}}
@php
    $c3a = ab_t('cta_h2a', 'আজই অর্ডার করুন — ', 'Order today — on ');
    $c3b = ab_t('cta_h2b', 'ক্যাশ অন ডেলিভারিতে', 'Cash on Delivery');
    $c3s = ab_t('cta_sub', 'আপনার পছন্দের জার এখনই বুক করুন, পণ্য হাতে পেয়ে দেখে মূল্য পরিশোধ করুন।', 'Book your favourite jars now — check them in hand and then pay.');
    $c3btn = ab_t('cta_btn', 'অর্ডার করতে চাই', 'I Want to Order');
@endphp
<section class="cta-v3">
    <div class="cta-v3__card">
        <span class="cta-v3__pill" data-en="Cash on Delivery">ক্যাশ অন ডেলিভারি</span>
        <h2 data-en="{{ $c3a['en'] }}{{ $c3b['en'] }}">{{ $c3a['bn'] }}{{ $c3b['bn'] }}</h2>
        <p data-en="{{ $c3s['en'] }}">{{ $c3s['bn'] }}</p>
        <button onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})" class="cta-v3__btn">
            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            <span data-en="{{ $c3btn['en'] }}">{{ $c3btn['bn'] }}</span>
        </button>
    </div>
</section>
<style>
    .cta-v3 { padding: 46px 20px 58px; background: var(--ds-primary-dark); }
    .cta-v3__card {
        max-width: 660px; margin: 0 auto; text-align: center;
        background: #fff; border-radius: 26px; padding: 40px 34px 36px;
        box-shadow: 0 30px 60px -24px rgba(0,0,0,.45);
        transform: translateY(18px);
    }
    .cta-v3__pill {
        display: inline-block; font-size: 11px; font-weight: 800; letter-spacing: .8px; text-transform: uppercase;
        color: var(--ds-primary); background: rgba(var(--ds-primary-rgb, 5,150,105), .1);
        border-radius: 999px; padding: 5px 14px; margin-bottom: 14px;
    }
    .cta-v3__card h2 { margin: 0 0 10px; font-size: clamp(21px, 3vw, 30px); font-weight: 800; color: #12261d; line-height: 1.35; }
    .cta-v3__card p { margin: 0 0 24px; font-size: 14px; color: #4b6357; line-height: 1.65; }
    .cta-v3__btn {
        display: inline-flex; align-items: center; gap: 9px;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
        font-size: 15.5px; font-weight: 800; font-family: inherit; border: none; cursor: pointer;
        padding: 14px 36px; border-radius: 14px; box-shadow: 0 14px 28px -10px rgba(var(--ds-primary-rgb, 5,150,105), .55);
        transition: transform .18s;
    }
    .cta-v3__btn:hover { transform: translateY(-2px); }
    @media (prefers-reduced-motion: reduce) {
        .cta-v3__btn { transition: none; }
    }
</style>
