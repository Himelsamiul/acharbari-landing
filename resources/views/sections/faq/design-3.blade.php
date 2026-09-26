{{-- Section: faq | Design 3 — Minimal Borderless List (scoped: faq-v3) --}}
@php
    $fv3head = ab_t('faq_eyebrow', 'প্রশ্ন-উত্তর', 'FAQ');
    $fv3tbn = ab_t('faq_h2a', 'সাধারণ ', 'Common ')['bn'] . ab_t('faq_h2b', 'জিজ্ঞাসা', 'Questions')['bn'];
    $fv3ten = ab_t('faq_h2a', 'সাধারণ ', 'Common ')['en'] . ab_t('faq_h2b', 'জিজ্ঞাসা', 'Questions')['en'];
    $fv3items = ab_json('faq_items', [
        ['q_bn' => 'প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া যাবে?', 'q_en' => 'Can I pay cash after receiving the product?', 'a_bn' => 'হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি — সিল করা জার দেখে টাকা দিন।', 'a_en' => 'Yes, 100% Cash on Delivery.'],
        ['q_bn' => 'আচার কতদিন ভালো থাকে?', 'q_en' => 'How long do the pickles last?', 'a_bn' => 'ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত।', 'a_en' => 'Up to 12 months at room temperature.'],
        ['q_bn' => 'ডেলিভারি চার্জ কত?', 'q_en' => 'What is the delivery charge?', 'a_bn' => 'জেলাভিত্তিক চার্জ চেকআউটে দেখানো হয়।', 'a_en' => 'Shown at checkout, per district.'],
        ['q_bn' => 'জার ভাঙলে?', 'q_en' => 'Broken jar?', 'a_bn' => '২৪ ঘণ্টায় ছবি দিলেই ফ্রি রিপ্লেসমেন্ট।', 'a_en' => 'Photo within 24 hours = free replacement.'],
        ['q_bn' => 'অর্ডার কীভাবে ট্র্যাক করব?', 'q_en' => 'How do I track my order?', 'a_bn' => 'মোবাইল নম্বর বা ইনভয়েস আইডি দিয়ে "অর্ডার ট্র্যাক"।', 'a_en' => '"Order Track" with mobile or invoice ID.'],
    ]);
@endphp
<section class="faq-v3" aria-label="faq">
    <div class="faq-v3__in">
        <h2 class="faq-v3__title"><span data-en="{{ $fv3head['en'] }}">{{ $fv3head['bn'] }}</span> — <span data-en="{{ $fv3ten }}">{{ $fv3tbn }}</span></h2>
        <div class="faq-v3__list">
            @foreach ($fv3items as $fi)
                <details class="faq-v3__item">
                    <summary>
                        <span data-en="{{ $fi['q_en'] ?? '' }}">{{ $fi['q_bn'] ?? '' }}</span>
                        <span class="faq-v3__plus" aria-hidden="true"></span>
                    </summary>
                    <div data-en="{{ $fi['a_en'] ?? '' }}">{{ $fi['a_bn'] ?? '' }}</div>
                </details>
            @endforeach
        </div>
    </div>
</section>
<style>
    .faq-v3 { padding: 52px 20px; }
    .faq-v3__in { max-width: 760px; margin: 0 auto; }
    .faq-v3__title { margin: 0 0 20px; font-size: clamp(20px, 2.6vw, 27px); font-weight: 800; color: #12261d; }
    .faq-v3__list { border-top: 1.5px solid rgba(18,38,29,.1); }
    .faq-v3__item { border-bottom: 1.5px solid rgba(18,38,29,.1); }
    .faq-v3__item summary {
        list-style: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 14px;
        padding: 16px 4px; font-size: 14.5px; font-weight: 700; color: #12261d;
        transition: color .2s;
    }
    .faq-v3__item summary::-webkit-details-marker { display: none; }
    .faq-v3__item summary:hover { color: var(--ds-primary); }
    .faq-v3__plus { position: relative; width: 16px; height: 16px; flex-shrink: 0; }
    .faq-v3__plus::before, .faq-v3__plus::after {
        content: ''; position: absolute; inset: 0; margin: auto; background: var(--ds-primary);
        border-radius: 2px; transition: transform .25s;
    }
    .faq-v3__plus::before { width: 16px; height: 2.5px; }
    .faq-v3__plus::after { width: 2.5px; height: 16px; }
    .faq-v3__item[open] .faq-v3__plus::after { transform: rotate(90deg); }
    .faq-v3__item > div { padding: 0 4px 16px; font-size: 13.5px; color: #4b6357; line-height: 1.7; }
</style>
