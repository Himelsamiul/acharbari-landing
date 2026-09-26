{{-- Section: trust | Design 4 — Static Pill Badges (scoped: trust-v4) --}}
@php
    $t4items = ab_json('marquee_items', [
        ['bn' => 'সারা বাংলাদেশে হোম ডেলিভারি', 'en' => 'Home delivery across Bangladesh'],
        ['bn' => 'পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)', 'en' => 'Pay after checking the parcel (Cash on Delivery)'],
        ['bn' => 'ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি', 'en' => 'Broken jar? Free replacement guarantee'],
        ['bn' => '১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত', 'en' => '100% natural — no preservatives or chemicals'],
        ['bn' => 'ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি', 'en' => 'Handcrafted in small batches with love'],
        ['bn' => '২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট', 'en' => '24/7 dedicated customer support'],
    ]);
@endphp
<section class="trust-v4" aria-label="trust">
    <div class="trust-v4__in">
        @foreach (array_slice($t4items, 0, 5) as $item)
            <span class="trust-v4__pill">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                <span data-en="{{ $item['en'] ?? '' }}">{{ $item['bn'] ?? '' }}</span>
            </span>
        @endforeach
    </div>
</section>
<style>
    .trust-v4 { padding: 18px 16px; }
    .trust-v4__in {
        max-width: 1100px; margin: 0 auto;
        display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;
    }
    .trust-v4__pill {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 12px; font-weight: 800; color: #14320f;
        background: rgba(163,230,53,.16); border: 1px solid rgba(132,204,22,.35);
        border-radius: 999px; padding: 8px 16px;
    }
    .trust-v4__pill svg { color: #65a30d; }
</style>
