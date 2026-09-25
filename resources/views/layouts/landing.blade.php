<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ')</title>

    <meta name="robots" content="index, follow">
    <meta name="author" content="AcharBari">
    <meta name="description"
        content="আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার, মধু, ঘি ও চাটনির বিশ্বস্ত অনলাইন শপ। প্রিজারভেটিভ মুক্ত ১০০% খাঁটি পণ্য ক্যাশ অন ডেলিভারিতে ঘরে বসে নিন।">
    <meta name="keywords"
        content="AcharBari, আচারবাড়ি, deshi achar online, mango pickle BD, আচার কিনুন, homemade pickle Bangladesh, Cash on Delivery.">

    <meta property="og:type" content="website">
    <meta property="og:title" content="আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ">
    <meta property="og:description"
        content="ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি এখন অর্ডার করুন ক্যাশ অন ডেলিভারিতে।">
    <meta property="og:site_name" content="AcharBari">
    <meta property="og:locale" content="bn_BD">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ">
    <meta name="twitter:description" content="খাঁটি দেশি আচার ও প্রিজার্ভ ক্যাশ অন ডেলিভারিতে ঘরে বসে অর্ডার করুন।">
    <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome 6.5.1 (fonts inlined as base64 — works via file:// too) -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome.min.css?v=5') }}">

    <link rel="stylesheet" href="{{ asset('assets/style.css?v=24') }}">
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
                    <i class="fa-solid fa-cart-shopping"></i>
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
                    <i class="fa-solid fa-house"></i> <span data-en="Home">হোম</span>
                </a>
                <a href="{{ route('products') }}" class="ds-mob-link ds-mob-seller" onclick="toggleMobileNav()">
                    <span class="ds-pulse-dot"></span>
                    <span data-en="All Products">সব প্রোডাক্ট</span>
                </a>
                <a href="#ds-why" class="ds-mob-link" onclick="toggleMobileNav()">
                    <i class="fa-solid fa-shield-halved"></i> <span data-en="Why Us">কেন আমরা</span>
                </a>
                <a href="#ds-reviews" class="ds-mob-link" onclick="toggleMobileNav()">
                    <i class="fa-solid fa-star"></i> <span data-en="Customer Reviews">কাস্টমার রিভিউ</span>
                </a>
                <a href="#ds-faq" class="ds-mob-link" onclick="toggleMobileNav()">
                    <i class="fa-solid fa-circle-question"></i> <span data-en="FAQ">সাধারণ প্রশ্ন-উত্তর</span>
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
                        <i class="fa-solid fa-jar"></i> <span data-en="Browse All Products">সব প্রোডাক্ট দেখুন</span>
                    </a>
                    <button class="ds-btn ds-btn-block"
                        onclick="toggleMobileNav(); document.getElementById('order-form').scrollIntoView({behavior:'smooth'});">
                        <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now (COD)">অর্ডার করুন (COD)</span>
                    </button>
                </div>
            </div>
        </div>
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
                    <a href="https://facebook.com/" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://m.me/AcharBari" target="_blank" rel="noopener" aria-label="Messenger"><i class="fa-brands fa-facebook-messenger"></i></a>
                    <a href="https://wa.me/8801707373692" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="tel:01707373692" aria-label="Hotline"><i class="fa-solid fa-phone"></i></a>
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
                <a href="{{ url('/#ds-products') }}"><i class="fa-solid fa-jar"></i> <span data-en="Products">প্রোডাক্টস</span></a>
                <a href="{{ route('products') }}"><i class="fa-solid fa-jar"></i> <span data-en="All Products">সব প্রোডাক্ট</span></a>
                <a href="#ds-why"><i class="fa-solid fa-shield-halved"></i> <span data-en="Why Us">কেন আমরা</span></a>
                <a href="#ds-faq"><i class="fa-solid fa-circle-question"></i> <span data-en="FAQ">প্রশ্ন-উত্তর</span></a>
            </div>

            <div class="lp-f-col">
                <h4 data-en="Contact &amp; Support">যোগাযোগ ও সাপোর্ট</h4>
                <a href="tel:01707373692"><i class="fa-solid fa-phone"></i> 01707373692</a>
                <a href="https://wa.me/8801707373692" target="_blank" rel="noopener"><i
                        class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                <a href="https://facebook.com/" target="_blank" rel="noopener"><i class="fa-brands fa-facebook"></i>
                    <span data-en="Facebook Page">ফেসবুক পেজ</span></a>
                <a href="{{ route('admin.login') }}"><i class="fa-solid fa-user-shield"></i> <span data-en="Admin Demo">অ্যাডমিন ডেমো</span></a>
            </div>
        </div>

        <div class="lp-f-bar">
            <span>© 2026 <strong data-ab-brand-name>আচারবাড়ি</strong>. <span data-en="All rights reserved">All rights
                    reserved</span></span>
            <span><span data-en="Made with love by">Made with love by</span> <strong
                    data-ab-brand-name>আচারবাড়ি</strong> 🧡</span>
        </div>
    </footer>

    <!-- ================= MODAL: ORDER TRACKING ================= -->
    <div id="trackModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 px-4"
        onclick="if(event.target===this)closeTrackModal()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4" style="background:var(--ds-primary-dark);">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass-location"></i> <span data-en="Track Your Order">অর্ডার ট্র্যাক করুন</span>
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
                                <i class="fa-solid fa-mobile-screen-button"></i>
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
                                <i class="fa-solid fa-receipt"></i>
                            </span>
                            <input id="trackInvoice" type="text" placeholder="যেমন: 54321" data-en-ph="e.g. 54321"
                                class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-green-400">
                        </div>
                    </div>
                </div>
                <button onclick="doTrack()" id="trackBtn"
                    class="mt-6 w-full py-3 rounded-lg font-bold text-base text-gray-900 transition hover:opacity-90 flex items-center justify-center gap-2"
                    style="background:var(--ds-lime-neon);">
                    <i class="fa-solid fa-magnifying-glass"></i> <span data-en="Track Now">ট্র্যাক করুন</span>
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
                    <i class="fa-solid fa-box-open"></i> <span data-en="Order Details">অর্ডারের বিস্তারিত</span>
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
                    <i class="fa-solid fa-triangle-exclamation"></i> <span data-en="Submit a Complaint">কমপ্লেইন জমা দিন</span>
                </h3>
                <button onclick="closeComplaintModal()"
                    class="text-white text-2xl leading-none hover:text-emerald-300 transition">×</button>
            </div>
            <div class="p-6">
                <div id="complaintSuccess"
                    class="hidden mb-4 bg-green-50 border border-emerald-200 rounded-xl p-4 text-center">
                    <div class="text-emerald-600 text-3xl mb-2"><i class="fa-solid fa-circle-check"></i></div>
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
                            <i class="fa-solid fa-paper-plane"></i>
                            <span id="complaintBtnText" data-en="Send Complaint">কমপ্লেইন পাঠান</span>
                        </button>
                    </div>
                </form>

                <div class="flex gap-6 mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                    <span class="flex items-center gap-1"><i class="fa-solid fa-shield-halved text-red-400"></i> <span
                            data-en="Secure data">নিরাপদ ডাটা</span></span>
                    <span class="flex items-center gap-1"><i class="fa-solid fa-clock text-red-400"></i> <span
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
                    <i class="fa-solid fa-circle-info"></i> <span data-en="Product Details">প্রোডাক্ট বিবরণ</span>
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
                                <div><i class="fa-solid fa-check text-emerald-600 mr-1.5"></i> <span data-en="Home delivery across Bangladesh">সারা বাংলাদেশে হোম ডেলিভারি</span></div>
                                <div><i class="fa-solid fa-check text-emerald-600 mr-1.5"></i> <span data-en="Check the sealed jar, then pay">সিল করা জার চেক করে মূল্য পরিশোধ</span></div>
                                <div><i class="fa-solid fa-check text-emerald-600 mr-1.5"></i> <span data-en="Free replacement on broken jars">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি</span></div>
                            </div>
                        </div>

                        <button id="qvOrderBtn" class="ds-btn ds-btn-block ds-btn-lg" onclick="orderFromQuickView()">
                            <i class="fa-solid fa-cart-shopping"></i> <span data-en="Order Now (Cash on Delivery)">অর্ডার করুন (ক্যাশ অন ডেলিভারি)</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= FLOATING CHAT WIDGET ================= -->
    