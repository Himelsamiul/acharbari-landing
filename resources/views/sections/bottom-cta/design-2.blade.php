{{-- Section: bottom-cta | Design 2 — Minimal Center CTA (scoped: cta-v2) --}}
@php
    $cv2a = ab_t('cta_h2a', 'আজই অর্ডার করুন — ', 'Order today — on ');
    $cv2b = ab_t('cta_h2b', 'ক্যাশ অন ডেলিভারিতে', 'Cash on Delivery');
    $cv2s = ab_t('cta_sub', 'আপনার পছন্দের জার এখনই বুক করুন, পণ্য হাতে পেয়ে দেখে মূল্য পরিশোধ করুন।', 'Book your favourite jars now — check them in hand and then pay.');
    $cv2b2 = ab_t('cta_btn', 'অর্ডার করতে চাই', 'I Want to Order');
@endphp
<section class="cta-v2">
    <div class="cta-v2__in">
        <h2 data-en="{{ $cv2a['en'] }}{{ $cv2b['en'] }}">{{ $cv2a['bn'] }}<span class="cta-v2__grad">{{ $cv2b['bn'] }}</span></h2>
        <p data-en="{{ $cv2s['en'] }}">{{ $cv2s['bn'] }}</p>
        <button onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})" class="cta-v2__btn">
            <span data-en="{{ $cv2b2['en'] }}">{{ $cv2b2['bn'] }}</span>
        </button>
        <div class="cta-v2__links">
            <a href="tel:{{ ab_contact('phone') }}">{{ ab_contact('phone') }}</a>
            <a href="https://wa.me/{{ ab_contact('whatsapp') }}" target="_blank" rel="noopener">WhatsApp</a>
            <a href="{{ route('track') }}" data-en="Order Track">অর্ডার ট্র্যাক</a>
        </div>
    </div>
</section>
<style>
    .cta-v2 { padding: 64px 20px; background: var(--ds-section-alt-bg, #f8fbf9); }
    .cta-v2__in { max-width: 640px; margin: 0 auto; text-align: center; }
    .cta-v2__in h2 { margin: 0 0 12px; font-size: clamp(23px, 3.4vw, 34px); font-weight: 800; color: #12261d; line-height: 1.35; }
    .cta-v2__grad { color: var(--ds-primary); }
    .cta-v2__in p { margin: 0 0 24px; font-size: 15px; color: #4b6357; line-height: 1.7; }
    .cta-v2__btn {
        display: inline-flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
        font-size: 16px; font-weight: 800; font-family: inherit; border: none; cursor: pointer;
        padding: 15px 42px; border-radius: 999px; box-shadow: 0 14px 30px -10px rgba(var(--ds-primary-rgb, 5,150,105), .55);
        transition: transform .18s, box-shadow .25s;
    }
    .cta-v2__btn:hover { transform: translateY(-2px); box-shadow: 0 20px 38px -12px rgba(var(--ds-primary-rgb, 5,150,105), .6); }
    .cta-v2__links { margin-top: 22px; display: flex; justify-content: center; flex-wrap: wrap; gap: 8px 22px; }
    .cta-v2__links a { font-size: 13px; font-weight: 700; color: #1f4234; text-decoration: none; border-bottom: 1.5px dashed rgba(5,150,105,.4); padding-bottom: 2px; }
    @media (prefers-reduced-motion: reduce) {
        .cta-v2__btn { transition: none; }
    }
</style>
