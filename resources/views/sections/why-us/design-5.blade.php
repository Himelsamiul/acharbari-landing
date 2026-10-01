{{-- Section: why-us | Design 5 — Guarantee Band + Feature Row (scoped: wy-v5)
     Same content keys as design-1: why_eyebrow, why_h2a/b, why_sub, why_big_t/d, why_verified, why_c1-c4 t/d --}}
    <section class="wy-v5" id="ds-why">
        <div class="wy-v5__in">
            @php
                $wy5h = ab_t('why_eyebrow', 'কেন আমরা সেরা', 'Why We Are the Best');
                $wy5a = ab_t('why_h2a', 'কেন বেছে নেবেন ', 'Why choose ');
                $wy5brandBn = trim(($settings['brand_bn1'] ?? '') . ($settings['brand_bn2'] ?? '')) ?: 'আচারবাড়ি';
                $wy5brandEn = trim(($settings['brand_en1'] ?? '') . ($settings['brand_en2'] ?? '')) ?: 'AcharBari';
                $wy5b = ab_t('why_h2b', $wy5brandBn, $wy5brandEn);
                $wy5s = ab_t('why_sub', 'আমরা দিচ্ছি খাঁটি স্বাদের নিশ্চয়তা ও দ্রুততম সার্ভিস', 'We guarantee authentic taste and the fastest service');
                $wy5bigT = ab_t('why_big_t', '১০০% খাঁটি ও প্রিজারভেটিভ-মুক্ত গ্যারান্টি', '100% Pure & Preservative-Free Guarantee');
                $wy5bigD = ab_t('why_big_d', 'প্রতিটি জার মৌসুমি ফল, খাঁটি সরিষার তেল ও বিশুদ্ধ মসলা দিয়ে ছোট ব্যাচে হাতে তৈরি। কোনো প্রিজারভেটিভ, কালার বা কেমিক্যাল নেই — ল্যাব-টেস্টেড এবং নকল প্রমাণিত হলে সম্পূর্ণ টাকা রিটার্নের নিশ্চয়তা।', 'Every jar is handmade in small batches with seasonal fruits, premium mustard oil and pure spices. No preservatives, no colour, no chemicals — laboratory-tested and money-back guaranteed.');
                $wy5cells = [
                    ['t' => ab_t('why_c1_t', 'সুপারফাস্ট ডেলিভারি', 'Superfast Delivery'), 'd' => ab_t('why_c1_d', 'ঢাকায় মাত্র ২৪ ঘণ্টা এবং ঢাকার বাইরে ৪৮-৭২ ঘণ্টার মধ্যে সিল করা জার নিরাপদে পৌঁছে যায়।', 'Within 24 hours in Dhaka and 48-72 hours outside Dhaka — sealed jars reach you safely.')],
                    ['t' => ab_t('why_c2_t', 'ক্যাশ অন ডেলিভারি', 'Cash on Delivery'), 'd' => ab_t('why_c2_d', 'অগ্রিম কোনো টাকা দিতে হবে না — পার্সেল হাতে পেয়ে চেক করে তারপর মূল্য পরিশোধ করুন।', 'No advance payment — check the parcel in hand and then pay.')],
                    ['t' => ab_t('why_c3_t', 'ভাঙা জারে রিপ্লেসমেন্ট', 'Broken Jar Replacement'), 'd' => ab_t('why_c3_d', 'জার ভাঙা বা লিক অবস্থায় পৌঁছালে ২৪ ঘণ্টার মধ্যে ছবি দিয়ে জানালেই সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট।', 'If a jar arrives broken or leaked, report within 24 hours with a photo — free replacement, no question asked.')],
                    ['t' => ab_t('why_c4_t', '২৪/৭ সাপোর্ট হেল্পলাইন', '24/7 Support Helpline'), 'd' => ab_t('why_c4_d', 'স্বাদ, সংরক্ষণ বা পাইকারি অর্ডার নিয়ে যেকোনো প্রশ্নে যেকোনো সময় কল বা WhatsApp করুন।', 'For any question about taste, storage or bulk orders — call or WhatsApp us anytime.')],
                ];
            @endphp
            <div class="wy-v5__head">
                <span class="wy-v5__eyebrow" data-en="{{ $wy5h['en'] }}">{{ $wy5h['bn'] }}</span>
                <h2 class="wy-v5__h2"><span data-en="{{ $wy5a['en'] }}">{{ $wy5a['bn'] }}</span><span class="wy-v5__grad" data-en="{{ $wy5b['en'] }}">{{ $wy5b['bn'] }}</span>?</h2>
                <p class="wy-v5__sub" data-en="{{ $wy5s['en'] }}">{{ $wy5s['bn'] }}</p>
            </div>

            <div class="wy-v5__band">
                <span class="wy-v5__band-ic">
                    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                </span>
                <div>
                    <h3 data-en="{{ $wy5bigT['en'] }}">{{ $wy5bigT['bn'] }}</h3>
                    <p data-en="{{ $wy5bigD['en'] }}">{{ $wy5bigD['bn'] }}</p>
                </div>
            </div>

            <div class="wy-v5__grid">
                @foreach ($wy5cells as $i => $cell)
                    <div class="wy-v5__cell">
                        <span class="wy-v5__cell-n">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <h4 data-en="{{ $cell['t']['en'] }}">{{ $cell['t']['bn'] }}</h4>
                        <p data-en="{{ $cell['d']['en'] }}">{{ $cell['d']['bn'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
<style>
    .wy-v5 { padding: 54px 20px; background: #fff; }
    .wy-v5__in { max-width: 1120px; margin: 0 auto; }
    .wy-v5__head { text-align: center; margin-bottom: 28px; }
    .wy-v5__eyebrow { display: block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .wy-v5__h2 { margin: 0 0 10px; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; }
    .wy-v5__grad { background: linear-gradient(90deg, var(--ds-primary), var(--ds-accent)); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .wy-v5__sub { margin: 0; font-size: 13.5px; color: #5b6b60; }
    .wy-v5__band {
        display: flex; gap: 18px; align-items: flex-start; text-align: left;
        background: linear-gradient(135deg, var(--ds-primary-dark, #064e3b), var(--ds-primary, #059669));
        color: #fff; border-radius: 22px; padding: 26px 30px; margin-bottom: 22px;
        box-shadow: 0 26px 50px -26px rgba(6,78,59,.55);
    }
    .wy-v5__band-ic {
        width: 54px; height: 54px; border-radius: 14px; flex-shrink: 0; display: grid; place-items: center;
        background: rgba(163,230,53,.18); color: var(--ds-lime-neon, #a3e635);
    }
    .wy-v5__band h3 { margin: 0 0 6px; font-size: 18px; font-weight: 800; }
    .wy-v5__band p { margin: 0; font-size: 12.5px; line-height: 1.7; color: rgba(255,255,255,.82); }
    .wy-v5__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 14px; }
    .wy-v5__cell {
        border: 1.5px solid rgba(5,150,105,.15); border-radius: 16px; padding: 18px; background: #fbfdfb;
        transition: transform .18s ease, box-shadow .25s ease, border-color .2s ease;
    }
    .wy-v5__cell:hover { transform: translateY(-4px); border-color: rgba(5,150,105,.4); box-shadow: 0 22px 40px -26px rgba(6,78,59,.4); }
    .wy-v5__cell-n {
        display: inline-block; font-size: 12px; font-weight: 800; color: var(--ds-primary);
        background: rgba(5,150,105,.1); border-radius: 8px; padding: 3px 9px; margin-bottom: 10px;
    }
    .wy-v5__cell h4 { margin: 0 0 5px; font-size: 14px; font-weight: 800; color: #12261d; }
    .wy-v5__cell p { margin: 0; font-size: 12px; line-height: 1.7; color: #5b6b60; }
</style>
