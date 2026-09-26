{{-- Section: navbar | Design 3 — Floating Glass Minimal (scoped: nv-v3)
     Same hooks as design-1/2: #dsHeaderWrap #dsHeader #mobileNavToggle #mobileNavDrawer #drawerBackdrop toggleMobileNav() AB.setLang() --}}
@php
    $n3Home = ab_t('nav_home', 'হোম', 'Home');
    $n3Products = ab_t('nav_products', 'সব প্রোডাক্ট', 'All Products');
    $n3Why = ab_t('nav_why', 'কেন আমরা', 'Why Us');
    $n3Reviews = ab_t('nav_reviews', 'রিভিউ', 'Reviews');
    $n3Faq = ab_t('nav_faq', 'প্রশ্ন-উত্তর', 'FAQ');
    $n3Order = ab_t('nav_order', 'অর্ডার করুন', 'Order Now');
    $nav3 = $nav ?? '';
@endphp
<header class="nv-v3" id="dsHeaderWrap">
    <div class="nv-v3__bar" id="dsHeader">
        <a class="nv-v3__logo" href="#">
            <span class="nv-v3__logo-ic">
                @if (!empty($settings['logo_path']))
                    <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                @else
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                @endif
            </span>
            <span class="nv-v3__brand">
                <span data-lang="bn">{{ $settings['brand_bn1'] }}<em>{{ $settings['brand_bn2'] }}</em></span>
                <span data-lang="en">{{ $settings['brand_en1'] }}<em>{{ $settings['brand_en2'] }}</em></span>
            </span>
        </a>

        <nav class="nv-v3__nav" aria-label="main">
            <a href="#" class="nv-v3__link {{ $nav3 === 'home' ? 'active' : '' }}" data-en="{{ $n3Home['en'] }}"
                onclick="if (window.location.pathname !== '/') { window.location.href = '/'; return false; } window.scrollTo({top:0,behavior:'smooth'}); return false;">{{ $n3Home['bn'] }}</a>
            <a href="{{ route('products') }}" class="nv-v3__link {{ $nav3 === 'products' ? 'active' : '' }}" data-en="{{ $n3Products['en'] }}">{{ $n3Products['bn'] }}</a>
            <a href="{{ url('/#ds-why') }}" class="nv-v3__link" data-en="{{ $n3Why['en'] }}">{{ $n3Why['bn'] }}</a>
            <a href="{{ url('/#ds-reviews') }}" class="nv-v3__link" data-en="{{ $n3Reviews['en'] }}">{{ $n3Reviews['bn'] }}</a>
            <a href="{{ url('/#ds-faq') }}" class="nv-v3__link" data-en="{{ $n3Faq['en'] }}">{{ $n3Faq['bn'] }}</a>
        </nav>

        <div class="nv-v3__right">
            <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাং</button>
                <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">EN</button>
            </div>
            <button class="nv-v3__cta" onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})" data-en="{{ $n3Order['en'] }}">{{ $n3Order['bn'] }}</button>
            <button class="ds-mobile-nav-toggle nv-v3__burger" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="মেনু">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>

    <div class="ds-mobile-drawer" id="mobileNavDrawer">
        <div class="ds-mobile-drawer-in">
            <a href="#" class="ds-mob-link active" onclick="toggleMobileNav(); window.scrollTo({top:0,behavior:'smooth'});return false;">
                <span data-en="{{ $n3Home['en'] }}">{{ $n3Home['bn'] }}</span>
            </a>
            <a href="{{ route('products') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n3Products['en'] }}">{{ $n3Products['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-why') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n3Why['en'] }}">{{ $n3Why['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-reviews') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n3Reviews['en'] }}">{{ $n3Reviews['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-faq') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n3Faq['en'] }}">{{ $n3Faq['bn'] }}</span>
            </a>
            <div class="ds-mob-lang">
                <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                    <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাংলা</button>
                    <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">English</button>
                </div>
            </div>
            <div class="ds-mob-actions">
                <button class="ds-btn ds-btn-block" onclick="toggleMobileNav(); document.getElementById('order-form').scrollIntoView({behavior:'smooth'});">
                    <span data-en="{{ $n3Order['en'] }} (COD)">{{ $n3Order['bn'] }} (COD)</span>
                </button>
            </div>
        </div>
    </div>
    <div class="ds-drawer-backdrop" id="drawerBackdrop" onclick="toggleMobileNav()" aria-hidden="true"></div>
</header>
<style>
    .nv-v3__bar {
        position: sticky; top: 12px; z-index: 90;
        max-width: 1140px; margin: 12px auto 0; padding: 10px 18px;
        display: flex; align-items: center; justify-content: space-between; gap: 14px;
        background: rgba(255,255,255,.72); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,.6); border-radius: 999px;
        box-shadow: 0 16px 38px -18px rgba(6,78,59,.45);
    }
    .nv-v3__logo { display: inline-flex; align-items: center; gap: 9px; text-decoration: none; color: inherit; }
    .nv-v3__logo-ic {
        width: 36px; height: 36px; border-radius: 50%; display: grid; place-items: center; overflow: hidden;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
    }
    .nv-v3__logo-ic img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 2px; box-sizing: border-box; }
    .nv-v3__brand { font-size: 17px; font-weight: 800; }
    .nv-v3__brand em { font-style: normal; color: var(--ds-accent); }
    .nv-v3__nav { display: flex; gap: 2px; }
    .nv-v3__link {
        text-decoration: none; color: #1f4234; font-size: 12.5px; font-weight: 700;
        padding: 7px 12px; border-radius: 999px; transition: background .2s, color .2s;
    }
    .nv-v3__link:hover { background: rgba(5,150,105,.09); color: var(--ds-primary); }
    .nv-v3__link.active { background: var(--ds-primary); color: #fff; }
    .nv-v3__right { display: flex; align-items: center; gap: 9px; }
    .nv-v3__cta {
        border: none; cursor: pointer; font-family: inherit; font-size: 12.5px; font-weight: 800;
        color: #12261d; background: var(--ds-lime-neon); padding: 9px 18px; border-radius: 999px;
        box-shadow: 0 10px 20px -8px rgba(163,230,53,.6); transition: transform .18s;
    }
    .nv-v3__cta:hover { transform: translateY(-1px); }
    .nv-v3__burger { display: none; }
    @media (max-width: 980px) {
        .nv-v3__nav { display: none; }
        .nv-v3__burger { display: inline-flex; }
    }
    @media (prefers-reduced-motion: reduce) {
        .nv-v3__cta { transition: none; }
    }
</style>
