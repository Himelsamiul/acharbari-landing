{{-- Section: checkout | Design 1 (extracted original) --}}
<!-- ================= CHECKOUT ORDER FORM SECTION ================= -->
    {{-- live product data for cart + quick view (single source of truth: DB) --}}
    <script>
        window.quickViewProducts = @json($qv);
        window.AB_COUPONS = @json(\App\Models\Coupon::activeMap());
    </script>
    {{-- Structured data: product catalog for rich results --}}
    @php
        $ldProducts = $products->map(fn ($p, $i) => [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'item' => [
                '@type' => 'Product',
                'name' => $p->name_en ?: $p->name,
                'image' => url(asset(ab_img($p->image))),
                'description' => $p->description_en ?: $p->description,
                'offers' => [
                    '@type' => 'Offer',
                    'price' => $p->price,
                    'priceCurrency' => 'BDT',
                    'availability' => $p->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                ],
            ],
        ])->all();
    @endphp
    <script type="application/ld+json">
        @json(['@context' => 'https://schema.org', '@type' => 'ItemList', 'itemListElement' => $ldProducts])
    </script>
    <section id="order-form" class="py-12 px-4">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl border border-emerald-200 overflow-hidden">
            <div class="text-center p-6 border-b border-green-100 bg-white">
                <div class="lp-order-head-ic mx-auto">
                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                </div>
                @php
                    $ohA = ab_t('order_head_a', 'ক্যাশ অন ডেলিভারিতে অর্ডার করতে ', 'Fill in the ');
                    $ohB = ab_t('order_head_b', 'ফর্মটি সঠিকভাবে', 'form correctly');
                    $ohC = ab_t('order_head_c', ' পূরণ করুন', ' to order on Cash on Delivery');
                    $ohSub = ab_t('order_head_sub', 'আপনার তথ্য দেওয়ার পর আমাদের কল সেন্টার থেকে ফোন করে অর্ডার কনফার্ম করা হবে।', 'After you submit your details, our call centre will phone you to confirm the order.');
                @endphp
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                    <span data-en="{{ $ohA['en'] }}">{{ $ohA['bn'] }}</span><span class="text-emerald-600" data-en="{{ $ohB['en'] }}">{{ $ohB['bn'] }}</span><span data-en="{{ $ohC['en'] }}">{{ $ohC['bn'] }}</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1" data-en="{{ $ohSub['en'] }}">{{ $ohSub['bn'] }}</p>
            </div>

            <div class="p-6 md:p-8">
                @php
                    $dIn = ab_charge('delivery_inside', 80);
                    $dOut = ab_charge('delivery_outside', 150);
                    $cartT = ab_t('cart_title', 'আপনার কার্ট', 'Your Cart');
                    $couponPh = ab_t('cart_coupon_ph', 'কুপন কোড লিখুন (যেমন: ACHAR10)', 'Enter coupon code (e.g. ACHAR10)');
                    $couponNote = ab_t('cart_coupon_note', 'কুপন থাকলে প্রয়োগ করুন, ডিসকাউন্ট অটো ক্যালকুলেট হবে।', 'If you have a coupon, apply it — discount is calculated automatically.');
                    $colM = ab_t('cart_col_mark', 'মার্ক', 'Mark');
                    $colP = ab_t('cart_col_product', 'প্রোডাক্ট', 'Product');
                    $colQ = ab_t('cart_col_qty', 'পরিমাণ', 'Qty');
                    $colPr = ab_t('cart_col_price', 'মূল্য', 'Price');
                    $totSub = ab_t('cart_total_sub', 'মোট', 'Subtotal');
                    $totDel = ab_t('cart_total_delivery', 'ডেলিভারি চার্জ', 'Delivery Charge');
                    $totGrand = ab_t('cart_total_grand', 'সর্বমোট', 'Grand Total');
                    $cartEmpty = ab_t('cart_empty', 'কার্ট এখন খালি — উপরের প্রোডাক্ট কার্ডের অর্ডার করুন বাটনে চাপ দিলে পছন্দের পণ্য এখানে যোগ হবে।', 'Cart is empty now — click the "Order Now" button on a product card above and your favourite jars will be added here.');
                    $advT = ab_t('advance_title', 'অগ্রিম পেমেন্ট প্রয়োজন', 'Advance Payment Required');
                    $advPay = ab_t('advance_payable', 'Payable Now', 'এখনই পরিশোধ');
                    $advDue = ab_t('advance_due', 'Due', 'বাকি');
                    $chkT = ab_t('checkout_title', 'ডেলিভারি তথ্য দিন', 'Enter Delivery Info');
                    $phName = ab_t('f_name_ph', 'যেমন: মোঃ কামরুল হাসান', 'e.g. Md. Kamrul Hasan');
                    $phPhone = ab_t('f_phone_ph', '০১xxxxxxxxx (১১ সংখ্যা)', '01xxxxxxxxx (11 digits)');
                    $phAddr = ab_t('f_address_ph', 'বাসা নং, রোড, এলাকা, থানা ও জেলা', 'House no., road, area, thana & district');
                    $fArea = ab_t('f_area', 'ডেলিভারি এরিয়া', 'Delivery Area');
                    $areaPick = ab_t('area_pick', 'প্রোডাক্ট সিলেক্ট করুন', 'Select a product');
                    $areaIn = ab_t('area_inside', 'ঢাকার ভিতরে', 'Inside Dhaka');
                    $areaOut = ab_t('area_outside', 'ঢাকার বাহিরে', 'Outside Dhaka');
                    $areaFree = ab_t('area_free', 'ফ্রি ডেলিভারি - কোন চার্জ নেই', 'Free Delivery — No Charge');
                    $payT = ab_t('pay_method', 'পেমেন্ট মেথড', 'Payment Method');
                    $codT = ab_t('pay_cod', 'ক্যাশ অন ডেলিভারি', 'Cash On Delivery');
                    $codS = ab_t('pay_cod_sub', 'আগে পার্সেল দেখুন, তারপর টাকা দিন', 'Check the parcel first, then pay');
                    $onlT = ab_t('pay_online', 'অনলাইন পেমেন্ট — বিকাশ / নগদ', 'Online Payment — bKash / Nagad');
                    $onlNA = ab_t('pay_online_note_a', 'অর্ডার কনফার্ম করলে সরাসরি ', 'After confirming you go straight ');
                    $onlNB = ab_t('pay_online_note_b', ' পেমেন্ট পেজে নিয়ে যাওয়া হবে — সেখানে পেমেন্ট শেষ করুন।', ' to the payment page to complete the payment.');
                    $confirmBtn = ab_t('confirm_order', 'অর্ডার কনফার্ম করুন', 'Confirm Order');
                    $tr1 = ab_t('trust_1', 'নিরাপদ অর্ডার', 'Secure order');
                    $tr2 = ab_t('trust_2', 'দেখে টাকা দিন', 'Pay after checking');
                    $tr3 = ab_t('trust_3', 'ভাঙা জারে ফ্রি রিপ্লেসমেন্ট', 'Broken jar? Free replacement');
                @endphp
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                    <!-- Left: Cart Summary & Coupon -->
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="p-4 border-b bg-gray-50 flex items-center justify-between">
                            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                                <svg class="text-emerald-600 mr-1" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 11-1 9"/><path d="m19 11-4-7"/><path d="M2 11h20"/><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"/><path d="M4.5 15.5h15"/><path d="m5 11 4-7"/><path d="m9 11 1 9"/></svg> <span data-en="{{ $cartT['en'] }}">{{ $cartT['bn'] }}</span>
                            </h3>
                            <span class="text-xs text-gray-500 font-semibold" id="cart-item-count-label">0
                                item(s)</span>
                        </div>

                        <div class="p-4 border-b bg-white">
                            <div class="flex gap-2">
                                <input id="coupon_input" name="coupon_code" type="text"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 outline-none"
                                    placeholder="{{ $couponPh['bn'] }}" data-en-ph="{{ $couponPh['en'] }}">
                                <button type="button" onclick="submitCoupon()"
                                    class="bg-emerald-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-emerald-700 transition whitespace-nowrap">
                                    <span data-en="Apply">প্রয়োগ করুন</span>
                                </button>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-2" data-en="{{ $couponNote['en'] }}">{{ $couponNote['bn'] }}</p>
                            <p class="lp-coupon-msg" id="couponMsg" hidden></p>
                            @php
                                $activeCoupons = \App\Models\Coupon::activeMap();
                            @endphp
                            @if (count($activeCoupons))
                                <div class="mt-3" id="coupon_list">
                                    <p class="text-[11px] font-bold text-gray-600 mb-1.5" data-en="Available coupons — tap to apply:">চালু কুপন — ক্লিক করলেই প্রয়োগ হবে:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($activeCoupons as $cCode => $cPct)
                                            <button type="button" onclick="applyCouponFromList('{{ $cCode }}')"
                                                class="lp-coupon-chip inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full border border-dashed border-amber-400 bg-amber-50 text-amber-700 hover:bg-amber-100 transition"
                                                data-en="{{ $cCode }} — {{ $cPct }}% off">
                                                🎟️ {{ $cCode }} — {{ bn_num($cPct) }}% ছাড়
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="cartlist p-4">
                            <div class="lp-cart-wrapper" data-cart-items="[]" data-subtotal="0" data-grand="{{ $dIn }}"
                                data-has-all-free-delivery="0" data-has-digital-only="0" data-cart-empty="1">

                                <div class="lp-cart-header">
                                    <div class="text-center" data-en="{{ $colM['en'] }}">{{ $colM['bn'] }}</div>
                                    <div data-en="{{ $colP['en'] }}">{{ $colP['bn'] }}</div>
                                    <div class="text-center" data-en="{{ $colQ['en'] }}">{{ $colQ['bn'] }}</div>
                                    <div class="text-end" data-en="{{ $colPr['en'] }}">{{ $colPr['bn'] }}</div>
                                </div>

                                <div class="lp-cart-totals">
                                    <div class="lp-cart-total-row">
                                        <span data-en="{{ $totSub['en'] }}">{{ $totSub['bn'] }}</span>
                                        <span id="net_total">৳ <strong>0</strong></span>
                                    </div>
                                    <div class="lp-cart-total-row">
                                        <span data-en="{{ $totDel['en'] }}">{{ $totDel['bn'] }}</span>
                                        <span id="cart_shipping_cost">৳ <strong>{{ $dIn }}</strong></span>
                                    </div>
                                    <div class="lp-cart-total-row final">
                                        <span data-en="{{ $totGrand['en'] }}">{{ $totGrand['bn'] }}</span>
                                        <span id="grand_total">৳ <strong>{{ $dIn }}</strong></span>
                                    </div>
                                </div>
                            </div>

                            <div class="lp-cart-empty" id="lpCartEmpty">
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 11-1 9"/><path d="m19 11-4-7"/><path d="M2 11h20"/><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"/><path d="M4.5 15.5h15"/><path d="m5 11 4-7"/><path d="m9 11 1 9"/></svg>
                                <span data-en="{{ $cartEmpty['en'] }}">{{ $cartEmpty['bn'] }}</span>
                            </div>

                            {{-- কার্টের নিচে প্রোডাক্ট স্ট্রিপ — উপরে স্ক্রল না করেও আরও প্রোডাক্ট যোগ করা যায় --}}
                            @if (!empty($qv))
                                <style>
                                    .lp-cart-add-strip { margin-top: 14px; padding: 12px; border: 1px dashed rgba(5,150,105,.3);
                                        border-radius: 14px; background: rgba(5,150,105,.03); }
                                    .lp-strip-label { font-size: 12.5px; font-weight: 800; color: #1f4234; margin-bottom: 8px; }
                                    .lp-strip-row { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 4px; }
                                    .lp-strip-item { min-width: 108px; max-width: 108px; background: #fff; border: 1px solid rgba(5,150,105,.18);
                                        border-radius: 12px; padding: 8px; display: flex; flex-direction: column; gap: 4px; }
                                    .lp-strip-item img { width: 100%; height: 64px; object-fit: cover; border-radius: 8px; }
                                    .lp-strip-name { font-size: 11px; font-weight: 700; color: #33443c;
                                        overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
                                    .lp-strip-price { font-size: 11.5px; font-weight: 800; color: #047857; }
                                    .lp-strip-add { border: none; background: #059669; color: #fff; font-size: 11.5px;
                                        font-weight: 800; padding: 5px 0; border-radius: 8px; cursor: pointer; }
                                    .lp-strip-add:hover { filter: brightness(1.08); }
                                </style>
                                <div class="lp-cart-add-strip">
                                    <div class="lp-strip-label" data-en="Add more products:">আরও প্রোডাক্ট যোগ করুন:</div>
                                    <div class="lp-strip-row">
                                        @foreach ($qv as $pid => $p)
                                            <div class="lp-strip-item">
                                                <img src="{{ $p['img'] }}" alt="{{ $p['alt'] }}" loading="lazy">
                                                <span class="lp-strip-name">{{ $p['title'] }}</span>
                                                <span class="lp-strip-price">{{ $p['price'] }}</span>
                                                <button type="button" class="lp-strip-add"
                                                    onclick="selectProductForOrder({{ $pid }})">
                                                    + যোগ
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div id="landing-advance-box" class="p-4 border-t bg-yellow-50 hidden">
                            <div class="text-sm font-bold text-yellow-800" data-en="{{ $advT['en'] }}">{{ $advT['bn'] }}</div>
                            <div class="mt-2 text-sm flex justify-between">
                                <span class="text-green-700 font-semibold" data-en="{{ $advPay['en'] }}">{{ $advPay['bn'] }}</span>
                                <span id="landing-advance-amount" class="font-bold text-green-700">৳ 0.00</span>
                            </div>
                            <div class="mt-1 text-sm flex justify-between">
                                <span class="text-red-700 font-semibold" data-en="{{ $advDue['en'] }}">{{ $advDue['bn'] }}</span>
                                <span id="landing-due-amount" class="font-bold text-red-700">৳ 0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Checkout Form -->
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="p-4 border-b bg-gray-50">
                            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                                <svg class="text-emerald-600 mr-1" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><path d="M16 10h2"/><path d="M16 14h2"/></svg> <span data-en="{{ $chkT['en'] }}">{{ $chkT['bn'] }}</span>
                            </h3>
                        </div>

                        <form id="landing-checkout-form" action="{{ route('order.store') }}" method="POST" class="p-6">
                            @csrf
                            <input type="hidden" name="items" id="cart_items_input">
                            <input type="hidden" name="coupon_code" id="coupon_hidden_code" value="">
                            <input type="hidden" name="landing_checkout" value="1">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="name">
                                        <span data-en="Your Full Name">আপনার সম্পূর্ণ নাম</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="name" type="text" name="customer_name" required="" value=""
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"
                                        placeholder="{{ $phName['bn'] }}" data-en-ph="{{ $phName['en'] }}">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="phone">
                                        <span data-en="Mobile Number">মোবাইল নাম্বার</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="phone" type="tel" inputmode="numeric" maxlength="15" name="phone" required="" value=""
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"
                                        placeholder="{{ $phPhone['bn'] }}" data-en-ph="{{ $phPhone['en'] }}">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="address">
                                        <span data-en="Full Delivery Address">সম্পূর্ণ ডেলিভারি ঠিকানা</span> <span class="text-red-500">*</span>
                                    </label>
                                    <input id="address" type="text" name="address" required="" value=""
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none"
                                        placeholder="{{ $phAddr['bn'] }}" data-en-ph="{{ $phAddr['en'] }}">
                                </div>

                                <div id="landing-area-wrapper">
                                    <label class="block text-xs font-bold text-gray-700 mb-1" for="area"><span
                                            data-en="{{ $fArea['en'] }}">{{ $fArea['bn'] }}</span></label>
                                    <input type="hidden" name="area" id="landing_area_input" value="inside">
                                    <input type="hidden" name="district" id="landing_district_input" value="">

                                    <div id="landing-area-empty" class="">
                                        <input type="text"
                                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-gray-100 cursor-not-allowed"
                                            value="{{ $areaPick['bn'] }}" data-en-val="{{ $areaPick['en'] }}" readonly="">
                                    </div>

                                    <div id="landing-area-digital" class="hidden">
                                        <input type="text"
                                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-gray-100"
                                            value="Digital Product (No Shipping Charge)" readonly="">
                                    </div>

                                    <div id="landing-area-physical-wrap" class="hidden">
                                        <div id="landing-area-select-wrap" class="">
                                            @php
                                                $abDistricts = ab_districts();
                                                $abDhaka = null;
                                                foreach ($abDistricts as $d) {
                                                    if (strcasecmp((string) $d['en'], 'Dhaka') === 0) { $abDhaka = $d; break; }
                                                }
                                                $abOutside = array_values(array_filter($abDistricts, fn ($d) => strcasecmp((string) $d['en'], 'Dhaka') !== 0));
                                            @endphp
                                            @if ($abDhaka && count($abOutside))
                                                {{-- zone picker: "ঢাকার ভিতরে" select korle district khujte hoy na --}}
                                                <select id="area_zone"
                                                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none bg-white"
                                                    required="">
                                                    <option value="inside" data-charge="{{ $abDhaka['charge'] }}">
                                                        ঢাকার ভিতরে (Dhaka) — ৳{{ bn_num($abDhaka['charge']) }}
                                                    </option>
                                                    <option value="outside">ঢাকার বাইরে (Outside Dhaka)</option>
                                                </select>
                                                <div id="landing-outside-wrap" class="hidden mt-2">
                                                    <select id="area"
                                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none bg-white"
                                                        required="">
                                                        @foreach ($abOutside as $d)
                                                            <option value="{{ $d['en'] }}" data-charge="{{ $d['charge'] }}" data-area="outside">
                                                                {{ $d['bn'] }} ({{ $d['en'] }}) — ৳{{ bn_num($d['charge']) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @elseif ($abDhaka)
                                                {{-- shudhu Dhaka-te delivery — kono district list/search nei --}}
                                                <select id="area" class="hidden" tabindex="-1" aria-hidden="true">
                                                    <option value="Dhaka" data-charge="{{ $abDhaka['charge'] }}" data-area="inside" selected>
                                                        {{ $abDhaka['bn'] }} ({{ $abDhaka['en'] }}) — ৳{{ bn_num($abDhaka['charge']) }}
                                                    </option>
                                                </select>
                                                <input type="text" readonly
                                                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-green-50 text-green-800 font-semibold"
                                                    value="ঢাকার ভিতরে — ৳{{ bn_num($abDhaka['charge']) }}">
                                            @else
                                                {{-- Dhaka nai — config kora district der list (aage jemon chhilo) --}}
                                                <select id="area"
                                                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none bg-white"
                                                    required="">
                                                    @foreach ($abOutside as $d)
                                                        <option value="{{ $d['en'] }}" data-charge="{{ $d['charge'] }}" data-area="outside">
                                                            {{ $d['bn'] }} ({{ $d['en'] }}) — ৳{{ bn_num($d['charge']) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                        <div id="landing-free-delivery-wrap" class="hidden">
                                            <input type="text"
                                                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm bg-green-50 text-green-800 font-semibold"
                                                value="{{ $areaFree['bn'] }}" data-en-val="{{ $areaFree['en'] }}" readonly="">
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-xl p-3 bg-white">
                                    <div class="text-sm font-bold text-gray-800 mb-2" data-en="{{ $payT['en'] }}">{{ $payT['bn'] }}</div>

                                    <div id="landing-advance-note"
                                        class="mb-3 p-3 rounded-lg border border-yellow-200 bg-yellow-50 text-sm text-yellow-900 hidden">
                                        <span data-en="This order requires an advance payment of ">এই অর্ডারে </span><b id="landing-advance-note-amount">৳ 0.00</b><span data-en=". COD is not available."> অগ্রিম পেমেন্ট করতে হবে। COD পাওয়া যাবে না।</span>
                                    </div>

                                    <div id="payment-methods-grid" class="space-y-2">
                                        <div id="cod-option-wrapper">
                                            <label class="pay-opt sel" style="--pbc:var(--ds-primary)">
                                                <span class="pay-ic"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></span>
                                                <span class="pay-tx">
                                                    <b data-en="{{ $codT['en'] }}">{{ $codT['bn'] }}</b>
                                                    <small data-en="{{ $codS['en'] }}">{{ $codS['bn'] }}</small>
                                                </span>
                                                <input type="radio" name="payment_method" id="payment_cod" value="cod"
                                                    checked="" class="accent-emerald-600">
                                            </label>
                                        </div>
                                        @if (ab_online_payment())
                                        <button type="button" class="pay-toggle" id="onlinePayToggle"
                                            onclick="toggleOnlinePay()">
                                            <span class="pay-toggle-l">
                                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/></svg>
                                                <span data-en="{{ $onlT['en'] }}">{{ $onlT['bn'] }}</span>
                                            </span>
                                            <svg class="pay-toggle-chev" viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                                        </button>
                                        <div class="pay-collapse" id="onlinePayWrap">
                                            <div class="pay-collapse-in">
                                                <div class="grid grid-cols-2 gap-2">
                                                    @if (\App\Services\Payment\BkashGateway::enabled())
                                                    <label class="pay-opt" style="--pbc:#e2136e">
                                                        <span class="pay-ic"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
                                                        <span class="pay-tx"><b>bKash</b><small data-en="Pay online">অনলাইনে পেমেন্ট</small></span>
                                                        <input type="radio" name="payment_method" value="bkash">
                                                    </label>
                                                    @endif
                                                    @if (\App\Services\Payment\NagadGateway::enabled())
                                                    <label class="pay-opt" style="--pbc:#f6921e">
                                                        <span class="pay-ic"><img src="{{ asset('assets/img/pay/nagad.svg') }}" alt="Nagad"></span>
                                                        <span class="pay-tx"><b>Nagad</b><small data-en="Pay online">অনলাইনে পেমেন্ট</small></span>
                                                        <input type="radio" name="payment_method" value="nagad">
                                                    </label>
                                                    @endif
                                                </div>
                                                <div id="payOnlineNote">
                                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                                                    <span data-en="{{ $onlNA['en'] }}{{ $onlNB['en'] }}">
                                                        {{ $onlNA['bn'] }}{{ $onlNB['bn'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div id="payment-error" class="hidden mt-2 text-sm font-bold text-red-600">
                                        <span data-en="Please select a payment method.">অনুগ্রহ করে একটি পেমেন্ট মেথড সিলেক্ট করুন।</span>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full bg-emerald-600 text-white font-bold text-lg px-4 py-3.5 rounded-xl shadow-lg hover:bg-emerald-700 transition flex justify-center items-center gap-2">
                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> <span data-en="{{ $confirmBtn['en'] }}">{{ $confirmBtn['bn'] }}</span>
                                </button>

                                <div class="lp-trust-row">
                                    <span><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> <span data-en="{{ $tr1['en'] }}">{{ $tr1['bn'] }}</span></span>
                                    <span><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg> <span data-en="{{ $tr2['en'] }}">{{ $tr2['bn'] }}</span></span>
                                    <span><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg> <span data-en="{{ $tr3['en'] }}">{{ $tr3['bn'] }}</span></span>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
<style>
/* modern polish (scoped, additive) */
#order-form .max-w-6xl { box-shadow: 0 34px 70px -36px rgba(6,78,59,.45); }
#order-form input:focus, #order-form select:focus { box-shadow: 0 0 0 4px rgba(5,150,105,.1); }
#landing-checkout-form button[type="submit"] { transition: transform .18s ease, box-shadow .25s ease; }
#landing-checkout-form button[type="submit"]:hover { transform: translateY(-2px); }
</style>
