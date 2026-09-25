<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">

    <!-- Icons: inline stroke SVGs everywhere (Font Awesome removed — 1.3MB saved) -->

    <link rel="stylesheet" href="{{ asset_v('assets/style.css') }}">
    @include('partials.seo-meta')
    @include('partials.theme-vars')
    @include('partials.pixels')

    <style>
        html[lang="en"] [data-lang="bn"] { display: none; }
        html[lang="bn"] [data-lang="en"] { display: none; }
    </style>
    <script>window.AB_MODE = 'server';</script>
</head>

<body class="text-gray-800 antialiased" >

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
                    <span data-lang="bn">{{ $settings['brand_bn1'] }}<em>{{ $settings['brand_bn2'] }}</em></span>
                    <span data-lang="en">{{ $settings['brand_en1'] }}<em>{{ $settings['brand_en2'] }}</em></span>
                </span>
                <span class="ds-logo-pill">খাঁটি</span>
            </a>

            <!-- Central Floating Pill Navigation -->
            <nav class="ds-nav-pill-track">
                <a href="#" class="ds-nav-pill {{ ($nav ?? '') === 'home' ? 'active' : '' }}" data-en="Home"
                    onclick="if (window.location.pathname !== '/') { window.location.href = '/'; return false; } window.scrollTo({top:0,behavior:'smooth'}); return false;">হোম</a>
                <a href="{{ route('products') }}" class="ds-nav-pill ds-nav-pill-seller {{ ($nav ?? '') === 'products' ? 'active' : '' }}">
                    <span class="ds-beacon-dot"></span>
                    <span data-en="All Products">সব প্রোডাক্ট</span>
                </a>
                <a href="{{ url('/#ds-why') }}" class="ds-nav-pill {{ ($nav ?? '') === 'why' ? 'active' : '' }}" data-en="Why Us">কেন আমরা</a>
                <a href="{{ url('/#ds-reviews') }}" class="ds-nav-pill" data-en="Reviews">রিভিউ</a>
                <a href="{{ url('/#ds-faq') }}" class="ds-nav-pill" data-en="FAQ">প্রশ্ন-উত্তর</a>
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
                    <span data-en="Order Now">অর্ডার করুন</span>
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
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg> <span data-en="Home">হোম</span>
                </a>
                <a href="{{ route('products') }}" class="ds-mob-link ds-mob-seller" onclick="toggleMobileNav()">
                    <span class="ds-pulse-dot"></span>
                    <span data-en="All Products">সব প্রোডাক্ট</span>
                </a>
                <a href="{{ url("/") }}#ds-why" class="ds-mob-link" onclick="toggleMobileNav()">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> <span data-en="Why Us">কেন আমরা</span>
                </a>
                <a href="{{ url("/") }}#ds-reviews" class="ds-mob-link" onclick="toggleMobileNav()">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> <span data-en="Customer Reviews">কাস্টমার রিভিউ</span>
                </a>
                <a href="{{ url("/") }}#ds-faq" class="ds-mob-link" onclick="toggleMobileNav()">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg> <span data-en="FAQ">সাধারণ প্রশ্ন-উত্তর</span>
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
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="Browse All Products">সব প্রোডাক্ট দেখুন</span>
                    </a>
                    <button class="ds-btn ds-btn-block"
                        onclick="toggleMobileNav(); document.getElementById('order-form').scrollIntoView({behavior:'smooth'});">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="Order Now (COD)">অর্ডার করুন (COD)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Backdrop: tap outside to close the drawer -->
        <div class="ds-drawer-backdrop" id="drawerBackdrop" onclick="toggleMobileNav()" aria-hidden="true"></div>
    </header>
    @yield('content')

<footer class="lp-footer">
        <div class="lp-footer-glow"></div>
        <div class="lp-footer-in">
            <div class="lp-f-brand">
                <a class="lp-f-logo" href="#">
                    <span class="lp-f-logo-ic" data-ab-logo-slot>
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 2.5h8"></path>
                            <path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"></path>
                            <path d="M5 10h14"></path>
                            <path d="M9.5 14.5h5"></path>
                        </svg>
                    </span>
                    <span class="lp-f-logo-tx" data-ab-brand-logo>আচার<em>বাড়ি</em></span>
                </a>
                <p class="lp-f-tag" data-en="Homemade deshi pickles, honey &amp; ghee — delivered to your home across Bangladesh with Cash on Delivery.">
                    ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি — সারা বাংলাদেশে ক্যাশ অন ডেলিভারিতে হোম ডেলিভারি।</p>
                <div class="lp-f-social">
                    <a href="{{ ab_contact('facebook') }}" target="_blank" rel="noopener" aria-label="Facebook" data-brand="facebook">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="https://m.me/{{ ab_contact('messenger') }}" target="_blank" rel="noopener" aria-label="Messenger" data-brand="messenger">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    </a>
                    <a href="https://wa.me/{{ ab_contact('whatsapp') }}" target="_blank" rel="noopener" aria-label="WhatsApp" data-brand="whatsapp">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    </a>
                    <a href="tel:{{ ab_contact('phone') }}" aria-label="Hotline" data-brand="phone">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg>
                    </a>
                </div>
                <div class="lp-f-pay">
                    <span class="img-chip"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
                    <span class="img-chip"><img src="{{ asset('assets/img/pay/nagad.svg') }}" alt="Nagad"></span>
                    <span>Rocket</span>
                    <span>Upay</span>
                    <span data-en="Cash on Delivery">ক্যাশ অন ডেলিভারি</span>
                </div>
            </div>

            <div class="lp-f-col">
                <h4 data-en="Quick Links">কুইক লিংক</h4>
                <a href="{{ url('/#ds-products') }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="Products">প্রোডাক্টস</span></a>
                <a href="{{ route('products') }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="14" rx="1.5"/><rect width="7" height="7" x="3" y="14" rx="1.5"/></svg> <span data-en="All Products">সব প্রোডাক্ট</span></a>
                <a href="{{ url("/") }}#ds-why"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> <span data-en="Why Us">কেন আমরা</span></a>
                <a href="{{ url("/") }}#ds-faq"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg> <span data-en="FAQ">প্রশ্ন-উত্তর</span></a>
            </div>

            <div class="lp-f-col">
                <h4 data-en="Contact &amp; Support">যোগাযোগ ও সাপোর্ট</h4>
                <a href="tel:{{ ab_contact('phone') }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg> {{ ab_contact('phone') }}</a>
                <a href="https://wa.me/{{ ab_contact('whatsapp') }}" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg> WhatsApp</a>
                <a href="{{ ab_contact('facebook') }}" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    <span data-en="Facebook Page">ফেসবুক পেজ</span></a>
                <a href="{{ route('admin.login') }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> <span data-en="Admin Demo">অ্যাডমিন ডেমো</span></a>
            </div>
        </div>

        <div class="lp-f-bar">
            <span>© 2026 <strong data-ab-brand-name>আচারবাড়ি</strong>. <span data-en="All rights reserved">All rights
                    reserved</span></span>
            <span class="lp-f-made"><span data-en="Made with love by">Made with love by</span> <strong
                    data-ab-brand-name>আচারবাড়ি</strong> <svg class="lp-f-heart" viewBox="0 0 24 24" width="13" height="13" fill="currentColor" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg></span>
        </div>
    </footer>

    <!-- ================= MODAL: ORDER TRACKING ================= -->
    <div id="trackModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 px-4"
        onclick="if(event.target===this)closeTrackModal()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4" style="background:var(--ds-primary-dark);">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/><path d="M11 8a3 3 0 0 1 3 3"/></svg> <span data-en="Track Your Order">অর্ডার ট্র্যাক করুন</span>
                </h3>
                <button onclick="closeTrackModal()"
                    class="text-white text-2xl leading-none hover:text-emerald-400 transition">×</button>
            </div>
            <div class="p-6">
                <p class="text-gray-500 text-sm mb-5" data-en="Check the current status of your order by mobile number OR invoice ID.">
                    মোবাইল নাম্বার <strong>অথবা</strong> ইনভয়েস আইডি দিয়ে আপনার অর্ডারের বর্তমান অবস্থা জানুন।</p>
                <div id="trackFormError"
                    class="hidden bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-4"></div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" data-en="Mobile Number">মোবাইল নাম্বার</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/></svg>
                            </span>
                            <input id="trackPhone" type="number" placeholder="017xxxxxxxx"
                                class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-green-400">
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-gray-400 text-xs font-semibold">
                        <div class="flex-1 h-px bg-gray-200"></div><span data-en="OR">অথবা</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1" data-en="Invoice ID">ইনভয়েস আইডি</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 17.5v-11"/></svg>
                            </span>
                            <input id="trackInvoice" type="text" placeholder="যেমন: 54321" data-en-ph="e.g. 54321"
                                class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-green-400">
                        </div>
                    </div>
                </div>
                <button onclick="doTrack()" id="trackBtn"
                    class="mt-6 w-full py-3 rounded-lg font-bold text-base text-gray-900 transition hover:opacity-90 flex items-center justify-center gap-2"
                    style="background:var(--ds-lime-neon);">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg> <span data-en="Track Now">ট্র্যাক করুন</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Tracking Result Modal -->
    <div id="trackResultModal" class="fixed inset-0 z-[61] hidden items-center justify-center bg-black/70 px-4 py-6"
        onclick="if(event.target===this)closeTrackResult()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
            onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 sticky top-0 z-10" style="background:var(--ds-primary-dark);">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg> <span data-en="Order Details">অর্ডারের বিস্তারিত</span>
                </h3>
                <button onclick="closeTrackResult()"
                    class="text-white text-2xl leading-none hover:text-emerald-400 transition">×</button>
            </div>
            <div id="trackResultBody" class="p-4 space-y-4"></div>
        </div>
    </div>

    <!-- ================= MODAL: COMPLAINT ================= -->
    <div id="complaintModal" class="fixed inset-0 z-[62] hidden items-center justify-center bg-black/70 px-4 py-6"
        onclick="if(event.target===this)closeComplaintModal()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[92vh] overflow-y-auto"
            onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 sticky top-0 z-10 bg-red-600">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg> <span data-en="Submit a Complaint">কমপ্লেইন জমা দিন</span>
                </h3>
                <button onclick="closeComplaintModal()"
                    class="text-white text-2xl leading-none hover:text-emerald-300 transition">×</button>
            </div>
            <div class="p-6">
                <div id="complaintSuccess"
                    class="hidden mb-4 bg-green-50 border border-emerald-200 rounded-xl p-4 text-center">
                    <div class="text-emerald-600 text-3xl mb-2"><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></div>
                    <p class="text-green-700 font-semibold" data-en="Your complaint has been submitted successfully!">আপনার কমপ্লেইন সফলভাবে জমা হয়েছে!</p>
                    <p class="text-sm text-gray-500 mt-1" data-en="Our support team will contact you within 24-48 hours.">২৪-৪৮ ঘণ্টার মধ্যে আমাদের সাপোর্ট টিম আপনার সাথে যোগাযোগ করবে।
                    </p>
                    <button onclick="closeComplaintModal()"
                        class="mt-3 bg-red-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition"><span
                            data-en="Okay">ঠিক আছে</span></button>
                </div>
                <div id="complaintError"
                    class="hidden mb-4 bg-red-50 border border-red-200 rounded-xl p-3 text-sm text-red-700"></div>

                <form id="complaintForm" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                        data-en="Your Name">আপনার নাম</span> <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" id="c_name"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                    placeholder="নাম লিখুন" data-en-ph="Enter your name" required="">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                        data-en="Mobile Number">মোবাইল নম্বর</span> <span
                                        class="text-red-500">*</span></label>
                                <input type="tel" name="phone" id="c_phone"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                    placeholder="০১xxx-xxxxxx" data-en-ph="01xxx-xxxxxx" required="" maxlength="11"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                    data-en="Order ID">অর্ডার আইডি</span> <span
                                    class="text-gray-400 font-normal" data-en="(optional)">(ঐচ্ছিক)</span></label>
                            <input type="text" name="order_id" id="c_order_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                placeholder="যেমন: 12345" data-en-ph="e.g. 12345"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                    data-en="Complaint Details">কমপ্লেইনের বিবরণ</span> <span
                                    class="text-red-500">*</span></label>
                            <textarea name="description" id="c_description" rows="4"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 resize-none"
                                placeholder="আপনার সমস্যাটি বিস্তারিত লিখুন..." data-en-ph="Describe your problem in detail..." required=""></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><span
                                    data-en="Proof Photo">প্রমাণের ছবি</span> <span
                                    class="text-gray-400 font-normal" data-en="(optional)">(ঐচ্ছিক)</span></label>
                            <input type="file" name="image" id="c_image" accept="image/jpg,image/jpeg,image/png"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none">
                            <p class="text-xs text-gray-400 mt-1">jpg/jpeg/png, <span data-en="max 2MB">সর্বোচ্চ 2MB</span></p>
                        </div>
                        <button type="button" onclick="submitComplaint()" id="complaintSubmitBtn"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="22" x2="11" y1="2" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            <span id="complaintBtnText" data-en="Send Complaint">কমপ্লেইন পাঠান</span>
                        </button>
                    </div>
                </form>

                <div class="flex gap-6 mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                    <span class="flex items-center gap-1"><svg class="text-red-400" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> <span
                            data-en="Secure data">নিরাপদ ডাটা</span></span>
                    <span class="flex items-center gap-1"><svg class="text-red-400" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> <span
                            data-en="Solution within 24-48 hours">২৪-৪৮ ঘণ্টার মধ্যে সমাধান</span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL: PRODUCT QUICK VIEW ================= -->
    <div id="quickViewModal" class="ds-modal-overlay" onclick="if(event.target===this)closeQuickViewModal()">
        <div class="ds-modal-card max-w-2xl">
            <div class="ds-modal-header">
                <div class="ds-modal-title" id="qvModalTitle">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg> <span data-en="Product Details">প্রোডাক্ট বিবরণ</span>
                </div>
                <button class="ds-modal-close" onclick="closeQuickViewModal()">×</button>
            </div>
            <div class="ds-modal-body">
                <div class="ds-qv-grid">
                    <div class="ds-qv-img">
                        <img id="qvModalImg" src="{{ asset('assets/img/prod_mango.jpg') }}" alt="Product Preview">
                    </div>
                    <div class="flex flex-col justify-between">
                        <div>
                            <span id="qvModalCategory"
                                class="ds-badge-category !static inline-block mb-2"><span data-en="Category">ক্যাটাগরি</span></span>
                            <h3 id="qvModalName" class="text-xl font-bold text-gray-900 mb-2" data-en="Product Name">প্রোডাক্টের নাম</h3>
                            <div class="flex items-center gap-2 mb-3">
                                <span id="qvModalPrice" class="text-2xl font-extrabold text-emerald-600">৳০</span>
                                <del id="qvModalOldPrice" class="text-sm text-gray-400">৳০</del>
                                <span id="qvModalDiscount" class="ds-badge-discount !static ml-auto">-০%</span>
                            </div>
                            <p id="qvModalDesc" class="text-sm text-gray-600 mb-4 leading-relaxed" data-en="100% authentic product with the fastest delivery and easy Cash on Delivery.">
                                ১০০% খাঁটি অথেনটিক প্রোডাক্ট। দ্রুততম ডেলিভারি এবং সহজ ক্যাশ অন ডেলিভারি সুবিধাসহ।
                            </p>
                            <div class="space-y-1 text-xs text-gray-700 mb-4">
                                <div><svg class="text-emerald-600 mr-1.5" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <span data-en="Home delivery across Bangladesh">সারা বাংলাদেশে হোম ডেলিভারি</span></div>
                                <div><svg class="text-emerald-600 mr-1.5" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <span data-en="Check the sealed jar, then pay">সিল করা জার চেক করে মূল্য পরিশোধ</span></div>
                                <div><svg class="text-emerald-600 mr-1.5" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <span data-en="Free replacement on broken jars">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি</span></div>
                            </div>
                        </div>

                        <button id="qvOrderBtn" class="ds-btn ds-btn-block ds-btn-lg" onclick="orderFromQuickView()">
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="Order Now (Cash on Delivery)">অর্ডার করুন (ক্যাশ অন ডেলিভারি)</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= FLOATING CHAT WIDGET ================= -->
    <div class="chat-widget">
        <div class="chat-options" id="chatOptions">
            <a class="chat-btn whatsapp" href="https://wa.me/{{ ab_contact('whatsapp') }}" target="_blank" rel="noopener" aria-label="WhatsApp">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
            </a>
            <a class="chat-btn messenger" href="https://m.me/{{ ab_contact('messenger') }}" target="_blank" rel="noopener" aria-label="Messenger">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            </a>
            <a class="chat-btn hotline" href="tel:{{ ab_contact('phone') }}" aria-label="Hotline">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg>
            </a>
        </div>
        <button type="button" class="chat-toggle" id="chatToggle" aria-label="Chat with us" aria-expanded="false">
            <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/><path d="M8 12h.01"/><path d="M12 12h.01"/><path d="M16 12h.01"/></svg>
        </button>
    </div>

    <!-- ================= PAGE SCRIPTS ================= -->
    <script src="{{ asset_v('assets/brand.js') }}" defer></script>
    <script src="{{ asset_v('assets/script.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.AB) AB.applyLang();
        });
    </script>
</body>
</html>
