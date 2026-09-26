{{-- Isolated single-section preview shell (admin Design Studio) --}}
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>সেকশন প্রিভিউ — {{ $section }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset_v('assets/style.css') }}">
    @include('partials.theme-vars')
    <style>
        html[lang="en"] [data-lang="bn"] { display: none; }
        html[lang="bn"] [data-lang="en"] { display: none; }
        body { margin: 0; background: #fff; }
    </style>
    <script>window.AB_MODE = 'server';</script>
</head>
<body>
    @php
        // shared layout-scope variables that section variants expect
        $phone = ab_contact('phone');
        $wa = ab_contact('whatsapp');
        $ms = ab_contact('messenger');
        $fb = ab_contact('facebook');
        $navHome = ab_t('nav_home', 'হোম', 'Home');
        $navProducts = ab_t('nav_products', 'সব প্রোডাক্ট', 'All Products');
        $navWhy = ab_t('nav_why', 'কেন আমরা', 'Why Us');
        $navReviews = ab_t('nav_reviews', 'রিভিউ', 'Reviews');
        $navFaq = ab_t('nav_faq', 'প্রশ্ন-উত্তর', 'FAQ');
        $navOrder = ab_t('nav_order', 'অর্ডার করুন', 'Order Now');
        $logoPill = ab_t('logo_pill', 'খাঁটি', 'Pure');
        $footerTag = ab_t('footer_tag', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি — সারা বাংলাদেশে ক্যাশ অন ডেলিভারিতে হোম ডেলিভারি।', 'Homemade deshi pickles, honey & ghee — delivered to your home across Bangladesh with Cash on Delivery.');
        $footerLinksH = ab_t('footer_col_links', 'কুইক লিংক', 'Quick Links');
        $footerContactH = ab_t('footer_col_contact', 'যোগাযোগ ও সাপোর্ট', 'Contact & Support');
        $footerFb = ab_t('footer_fb', 'ফেসবুক পেজ', 'Facebook Page');
        $footerAdmin = ab_t('footer_admin', 'অ্যাডমিন ডেমো', 'Admin Demo');
        $footerRights = ab_t('footer_rights', 'সর্বস্বত্ব সংরক্ষিত', 'All rights reserved');
        $footerMade = ab_t('footer_made', 'Made with love by', 'Made with love by');
    @endphp
    @include($sectionView)

    <script src="{{ asset_v('assets/brand.js') }}" defer></script>
    <script src="{{ asset_v('assets/script.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.AB) AB.applyLang();
            // tell the parent studio the rendered height so the modal fits the section exactly
            function report() {
                try {
                    var h = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
                    if (window.parent !== window) window.parent.postMessage({ abPreviewHeight: h, section: '{{ $section }}' }, '*');
                } catch (e) { }
            }
            report();
            setTimeout(report, 600);
            setTimeout(report, 1500);
            window.addEventListener('resize', report);
            document.addEventListener('ab:lang', report);
        });
    </script>
</body>
</html>
