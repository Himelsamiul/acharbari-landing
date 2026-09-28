<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset($settings['favicon_path'] ?? 'assets/img/favicon.svg') }}" type="image/svg+xml">

    <!-- Google Fonts (base pair + any fonts picked in admin theme settings) -->
    @php
        $themeFonts = \App\Http\Controllers\Admin\ThemeLibrary::fonts();
        $googleFamilies = collect([
            $themeFonts['hind']['google'] ?? '',
            $themeFonts['jakarta']['google'] ?? '',
            $themeFonts[\App\Models\Setting::get('font_body', 'jakarta')]['google'] ?? '',
            $themeFonts[\App\Models\Setting::get('font_heading', '')]['google'] ?? '',
        ])->filter()->unique()->values()->all();
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?{{ implode('&', array_map(fn ($f) => 'family=' . $f, $googleFamilies)) }}&display=swap"
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
    @php
        // shared contact vars (navbar / footer variants / chat widget)
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
        $footerTag = ab_t('footer_tag', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি — সারা বাংলাদেশে ক্যাশ অন ডেলিভারিতে হোম ডেলিভারি।', 'Homemade deshi pickles, honey & ghee — delivered to your home across Bangladesh with Cash on Delivery.');
        $footerLinksH = ab_t('footer_col_links', 'কুইক লিংক', 'Quick Links');
        $footerContactH = ab_t('footer_col_contact', 'যোগাযোগ ও সাপোর্ট', 'Contact & Support');
        $footerFb = ab_t('footer_fb', 'ফেসবুক পেজ', 'Facebook Page');
        $footerRights = ab_t('footer_rights', 'সর্বস্বত্ব সংরক্ষিত', 'All rights reserved');
        $footerMade = ab_t('footer_made', 'Made with love by', 'Made with love by');
    @endphp

    @include(ab_section_view("navbar"))

    @yield('content')

    @include(ab_section_view("footer"))


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
                            <p id="qvModalMeta" class="text-xs font-semibold text-gray-500 mb-2" style="display:none"></p>
                            <p id="qvModalDesc" class="text-sm text-gray-600 mb-4 leading-relaxed" data-en="100% authentic product with the fastest delivery and easy Cash on Delivery.">
                                ১০০% খাঁটি অথেনটিক প্রোডাক্ট। দ্রুততম ডেলিভারি এবং সহজ ক্যাশ অন ডেলিভারি সুবিধাসহ।
                            </p>
                            <div class="space-y-1 text-xs text-gray-700 mb-4">
                                <div><svg class="text-emerald-600 mr-1.5" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <span data-en="Home delivery across Bangladesh">সারা বাংলাদেশে হোম ডেলিভারি</span></div>
                                <div><svg class="text-emerald-600 mr-1.5" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <span data-en="Check the sealed jar, then pay">সিল করা জার চেক করে মূল্য/স্টক দেখায়</span></div>
                                <div><svg class="text-emerald-600 mr-1.5" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <span data-en="Free replacement on broken jars">ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি</span></div>
                            </div>

                            {{-- ভ্যারিয়েন্ট (সাইজ) সিলেক্টর — variant thakle modal e dekhabe --}}
                            <div id="qvVariantBox" class="hidden" style="margin-bottom:16px">
                                <div style="font-size:12.5px;font-weight:800;color:#1f4234;margin-bottom:8px">সাইজ বাছুন:</div>
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

    <!-- ================= FLOATING CHAT WIDGET ================= -->
    @if ($phone !== '' || $wa !== '' || $ms !== '')
    <div class="chat-widget">
        <div class="chat-options" id="chatOptions">
            @if ($wa !== '')
            <a class="chat-btn whatsapp" href="{{ ab_social('whatsapp', 'https://wa.me/') }}" target="_blank" rel="noopener" aria-label="WhatsApp">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
            </a>
            @endif
            @if ($ms !== '')
            <a class="chat-btn messenger" href="{{ ab_social('messenger', 'https://m.me/') }}" target="_blank" rel="noopener" aria-label="Messenger">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            </a>
            @endif
            @if ($phone !== '')
            <a class="chat-btn hotline" href="tel:{{ $phone }}" aria-label="Hotline">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg>
            </a>
            @endif
        </div>
        <button type="button" class="chat-toggle" id="chatToggle" aria-label="Chat with us" aria-expanded="false">
            <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/><path d="M8 12h.01"/><path d="M12 12h.01"/><path d="M16 12h.01"/></svg>
        </button>
    </div>
    @endif

    {{-- ================= ADMIN: floating preview bar (design preview mode only) ================= --}}
    @if (request()->query('dp') !== null && auth()->check())
        <div class="ab-pvbar" id="abPvBar">
            <span class="ab-pvbar-badge"><i class="fa-solid fa-eye"></i> প্রিভিউ মোড</span>
            <span class="ab-pvbar-note">ভিজিটররা এখনো পুরনো ডিজাইন দেখছে — পছন্দ হলে সেভ করুন</span>
            <span class="ab-pvbar-actions">
                <button type="button" onclick="abPvSave(this)"><i class="fa-solid fa-floppy-disk"></i> সেভ করুন</button>
                <button type="button" class="ab-pvbar-cancel" onclick="location.href='{{ route('admin.settings.sections') }}'"><i class="fa-solid fa-xmark"></i> বাতিল</button>
            </span>
        </div>
        <style>
            .ab-pvbar {
                position: fixed; left: 50%; bottom: 14px; transform: translateX(-50%);
                z-index: 9999; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; justify-content: center;
                background: linear-gradient(135deg, #0d2b20, #064e3b); color: #fff;
                border: 1px solid rgba(163,230,53,.35); border-radius: 999px;
                padding: 10px 18px; box-shadow: 0 18px 40px -12px rgba(0,0,0,.5);
                max-width: calc(100vw - 24px); font-family: 'Hind Siliguri', sans-serif;
            }
            .ab-pvbar-badge { display: inline-flex; gap: 6px; align-items: center; font-size: 12px; font-weight: 800; color: #a3e635; white-space: nowrap; }
            .ab-pvbar-note { font-size: 11.5px; opacity: .85; }
            .ab-pvbar-actions { display: inline-flex; gap: 8px; }
            .ab-pvbar button {
                border: none; cursor: pointer; font-family: inherit; font-size: 12px; font-weight: 800;
                border-radius: 999px; padding: 8px 16px; display: inline-flex; gap: 6px; align-items: center;
                background: linear-gradient(135deg, #059669, #10b981); color: #fff;
            }
            .ab-pvbar button.ab-pvbar-cancel { background: rgba(255,255,255,.14); }
        </style>
        <script>
            function abPvConfig() {
                try {
                    var cfg = JSON.parse(decodeURIComponent(escape(atob(new URLSearchParams(location.search).get('dp')))));
                    return (cfg && typeof cfg === 'object') ? cfg : null;
                } catch (e) { return null; }
            }
            function abPvSave(btn) {
                var cfg = abPvConfig();
                if (!cfg) { alert('প্রিভিউ কনফিগ পাওয়া যায়নি।'); return; }
                btn.disabled = true;
                var fd = new FormData();
                fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                fd.append('designs', JSON.stringify(cfg));
                fetch('{{ route('admin.settings.sections.save') }}', { method: 'POST', body: fd })
                    .then(function (r) {
                        if (!r.ok) throw 0;
                        btn.innerHTML = '<i class="fa-solid fa-check"></i> সেভ হয়েছে';
                        setTimeout(function () { location.href = '{{ route('admin.settings.sections') }}'; }, 700);
                    })
                    .catch(function () { btn.disabled = false; alert('সেভ ব্যর্থ — আবার চেষ্টা করুন।'); });
            }
        </script>
    @endif

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
