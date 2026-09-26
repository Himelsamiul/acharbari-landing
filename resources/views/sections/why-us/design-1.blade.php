{{-- Section: why-us | Design 1 (extracted original) --}}
<!-- ================= WHY US (BENTO GRID) ================= -->
    @php
        $wh = ab_t('why_eyebrow', 'কেন আমরা সেরা', 'Why We Are the Best');
        $wh2a = ab_t('why_h2a', 'কেন বেছে নেবেন ', 'Why choose ');
        $brandBn = trim(($settings['brand_bn1'] ?? '') . ($settings['brand_bn2'] ?? '')) ?: 'আচারবাড়ি';
        $brandEn = trim(($settings['brand_en1'] ?? '') . ($settings['brand_en2'] ?? '')) ?: 'AcharBari';
        $wh2b = ab_t('why_h2b', $brandBn, $brandEn);
        $whsub = ab_t('why_sub', 'আমরা দিচ্ছি খাঁটি স্বাদের নিশ্চয়তা ও দ্রুততম সার্ভিস', 'We guarantee authentic taste and the fastest service');
        $bigT = ab_t('why_big_t', '১০০% খাঁটি ও প্রিজারভেটিভ-মুক্ত গ্যারান্টি', '100% Pure & Preservative-Free Guarantee');
        $bigD = ab_t('why_big_d', 'প্রতিটি জার মৌসুমি ফল, খাঁটি সরিষার তেল ও বিশুদ্ধ মসলা দিয়ে ছোট ব্যাচে হাতে তৈরি। কোনো প্রিজারভেটিভ, কালার বা কেমিক্যাল নেই — ল্যাব-টেস্টেড এবং নকল প্রমাণিত হলে সম্পূর্ণ টাকা রিটার্নের নিশ্চয়তা।', 'Every jar is handmade in small batches with seasonal fruits, premium mustard oil and pure spices. No preservatives, no colour, no chemicals — laboratory-tested and money-back guaranteed.');
        $verB = ab_t('why_verified', 'ভেরিফাইড গ্রামীণ রান্নাঘর', 'Verified Village Kitchens');
        $whyCells = [
            ['icon' => 'truck', 't' => ab_t('why_c1_t', 'সুপারফাস্ট ডেলিভারি', 'Superfast Delivery'), 'd' => ab_t('why_c1_d', 'ঢাকায় মাত্র ২৪ ঘণ্টা এবং ঢাকার বাইরে ৪৮-৭২ ঘণ্টার মধ্যে সিল করা জার নিরাপদে পৌঁছে যায়।', 'Within 24 hours in Dhaka and 48-72 hours outside Dhaka — sealed jars reach you safely.')],
            ['icon' => 'banknote', 't' => ab_t('why_c2_t', 'ক্যাশ অন ডেলিভারি', 'Cash on Delivery'), 'd' => ab_t('why_c2_d', 'অগ্রিম কোনো টাকা দিতে হবে না — পার্সেল হাতে পেয়ে চেক করে তারপর মূল্য পরিশোধ করুন।', 'No advance payment — check the parcel in hand and then pay.')],
            ['icon' => 'jarcheck', 't' => ab_t('why_c3_t', 'ভাঙা জারে রিপ্লেসমেন্ট', 'Broken Jar Replacement'), 'd' => ab_t('why_c3_d', 'জার ভাঙা বা লিক অবস্থায় পৌঁছালে ২৪ ঘণ্টার মধ্যে ছবি দিয়ে জানালেই সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট।', 'If a jar arrives broken or leaked, report within 24 hours with a photo — free replacement, no question asked.')],
            ['icon' => 'headset', 't' => ab_t('why_c4_t', '২৪/৭ সাপোর্ট হেল্পলাইন', '24/7 Support Helpline'), 'd' => ab_t('why_c4_d', 'স্বাদ, সংরক্ষণ বা পাইকারি অর্ডার নিয়ে যেকোনো প্রশ্নে যেকোনো সময় কল বা WhatsApp করুন।', 'For any question about taste, storage or bulk orders — call or WhatsApp us anytime.')],
        ];
    @endphp
    <section class="ds-section ds-section-alt" id="ds-why">
        <div class="ds-container">
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="{{ $wh['en'] }}">{{ $wh['bn'] }}</span>
                <h2 class="ds-h2"><span data-en="{{ $wh2a['en'] }}">{{ $wh2a['bn'] }}</span><span class="ds-grad" data-en="{{ $wh2b['en'] }}">{{ $wh2b['bn'] }}</span><span>?</span></h2>
                <p class="ds-sub" data-en="{{ $whsub['en'] }}">{{ $whsub['bn'] }}</p>
            </div>
            <div class="ds-bento">
                <div class="ds-bento-big">
                    <div>
                        <span class="ds-ic ds-ic-glass"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg></span>
                        <h3 data-en="{{ $bigT['en'] }}">{{ $bigT['bn'] }}</h3>
                        <p data-en="{{ $bigD['en'] }}">{{ $bigD['bn'] }}</p>
                    </div>
                    <div class="flex items-center gap-3 text-sm font-bold text-emerald-300">
                        <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>
                        <span data-en="{{ $verB['en'] }}">{{ $verB['bn'] }}</span>
                    </div>
                </div>
                @foreach ($whyCells as $wc)
                    <div class="ds-bento-cell">
                        <span class="ds-ic">
                            @if ($wc['icon'] === 'truck')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                            @elseif ($wc['icon'] === 'banknote')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg>
                            @elseif ($wc['icon'] === 'jarcheck')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="m9.5 15.2 1.9 1.9 3.1-3.7"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3v-5a9 9 0 0 1 18 0v5h-3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/></svg>
                            @endif
                        </span>
                        <h4 data-en="{{ $wc['t']['en'] }}">{{ $wc['t']['bn'] }}</h4>
                        <p data-en="{{ $wc['d']['en'] }}">{{ $wc['d']['bn'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
