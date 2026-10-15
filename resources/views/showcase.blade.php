@extends('layouts.showcase')

@section('content')
    @php
        $insideCharge = ab_charge('delivery_charge_inside', 80);
        $districts = ab_districts();
        $dhaka = null;
        $outside = [];
        foreach ($districts as $d) {
            if (strcasecmp((string) $d['en'], 'Dhaka') === 0) { $dhaka = $d; continue; }
            $outside[] = $d;
        }
    @endphp

    <!-- ================= HEADER ================= -->
    <header class="sc-header">
        <div class="sc-wrap sc-header-in">
            <a class="sc-logo" href="{{ route('showcase.index') }}">
                <span class="sc-logo-ic"><i class="fa-solid fa-palette"></i></span>
                <span>
                    <span data-lang="bn">{{ config('showcase.title_bn') }}</span>
                    <span data-lang="en">{{ config('showcase.title_en') }}</span>
                    <small>ACHARBARI SHOWCASE</small>
                </span>
            </a>
            <div class="sc-lang">
                <button type="button" data-lang-btn="bn" onclick="AB.setLang('bn')">বাংলা</button>
                <button type="button" data-lang-btn="en" onclick="AB.setLang('en')">EN</button>
            </div>
        </div>
    </header>

    <!-- ================= HERO ================= -->
    <section class="sc-hero sc-wrap">
        <span class="sc-chip"><i class="fa-solid fa-wand-magic-sparkles"></i>
            <span data-lang="bn">১০টি ইন্ডাস্ট্রির রেডি ডিজাইন — লাইভ ডেমোসহ</span>
            <span data-lang="en">Ready designs for 10 industries — with live demos</span>
        </span>
        <h1>
            <span data-lang="bn">আমাদের ল্যান্ডিং পেজ <em>ডিজাইনসমূহ</em></span>
            <span data-lang="en">Pick a landing page <em>you love</em></span>
        </h1>
        <p>
            <span data-lang="bn">পছন্দের ইন্ডাস্ট্রির ডিজাইনটি লাইভ ডেমোতে দেখুন, পছন্দ হলে সরাসরি অর্ডার করুন — আমরা আপনার ব্যবসার জন্য সেটআপ করে দেব।</span>
            <span data-lang="en">Watch the live demo of the industry you like, then order it directly — we set it up for your business.</span>
        </p>
    </section>

    <!-- ================= DESIGN GRID ================= -->
    <main class="sc-wrap">
        <div class="sc-grid-h">
            <h2><span data-lang="bn">সব ডিজাইন</span><span data-lang="en">All Designs</span></h2>
            <span><span data-lang="bn">{{ $designs->count() }} টি রেডি ল্যান্ডিং পেজ</span><span data-lang="en">{{ $designs->count() }} ready landing pages</span></span>
        </div>

        <div class="sc-grid">
            @foreach ($designs as $d)
                <article class="sc-card" id="sc-card-{{ $d['key'] }}">
                    <div class="sc-card-cover">
                        <span class="sc-theme-chip"><i class="fa-solid {{ $d['icon'] }}"></i></span>
                        <img src="{{ asset($d['cover']) }}" alt="{{ $d['name_bn'] }} landing page design" loading="lazy">
                        <span class="sc-price-chip">৳ {{ bn_num(number_format($d['product']?->price ?? $d['price'])) }}</span>
                    </div>
                    <div class="sc-card-body">
                        <h3>
                            {{ $d['name_bn'] }}
                            <small>{{ $d['name_en'] }}</small>
                        </h3>
                        <p class="sc-card-desc">{{ $d['desc'] }}</p>
                        <div class="sc-swatch">
                            @foreach ($d['swatch'] as $c)
                                <i style="background: {{ $c }}" title="{{ $c }}"></i>
                            @endforeach
                        </div>
                        <div class="sc-card-actions">
                            <a class="sc-btn sc-btn-demo" href="{{ route('showcase.demo', $d['key']) }}" target="_blank" rel="noopener">
                                <i class="fa-solid fa-eye"></i>
                                <span data-lang="bn">লাইভ ডেমো</span>
                                <span data-lang="en">Live Demo</span>
                            </a>
                            <button type="button" class="sc-btn sc-btn-order" onclick="scAddToCart('{{ $d['key'] }}', this)">
                                <i class="fa-solid fa-cart-plus"></i>
                                <span data-lang="bn">অর্ডার করুন</span>
                                <span data-lang="en">Order</span>
                            </button>
                        </div>

                        {{-- oi design er admin demo credential — user log in kore puro panel ghure theme optimize kore dekhte pare --}}
                        @if ($d['demo_admin']['exists'])
                            <div class="sc-creds">
                                <span class="sc-creds-h">
                                    <i class="fa-solid fa-user-shield"></i>
                                    <span data-lang="bn">অ্যাডমিন ডেমো লগইন</span>
                                    <span data-lang="en">Admin Demo Login</span>
                                </span>
                                <span class="sc-creds-row">
                                    <i class="fa-regular fa-envelope"></i><code>{{ $d['demo_admin']['email'] }}</code>
                                    <button type="button" onclick="scCopyText('{{ $d['demo_admin']['email'] }}', this)"><span data-lang="bn">কপি</span><span data-lang="en">Copy</span></button>
                                </span>
                                <span class="sc-creds-row">
                                    <i class="fa-solid fa-key"></i><code>{{ $d['demo_admin']['password'] }}</code>
                                    <button type="button" onclick="scCopyText('{{ $d['demo_admin']['password'] }}', this)"><span data-lang="bn">কপি</span><span data-lang="en">Copy</span></button>
                                </span>
                                <a class="sc-creds-login" href="{{ route('admin.login', ['email' => $d['demo_admin']['email']]) }}" target="_blank" rel="noopener">
                                    <span data-lang="bn">প্যানেলে লগইন করে দেখুন →</span>
                                    <span data-lang="en">Log in to the panel →</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </main>

    <!-- ================= CHECKOUT (#order) ================= -->
    <section class="sc-checkout sc-wrap" id="order">
        <div class="sc-checkout-card">
            <div class="sc-checkout-head">
                <h2>
                    <span data-lang="bn">আপনার ডিজাইন অর্ডার করুন</span>
                    <span data-lang="en">Order Your Design</span>
                </h2>
                <p>
                    <span data-lang="bn">নাম, মোবাইল ও ঠিকানা দিন — আমাদের প্রতিনিধি ফোন করে কনফার্ম করবেন।</span>
                    <span data-lang="en">Give your name, mobile and address — our agent will call to confirm.</span>
                </p>
            </div>

            <form id="sc-checkout-form" method="POST" action="{{ route('order.store') }}">
                @csrf
                <input type="hidden" name="items" id="sc-items-input">
                <input type="hidden" name="coupon_code" id="sc-coupon-hidden" value="">
                <input type="hidden" name="area" id="sc-area-input" value="inside">
                <input type="hidden" name="district" id="sc-district-input" value="">

                <div class="sc-checkout-grid">
                    <!-- left: order summary + coupon -->
                    <div class="sc-checkout-col">
                        <h3><i class="fa-solid fa-bag-shopping"></i> <span data-lang="bn">অর্ডার সামারি</span><span data-lang="en">Order Summary</span></h3>

                        <div class="sc-order-summary">
                            <div id="sc-summary-rows">
                                <p class="sc-cart-empty"><span data-lang="bn">কার্ট এখন খালি — উপরের ডিজাইন কার্ডের "অর্ডার করুন" বাটনে চাপ দিন।</span><span data-lang="en">Cart is empty — hit "Order" on a design card above.</span></p>
                            </div>
                            <div class="sc-total-row" style="margin-top:8px">
                                <span><span data-lang="bn">সাবটোটাল</span><span data-lang="en">Subtotal</span></span>
                                <span id="sc-subtotal">৳ 0</span>
                            </div>
                            <div class="sc-total-row" id="sc-discount-row" style="display:none">
                                <span id="sc-discount-label">Discount</span>
                                <span id="sc-discount" style="color:var(--sc-ok)">− ৳ 0</span>
                            </div>
                            <div class="sc-total-row">
                                <span><span data-lang="bn">ডেলিভারি চার্জ</span><span data-lang="en">Delivery Charge</span></span>
                                <span id="sc-shipping">৳ {{ bn_num($insideCharge) }}</span>
                            </div>
                            <div class="sc-total-row grand">
                                <span><span data-lang="bn">সর্বমোট</span><span data-lang="en">Grand Total</span></span>
                                <span id="sc-grand">৳ 0</span>
                            </div>
                        </div>

                        <div class="sc-coupon">
                            <input class="sc-input" type="text" id="sc-coupon-input"
                                placeholder="কুপন কোড (যেমন: ACHAR10)" data-en-ph="Coupon code (e.g. ACHAR10)">
                            <button type="button" class="sc-btn sc-btn-demo" onclick="scSubmitCoupon()">
                                <span data-lang="bn">প্রয়োগ</span><span data-lang="en">Apply</span>
                            </button>
                        </div>
                        <p class="sc-coupon-note"><span data-lang="bn">কুপন থাকলে প্রয়োগ করুন — ডিসকাউন্ট অটো হিসাব হবে।</span><span data-lang="en">If you have a coupon, apply it — the discount is calculated automatically.</span></p>
                        <p class="sc-coupon-msg" id="sc-coupon-msg" hidden></p>
                        @if (count($coupons))
                            <div>
                                @foreach ($coupons as $code => $pct)
                                    <button type="button" class="sc-coupon-chip" onclick="scApplyCouponList('{{ $code }}')">
                                        🎟️ {{ $code }} — {{ bn_num($pct) }}% <span data-lang="bn">ছাড়</span><span data-lang="en">off</span>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- right: delivery form -->
                    <div class="sc-checkout-col">
                        <h3><i class="fa-solid fa-truck-fast"></i> <span data-lang="bn">ডেলিভারি তথ্য</span><span data-lang="en">Delivery Info</span></h3>

                        <div class="sc-banner-error" id="sc-form-error"></div>

                        <div class="sc-field">
                            <label><span data-lang="bn">আপনার সম্পূর্ণ নাম</span><span data-lang="en">Your Full Name</span> <span class="req">*</span></label>
                            <input class="sc-input" type="text" name="customer_name" required
                                placeholder="যেমন: মোঃ কামরুল হাসান" data-en-ph="e.g. Md. Kamrul Hasan">
                        </div>
                        <div class="sc-field">
                            <label><span data-lang="bn">মোবাইল নাম্বার</span><span data-lang="en">Mobile Number</span> <span class="req">*</span></label>
                            <input class="sc-input" type="tel" inputmode="numeric" maxlength="15" name="phone" required
                                placeholder="০১xxxxxxxxx (১১ সংখ্যা)" data-en-ph="01xxxxxxxxx (11 digits)">
                        </div>
                        <div class="sc-field">
                            <label><span data-lang="bn">সম্পূর্ণ ঠিকানা</span><span data-lang="en">Full Address</span> <span class="req">*</span></label>
                            <input class="sc-input" type="text" name="address" required
                                placeholder="বাসা নং, রোড, এলাকা, থানা ও জেলা" data-en-ph="House no., road, area, thana & district">
                        </div>
                        <div class="sc-field">
                            <label><span data-lang="bn">ডেলিভারি এরিয়া</span><span data-lang="en">Delivery Area</span></label>
                            @if ($dhaka)
                                <select class="sc-input" id="sc-zone">
                                    <option value="inside" data-charge="{{ $dhaka['charge'] }}" data-district="Dhaka">
                                        {{ $dhaka['bn'] }} ({{ $dhaka['en'] }}) — ৳{{ bn_num($dhaka['charge']) }}
                                    </option>
                                    <option value="outside">ঢাকার বাইরে (Outside Dhaka)</option>
                                </select>
                            @endif
                            <select class="sc-input" id="sc-district" style="@if(!$dhaka) @else display:none; @endif margin-top:8px" @if(!$dhaka) required @endif>
                                @foreach ($outside as $d)
                                    <option value="{{ $d['en'] }}" data-charge="{{ $d['charge'] }}" data-area="outside">{{ $d['bn'] }} ({{ $d['en'] }}) — ৳{{ bn_num($d['charge']) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- payment methods — server-computed exactly like the store checkout --}}
                        <div class="sc-pay-box">
                            <b><span data-lang="bn">পেমেন্ট মেথড</span><span data-lang="en">Payment Method</span></b>

                            <label class="sc-pay-opt sel">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <span class="tx">
                                    <b><span data-lang="bn">ক্যাশ অন ডেলিভারি</span><span data-lang="en">Cash On Delivery</span></b>
                                    <small><span data-lang="bn">আগে কনফার্ম করুন, তারপর টাকা দিন</span><span data-lang="en">Confirm first, pay later</span></small>
                                </span>
                            </label>
                            @if (ab_online_payment())
                                @if (\App\Services\Payment\BkashGateway::enabled())
                                    <label class="sc-pay-opt">
                                        <input type="radio" name="payment_method" value="bkash">
                                        <span class="tx"><b>bKash</b><small><span data-lang="bn">অনলাইনে পেমেন্ট</span><span data-lang="en">Pay online</span></small></span>
                                    </label>
                                @endif
                                @if (\App\Services\Payment\NagadGateway::enabled())
                                    <label class="sc-pay-opt">
                                        <input type="radio" name="payment_method" value="nagad">
                                        <span class="tx"><b>Nagad</b><small><span data-lang="bn">অনলাইনে পেমেন্ট</span><span data-lang="en">Pay online</span></small></span>
                                    </label>
                                @endif
                            @endif
                            @if (ab_manual_payment())
                                @php $manualNums = ab_manual_payment_numbers(); @endphp
                                <label class="sc-pay-opt">
                                    <input type="radio" name="payment_method" value="manual">
                                    <span class="tx">
                                        <b><span data-lang="bn">ম্যানুয়াল — bKash/Nagad এ টাকা পাঠান</span><span data-lang="en">Manual — send via bKash/Nagad</span></b>
                                        @if ($manualNums['bkash'] !== '')<small>bKash: {{ $manualNums['bkash'] }}</small>@endif
                                        @if ($manualNums['nagad'] !== '')<small>Nagad: {{ $manualNums['nagad'] }}</small>@endif
                                    </span>
                                </label>
                                <input class="sc-input" type="text" name="payment_ref" maxlength="60" autocomplete="off" id="sc-payment-ref"
                                    placeholder="TrxID লিখুন (ম্যানুয়াল পেমেন্টে আবশ্যক)" data-en-ph="Enter TrxID (required for manual)"
                                    style="display:none; margin-top:4px">
                            @endif
                        </div>

                        <button type="submit" class="sc-btn sc-btn-order sc-submit">
                            <i class="fa-solid fa-circle-check"></i>
                            <span data-lang="bn">অর্ডার কনফার্ম করুন</span>
                            <span data-lang="en">Confirm Order</span>
                        </button>
                        <div class="sc-trust-row">
                            <span><span data-lang="bn">নিরাপদ অর্ডার</span><span data-lang="en">Secure order</span></span> •
                            <span><span data-lang="bn">ফোনে কনফার্মেশন</span><span data-lang="en">Phone confirmation</span></span> •
                            <span><span data-lang="bn">সেটআপ গ্যারান্টি</span><span data-lang="en">Setup guarantee</span></span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="sc-footer sc-wrap">
        <p>
            <span data-lang="bn">সব ডিজাইনে রেসপন্সিভ লেআউট, বাংলা-ইংরেজি দুই ভাষা ও অর্ডার-রেডি চেকআউট অন্তর্ভুক্ত।</span>
            <span data-lang="en">Every design includes a responsive layout, Bangla-English bilingual copy and an order-ready checkout.</span>
        </p>
        <p>© {{ date('Y') }} — <a href="{{ route('showcase.index') }}">AcharBari Showcase</a></p>
    </footer>

    <!-- ================= CART DRAWER ================= -->
    <div class="sc-drawer-overlay" id="scDrawerOverlay" onclick="scToggleDrawer(false)"></div>
    <aside class="sc-drawer" id="scDrawer" aria-label="cart drawer">
        <div class="sc-drawer-head">
            <b><i class="fa-solid fa-cart-shopping"></i> <span data-lang="bn">আপনার ডিজাইন কার্ট</span><span data-lang="en">Your Design Cart</span></b>
            <button type="button" class="sc-drawer-close" onclick="scToggleDrawer(false)" aria-label="close">×</button>
        </div>
        <div class="sc-drawer-body" id="scDrawerBody"></div>
        <div class="sc-drawer-foot">
            <div class="sc-total-row">
                <span><span data-lang="bn">সাবটোটাল</span><span data-lang="en">Subtotal</span></span>
                <span id="sc-drawer-subtotal">৳ 0</span>
            </div>
            <div class="sc-total-row grand">
                <span><span data-lang="bn">সর্বমোট (ডেলিভারিসহ)</span><span data-lang="en">Grand Total</span></span>
                <span id="sc-drawer-grand">৳ 0</span>
            </div>
            <a class="sc-btn sc-btn-order" href="#order" onclick="scToggleDrawer(false)">
                <i class="fa-solid fa-arrow-right"></i>
                <span data-lang="bn">চেকআউট করুন</span>
                <span data-lang="en">Checkout</span>
            </a>
        </div>
    </aside>

    <button type="button" class="sc-cart-fab" id="scCartFab" onclick="scToggleDrawer(true)">
        <i class="fa-solid fa-cart-shopping"></i>
        <span><span data-lang="bn">কার্ট</span><span data-lang="en">Cart</span></span>
        <span class="n" id="scCartCount">0</span>
    </button>

    {{-- design catalogue for the cart JS: product id + price come from the DB rows --}}
    @php
        $designsJs = $designs->mapWithKeys(fn ($d) => [$d['key'] => [
            'id' => $d['product']?->id,
            'name' => $d['name_bn'],
            'name_en' => $d['name_en'],
            'price' => (float) ($d['product']?->price ?? $d['price']),
            'img' => asset($d['cover']),
        ]])->all();
    @endphp
    <script>
        window.SC_DESIGNS = @json($designsJs);
        window.AB_COUPONS = @json($coupons);
    </script>
@endsection
