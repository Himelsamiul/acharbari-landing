{{-- Section: promises | Design 1 (extracted original) --}}
<!-- ================= OUR PROMISES (4 CARDS) ================= -->
    <section class="ds-seller-section" id="ds-promise">
        <canvas id="neuralCanvas" class="ds-neural-canvas"></canvas>

        <div class="ds-container relative z-10">
            @php
                $pmh = ab_t('promise_eyebrow', 'আমাদের গ্যারান্টি', 'Our Guarantee');
                $pm2a = ab_t('promise_h2a', 'অর্ডার করুন ', 'Order with ');
                $pm2b = ab_t('promise_h2b', 'সম্পূর্ণ নিশ্চিন্তে', 'total peace of mind');
                $pmsub = ab_t('promise_sub', 'ফি, পেমেন্ট, ডেলিভারি — প্রতিটি ধাপে স্বচ্ছতা ও নিরাপত্তা।', 'Fee, payment, delivery — transparency and safety at every single step.');
                $promiseCards = [
                    ['icon' => 'percent', 't' => ab_t('promise_c1_t', '০% হিডেন সার্ভিস ফি', '0% Hidden Service Fee'), 'd' => ab_t('promise_c1_d', 'কোনো লুকায়িত ফি বা অতিরিক্ত চার্জ নেই। চেকআউটে যা দেখেন, ঠিক তাই পরিশোধ করবেন।', 'No hidden fees or extra charges ever. What you see at checkout is exactly what you pay.'), 'tag' => ab_t('promise_c1_tag', '১০০% স্বচ্ছ', '100% Transparent')],
                    ['icon' => 'banknote', 't' => ab_t('promise_c2_t', '৪৮ ঘণ্টায় নিশ্চিত পেআউট', '48-Hour Guaranteed Payout'), 'd' => ab_t('promise_c2_d', 'রিফান্ড হোক বা পেআউট — টাকা পৌঁছে যাবে মাত্র ৪৮ ঘণ্টায় আপনার বিকাশ বা ব্যাংকে।', 'Refund or payout — money reaches your bKash or bank within just 48 hours, guaranteed.'), 'tag' => ab_t('promise_c2_tag', 'ইনস্ট্যান্ট বিকাশ/ব্যাংক', 'Instant bKash/Bank')],
                    ['icon' => 'truck', 't' => ab_t('promise_c3_t', '৬৪ জেলায় অটো লজিস্টিকস', 'Logistics in 64 Districts'), 'd' => ab_t('promise_c3_d', 'আপনার লোকাল বা বাসা থেকে ফিক্সড ও সারা দেশে ডেলিভারি — সব হ্যান্ডেল করে আচারবাড়ি ট্রাস্টেড কুরিয়ার পার্টনারদের মাধ্যমে।', 'From your door anywhere in Bangladesh — pickup and delivery handled entirely by AcharBari via trusted courier partners.'), 'tag' => ab_t('promise_c3_tag', 'Steadfast + Pathao', 'Steadfast + Pathao')],
                    ['icon' => 'package', 't' => ab_t('promise_c4_t', 'সিলড ও সেফ প্যাকেজিং', 'Sealed & Safe Packaging'), 'd' => ab_t('promise_c4_d', 'প্রতিটি জার এয়ার-টাইট সিল ও মোটা বাবল-র‍্যাপে সাজানো — ভাঙার ঝুঁকি প্রায় শূন্য, নাহলে ফ্রি রিপ্লেসমেন্ট।', 'Every jar is air-tight sealed and wrapped in thick bubble layers — breakage risk is practically zero, or we replace it free.'), 'tag' => ab_t('promise_c4_tag', 'সিলড অ্যান্ড সেফ', 'Sealed & Safe')],
                ];
            @endphp
            <div class="ds-sec-head text-center">
                <span class="ds-eyebrow" data-en="{{ $pmh['en'] }}">{{ $pmh['bn'] }}</span>
                <h2 class="ds-h2"><span data-en="{{ $pm2a['en'] }}">{{ $pm2a['bn'] }}</span><span class="ds-grad-neon" data-en="{{ $pm2b['en'] }}">{{ $pm2b['bn'] }}</span></h2>
                <p class="ds-sub" data-en="{{ $pmsub['en'] }}">{{ $pmsub['bn'] }}</p>
            </div>

            <div class="ds-seller-benefits ds-bento-grid">
                @foreach ($promiseCards as $pc)
                    <div class="ds-seller-card ds-bento-card">
                        <div class="ds-bento-glow"></div>
                        <div class="ds-seller-card-ic">
                            @if ($pc['icon'] === 'percent')
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" x2="5" y1="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                            @elseif ($pc['icon'] === 'banknote')
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg>
                            @elseif ($pc['icon'] === 'truck')
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                            @endif
                        </div>
                        <h4 data-en="{{ $pc['t']['en'] }}">{{ $pc['t']['bn'] }}</h4>
                        <p data-en="{{ $pc['d']['en'] }}">{{ $pc['d']['bn'] }}</p>
                        <span class="ds-bento-tag" data-en="{{ $pc['tag']['en'] }}">{{ $pc['tag']['bn'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
<style>
/* modern polish (scoped, additive) */
.ds-bento-card { transition: transform .2s ease, box-shadow .25s ease; }
.ds-bento-card:hover { transform: translateY(-4px); box-shadow: 0 26px 48px -26px rgba(6,78,59,.55); }
.ds-seller-card-ic { transition: transform .3s ease; }
.ds-bento-card:hover .ds-seller-card-ic { transform: scale(1.08) rotate(-3deg); }
</style>
