{{-- Section: trust | Design 3 — Dark Stats Bar (scoped: trust-v3) --}}
@php
    $barItems = ab_json('marquee_items', [
        ['bn' => 'সারা বাংলাদেশে হোম ডেলিভারি', 'en' => 'Home delivery across Bangladesh'],
        ['bn' => 'পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)', 'en' => 'Pay after checking the parcel (Cash on Delivery)'],
        ['bn' => 'ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি', 'en' => 'Broken jar? Free replacement guarantee'],
        ['bn' => '১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত', 'en' => '100% natural — no preservatives or chemicals'],
        ['bn' => 'ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি', 'en' => 'Handcrafted in small batches with love'],
        ['bn' => '২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট', 'en' => '24/7 dedicated customer support'],
    ]);
@endphp
<section class="trust-v3" aria-label="trust">
    <div class="trust-v3__in">
        @foreach (array_slice($barItems, 0, 4) as $i => $item)
            <div class="trust-v3__item">
                <span class="trust-v3__dot"></span>
                <span data-en="{{ $item['en'] ?? '' }}">{{ $item['bn'] ?? '' }}</span>
            </div>
        @endforeach
    </div>
</section>
<style>
    .trust-v3 { background: var(--ds-primary-dark); padding: 13px 20px; }
    .trust-v3__in {
        max-width: 1200px; margin: 0 auto;
        display: flex; flex-wrap: wrap; justify-content: center; column-gap: 34px; row-gap: 8px;
    }
    .trust-v3__item { display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,.92); font-size: 12.5px; font-weight: 700; }
    .trust-v3__dot { width: 7px; height: 7px; border-radius: 50%; background: var(--ds-lime-neon); box-shadow: 0 0 8px var(--ds-lime-neon); }
    @media (max-width: 768px) {
        .trust-v3__in { justify-content: flex-start; }
        .trust-v3__item { font-size: 11.5px; }
    }
</style>
