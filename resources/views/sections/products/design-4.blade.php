{{-- Section: products | Design 4 — Serene Skin (scoped restyle of the proven design-1 grid)
     Same hooks/IDs preserved: #ds-products, filters, quick-view, add buttons --}}
<section class="pd-v4" id="ds-products">
    <style>
        .pd-v4 { padding: 40px 0 46px; background: linear-gradient(180deg, #fbfdfb, #f3f9f5); }
        .pd-v4 .ds-container { max-width: 1160px; }
        .pd-v4 .ds-sec-head { text-align: center; }
        .pd-v4 .ds-filter-btn {
            background: #fff; border: 1.5px solid rgba(5,150,105,.18); border-radius: 999px;
            box-shadow: 0 4px 12px -8px rgba(6,78,59,.25); transition: transform .15s, border-color .2s;
        }
        .pd-v4 .ds-filter-btn:hover { transform: translateY(-2px); border-color: var(--ds-primary); }
        .pd-v4 .ds-filter-btn.active { background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); border-color: transparent; }
        .pd-v4 .ds-product-card {
            border-radius: 20px !important; border: 1px solid rgba(5,150,105,.12) !important;
            background: #fff; overflow: hidden;
            transition: transform .2s ease, box-shadow .3s ease;
        }
        .pd-v4 .ds-product-card:hover { transform: translateY(-6px); box-shadow: 0 30px 55px -30px rgba(6,78,59,.45); }
        .pd-v4 .ds-product-media img { border-bottom-left-radius: 0; }
        .pd-v4 .ds-badge-discount, .pd-v4 .ds-badge-category { border-radius: 999px; }
    </style>
    @include('sections.products.design-1')
</section>
