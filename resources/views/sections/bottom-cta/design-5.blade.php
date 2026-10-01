{{-- Section: bottom-cta | Design 5 — Ticket Card CTA (scoped: bc-v5)
     Same content keys as design-1: cta_h2a/b, cta_sub, cta_btn + contact links --}}
    @php
        $bc5a = ab_t('cta_h2a', 'আজই অর্ডার করুন — ', 'Order today — on ');
        $bc5b = ab_t('cta_h2b', 'ক্যাশ অন ডেলিভারিতে', 'Cash on Delivery');
        $bc5s = ab_t('cta_sub', 'আপনার পছন্দের জার এখনই বুক করুন, পণ্য হাতে পেয়ে দেখে মূল্য পরিশোধ করুন।', 'Book your favourite jars now — check them in hand and then pay.');
        $bc5b2 = ab_t('cta_btn', 'অর্ডার করতে চাই', 'I Want to Order');
    @endphp
    <section class="bc-v5">
        <div class="bc-v5__ticket">
            <span class="bc-v5__hole bc-v5__hole--l" aria-hidden="true"></span>
            <span class="bc-v5__hole bc-v5__hole--r" aria-hidden="true"></span>
            <h2><span data-en="{{ $bc5a['en'] }}">{{ $bc5a['bn'] }}</span><span class="bc-v5__hl" data-en="{{ $bc5b['en'] }}">{{ $bc5b['bn'] }}</span></h2>
            <p data-en="{{ $bc5s['en'] }}">{{ $bc5s['bn'] }}</p>
            <button onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})" class="bc-v5__btn">
                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                <span data-en="{{ $bc5b2['en'] }}">{{ $bc5b2['bn'] }}</span>
            </button>
            <div class="bc-v5__links">
                @if (ab_contact('phone') !== '')
                <a href="tel:{{ ab_contact('phone') }}">{{ ab_contact('phone') }}</a>
                @endif
                @if (ab_contact('whatsapp') !== '')
                <a href="https://wa.me/{{ ab_contact('whatsapp') }}" target="_blank" rel="noopener" data-en="WhatsApp">WhatsApp</a>
                @endif
                <a href="{{ route('track') }}" onclick="openTrackModal();return false;" data-en="Order Track">অর্ডার ট্র্যাক</a>
            </div>
        </div>
    </section>
<style>
    .bc-v5 { padding: 50px 20px; background: linear-gradient(180deg, #f4faf6, #fff); }
    .bc-v5__ticket {
        position: relative; max-width: 680px; margin: 0 auto; text-align: center;
        background: linear-gradient(135deg, #064e3b, #022c22); color: #fff;
        border-radius: 24px; padding: 38px 34px 32px;
        box-shadow: 0 34px 64px -30px rgba(2,44,34,.75);
    }
    .bc-v5__hole {
        position: absolute; top: 50%; width: 26px; height: 26px; border-radius: 50%;
        background: #f4faf6; transform: translateY(-50%);
    }
    .bc-v5__hole--l { left: -13px; }
    .bc-v5__hole--r { right: -13px; }
    .bc-v5__ticket h2 { margin: 0 0 10px; font-size: clamp(21px, 3vw, 30px); font-weight: 800; line-height: 1.3; }
    .bc-v5__hl { color: var(--ds-lime-neon, #a3e635); }
    .bc-v5__ticket p { margin: 0 auto 20px; font-size: 13px; line-height: 1.75; color: rgba(255,255,255,.8); max-width: 440px; }
    .bc-v5__btn {
        display: inline-flex; align-items: center; gap: 8px; border: 0; cursor: pointer; font-family: inherit;
        background: linear-gradient(135deg, var(--ds-lime, #84cc16), var(--ds-lime-neon, #a3e635)); color: #143024;
        font-size: 14px; font-weight: 800; padding: 14px 30px; border-radius: 14px;
        box-shadow: 0 18px 34px -14px rgba(163,230,53,.55); transition: transform .18s ease;
    }
    .bc-v5__btn:hover { transform: translateY(-2px); }
    .bc-v5__links { display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; margin-top: 20px; }
    .bc-v5__links a {
        font-size: 11.5px; font-weight: 800; color: #d1fae5; text-decoration: none;
        border: 1px solid rgba(255,255,255,.25); border-radius: 999px; padding: 6px 14px;
        transition: background .2s, color .2s;
    }
    .bc-v5__links a:hover { background: rgba(255,255,255,.12); color: #fff; }
</style>
