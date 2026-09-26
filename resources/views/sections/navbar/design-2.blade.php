{{-- Section: navbar | Design 2 — Centered Brand (scoped: nv-v2)
     Same JS hooks as design-1: #dsHeaderWrap #dsHeader #mobileNavToggle #mobileNavDrawer #drawerBackdrop toggleMobileNav() AB.setLang() --}}
@php
    $nvHome = ab_t('nav_home', 'হোম', 'Home');
    $nvProducts = ab_t('nav_products', 'সব প্রোডাক্ট', 'All Products');
    $nvWhy = ab_t('nav_why', 'কেন আমরা', 'Why Us');
    $nvReviews = ab_t('nav_reviews', 'রিভিউ', 'Reviews');
    $nvFaq = ab_t('nav_faq', 'প্রশ্ন-উত্তর', 'FAQ');
    $navOrder2 = ab_t('nav_order', 'অর্ডার করুন', 'Order Now');
    $nav = $nav ?? '';
@endphp
<header class="nv-v2" id="dsHeaderWrap">
    <div class="nv-v2__top" id="dsHeader">
        <a class="nv-v2__logo" href="#">
            <span class="nv-v2__logo-ic">
                @if (!empty($settings['logo_path']))
                    <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                @else
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                @endif
            </span>
            <span class="nv-v2__brand">
                <span data-lang="bn">{{ $settings['brand_bn1'] }}<em>{{ $settings['brand_bn2'] }}</em></span>
                <span data-lang="en">{{ $settings['brand_en1'] }}<em>{{ $settings['brand_en2'] }}</em></span>
            </span>
        </a>

        <nav class="nv-v2__nav" aria-label="main">
            <a href="#" class="nv-v2__link {{ $nav === 'home' ? 'active' : '' }}" data-en="{{ $nvHome['en'] }}"
                onclick="if (window.location.pathname !== '/') { window.location.href = '/'; return false; } window.scrollTo({top:0,behavior:'smooth'}); return false;">{{ $nvHome['bn'] }}</a>
            <a href="{{ route('products') }}" class="nv-v2__link {{ $nav === 'products' ? 'active' : '' }}" data-en="{{ $nvProducts['en'] }}">{{ $nvProducts['bn'] }}</a>
            <a href="{{ url('/#ds-why') }}" class="nv-v2__link" data-en="{{ $nvWhy['en'] }}">{{ $nvWhy['bn'] }}</a>
            <a href="{{ url('/#ds-reviews') }}" class="nv-v2__link" data-en="{{ $nvReviews['en'] }}">{{ $nvReviews['bn'] }}</a>
            <a href="{{ url('/#ds-faq') }}" class="nv-v2__link" data-en="{{ $nvFaq['en'] }}">{{ $nvFaq['bn'] }}</a>
        </nav>

        <div class="nv-v2__actions">
            <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাং</button>
                <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">EN</button>
            </div>
            <button class="nv-v2__order" onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})" data-en="{{ $navOrder2['en'] }}">{{ $navOrder2['bn'] }}</button>
            <button class="ds-mobile-nav-toggle nv-v2__burger" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="মেনু">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>

    <nav class="nv-v2__subnav" aria-label="quick links">
        <a href="{{ url('/#ds-why') }}" data-en="{{ $nvWhy['en'] }}">{{ $nvWhy['bn'] }}</a>
        <span aria-hidden="true">•</span>
        <a href="{{ url('/#ds-reviews') }}" data-en="{{ $nvReviews['en'] }}">{{ $nvReviews['bn'] }}</a>
        <span aria-hidden="true">•</span>
        <a href="{{ url('/#ds-faq') }}" data-en="{{ $nvFaq['en'] }}">{{ $nvFaq['bn'] }}</a>
        <span aria-hidden="true">•</span>
        <a href="{{ route('track') }}" data-en="Order Track">অর্ডার ট্র্যাক</a>
    </nav>

    <div class="ds-mobile-drawer" id="mobileNavDrawer">
        <div class="ds-mobile-drawer-in">
            <a href="#" class="ds-mob-link active" onclick="toggleMobileNav(); window.scrollTo({top:0,behavior:'smooth'});return false;">
                <span data-en="{{ $nvHome['en'] }}">{{ $nvHome['bn'] }}</span>
            </a>
            <a href="{{ route('products') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $nvProducts['en'] }}">{{ $nvProducts['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-why') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $nvWhy['en'] }}">{{ $nvWhy['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-reviews') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $nvReviews['en'] }}">{{ $nvReviews['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-faq') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $nvFaq['en'] }}">{{ $nvFaq['bn'] }}</span>
            </a>
            <div class="ds-mob-lang">
                <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                    <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাংলা</button>
                    <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">English</button>
                </div>
            </div>
            <div class="ds-mob-actions">
                <button class="ds-btn ds-btn-block" onclick="toggleMobileNav(); document.getElementById('order-form').scrollIntoView({behavior:'smooth'});">
                    <span data-en="{{ $navOrder2['en'] }} (COD)">{{ $navOrder2['bn'] }} (COD)</span>
                </button>
            </div>
        </div>
    </div>
    <div class="ds-drawer-backdrop" id="drawerBackdrop" onclick="toggleMobileNav()" aria-hidden="true"></div>
</header>
<style>
    .nv-v2__top {
        display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 14px;
        max-width: 1200px; margin: 0 auto; padding: 14px 20px 6px;
    }
    .nv-v2__logo { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: inherit; justify-self: start; }
    .nv-v2__logo-ic {
        width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center; overflow: hidden;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
        box-shadow: 0 8px 18px -8px rgba(var(--ds-accent-rgb, 16,185,129), .55);
    }
    .nv-v2__logo-ic img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 3px; box-sizing: border-box; }
    .nv-v2__brand { font-size: 19px; font-weight: 800; }
    .nv-v2__brand em { font-style: normal; color: var(--ds-accent); }
    .nv-v2__nav { display: flex; gap: 4px; justify-content: center; }
    .nv-v2__link {
        text-decoration: none; color: #1f4234; font-size: 13px; font-weight: 700;
        padding: 8px 13px; border-radius: 999px; transition: background .2s, color .2s;
    }
    .nv-v2__link:hover { background: rgba(5,150,105,.08); color: var(--ds-primary); }
    .nv-v2__link.active { background: var(--ds-primary); color: #fff; }
    .nv-v2__actions { display: flex; gap: 10px; align-items: center; justify-self: end; }
    .nv-v2__order {
        border: none; cursor: pointer; font-family: inherit; font-size: 13px; font-weight: 800;
        color: #fff; background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent));
        padding: 10px 20px; border-radius: 999px;
        box-shadow: 0 10px 22px -8px rgba(var(--ds-primary-rgb, 5,150,105), .55);
        transition: transform .18s;
    }
    .nv-v2__order:hover { transform: translateY(-1px); }
    .nv-v2__burger { display: none; }
    .nv-v2__subnav {
        display: flex; gap: 12px; justify-content: center; align-items: center;
        padding: 4px 20px 12px; font-size: 12px; font-weight: 700; color: #4b6357;
    }
    .nv-v2__subnav a { color: #4b6357; text-decoration: none; }
    .nv-v2__subnav a:hover { color: var(--ds-primary); }
    @media (max-width: 980px) {
        .nv-v2__nav { display: none; }
        .nv-v2__burger { display: inline-flex; }
        .nv-v2__subnav { display: none; }
        .nv-v2__top { grid-template-columns: auto 1fr; }
        .nv-v2__actions { justify-self: end; }
    }
    @media (prefers-reduced-motion: reduce) {
        .nv-v2__order { transition: none; }
    }
</style>
