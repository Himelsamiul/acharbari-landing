{{-- Section: trust | Design 1 (extracted original) --}}
<!-- ================= TRUST MARQUEE ================= -->
    @php
        $marqueeItems = ab_json('marquee_items', [
            ['bn' => 'সারা বাংলাদেশে হোম ডেলিভারি', 'en' => 'Home delivery across Bangladesh'],
            ['bn' => 'পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)', 'en' => 'Pay after checking the parcel (Cash on Delivery)'],
            ['bn' => 'ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি', 'en' => 'Broken jar? Free replacement guarantee'],
            ['bn' => '১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত', 'en' => '100% natural — no preservatives or chemicals'],
            ['bn' => 'ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি', 'en' => 'Handcrafted in small batches with love'],
            ['bn' => '২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট', 'en' => '24/7 dedicated customer support'],
        ]);
    @endphp
    <div class="ds-marquee" aria-hidden="true">
        <div class="ds-marquee-track">
            @foreach (array_merge($marqueeItems, $marqueeItems) as $item)
                <span class="ds-marquee-item"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> <span data-en="{{ $item['en'] ?? '' }}">{{ $item['bn'] ?? '' }}</span></span>
            @endforeach
        </div>
    </div>
