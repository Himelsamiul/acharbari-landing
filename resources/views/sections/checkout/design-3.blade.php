{{-- Section: checkout | Design 3 — Minimal Light Skin over the proven checkout markup.
     All cart/coupon/district/payment/order hooks reused verbatim via design-1 include. --}}
<section class="co-v3" aria-label="checkout">
    <style>
        .co-v3 { padding: 30px 14px 44px; background: #fff; }
        .co-v3 > .ds-container,
        .co-v3 > section { max-width: 1160px; margin: 0 auto; }
        .co-v3 .max-w-6xl { border: none !important; box-shadow: 0 10px 60px -30px rgba(6,78,59,.25) !important; border-radius: 22px !important; }
        .co-v3 .text-center.p-6 { border-bottom: 1.5px solid rgba(18,38,29,.07) !important; }
        .co-v3 .lp-order-head-ic {
            background: rgba(18,38,29,.05) !important; color: #12261d !important; border-radius: 50%;
        }
        .co-v3 .text-center.p-6 h2 { font-weight: 800 !important; letter-spacing: -.2px; }
        .co-v3 .bg-white.rounded-xl { border: none !important; box-shadow: 0 6px 30px -18px rgba(6,78,59,.25) !important; border-radius: 20px !important; }
        .co-v3 .lp-cart-total-row.final span:last-child { color: var(--ds-primary) !important; }
        .co-v3 button[type="submit"] {
            background: #12261d !important; border-radius: 14px !important;
            box-shadow: 0 14px 30px -14px rgba(18,38,29,.6) !important; transition: transform .18s !important;
        }
        .co-v3 button[type="submit"]:hover { transform: translateY(-2px); }
        .co-v3 .pay-opt { border-radius: 14px !important; }
        @media (prefers-reduced-motion: reduce) {
            .co-v3 button[type="submit"] { transition: none; }
        }
    </style>
    @include('sections.checkout.design-1')
</section>
