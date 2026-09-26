{{-- Section: faq | Design 4 — Open Q/A Cards, two-column (scoped: faq-v4) --}}
@php
    $fv4head = ab_t('faq_eyebrow', 'প্রশ্ন-উত্তর', 'FAQ');
    $fv4tbn = ab_t('faq_h2a', 'সাধারণ ', 'Common ')['bn'] . ab_t('faq_h2b', 'জিজ্ঞাসা', 'Questions')['bn'];
    $fv4ten = ab_t('faq_h2a', 'সাধারণ ', 'Common ')['en'] . ab_t('faq_h2b', 'জিজ্ঞাসা', 'Questions')['en'];
    $fv4items = ab_json('faq_items', [
        ['q_bn' => 'প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া যাবে?', 'q_en' => 'Can I pay cash after receiving the product?', 'a_bn' => 'হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি — সিল করা জার দেখে টাকা দিন।', 'a_en' => 'Yes, 100% Cash on Delivery.'],
        ['q_bn' => 'আচার কতদিন ভালো থাকে?', 'q_en' => 'How long do the pickles last?', 'a_bn' => 'ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত।', 'a_en' => 'Up to 12 months at room temperature.'],
        ['q_bn' => 'ডেলিভারি চার্জ কত?', 'q_en' => 'What is the delivery charge?', 'a_bn' => 'জেলাভিত্তিক চার্জ চেকআউটে দেখানো হয়।', 'a_en' => 'Shown at checkout, per district.'],
        ['q_bn' => 'জার ভাঙলে?', 'q_en' => 'Broken jar?', 'a_bn' => '২৪ ঘণ্টায় ছবি দিলেই ফ্রি রিপ্লেসমেন্ট।', 'a_en' => 'Photo within 24h = free replacement.'],
        ['q_bn' => 'অর্ডার কীভাবে ট্র্যাক করব?', 'q_en' => 'How do I track my order?', 'a_bn' => 'মোবাইল নম্বর বা ইনভয়েস আইডি দিয়ে "অর্ডার ট্র্যাক"।', 'a_en' => '"Order Track" with mobile or invoice ID.'],
    ]);
@endphp
<section class="faq-v4" aria-label="faq">
    <div class="faq-v4__in">
        <div class="faq-v4__head">
            <span class="faq-v4__tag" data-en="{{ $fv4head['en'] }}">{{ $fv4head['bn'] }}</span>
            <h2 data-en="{{ $fv4ten }}">{{ $fv4tbn }}</h2>
        </div>
        <div class="faq-v4__grid">
            @foreach ($fv4items as $fi)
                <div class="faq-v4__card">
                    <h3>
                        <span class="faq-v4__q">Q</span>
                        <span data-en="{{ $fi['q_en'] ?? '' }}">{{ $fi['q_bn'] ?? '' }}</span>
                    </h3>
                    <p><span class="faq-v4__a">A</span><span data-en="{{ $fi['a_en'] ?? '' }}">{{ $fi['a_bn'] ?? '' }}</span></p>
                </div>
            @endforeach
        </div>
    </div>
</section>
<style>
    .faq-v4 { padding: 54px 20px; background: var(--ds-section-alt-bg, #f8fbf9); }
    .faq-v4__in { max-width: 1180px; margin: 0 auto; }
    .faq-v4__head { text-align: center; margin-bottom: 26px; }
    .faq-v4__tag {
        display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase;
        color: var(--ds-primary); background: rgba(var(--ds-primary-rgb, 5,150,105), .08);
        border-radius: 999px; padding: 6px 16px; margin-bottom: 10px;
    }
    .faq-v4__head h2 { margin: 0; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; }
    .faq-v4__grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .faq-v4__card {
        background: #fff; border-radius: 18px; padding: 22px 24px;
        border: 1.5px solid rgba(5,150,105,.14);
        box-shadow: 0 14px 30px -26px rgba(6,78,59,.4);
    }
    .faq-v4__card h3 {
        margin: 0 0 10px; font-size: 14.5px; font-weight: 800; color: #12261d;
        display: flex; gap: 10px; align-items: flex-start; line-height: 1.5;
    }
    .faq-v4__q {
        flex-shrink: 0; width: 24px; height: 24px; border-radius: 8px; display: grid; place-items: center;
        background: var(--ds-primary); color: #fff; font-size: 12px; font-weight: 800;
    }
    .faq-v4__card p {
        margin: 0; padding-left: 34px; font-size: 13px; color: #4b6357; line-height: 1.7;
        display: flex; gap: 10px; align-items: flex-start;
    }
    .faq-v4__a {
        flex-shrink: 0; margin-top: 2px; font-style: normal; font-weight: 800;
        color: var(--ds-primary); background: rgba(var(--ds-primary-rgb, 5,150,105), .08);
        border-radius: 7px; padding: 2px 8px; font-size: 11px;
    }
    @media (max-width: 860px) {
        .faq-v4__grid { grid-template-columns: 1fr; }
    }
</style>
