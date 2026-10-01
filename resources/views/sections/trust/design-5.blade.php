{{-- Section: trust | Design 5 — Static Checklist Strip (scoped: tr-v5, no marquee) --}}
    @php
        $tr5items = ab_json('marquee_items', [
            ['bn' => 'সারা বাংলাদেশে হোম ডেলিভারি', 'en' => 'Home delivery across Bangladesh'],
            ['bn' => 'পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)', 'en' => 'Pay after checking the parcel (Cash on Delivery)'],
            ['bn' => 'ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি', 'en' => 'Broken jar? Free replacement guarantee'],
            ['bn' => '১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত', 'en' => '100% natural — no preservatives or chemicals'],
            ['bn' => 'ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি', 'en' => 'Handcrafted in small batches with love'],
            ['bn' => '২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট', 'en' => '24/7 dedicated customer support'],
        ]);
    @endphp
    <div class="tr-v5">
        <div class="tr-v5__in">
            @foreach (array_slice($tr5items, 0, 6) as $item)
                <div class="tr-v5__item">
                    <span class="tr-v5__ic">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                    </span>
                    <span data-en="{{ $item['en'] ?? '' }}">{{ $item['bn'] ?? '' }}</span>
                </div>
            @endforeach
        </div>
    </div>
<style>
    .tr-v5 { background: #fff; border-top: 1px solid rgba(5,150,105,.1); border-bottom: 1px solid rgba(5,150,105,.1); }
    .tr-v5__in {
        max-width: 1180px; margin: 0 auto; padding: 12px 20px;
        display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 170px), 1fr)); gap: 8px 14px;
    }
    .tr-v5__item { display: flex; align-items: center; gap: 8px; font-size: 11.5px; font-weight: 700; color: #33443c; }
    .tr-v5__ic {
        width: 19px; height: 19px; border-radius: 50%; flex-shrink: 0; display: grid; place-items: center;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
    }
</style>
