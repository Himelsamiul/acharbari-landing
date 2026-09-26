{{-- Section: trust | Design 2 — Static Trust Cards (scoped: trust-v2) --}}
@php
    $trustItems = ab_json('marquee_items', [
        ['bn' => 'সারা বাংলাদেশে হোম ডেলিভারি', 'en' => 'Home delivery across Bangladesh'],
        ['bn' => 'পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)', 'en' => 'Pay after checking the parcel (Cash on Delivery)'],
        ['bn' => 'ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি', 'en' => 'Broken jar? Free replacement guarantee'],
        ['bn' => '১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত', 'en' => '100% natural — no preservatives or chemicals'],
        ['bn' => 'ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি', 'en' => 'Handcrafted in small batches with love'],
        ['bn' => '২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট', 'en' => '24/7 dedicated customer support'],
    ]);
    $trustIcons = [
        '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
        '<rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/>',
        '<path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="m9.5 15.2 1.9 1.9 3.1-3.7"/>',
        '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
        '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>',
        '<path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3v-5a9 9 0 0 1 18 0v5h-3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/>',
    ];
@endphp
<section class="trust-v2" aria-label="trust">
    <div class="trust-v2__grid">
        @foreach ($trustItems as $i => $item)
            <div class="trust-v2__card">
                <span class="trust-v2__ic">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $trustIcons[$i % count($trustIcons)] !!}</svg>
                </span>
                <p data-en="{{ $item['en'] ?? '' }}">{{ $item['bn'] ?? '' }}</p>
            </div>
        @endforeach
    </div>
</section>
<style>
    .trust-v2 { padding: 26px 0 6px; }
    .trust-v2__grid {
        max-width: 1200px; margin: 0 auto; padding: 0 20px;
        display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px;
    }
    .trust-v2__card {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border: 1.5px solid rgba(5,150,105,.16); border-radius: 14px;
        padding: 12px 14px; box-shadow: 0 8px 22px -14px rgba(6,78,59,.35);
    }
    .trust-v2__ic {
        flex-shrink: 0; width: 34px; height: 34px; border-radius: 10px;
        display: grid; place-items: center; color: var(--ds-primary);
        background: rgba(var(--ds-primary-rgb, 5,150,105), .1);
    }
    .trust-v2__ic svg { width: 17px; height: 17px; }
    .trust-v2__card p { margin: 0; font-size: 12px; font-weight: 700; color: #1f4234; line-height: 1.45; }
    @media (max-width: 640px) {
        .trust-v2__grid { grid-template-columns: 1fr 1fr; gap: 8px; padding: 0 14px; }
        .trust-v2__card p { font-size: 11px; }
    }
</style>
