{{-- Section: faq | Design 1 (extracted original) --}}
<!-- ================= FAQ ================= -->
    @php
        $fqh = ab_t('faq_eyebrow', 'প্রশ্ন-উত্তর', 'FAQ');
        $fq2a = ab_t('faq_h2a', 'সাধারণ ', 'Common ');
        $fq2b = ab_t('faq_h2b', 'জিজ্ঞাসা', 'Questions');
        $fqsub = ab_t('faq_sub', 'আপনার মনে থাকা সাধারণ প্রশ্নের উত্তর জেনে নিন', 'Find answers to the questions you have in mind');
        $faqItems = ab_json('faq_items', [
            ['q_bn' => 'প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া যাবে?', 'q_en' => 'Can I pay cash after receiving the product?', 'a_bn' => 'হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি সুবিধা রয়েছে — ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে টাকা পরিশোধ করতে পারবেন। কোনো অগ্রিম টাকা লাগবে না।', 'a_en' => 'Yes, we have 100% Cash on Delivery — check the sealed jar in front of the delivery man and then pay. No advance money is needed.'],
            ['q_bn' => 'আচার কতদিন ভালো থাকে? প্রিজারভেটিভ আছে কি?', 'q_en' => 'How long do the pickles last? Any preservatives?', 'a_bn' => 'সঠিক পদ্ধতিতে তৈরি ও খাঁটি সরিষার তেল, পর্যাপ্ত লবণ ও বিশুদ্ধ মসলার কারণে আমাদের আচার ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত ভালো থাকে। প্রিজারভেটিভ, কালার ও কেমিক্যাল সম্পূর্ণ মুক্ত।', 'a_en' => 'Our pickles stay good for 12 months at room temperature — made the traditional way with premium mustard oil, enough salt and pure spices. Completely free of preservatives, colours and chemicals.'],
            ['q_bn' => 'ডেলিভারি চার্জ কত টাকা?', 'q_en' => 'What is the delivery charge?', 'a_bn' => 'ঢাকার ভেতরের জন্য ডেলিভারি চার্জ ৮০ টাকা এবং ঢাকার বাইরের জন্য ১৫০ টাকা। বিশেষ অফার চলাকালীন অনেক প্রোডাক্টে ফ্রি ডেলিভারিও থাকে।', 'a_en' => 'Delivery charge is ৳80 inside Dhaka and ৳150 outside Dhaka. During special offers many products also get free delivery.'],
            ['q_bn' => 'জার ভেঙে বা লিক হয়ে এলে কী করব?', 'q_en' => 'What if the jar arrives broken or leaked?', 'a_bn' => 'পার্সেল পাওয়ার ২৪ ঘণ্টার মধ্যে ছবি দিয়ে আমাদের হেল্পলাইনে জানালেই আমরা সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট করে দেব।', 'a_en' => 'Just inform our helpline with a photo within 24 hours of receiving the parcel — we will replace it completely free of charge.'],
            ['q_bn' => 'অর্ডার কীভাবে ট্র্যাক করব?', 'q_en' => 'How do I track my order?', 'a_bn' => 'অর্ডার দেওয়ার পর ওয়েবসাইটের "অর্ডার ট্র্যাক" বাটন থেকে আপনার মোবাইল নম্বর অথবা ইনভয়েস আইডি দিয়ে লাইভ স্ট্যাটাস দেখতে পারবেন।', 'a_en' => 'You can see live status from the "Order Track" button on the website using your mobile number or invoice ID.'],
        ]);
    @endphp
    <section class="ds-section" id="ds-faq">
        <div class="ds-container ds-faq-wrap">
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="{{ $fqh['en'] }}">{{ $fqh['bn'] }}</span>
                <h2 class="ds-h2"><span data-en="{{ $fq2a['en'] }}">{{ $fq2a['bn'] }}</span><span class="ds-grad" data-en="{{ $fq2b['en'] }}">{{ $fq2b['bn'] }}</span></h2>
                <p class="ds-sub" data-en="{{ $fqsub['en'] }}">{{ $fqsub['bn'] }}</p>
            </div>
            <div class="ds-faqs">
                @foreach ($faqItems as $i => $fi)
                    <details class="ds-faq" {{ $i === 0 ? 'open' : '' }}>
                        <summary><span data-en="{{ $fi['q_en'] ?? '' }}">{{ $fi['q_bn'] ?? '' }}</span> <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></summary>
                        <div data-en="{{ $fi['a_en'] ?? '' }}">{{ $fi['a_bn'] ?? '' }}</div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>
<style>
/* modern polish (scoped, additive) */
.ds-faq { transition: box-shadow .25s ease, border-color .25s ease; }
.ds-faq[open] { box-shadow: 0 18px 36px -26px rgba(6,78,59,.45); border-color: rgba(5,150,105,.4); }
.ds-faq summary { transition: color .2s ease; }
</style>
