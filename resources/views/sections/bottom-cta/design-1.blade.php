{{-- Section: bottom-cta | Design 1 (extracted original) --}}
<!-- ================= BOTTOM CTA ================= -->
    @php
        $ctaHa = ab_t('cta_h2a', 'আজই অর্ডার করুন — ', 'Order today — on ');
        $ctaHb = ab_t('cta_h2b', 'ক্যাশ অন ডেলিভারিতে', 'Cash on Delivery');
        $ctaS = ab_t('cta_sub', 'আপনার পছন্দের জার এখনই বুক করুন, পণ্য হাতে পেয়ে দেখে মূল্য পরিশোধ করুন।', 'Book your favourite jars now — check them in hand and then pay.');
        $ctaB = ab_t('cta_btn', 'অর্ডার করতে চাই', 'I Want to Order');
    @endphp
    <section class="ds-cta">
        <div>
            <h2><span data-en="{{ $ctaHa['en'] }}">{{ $ctaHa['bn'] }}</span><span style="color:var(--ds-lime-neon)" data-en="{{ $ctaHb['en'] }}">{{ $ctaHb['bn'] }}</span></h2>
            <p data-en="{{ $ctaS['en'] }}">{{ $ctaS['bn'] }}</p>
            <button onclick="document.getElementById('order-form').scrollIntoView({behavior:'smooth'})"
                class="ds-btn ds-btn-lg">
                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> <span data-en="{{ $ctaB['en'] }}">{{ $ctaB['bn'] }}</span>
            </button>
            <div class="ds-cta-links">
                @if (ab_contact('phone') !== '')
                <a href="tel:{{ ab_contact('phone') }}"><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg> {{ ab_contact('phone') }}</a>
                @endif
                @if (ab_contact('whatsapp') !== '')
                <a href="https://wa.me/{{ ab_contact('whatsapp') }}" target="_blank" rel="noopener"><svg class="text-lg" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg> WhatsApp</a>
                @endif
                @if (ab_contact('facebook') !== '')
                <a href="{{ ab_contact('facebook') }}" target="_blank" rel="noopener"><svg class="text-lg" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg> <span data-en="Facebook Page">Facebook Page</span></a>
                @endif
                <a href="{{ route('track') }}" onclick="openTrackModal();return false;" style="text-decoration:none;color:inherit"><svg class="text-lg" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/><path d="M11 8a3 3 0 0 1 3 3"/></svg> <span
                        data-en="Order Track">অর্ডার ট্র্যাক</span></a>
                <button onclick="openComplaintModal()"><svg class="text-lg" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                    <span data-en="Complaint">কমপ্লেইন</span></button>
            </div>
        </div>
    </section>
<style>
/* modern polish (scoped, additive) */
.ds-cta { position: relative; overflow: hidden; }
.ds-cta::before {
    content: ''; position: absolute; inset: 0; pointer-events: none;
    background: radial-gradient(70% 90% at 80% 0%, rgba(163,230,53,.14), transparent 60%);
}
.ds-cta .ds-btn { transition: transform .18s ease; }
.ds-cta .ds-btn:hover { transform: translateY(-2px); }
</style>
