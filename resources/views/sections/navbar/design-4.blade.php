{{-- Section: navbar | Design 4 — Announcement Bar + Clean Nav (scoped: nv-v4)
     Same hooks as design-1/2/3: #dsHeaderWrap #dsHeader #mobileNavToggle #mobileNavDrawer #drawerBackdrop toggleMobileNav() AB.setLang() --}}
@php
    $n4Home = ab_t('nav_home', 'হোম', 'Home');
    $n4Products = ab_t('nav_products', 'সব প্রোডাক্ট', 'All Products');
    $n4Why = ab_t('nav_why', 'কেন আমরা', 'Why Us');
    $n4Reviews = ab_t('nav_reviews', 'রিভিউ', 'Reviews');
    $n4Faq = ab_t('nav_faq', 'প্রশ্ন-উত্তর', 'FAQ');
    $n4Order = ab_t('nav_order', 'অর্ডার করুন', 'Order Now');
    $nav4 = $nav ?? '';
@endphp
<header class="nv-v4" id="dsHeaderWrap">
    <div class="nv-v4__announce">
        <span data-en="Free delivery on special offers — nationwide">বিশেষ অফারে ফ্রি ডেলিভারি — সারা দেশে</span>
    </div>
    <div class="nv-v4__bar" id="dsHeader">
        <a class="nv-v4__logo" href="#">
            <span class="nv-v4__logo-ic">
                @if (!empty($settings['logo_path']))
                    <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                @else
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                @endif
            </span>
            <span class="nv-v4__brand">
                <span data-lang="bn">{{ $settings['brand_bn1'] }}<em>{{ $settings['brand_bn2'] }}</em></span>
                <span data-lang="en">{{ $settings['brand_en1'] }}<em>{{ $settings['brand_en2'] }}</em></span>
            </span>
        </a>

        <nav class="nv-v4__nav" aria-label="main">
            <a href="#" class="nv-v4__link {{ $nav4 === 'home' ? 'active' : '' }}" data-en="{{ $n4Home['en'] }}"
                onclick="if (window.location.pathname !== '/') { window.location.href = '/'; return false; } window.scrollTo({top:0,behavior:'smooth'}); return false;">{{ $n4Home['bn'] }}</a>
            <a href="{{ route('products') }}" class="nv-v4__link {{ $nav4 === 'products' ? 'active' : '' }}" data-en="{{ $n4Products['en'] }}">{{ $n4Products['bn'] }}</a>
            <a href="{{ url('/#ds-why') }}" class="nv-v4__link" data-en="{{ $n4Why['en'] }}">{{ $n4Why['bn'] }}</a>
            <a href="{{ url('/#ds-reviews') }}" class="nv-v4__link" data-en="{{ $n4Reviews['en'] }}">{{ $n4Reviews['bn'] }}</a>
            <a href="{{ url('/#ds-faq') }}" class="nv-v4__link" data-en="{{ $n4Faq['en'] }}">{{ $n4Faq['bn'] }}</a>
        </nav>

        <div class="nv-v4__right">
            <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাং</button>
                <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">EN</button>
            </div>
            <button class="nv-v4__cta" onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})" data-en="{{ $n4Order['en'] }}">{{ $n4Order['bn'] }}</button>
            <button class="ds-mobile-nav-toggle nv-v4__burger" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="মেনু">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>

    <div class="ds-mobile-drawer" id="mobileNavDrawer">
        <div class="ds-mobile-drawer-in">
            <a href="#" class="ds-mob-link active" onclick="toggleMobileNav(); window.scrollTo({top:0,behavior:'smooth'});return false;">
                <span data-en="{{ $n4Home['en'] }}">{{ $n4Home['bn'] }}</span>
            </a>
            <a href="{{ route('products') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n4Products['en'] }}">{{ $n4Products['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-why') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n4Why['en'] }}">{{ $n4Why['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-reviews') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n4Reviews['en'] }}">{{ $n4Reviews['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-faq') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n4Faq['en'] }}">{{ $n4Faq['bn'] }}</span>
            </a>
            <div class="ds-mob-lang">
                <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                    <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাংলা</button>
                    <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">English</button>
                </div>
            </div>
            <div class="ds-mob-actions">
                <button class="ds-btn ds-btn-block" onclick="toggleMobileNav(); document.getElementById('order-form').scrollIntoView({behavior:'smooth'});">
                    <span data-en="{{ $n4Order['en'] }} (COD)">{{ $n4Order['bn'] }} (COD)</span>
                </button>
            </div>
        </div>
    </div>
    <div class="ds-drawer-backdrop" id="drawerBackdrop" onclick="toggleMobileNav()" aria-hidden="true"></div>
</header>
<style>
    .nv-v4__announce {
        background: var(--ds-primary-dark); color: rgba(255,255,255,.9);
        text-align: center; font-size: 11.5px; font-weight: 700; padding: 7px 14px; letter-spacing: .3px;
    }
    .nv-v4__bar {
        display: flex; align-items: center; justify-content: space-between; gap: 14px;
        max-width: 1200px; margin: 0 auto; padding: 13px 20px;
        border-bottom: 1.5px solid rgba(18,38,29,.07); background: #fff;
    }
    .nv-v4__logo { display: inline-flex; align-items: center; gap: 9px; text-decoration: none; color: inherit; }
    .nv-v4__logo-ic {
        width: 38px; height: 38px; border-radius: 11px; display: grid; place-items: center; overflow: hidden;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
    }
    .nv-v4__logo-ic img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 2px; box-sizing: border-box; }
    .nv-v4__brand { font-size: 18px; font-weight: 800; }
    .nv-v4__brand em { font-style: normal; color: var(--ds-accent); }
    .nv-v4__nav { display: flex; gap: 22px; }
    .nv-v4__link { text-decoration: none; color: #1f4234; font-size: 13px; font-weight: 700; position: relative; padding: 4px 0; }
    .nv-v4__link::after {
        content: ''; position: absolute; left: 0; right: 100%; bottom: -2px; height: 2px;
        background: var(--ds-primary); transition: right .25s ease;
    }
    .nv-v4__link:hover::after, .nv-v4__link.active::after { right: 0; }
    .nv-v4__link:hover, .nv-v4__link.active { color: var(--ds-primary); }
    .nv-v4__right { display: flex; align-items: center; gap: 10px; }
    .nv-v4__cta {
        border: 2px solid var(--ds-primary); background: transparent; color: var(--ds-primary);
        cursor: pointer; font-family: inherit; font-size: 12.5px; font-weight: 800;
        padding: 9px 18px; border-radius: 12px; transition: background .2s, color .2s;
    }
    .nv-v4__cta:hover { background: var(--ds-primary); color: #fff; }
    .nv-v4__burger { display: none; }
    @media (max-width: 980px) {
        .nv-v4__nav { display: none; }
        .nv-v4__burger { display: inline-flex; }
    }
    @media (prefers-reduced-motion: reduce) {
        .nv-v4__link::after, .nv-v4__cta { transition: none; }
    }
</style>
