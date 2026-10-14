<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pack['name_bn'] }} — {{ $pack['brand_bn'] }} | Live Demo</title>
    <meta name="description" content="{{ $pack['desc'] }}">
    {{-- demo page — search engine e store page er duplicate content dhukate na --}}
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset_v('assets/style.css') }}">
    {{-- genre theme tokens resolved per-request from ThemeLibrary — the store's
         saved theme/festive/font settings are irrelevant on a demo page --}}
    @include('partials.theme-vars', ['themeOverride' => $theme, 'fontOverride' => 'hind'])

    <script>
        /* language boot — deferred brand.js er agei saved lang set hoy,
           nahole load er somoy ek-ta text flash dekha jay (user-reported) */
        try {
            if ((localStorage.getItem('ab_lang') || 'bn') === 'en') {
                document.documentElement.setAttribute('lang', 'en');
            }
        } catch (e) { }
    </script>

    <style>
        html[lang="en"] [data-lang="bn"] { display: none; }
        html[lang="bn"] [data-lang="en"] { display: none; }
    </style>
    <script>window.AB_MODE = 'server';</script>
</head>

<body class="text-gray-800 antialiased">
    @php
        // demo brand: fictional pack brand, store logo/contacts never leak in
        $settings['logo_path'] = '';
        $phone = ab_contact('phone');
        $wa = ab_contact('whatsapp');
        $ms = ab_contact('messenger');
        $fb = ab_contact('facebook');
    @endphp
    @php
        $navHome = ab_t('nav_home', 'হোম', 'Home');
        $navProducts = ab_t('nav_products', 'সব প্রোডাক্ট', 'All Products');
        $navWhy = ab_t('nav_why', 'কেন আমরা', 'Why Us');
        $navReviews = ab_t('nav_reviews', 'রিভিউ', 'Reviews');
        $navFaq = ab_t('nav_faq', 'প্রশ্ন-উত্তর', 'FAQ');
        $navOrder = ab_t('nav_order', 'অর্ডার করুন', 'Order Now');
        $footerTag = ab_t('footer_tag', 'অনলাইনে অর্ডার করুন — ক্যাশ অন ডেলিভারিতে সারা বাংলাদেশে হোম ডেলিভারি।', 'Order online — home delivery across Bangladesh on Cash on Delivery.');
        $footerLinksH = ab_t('footer_col_links', 'কুইক লিংক', 'Quick Links');
        $footerContactH = ab_t('footer_col_contact', 'যোগাযোগ ও সাপোর্ট', 'Contact & Support');
        $footerFb = ab_t('footer_fb', 'ফেসবুক পেজ', 'Facebook Page');
        $footerRights = ab_t('footer_rights', 'সর্বস্বত্ব সংরক্ষিত', 'All rights reserved');
        $footerMade = ab_t('footer_made', 'Made with love by', 'Made with love by');
    @endphp

    {{-- demo pages always render design-1, all sections on — the store's
         section_designs/sections_hidden settings don't apply here --}}
    @include('sections.navbar.design-1')

    @yield('content')

    @include('sections.footer.design-1')

    {{-- subtle fixed link back to the gallery — does not block the checkout UX --}}
    <a href="{{ route('showcase.index') }}" class="sc-demo-bar" style="position:fixed;left:14px;bottom:14px;z-index:70;display:inline-flex;align-items:center;gap:8px;background:#111827;color:#fff;text-decoration:none;font-size:13px;font-weight:700;padding:9px 16px;border-radius:999px;box-shadow:0 14px 34px -12px rgba(0,0,0,.55);border:1px solid rgba(255,255,255,.18)">
        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
        <span data-en="Want this design? →">এই ডিজাইনটি নিতে চান? →</span>
    </a>

    <!-- ================= MODAL: ORDER TRACKING (demo orders are real orders) ================= -->
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
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1 2 1Z"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 17.5v-11"/></svg>
                            </span>
                            <input id="trackInvoice" type="text" placeholder="যেমন: 6ABD8E40BFBF" data-en-ph="e.g. 6ABD8E40BFBF"
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
                        <img id="qvModalImg" src="{{ asset($products->first()?->image ?: 'assets/img/genres/' . $genre . '/product-1.jpg') }}" alt="Product Preview">
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
                            <p id="qvModalMeta" class="text-xs font-semibold text-gray-500 mb-2" style="display:none"></p>
                            <p id="qvModalDesc" class="text-sm text-gray-600 mb-4 leading-relaxed" data-en="100% authentic product with the fastest delivery and easy Cash on Delivery.">
                                ১০০% খাঁটি অথেনটিক প্রোডাক্ট। দ্রুততম ডেলিভারি এবং সহজ ক্যাশ অন ডেলিভারি সুবিধাসহ।
                            </p>
                            <div class="space-y-1 text-xs text-gray-700 mb-4">
                                <div><svg class="text-emerald-600 mr-1.5" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <span data-en="Home delivery across Bangladesh">সারা বাংলাদেশে হোম ডেলিভারি</span></div>
                                <div><svg class="text-emerald-600 mr-1.5" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <span data-en="Check the parcel, then pay">পার্সেল চেক করে তারপর টাকা দিন</span></div>
                                <div><svg class="text-emerald-600 mr-1.5" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <span data-en="Broken item? Free replacement">ভাঙা পণ্যে ফ্রি রিপ্লেসমেন্ট</span></div>
                            </div>

                            {{-- ভ্যারিয়েন্ট (সাইজ) সিলেক্টর — variant thakle modal e dekhabe --}}
                            <div id="qvVariantBox" class="hidden" style="margin-bottom:16px">
                                <div style="font-size:12.5px;font-weight:800;color:#1f4234;margin-bottom:8px" data-en="Choose size:">সাইজ বাছুন:</div>
                                <div id="qvVariantGrid" style="display:flex;flex-wrap:wrap;gap:8px"></div>
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

    <style>
        /* quick-view modal er variant (size) buttons */
        #qvVariantGrid .qv-size { display:flex; flex-direction:column; align-items:center; gap:2px; cursor:pointer;
            border:2px solid rgba(5,150,105,.22); border-radius:12px; padding:8px 14px; background:#fff;
            min-width:78px; text-align:center; transition:border-color .15s, background .15s; position:relative; }
        #qvVariantGrid .qv-size:hover { border-color:#059669; }
        #qvVariantGrid .qv-size.sel { border-color:#059669; background:rgba(5,150,105,.07); }
        #qvVariantGrid .qv-size.off { opacity:.45; cursor:not-allowed; }
        #qvVariantGrid .qv-size input { position:absolute; opacity:0; pointer-events:none; }
        #qvVariantGrid .qv-size-name { font-size:13px; font-weight:800; color:#1f4234; }
        #qvVariantGrid .qv-size-price { font-size:12.5px; font-weight:700; color:#047857; }
        #qvVariantGrid .qv-size small { font-size:10px; color:#dc2626; font-weight:700; }
    </style>

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
