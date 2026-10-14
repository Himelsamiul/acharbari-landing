/* ============================================================
   AcharBari — showcase.js
   /showcase gallery cart: add designs (qty fixed 1 each), drawer,
   coupon, totals and the hidden-field assembly for the normal
   form POST to /order (OrderController re-prices everything).
   ============================================================ */
(function () {
    'use strict';

    var cart = {};            // { designKey: true } — one landing page per design
    var coupon = null;        // { code, pct }
    var COUPONS = window.AB_COUPONS || {};
    var DESIGNS = window.SC_DESIGNS || {};

    /* ---------- helpers ---------- */
    function en() { return window.AB && AB.lang === 'en'; }
    function L(bn, enStr) { return en() ? enStr : bn; }
    function esc(s) { return String(s == null ? '' : s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'); }
    function bnNum(nStr) {
        return String(nStr).replace(/[0-9]/g, function (d) { return '০১২৩৪৫৬৭৮৯'[+d]; });
    }
    function money(n) {
        var f = Math.round(n).toLocaleString('en-US');
        return '৳ ' + (en() ? f : bnNum(f));
    }
    function keys() { return Object.keys(cart); }
    function design(key) { return DESIGNS[key] || null; }

    /* ---------- delivery area (mirrors the store checkout contract) ---------- */
    function areaSelection() {
        var zone = document.getElementById('sc-zone');
        if (zone && zone.selectedOptions && zone.selectedOptions[0]) {
            var z = zone.selectedOptions[0];
            if (z.value === 'inside') {
                var zc = parseFloat(z.getAttribute('data-charge'));
                return { area: 'inside', district: z.getAttribute('data-district') || 'Dhaka', charge: isNaN(zc) ? 80 : zc };
            }
        }
        var sel = document.getElementById('sc-district');
        if (sel && sel.selectedOptions && sel.selectedOptions[0] && sel.style.display !== 'none') {
            var o = sel.selectedOptions[0];
            var c = parseFloat(o.getAttribute('data-charge'));

            return { area: o.getAttribute('data-area') || 'outside', district: sel.value || '', charge: isNaN(c) ? 0 : c };
        }

        return { area: 'inside', district: '', charge: 80 };
    }

    /* ---------- totals (VAT 0 on landing-design rows — server agrees) ---------- */
    function compute() {
        var subtotal = 0;
        keys().forEach(function (k) {
            var d = design(k);
            if (d) subtotal += d.price;
        });
        var discount = coupon ? Math.round(subtotal * coupon.pct / 100) : 0;
        var pick = areaSelection();
        var shipping = keys().length ? pick.charge : 0;

        return { subtotal: subtotal, discount: discount, shipping: shipping, grand: Math.max(0, subtotal - discount) + shipping, pick: pick };
    }

    /* ---------- render ---------- */
    function render() {
        var fab = document.getElementById('scCartFab');
        var count = document.getElementById('scCartCount');
        var body = document.getElementById('scDrawerBody');
        var list = keys();

        if (fab) fab.classList.toggle('show', list.length > 0);
        if (count) count.textContent = list.length;

        if (body) {
            if (!list.length) {
                body.innerHTML = '<p class="sc-cart-empty">' + L(
                    'কার্ট এখন খালি — উপরের ডিজাইন কার্ডের "অর্ডার করুন" বাটনে চাপ দিন।',
                    'Cart is empty — hit "Order" on a design card above.') + '</p>';
            } else {
                body.innerHTML = list.map(function (k) {
                    var d = design(k);
                    if (!d) return '';
                    return '<div class="sc-cart-row">' +
                        '<img src="' + esc(d.img) + '" alt="">' +
                        '<div class="sc-cart-row-info"><b>' + esc(en() ? (d.name_en || d.name) : d.name) + '</b>' +
                        '<small>' + L('ল্যান্ডিং পেজ ডিজাইন × ১', 'Landing page design × 1') + '</small></div>' +
                        '<span class="sc-cart-row-price">' + money(d.price) + '</span>' +
                        '<button type="button" class="sc-cart-row-x" onclick="scRemoveFromCart(\'' + esc(k) + '\')" aria-label="remove">×</button>' +
                        '</div>';
                }).join('');
            }
        }

        var t = compute();

        var dSub = document.getElementById('sc-drawer-subtotal');
        var dGrand = document.getElementById('sc-drawer-grand');
        if (dSub) dSub.textContent = money(t.subtotal);
        if (dGrand) dGrand.textContent = money(t.grand);

        // checkout summary
        var rows = document.getElementById('sc-summary-rows');
        if (rows) {
            rows.innerHTML = list.length
                ? list.map(function (k) {
                    var d = design(k);
                    if (!d) return '';
                    return '<div class="sc-cart-row">' +
                        '<img src="' + esc(d.img) + '" alt="">' +
                        '<div class="sc-cart-row-info"><b>' + esc(en() ? (d.name_en || d.name) : d.name) + '</b>' +
                        '<small>' + L('ল্যান্ডিং পেজ ডিজাইন × ১', 'Landing page design × 1') + '</small></div>' +
                        '<span class="sc-cart-row-price">' + money(d.price) + '</span>' +
                        '</div>';
                  }).join('')
                : '<p class="sc-cart-empty">' + L('কার্ট এখন খালি — উপরের ডিজাইন কার্ডের "অর্ডার করুন" বাটনে চাপ দিন।', 'Cart is empty — hit "Order" on a design card above.') + '</p>';
        }
        var set = function (id, val) { var el = document.getElementById(id); if (el) el.textContent = val; };
        set('sc-subtotal', money(t.subtotal));
        set('sc-shipping', money(t.shipping));
        set('sc-grand', money(t.grand));
        var dRow = document.getElementById('sc-discount-row');
        if (dRow) {
            dRow.style.display = coupon ? '' : 'none';
            if (coupon) {
                set('sc-discount-label', L('ডিসকাউন্ট (' + coupon.code + ')', 'Discount (' + coupon.code + ')'));
                set('sc-discount', '− ' + money(t.discount));
            }
        }

        // card buttons reflect the cart (bn + en label spans both stay in sync)
        function setCardBtn(key, added) {
            var card = document.getElementById('sc-card-' + key);
            if (!card) return;
            var btn = card.querySelector('.sc-btn-order');
            if (!btn) return;
            btn.classList.toggle('added', added);
            var spans = btn.querySelectorAll('[data-lang]');
            if (spans[0]) spans[0].innerHTML = added
                ? '<i class="fa-solid fa-check"></i> কার্টে আছে'
                : '<i class="fa-solid fa-cart-plus"></i> অর্ডার করুন';
            if (spans[1]) spans[1].innerHTML = added
                ? '<i class="fa-solid fa-check"></i> In Cart'
                : '<i class="fa-solid fa-cart-plus"></i> Order';
        }
        keys().forEach(function (k) { setCardBtn(k, true); });
        Object.keys(DESIGNS).forEach(function (k) {
            if (!cart[k]) setCardBtn(k, false);
        });
    }

    /* ---------- drawer ---------- */
    window.scToggleDrawer = function (open) {
        var d = document.getElementById('scDrawer');
        var o = document.getElementById('scDrawerOverlay');
        if (d) d.classList.toggle('open', open);
        if (o) o.classList.toggle('open', open);
        document.body.style.overflow = open ? 'hidden' : '';
    };

    /* ---------- cart ops ---------- */
    window.scAddToCart = function (key, btn) {
        var d = design(key);
        if (!d || !d.id) return;
        cart[key] = true;
        render();
        scToggleDrawer(true);
    };

    window.scRemoveFromCart = function (key) {
        delete cart[key];
        render();
    };

    /* ---------- coupon (same codes as the store checkout) ---------- */
    function couponMsg(text, ok) {
        var el = document.getElementById('sc-coupon-msg');
        if (!el) return;
        el.hidden = false;
        el.className = 'sc-coupon-msg ' + (ok ? 'ok' : 'err');
        el.textContent = text;
    }

    window.scSubmitCoupon = function () {
        var input = document.getElementById('sc-coupon-input');
        var code = input ? input.value.trim() : '';
        if (!code) {
            coupon = null;
            couponMsg(L('কুপন কোড লিখে আবার চেষ্টা করুন।', 'Enter a coupon code and try again.'), false);
            render();
            return;
        }
        if (coupon && coupon.code.toUpperCase() === code.toUpperCase()) {
            coupon = null;
            couponMsg(L('কুপনটি সরানো হয়েছে।', 'Coupon removed.'), true);
            render();
            return;
        }
        var normalized = code.toUpperCase();
        if (COUPONS[normalized]) {
            coupon = { code: normalized, pct: COUPONS[normalized] };
            couponMsg(L('কুপন প্রয়োগ হয়েছে — ' + coupon.pct + '% ডিসকাউন্ট!', 'Coupon applied — ' + coupon.pct + '% discount!'), true);
        } else {
            coupon = null;
            couponMsg(L('কুপনটি প্রয়োজ্য নয়।', 'This coupon is not valid.'), false);
        }
        render();
    };

    window.scApplyCouponList = function (code) {
        var input = document.getElementById('sc-coupon-input');
        if (input) input.value = code;
        if (coupon && coupon.code === String(code).toUpperCase()) return;
        scSubmitCoupon();
    };

    /* ---------- area selects ---------- */
    function syncAreaSelects() {
        var zone = document.getElementById('sc-zone');
        var dist = document.getElementById('sc-district');
        if (zone && dist) {
            dist.style.display = zone.value === 'outside' ? '' : 'none';
        }
    }

    /* ---------- submit assembly (server re-prices everything) ---------- */
    function fail(msg) {
        var el = document.getElementById('sc-form-error');
        if (el) {
            el.textContent = msg;
            el.classList.add('show');
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('sc-checkout-form');
        if (form) {
            form.addEventListener('submit', function (e) {
                var err = document.getElementById('sc-form-error');
                if (err) err.classList.remove('show');

                var list = keys().map(function (k) { return design(k); }).filter(Boolean);
                if (!list.length) {
                    e.preventDefault();
                    fail(L('কার্ট খালি — অন্তত একটি ডিজাইন যোগ করুন।', 'Cart is empty — add at least one design.'));
                    return;
                }

                var phoneEl = form.querySelector('[name="phone"]');
                var digits = (phoneEl ? phoneEl.value : '').replace(/\D+/g, '');
                if (digits.indexOf('880') === 0) digits = '0' + digits.slice(3);
                if (!/^01[3-9]\d{8}$/.test(digits)) {
                    e.preventDefault();
                    fail(L('সঠিক মোবাইল নম্বর দিন — ১১ সংখ্যার নম্বর 01 দিয়ে শুরু (যেমন: 01712345678)।', 'Enter a valid mobile number — 11 digits starting with 01 (e.g. 01712345678).'));
                    return;
                }

                var checked = form.querySelector('input[name="payment_method"]:checked');
                if (!checked) {
                    e.preventDefault();
                    fail(L('একটি পেমেন্ট মেথড সিলেক্ট করুন।', 'Select a payment method.'));
                    return;
                }
                if (checked.value === 'manual') {
                    var ref = document.getElementById('sc-payment-ref');
                    if (ref && ref.value.trim() === '') {
                        e.preventDefault();
                        fail(L('টাকা পাঠানোর পর TrxID লিখুন — তারপর অর্ডার করুন।', 'Enter the TrxID after sending the money — then place the order.'));
                        return;
                    }
                }

                var t = compute();
                document.getElementById('sc-items-input').value = JSON.stringify(list.map(function (d) {
                    return { id: d.id, qty: 1 };
                }));
                document.getElementById('sc-coupon-hidden').value = coupon ? coupon.code : '';
                document.getElementById('sc-area-input').value = t.pick.area;
                document.getElementById('sc-district-input').value = keys().length ? t.pick.district : '';
                // natural POST → OrderController derives source='landing' server-side
            });

            // payment option highlight + manual TrxID field
            form.querySelectorAll('input[name="payment_method"]').forEach(function (r) {
                r.addEventListener('change', function () {
                    form.querySelectorAll('.sc-pay-opt').forEach(function (l) { l.classList.remove('sel'); });
                    var box = r.closest('.sc-pay-opt');
                    if (box) box.classList.add('sel');
                    var ref = document.getElementById('sc-payment-ref');
                    if (ref) ref.style.display = r.value === 'manual' ? '' : 'none';
                });
            });
        }

        var zone = document.getElementById('sc-zone');
        var dist = document.getElementById('sc-district');
        if (zone) zone.addEventListener('change', function () { syncAreaSelects(); render(); });
        if (dist) dist.addEventListener('change', render);

        document.addEventListener('ab:lang', render);
        syncAreaSelects();
        render();
    });
})();
