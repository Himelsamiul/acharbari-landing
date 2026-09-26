{{-- Section: navbar | Design 1 (extracted original) --}}
<header class="ds-header-wrap" id="dsHeaderWrap">
        <div class="ds-header-bar" id="dsHeader">
            <!-- Brand Logo -->
            <a class="ds-logo" href="#">
                <span class="ds-logo-ic">
                    @if (!empty($settings['logo_path']))
                        <img src="{{ asset($settings['logo_path']) }}" alt="logo" style="width:100%;height:100%;object-fit:cover">
                    @else
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 2.5h8"></path>
                            <path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"></path>
                            <path d="M5 10h14"></path>
                            <path d="M9.5 14.5h5"></path>
                        </svg>
                    @endif
                </span>
                <span class="ds-logo-tx">
                    <span data-lang="bn">{{ $settings['brand_bn1'] ?? 'আচার' }}<em>{{ $settings['brand_bn2'] ?? 'বাড়ি' }}</em></span>
                    <span data-lang="en">{{ $settings['brand_en1'] ?? 'Achar' }}<em>{{ $settings['brand_en2'] ?? 'Bari' }}</em></span>
                </span>
            </a>

            <!-- Central Floating Pill Navigation -->
            <nav class="ds-nav-pill-track">
                <a href="#" class="ds-nav-pill {{ ($nav ?? '') === 'home' ? 'active' : '' }}" data-en="{{ $navHome['en'] }}"
                    onclick="if (window.location.pathname !== '/') { window.location.href = '/'; return false; } window.scrollTo({top:0,behavior:'smooth'}); return false;">{{ $navHome['bn'] }}</a>
                <a href="{{ route('products') }}" class="ds-nav-pill ds-nav-pill-seller {{ ($nav ?? '') === 'products' ? 'active' : '' }}">
                    <span class="ds-beacon-dot"></span>
                    <span data-en="{{ $navProducts['en'] }}">{{ $navProducts['bn'] }}</span>
                </a>
                <a href="{{ url('/#ds-why') }}" class="ds-nav-pill {{ ($nav ?? '') === 'why' ? 'active' : '' }}" data-en="{{ $navWhy['en'] }}">{{ $navWhy['bn'] }}</a>
                <a href="{{ url('/#ds-reviews') }}" class="ds-nav-pill" data-en="{{ $navReviews['en'] }}">{{ $navReviews['bn'] }}</a>
                <a href="{{ url('/#ds-faq') }}" class="ds-nav-pill" data-en="{{ $navFaq['en'] }}">{{ $navFaq['bn'] }}</a>
                <a href="{{ route('track') }}" class="ds-nav-pill" onclick="openTrackModal();return false;">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/><path d="M11 8a3 3 0 0 1 3 3"/></svg> <span data-en="Track">ট্র্যাক</span>
                </a>
            </nav>

            <!-- Right Action Buttons -->
            <div class="ds-header-actions">
                <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                    <button type="button" class="ds-lang-btn on" data-lang-btn="bn" onclick="AB.setLang('bn')">বাং</button>
                    <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">EN</button>
                </div>
                <button class="ds-btn-order-shine" aria-label="অর্ডার করুন"
                    onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    <span data-en="{{ $navOrder['en'] }}">{{ $navOrder['bn'] }}</span>
                    <span class="ds-btn-shimmer-fx"></span>
                </button>
                <button class="ds-mobile-nav-toggle" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="মেনู">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Glass Navigation Drawer -->
        <div class="ds-mobile-drawer" id="mobileNavDrawer">
            <div class="ds-mobile-drawer-in">
                <a href="#" class="ds-mob-link active" onclick="toggleMobileNav(); window.scrollTo({top:0,behavior:'smooth'});return false;">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg> <span data-en="{{ $navHome['en'] }}">{{ $navHome['bn'] }}</span>
                </a>
                <a href="{{ route('products') }}" class="ds-mob-link ds-mob-seller" onclick="toggleMobileNav()">
                    <span class="ds-pulse-dot"></span>
                    <span data-en="{{ $navProducts['en'] }}">{{ $navProducts['bn'] }}</span>
                </a>
                <a href="{{ url("/") }}#ds-why" class="ds-mob-link" onclick="toggleMobileNav()">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> <span data-en="{{ $navWhy['en'] }}">{{ $navWhy['bn'] }}</span>
                </a>
                <a href="{{ url("/") }}#ds-reviews" class="ds-mob-link" onclick="toggleMobileNav()">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> <span data-en="{{ $navReviews['en'] }}">{{ $navReviews['bn'] }}</span>
                </a>
                <a href="{{ url("/") }}#ds-faq" class="ds-mob-link" onclick="toggleMobileNav()">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg> <span data-en="{{ $navFaq['en'] }}">{{ $navFaq['bn'] }}</span>
                </a>
                <a href="{{ route('track') }}" class="ds-mob-link" onclick="toggleMobileNav(); openTrackModal(); return false;">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/><path d="M11 8a3 3 0 0 1 3 3"/></svg> <span data-en="Track Order">অর্ডার ট্র্যাক করুন</span>
                </a>
                <div class="ds-mob-lang">
                    <div class="ds-lang-switch" role="group" aria-label="Language / ভাষা">
                        <button type="button" class="ds-lang-btn on" data-lang-btn="bn"
                            onclick="AB.setLang('bn')">বাংলা</button>
                        <button type="button" class="ds-lang-btn" data-lang-btn="en" onclick="AB.setLang('en')">English</button>
                    </div>
                </div>
                <div class="ds-mob-actions">
                    <a class="ds-btn ds-btn-block ds-btn-ghost mb-2" href="{{ route('products') }}" style="text-decoration:none"
                        onclick="toggleMobileNav();">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="{{ $navProducts['en'] }}">{{ $navProducts['bn'] }}</span>
                    </a>
                    <button class="ds-btn ds-btn-block"
                        onclick="toggleMobileNav(); document.getElementById('order-form').scrollIntoView({behavior:'smooth'});">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="{{ $navOrder['en'] }} (COD)">{{ $navOrder['bn'] }} (COD)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Backdrop: tap outside to close the drawer -->
        <div class="ds-drawer-backdrop" id="drawerBackdrop" onclick="toggleMobileNav()" aria-hidden="true"></div>
    </header>
