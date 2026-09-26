{{-- Section: footer | Design 3 — Premium Dark Footer (scoped: ft-v3)
     Preserves brand.js hooks: data-ab-logo-slot, data-ab-brand-logo, data-ab-brand-name --}}
@php
    $ft3tag = ab_t('footer_tag', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি — সারা বাংলাদেশে ক্যাশ অন ডেলিভারিতে হোম ডেলিভারি।', 'Homemade deshi pickles, honey & ghee — delivered nationwide with Cash on Delivery.');
    $ft3links = ab_t('footer_col_links', 'কুইক লিংক', 'Quick Links');
    $ft3contact = ab_t('footer_col_contact', 'যোগাযোগ ও সাপোর্ট', 'Contact & Support');
    $ft3fb = ab_t('footer_fb', 'ফেসবুক পেজ', 'Facebook Page');
    $ft3admin = ab_t('footer_admin', 'অ্যাডমিন ডেমো', 'Admin Demo');
    $ft3rights = ab_t('footer_rights', 'সর্বস্বত্ব সংরক্ষিত', 'All rights reserved');
    $ft3made = ab_t('footer_made', 'Made with love by', 'Made with love by');
@endphp
<footer class="ft-v3">
    <div class="ft-v3__glow"></div>
    <div class="ft-v3__grid">
        <div class="ft-v3__brand">
            <a class="ft-v3__logo" href="#">
                <span class="ft-v3__logo-ic" data-ab-logo-slot>
                    @if (!empty($settings['logo_path']))
                        <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                    @else
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                    @endif
                </span>
                <span class="ft-v3__name" data-ab-brand-logo>{{ $settings['brand_bn1'] ?? 'আচার' }}<em>{{ $settings['brand_bn2'] ?? 'বাড়ি' }}</em></span>
            </a>
            <p class="ft-v3__tag" data-en="{{ $ft3tag['en'] }}">{{ $ft3tag['bn'] }}</p>
            <div class="ft-v3__pay">
                <span class="ft-v3__chip"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
                <span class="ft-v3__chip"><img src="{{ asset('assets/img/pay/nagad.svg') }}" alt="Nagad"></span>
                <span class="ft-v3__cod" data-en="Cash on Delivery">ক্যাশ অন ডেলিভারি</span>
            </div>
        </div>

        <div class="ft-v3__col">
            <h4 data-en="{{ $ft3links['en'] }}">{{ $ft3links['bn'] }}</h4>
            <a href="{{ url('/#ds-products') }}" data-en="Products">প্রোডাক্টস</a>
            <a href="{{ route('products') }}" data-en="All Products">সব প্রোডাক্ট</a>
            <a href="{{ url('/#ds-why') }}" data-en="Why Us">কেন আমরা</a>
            <a href="{{ route('track') }}" data-en="Order Track">অর্ডার ট্র্যাক</a>
        </div>

        <div class="ft-v3__col">
            <h4 data-en="{{ $ft3contact['en'] }}">{{ $ft3contact['bn'] }}</h4>
            @if ($phone !== '')<a href="tel:{{ $phone }}">{{ $phone }}</a>@endif
            @if ($wa !== '')<a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">WhatsApp</a>@endif
            @if ($fb !== '')<a href="{{ $fb }}" target="_blank" rel="noopener" data-en="{{ $ft3fb['en'] }}">{{ $ft3fb['bn'] }}</a>@endif
            <a href="{{ route('admin.login') }}" data-en="{{ $ft3admin['en'] ?? 'Admin' }}">{{ $ft3admin['bn'] ?? 'অ্যাডমিন' }}</a>
        </div>
    </div>

    <div class="ft-v3__bar">
        <span>© {{ date('Y') }} <strong data-ab-brand-name>আচারবাড়ি</strong>. <span data-en="{{ $ft3rights['en'] }}">{{ $ft3rights['bn'] }}</span></span>
        <span class="ft-v3__made"><span data-en="{{ $ft3made['en'] }}">{{ $ft3made['bn'] }}</span> <strong data-ab-brand-name>আচারবাড়ি</strong> <svg class="ft-v3__heart" viewBox="0 0 24 24" width="12" height="12" fill="currentColor" aria-hidden="true"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg></span>
    </div>
</footer>
<style>
    .ft-v3 { position: relative; overflow: hidden; background: var(--ds-primary-xdark); color: rgba(255,255,255,.85); }
    .ft-v3__glow {
        position: absolute; top: -120px; left: 50%; transform: translateX(-50%);
        width: 620px; height: 240px; border-radius: 50%;
        background: radial-gradient(closest-side, rgba(163,230,53,.18), transparent);
        pointer-events: none;
    }
    .ft-v3__grid {
        position: relative; max-width: 1180px; margin: 0 auto;
        display: grid; grid-template-columns: 1.4fr 1fr 1fr; gap: 36px;
        padding: 44px 20px 30px;
    }
    .ft-v3__logo { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: #fff; }
    .ft-v3__logo-ic {
        width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center; overflow: hidden;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
    }
    .ft-v3__logo-ic img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 3px; box-sizing: border-box; }
    .ft-v3__name { font-size: 19px; font-weight: 800; }
    .ft-v3__name em { font-style: normal; color: var(--ds-lime-neon); }
    .ft-v3__tag { margin: 12px 0 16px; font-size: 12.5px; line-height: 1.7; color: rgba(255,255,255,.66); max-width: 340px; }
    .ft-v3__pay { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
    .ft-v3__chip { display: inline-grid; place-items: center; background: #fff; border-radius: 8px; padding: 4px 8px; }
    .ft-v3__chip img { height: 16px; display: block; }
    .ft-v3__cod { font-size: 11px; font-weight: 800; color: var(--ds-lime-neon); border: 1px solid rgba(163,230,53,.4); border-radius: 999px; padding: 4px 10px; }
    .ft-v3__col { display: flex; flex-direction: column; gap: 10px; }
    .ft-v3__col h4 { margin: 0 0 4px; font-size: 13px; font-weight: 800; color: #fff; letter-spacing: .4px; }
    .ft-v3__col a { color: rgba(255,255,255,.68); text-decoration: none; font-size: 12.5px; transition: color .2s, transform .2s; }
    .ft-v3__col a:hover { color: var(--ds-lime-neon); transform: translateX(3px); }
    .ft-v3__bar {
        position: relative; border-top: 1px solid rgba(255,255,255,.12);
        max-width: 1180px; margin: 0 auto; padding: 14px 20px 18px;
        display: flex; flex-wrap: wrap; gap: 6px 18px; justify-content: space-between;
        font-size: 11.5px; color: rgba(255,255,255,.55);
    }
    .ft-v3__made { display: inline-flex; gap: 5px; align-items: center; }
    .ft-v3__heart { color: #f87171; }
    @media (max-width: 860px) {
        .ft-v3__grid { grid-template-columns: 1fr; gap: 26px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ft-v3__col a { transition: none; }
    }
</style>
