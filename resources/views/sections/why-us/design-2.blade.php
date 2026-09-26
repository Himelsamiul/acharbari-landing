{{-- Section: why-us | Design 2 — Equal Feature Grid (scoped: wy-v2) --}}
@php
    $wy2head = ab_t('why_eyebrow', 'কেন আমরা সেরা', 'Why We Are the Best');
    $wy2tbn = ab_t('why_h2a', 'কেন বেছে নেবেন ', 'Why choose ')['bn'] . ab_t('why_h2b', 'আচারবাড়ি', 'AcharBari')['bn'];
    $wy2ten = ab_t('why_h2a', 'কেন বেছে নেবেন ', 'Why choose ')['en'] . ab_t('why_h2b', 'আচারবাড়ি', 'AcharBari')['en'];
    $wy2big = ['t' => ab_t('why_big_t', '১০০% খাঁটি ও প্রিজারভেটিভ-মুক্ত গ্যারান্টি', '100% Pure & Preservative-Free Guarantee'), 'd' => ab_t('why_big_d', 'প্রতিটি জার মৌসুমি ফল, খাঁটি সরিষার তেল ও বিশুদ্ধ মসলা দিয়ে ছোট ব্যাচে হাতে তৈরি।', 'Handmade in small batches with seasonal fruits and pure spices.')];
    $wy2cells = [
        ['t' => ab_t('why_c1_t', 'সুপারফাস্ট ডেলিভারি', 'Superfast Delivery'), 'd' => ab_t('why_c1_d', 'ঢাকায় ২৪ ঘণ্টা, বাইরে ৪৮-৭২ ঘণ্টা।', '24h Dhaka, 48-72h outside.')],
        ['t' => ab_t('why_c2_t', 'ক্যাশ অন ডেলিভারি', 'Cash on Delivery'), 'd' => ab_t('why_c2_d', 'অগ্রিম টাকা লাগবে না — হাতে পেয়ে চেক করে পেমেন্ট।', 'No advance — pay after checking.')],
        ['t' => ab_t('why_c3_t', 'ভাঙা জারে রিপ্লেসমেন্ট', 'Broken Jar Replacement'), 'd' => ab_t('why_c3_d', '২৪ ঘণ্টায় ছবি দিলেই ফ্রি রিপ্লেসমেন্ট।', 'Photo within 24h = free replacement.')],
        ['t' => ab_t('why_c4_t', '২৪/৭ সাপোর্ট হেল্পলাইন', '24/7 Support Helpline'), 'd' => ab_t('why_c4_d', 'যেকোনো প্রশ্নে কল বা WhatsApp করুন।', 'Call or WhatsApp anytime.')],
    ];
@endphp
<section class="wy-v2" id="ds-why" aria-label="why us">
    <div class="wy-v2__in">
        <div class="wy-v2__head">
            <span class="wy-v2__eyebrow" data-en="{{ $wy2head['en'] }}">{{ $wy2head['bn'] }}</span>
            <h2 data-en="{{ $wy2ten }}">{{ $wy2tbn }}</h2>
        </div>
        <div class="wy-v2__feature">
            <h3 data-en="{{ $wy2big['t']['en'] }}">{{ $wy2big['t']['bn'] }}</h3>
            <p data-en="{{ $wy2big['d']['en'] }}">{{ $wy2big['d']['bn'] }}</p>
        </div>
        <div class="wy-v2__grid">
            @foreach ($wy2cells as $cell)
                <div class="wy-v2__cell">
                    <h4 data-en="{{ $cell['t']['en'] }}">{{ $cell['t']['bn'] }}</h4>
                    <p data-en="{{ $cell['d']['en'] }}">{{ $cell['d']['bn'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
<style>
    .wy-v2 { padding: 56px 20px; background: #f8fbf9; }
    .wy-v2__in { max-width: 1180px; margin: 0 auto; }
    .wy-v2__head { text-align: center; margin-bottom: 24px; }
    .wy-v2__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .wy-v2__head h2 { margin: 0; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; }
    .wy-v2__feature {
        text-align: center; max-width: 780px; margin: 0 auto 26px;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-primary-dark));
        border-radius: 22px; padding: 30px 34px; color: #fff;
        box-shadow: 0 22px 44px -20px rgba(var(--ds-primary-rgb, 5,150,105), .6);
    }
    .wy-v2__feature h3 { margin: 0 0 8px; font-size: clamp(17px, 2.2vw, 22px); font-weight: 800; }
    .wy-v2__feature p { margin: 0; font-size: 14px; line-height: 1.65; opacity: .92; }
    .wy-v2__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; }
    .wy-v2__cell { background: #fff; border: 1.5px solid rgba(5,150,105,.18); border-radius: 16px; padding: 18px; }
    .wy-v2__cell h4 { margin: 0 0 6px; font-size: 14.5px; font-weight: 800; color: #12261d; }
    .wy-v2__cell p { margin: 0; font-size: 13px; color: #4b6357; line-height: 1.55; }
</style>
