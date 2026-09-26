{{-- Section: promises | Design 3 — Numbered Minimal List (scoped: pm-v3) --}}
@php
    $pm3head = ab_t('promise_eyebrow', 'আমাদের গ্যারান্টি', 'Our Guarantee');
    $pm3tbn = ab_t('promise_h2a', 'অর্ডার করুন ', 'Order with ')['bn'] . ab_t('promise_h2b', 'সম্পূর্ণ নিশ্চিন্তে', 'total peace of mind')['bn'];
    $pm3ten = ab_t('promise_h2a', 'অর্ডার করুন ', 'Order with ')['en'] . ab_t('promise_h2b', 'সম্পূর্ণ নিশ্চিন্তে', 'total peace of mind')['en'];
    $pm3rows = [
        ['t' => ab_t('promise_c1_t', '০% হিডেন সার্ভিস ফি', '0% Hidden Service Fee'), 'd' => ab_t('promise_c1_d', 'কোনো লুকায়িত ফি বা অতিরিক্ত চার্জ নেই।', 'No hidden fees or extra charges.')],
        ['t' => ab_t('promise_c2_t', '৪৮ ঘণ্টায় নিশ্চিত পেআউট', '48-Hour Guaranteed Payout'), 'd' => ab_t('promise_c2_d', 'রিফান্ড/পেআউট ৪৮ ঘণ্টায় বিকাশ বা ব্যাংকে।', 'Refunds within 48 hours.')],
        ['t' => ab_t('promise_c3_t', '৬৪ জেলায় অটো লজিস্টিকস', 'Logistics in 64 Districts'), 'd' => ab_t('promise_c3_d', 'সারা দেশে ট্রাস্টেড কুরিয়ার পার্টনার।', 'Trusted courier partners nationwide.')],
        ['t' => ab_t('promise_c4_t', 'সিলড ও সেফ প্যাকেজিং', 'Sealed & Safe Packaging'), 'd' => ab_t('promise_c4_d', 'এয়ার-টাইট সিল + বাবল-র‍্যাপ, নাহলে ফ্রি রিপ্লেসমেন্ট।', 'Sealed and wrapped, or free replacement.')],
    ];
@endphp
<section class="pm-v3" aria-label="promises">
    <div class="pm-v3__grid">
        <div class="pm-v3__intro">
            <span class="pm-v3__eyebrow" data-en="{{ $pm3head['en'] }}">{{ $pm3head['bn'] }}</span>
            <h2 data-en="{{ $pm3ten }}">{{ $pm3tbn }}</h2>
        </div>
        <ol class="pm-v3__list">
            @foreach ($pm3rows as $i => $row)
                <li class="pm-v3__row">
                    <span class="pm-v3__num">{{ bn_num($i + 1) }}</span>
                    <div>
                        <h3 data-en="{{ $row['t']['en'] }}">{{ $row['t']['bn'] }}</h3>
                        <p data-en="{{ $row['d']['en'] }}">{{ $row['d']['bn'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
<style>
    .pm-v3 { padding: 48px 20px; max-width: 1080px; margin: 0 auto; }
    .pm-v3__grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 40px; align-items: start; }
    .pm-v3__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 10px; }
    .pm-v3__intro h2 { margin: 0; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; line-height: 1.3; }
    .pm-v3__list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; }
    .pm-v3__row { display: flex; gap: 16px; padding: 16px 0; border-bottom: 1.5px dashed rgba(5,150,105,.2); }
    .pm-v3__row:last-child { border-bottom: 0; }
    .pm-v3__num { flex-shrink: 0; font-size: 30px; font-weight: 800; color: rgba(5,150,105,.35); line-height: 1; min-width: 40px; }
    .pm-v3__row h3 { margin: 0 0 4px; font-size: 15px; font-weight: 800; color: #12261d; }
    .pm-v3__row p { margin: 0; font-size: 13px; color: #4b6357; line-height: 1.55; }
    @media (max-width: 860px) {
        .pm-v3__grid { grid-template-columns: 1fr; gap: 18px; }
    }
</style>
