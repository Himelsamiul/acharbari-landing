{{-- Section: checkout | Design 2 — Premium Skin over the proven checkout markup.
     The entire design-1 checkout (cart, coupon, district select, payment methods,
     order form — every ID/class hook) is reused verbatim inside a modern styled
     wrapper, so zero business logic or JS hooks can drift. --}}
<section class="co-v2" aria-label="checkout">
    <style>
        .co-v2 { padding: 26px 14px 40px; background:
            radial-gradient(90% 60% at 10% 0%, rgba(5,150,105,.08), transparent 60%),
            radial-gradient(90% 60% at 90% 10%, rgba(163,230,53,.1), transparent 60%),
            var(--ds-section-alt-bg, #f8fbf9); }
        .co-v2 > .ds-container,
        .co-v2 > section { max-width: 1160px; margin: 0 auto; }
        /* soften + modernize the existing panels */
        .co-v2 .max-w-6xl { box-shadow: 0 34px 70px -34px rgba(6,78,59,.45) !important; border-radius: 26px !important; border: 1.5px solid rgba(5,150,105,.22) !important; }
        .co-v2 .text-center.p-6 { background: linear-gradient(135deg, var(--ds-primary-dark), var(--ds-primary)) !important; border-radius: 24px 24px 0 0; padding: 26px 20px !important; position: relative; overflow: hidden; }
        .co-v2 .text-center.p-6::after {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background: radial-gradient(60% 90% at 85% 0%, rgba(163,230,53,.25), transparent 60%);
        }
        .co-v2 .text-center.p-6 h2 { color: #fff !important; position: relative; }
        .co-v2 .text-center.p-6 h2 .text-emerald-600 { color: var(--ds-lime-neon) !important; }
        .co-v2 .text-center.p-6 p { color: rgba(255,255,255,.82) !important; position: relative; }
        .co-v2 .lp-order-head-ic {
            background: rgba(163,230,53,.2) !important; color: var(--ds-lime-neon) !important;
            box-shadow: 0 0 0 8px rgba(163,230,53,.12); border-radius: 18px;
        }
        .co-v2 .bg-white.rounded-xl { border-radius: 18px !important; border: 1.5px solid rgba(5,150,105,.16) !important; box-shadow: 0 14px 30px -22px rgba(6,78,59,.4); transition: box-shadow .25s; }
        .co-v2 .bg-white.rounded-xl:hover { box-shadow: 0 20px 40px -22px rgba(6,78,59,.5); }
        .co-v2 .lp-cart-wrapper, .co-v2 .lp-cart-total-row.final { border-radius: 12px; }
        .co-v2 button[type="submit"] {
            background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)) !important;
            border-radius: 16px !important; box-shadow: 0 16px 32px -12px rgba(var(--ds-primary-rgb, 5,150,105), .6) !important;
            transition: transform .18s, box-shadow .25s !important;
        }
        .co-v2 button[type="submit"]:hover { transform: translateY(-2px); }
        .co-v2 .pay-opt.sel { border-color: var(--ds-primary) !important; background: rgba(5,150,105,.04) !important; }
        @media (prefers-reduced-motion: reduce) {
            .co-v2 button[type="submit"] { transition: none; }
        }
    </style>
    @include('sections.checkout.design-1')
</section>
