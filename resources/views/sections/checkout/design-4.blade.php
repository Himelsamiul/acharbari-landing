{{-- Section: checkout | Design 4 — Dark Premium Skin (scoped restyle of the proven design-1 checkout)
     Same hooks as design-1/2/3: cart, coupon, district select, payment methods, order form --}}
<section class="co-v4" aria-label="checkout">
    <style>
        .co-v4 { padding: 34px 14px 46px; background: radial-gradient(80% 50% at 50% 0%, rgba(4,78,59,.16), transparent 65%), #f5f8f6; }
        .co-v4 > .ds-container,
        .co-v4 > section { max-width: 1160px; margin: 0 auto; }
        .co-v4 .max-w-6xl {
            border: 1.5px solid rgba(4,78,59,.25) !important; border-radius: 24px !important;
            box-shadow: 0 34px 70px -34px rgba(4,78,59,.5) !important; overflow: hidden;
        }
        .co-v4 .text-center.p-6 {
            background: linear-gradient(135deg, #022c22, #064e3b) !important;
            border-radius: 24px 24px 0 0 !important; padding: 28px 20px !important; position: relative;
        }
        .co-v4 .text-center.p-6::before {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background: radial-gradient(70% 100% at 20% 0%, rgba(163,230,53,.16), transparent 60%);
        }
        .co-v4 .text-center.p-6 h2 { color: #fff !important; position: relative; letter-spacing: -.2px; }
        .co-v4 .text-center.p-6 p { color: rgba(255,255,255,.75) !important; position: relative; }
        .co-v4 .bg-white.rounded-xl,
        .co-v4 .bg-white { border-radius: 18px !important; }
        .co-v4 button[type="submit"] {
            background: linear-gradient(135deg, #022c22, #047857) !important;
            border-radius: 14px !important; font-weight: 800 !important;
            box-shadow: 0 18px 34px -14px rgba(4,78,59,.65) !important; transition: transform .18s, box-shadow .25s !important;
        }
        .co-v4 button[type="submit"]:hover { transform: translateY(-2px); box-shadow: 0 24px 42px -16px rgba(4,78,59,.75) !important; }
        .co-v4 .pay-opt.sel { border-color: #047857 !important; background: rgba(4,78,59,.03) !important; }
        .co-v4 .status-select, .co-v4 .a-input, .co-v4 select, .co-v4 input[type="text"], .co-v4 input[type="tel"] { border-radius: 12px !important; }
    </style>
    @include('sections.checkout.design-1')
</section>
