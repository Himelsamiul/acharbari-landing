{{-- Section: navbar | Design 5 — Slim Glass Pill Bar (scoped: nv-v5)
     Same hooks as design-1/2/3/4: #dsHeaderWrap #dsHeader #mobileNavToggle #mobileNavDrawer #drawerBackdrop toggleMobileNav() AB.setLang() --}}
@php
    $n5Home = ab_t('nav_home', 'হোম', 'Home');
    $n5Products = ab_t('nav_products', 'সব প্রোডাক্ট', 'All Products');
    $n5Why = ab_t('nav_why', 'কেন আমরা', 'Why Us');
    $n5Reviews = ab_t('nav_reviews', 'রিভিউ', 'Reviews');
    $n5Faq = ab_t('nav_faq', 'প্রশ্ন-উত্তর', 'FAQ');
    $n5Order = ab_t('nav_order', 'অর্ডার করুন', 'Order Now');
    $nav5 = $nav ?? '';
@endphp
<header class="nv-v5" id="dsHeaderWrap">
    <div class="nv-v5__wrap" id="dsHeader">
        <a class="nv-v5__logo" href="#">
            <span class="nv-v5__logo-ic">
                @if (!empty($settings['logo_path']))
                    <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                @else
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                @endif
            </span>
            <span class="nv-v5__brand">
                <span data-lang="bn">{{ $settings['brand_bn1'] }}<em>{{ $settings['brand_bn2'] }}</em></span>
                <span data-lang="en">{{ $settings['brand_en1'] }}<em>{{ $settings['brand_en2'] }}</em></span>
            </span>
        </a>

        <nav class="nv-v5__nav" aria-label="main">
            <a href="#" class="nv-v5__link {{ $nav5 === 'home' ? 'active' : '' }}" data-en="{{ $n5Home['en'] }}"
                onclick="if (window.location.pathname !== '/') { window.location.href = '/'; return false; } window.scrollTo({top:0,behavior:'smooth'}); return false;">{{ $n5Home['bn'] }}</a>
            <a href="{{ route('products') }}" class="nv-v5__link {{ $nav5 === 'products' ? 'active' : '' }}" data-en="{{ $n5Products['en'] }}">{{ $n5Products['bn'] }}</a>
            <a href="{{ url('/#ds-why') }}" class="nv-v5__link" data-en="{{ $n5Why['en'] }}">{{ $n5Why['bn'] }}</a>
            <a href="{{ url('/#ds-reviews') }}" class="nv-v5__link" data-en="{{ $n5Reviews['en'] }}">{{ $n5Reviews['bn'] }}</a>
            <a href="{{ url('/#ds-faq') }}" class="nv-v5__link" data-en="{{ $n5Faq['en'] }}">{{ $n5Faq['bn'] }}</a>
        </nav>

        <div class="nv-v5__right">
            <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাং</button>
                <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">EN</button>
            </div>
            <button class="nv-v5__cta" onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})" data-en="{{ $n5Order['en'] }}">{{ $n5Order['bn'] }}</button>
            <button class="ds-mobile-nav-toggle nv-v5__burger" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="মেনু">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>

    <div class="ds-mobile-drawer" id="mobileNavDrawer">
        <div class="ds-mobile-drawer-in">
            <a href="#" class="ds-mob-link active" onclick="toggleMobileNav(); window.scrollTo({top:0,behavior:'smooth'});return false;">
                <span data-en="{{ $n5Home['en'] }}">{{ $n5Home['bn'] }}</span>
            </a>
            <a href="{{ route('products') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n5Products['en'] }}">{{ $n5Products['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-why') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n5Why['en'] }}">{{ $n5Why['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-reviews') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n5Reviews['en'] }}">{{ $n5Reviews['bn'] }}</span>
            </a>
            <a href="{{ url('/#ds-faq') }}" class="ds-mob-link" onclick="toggleMobileNav()">
                <span data-en="{{ $n5Faq['en'] }}">{{ $n5Faq['bn'] }}</span>
            </a>
            <div class="ds-mob-lang">
                <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                    <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাংলা</button>
                    <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">English</button>
                </div>
            </div>
            <div class="ds-mob-actions">
                <button class="ds-btn ds-btn-block" onclick="toggleMobileNav(); document.getElementById('order-form').scrollIntoView({behavior:'smooth'});">
                    <span data-en="{{ $n5Order['en'] }} (COD)">{{ $n5Order['bn'] }} (COD)</span>
                </button>
            </div>
        </div>
    </div>
    <div class="ds-drawer-backdrop" id="drawerBackdrop" onclick="toggleMobileNav()" aria-hidden="true"></div>
</header>
<style>
    .nv-v5__wrap {
        display: flex; align-items: center; justify-content: space-between; gap: 14px;
        max-width: 1160px; margin: 10px auto 0; padding: 10px 12px 10px 16px;
        background: rgba(255,255,255,.82); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
        border: 1.5px solid rgba(5,150,105,.18); border-radius: 16px;
        box-shadow: 0 14px 34px -20px rgba(6,78,59,.4);
    }
    .nv-v5__logo { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: inherit; }
    .nv-v5__logo-ic {
        width: 34px; height: 34px; border-radius: 10px; display: grid; place-items: center; overflow: hidden;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
    }
    .nv-v5__logo-ic img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 2px; box-sizing: border-box; }
    .nv-v5__brand { font-size: 16px; font-weight: 800; }
    .nv-v5__brand em { font-style: normal; color: var(--ds-accent); }
    .nv-v5__nav { display: flex; gap: 4px; }
    .nv-v5__link {
        text-decoration: none; color: #33443c; font-size: 12.5px; font-weight: 700;
        padding: 7px 12px; border-radius: 999px; transition: background .18s, color .18s;
    }
    .nv-v5__link:hover { background: rgba(5,150,105,.09); color: var(--ds-primary); }
    .nv-v5__link.active { background: var(--ds-primary); color: #fff; }
    .nv-v5__right { display: flex; align-items: center; gap: 9px; }
    .nv-v5__cta {
        border: 0; cursor: pointer; font-family: inherit;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
        font-size: 12.5px; font-weight: 800; padding: 9px 18px; border-radius: 999px;
        box-shadow: 0 10px 20px -10px rgba(5,150,105,.6); transition: transform .18s, box-shadow .25s;
    }
    .nv-v5__cta:hover { transform: translateY(-1px); box-shadow: 0 14px 26px -10px rgba(5,150,105,.7); }
    .nv-v5__burger { display: none; }
    @media (max-width: 980px) {
        .nv-v5__nav { display: none; }
        .nv-v5__burger { display: inline-flex; }
    }
</style>
