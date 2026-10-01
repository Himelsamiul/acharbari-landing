{{-- Section: promises | Design 5 — Numbered Ledger Rows (scoped: pr-v5)
     Same content keys as design-1: promise_eyebrow, promise_h2a/b, promise_sub, promise_c1-c4 t/d/tag --}}
    <section class="pr-v5" id="ds-promise">
        <div class="pr-v5__in">
            @php
                $pr5h = ab_t('promise_eyebrow', 'আমাদের গ্যারান্টি', 'Our Guarantee');
                $pr5a = ab_t('promise_h2a', 'অর্ডার করুন ', 'Order with ');
                $pr5b = ab_t('promise_h2b', 'সম্পূর্ণ নিশ্চিন্তে', 'total peace of mind');
                $pr5s = ab_t('promise_sub', 'ফি, পেমেন্ট, ডেলিভারি — প্রতিটি ধাপে স্বচ্ছতা ও নিরাপত্তা।', 'Fee, payment, delivery — transparency and safety at every single step.');
                $pr5cards = [
                    ['n' => '০১', 't' => ab_t('promise_c1_t', '০% হিডেন সার্ভিস ফি', '0% Hidden Service Fee'), 'd' => ab_t('promise_c1_d', 'কোনো লুকায়িত ফি বা অতিরিক্ত চার্জ নেই। চেকআউটে যা দেখেন, ঠিক তাই পরিশোধ করবেন।', 'No hidden fees or extra charges ever. What you see at checkout is exactly what you pay.'), 'tag' => ab_t('promise_c1_tag', '১০০% স্বচ্ছ', '100% Transparent')],
                    ['n' => '০২', 't' => ab_t('promise_c2_t', '৪৮ ঘণ্টায় নিশ্চিত পেআউট', '48-Hour Guaranteed Payout'), 'd' => ab_t('promise_c2_d', 'রিফান্ড হোক বা পেআউট — টাকা পৌঁছে যাবে মাত্র ৪৮ ঘণ্টায় আপনার বিকাশ বা ব্যাংকে।', 'Refund or payout — money reaches your bKash or bank within just 48 hours, guaranteed.'), 'tag' => ab_t('promise_c2_tag', 'ইনস্ট্যান্ট বিকাশ/ব্যাংক', 'Instant bKash/Bank')],
                    ['n' => '০৩', 't' => ab_t('promise_c3_t', '৬৪ জেলায় অটো লজিস্টিকস', 'Logistics in 64 Districts'), 'd' => ab_t('promise_c3_d', 'আপনার লোকাল বা বাসা থেকে ফিক্সড ও সারা দেশে ডেলিভারি — সব হ্যান্ডেল করে আচারবাড়ি ট্রাস্টেড কুরিয়ার পার্টনারদের মাধ্যমে।', 'From your door anywhere in Bangladesh — pickup and delivery handled entirely by AcharBari via trusted courier partners.'), 'tag' => ab_t('promise_c3_tag', 'Steadfast + Pathao', 'Steadfast + Pathao')],
                    ['n' => '০৪', 't' => ab_t('promise_c4_t', 'সিলড ও সেফ প্যাকেজিং', 'Sealed & Safe Packaging'), 'd' => ab_t('promise_c4_d', 'প্রতিটি জার এয়ার-টাইট সিল ও মোটা বাবল-র‍্যাপে সাজানো — ভাঙার ঝুঁকি প্রায় শূন্য, নাহলে ফ্রি রিপ্লেসমেন্ট।', 'Every jar is air-tight sealed and wrapped in thick bubble layers — breakage risk is practically zero, or we replace it free.'), 'tag' => ab_t('promise_c4_tag', 'সিলড অ্যান্ড সেফ', 'Sealed & Safe')],
                ];
            @endphp
            <div class="pr-v5__head">
                <span class="pr-v5__eyebrow" data-en="{{ $pr5h['en'] }}">{{ $pr5h['bn'] }}</span>
                <h2 class="pr-v5__h2"><span data-en="{{ $pr5a['en'] }}">{{ $pr5a['bn'] }}</span><span class="pr-v5__grad" data-en="{{ $pr5b['en'] }}">{{ $pr5b['bn'] }}</span></h2>
                <p class="pr-v5__sub" data-en="{{ $pr5s['en'] }}">{{ $pr5s['bn'] }}</p>
            </div>
            <div class="pr-v5__rows">
                @foreach ($pr5cards as $pc)
                    <div class="pr-v5__row">
                        <span class="pr-v5__num">{{ $pc['n'] }}</span>
                        <div class="pr-v5__body">
                            <h4 data-en="{{ $pc['t']['en'] }}">{{ $pc['t']['bn'] }}</h4>
                            <p data-en="{{ $pc['d']['en'] }}">{{ $pc['d']['bn'] }}</p>
                        </div>
                        <span class="pr-v5__tag" data-en="{{ $pc['tag']['en'] }}">{{ $pc['tag']['bn'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
<style>
    .pr-v5 { padding: 54px 20px; background: linear-gradient(180deg, #fbfdfb, #fff); }
    .pr-v5__in { max-width: 900px; margin: 0 auto; }
    .pr-v5__head { text-align: center; margin-bottom: 30px; }
    .pr-v5__eyebrow { display: block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .pr-v5__h2 { margin: 0 0 10px; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; }
    .pr-v5__grad { background: linear-gradient(90deg, var(--ds-primary), var(--ds-accent)); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .pr-v5__sub { margin: 0; font-size: 13.5px; color: #5b6b60; }
    .pr-v5__rows { display: flex; flex-direction: column; gap: 12px; }
    .pr-v5__row {
        display: flex; align-items: center; gap: 16px; text-align: left;
        background: #fff; border: 1.5px solid rgba(5,150,105,.14); border-radius: 16px; padding: 16px 18px;
        transition: transform .18s ease, box-shadow .25s ease, border-color .2s ease;
    }
    .pr-v5__row:hover { transform: translateX(6px); border-color: rgba(5,150,105,.4); box-shadow: 0 18px 36px -24px rgba(6,78,59,.4); }
    .pr-v5__num {
        font-size: 22px; font-weight: 800; color: transparent; flex-shrink: 0; width: 52px; text-align: center;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent));
        -webkit-background-clip: text; background-clip: text;
    }
    .pr-v5__body { flex: 1; }
    .pr-v5__body h4 { margin: 0 0 3px; font-size: 14.5px; font-weight: 800; color: #12261d; }
    .pr-v5__body p { margin: 0; font-size: 12.5px; line-height: 1.65; color: #5b6b60; }
    .pr-v5__tag {
        flex-shrink: 0; font-size: 10.5px; font-weight: 800; color: #047857;
        background: rgba(5,150,105,.09); border-radius: 999px; padding: 5px 12px;
    }
    @media (max-width: 640px) {
        .pr-v5__row { flex-wrap: wrap; }
        .pr-v5__tag { margin-left: 68px; }
    }
</style>
