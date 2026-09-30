/* ============================================================
   Custom shims: mini-jQuery + mini-Swiper
   (replaces jquery-3.6.3.min.js and swiper-bundle.min.js —
    only the features this page actually uses, ~6 KB total)
   ============================================================ */
(function () {
    'use strict';

    /* ---------------- mini-jQuery ---------------- */
    function Q(sel, ctx) {
        if (!(this instanceof Q)) return new Q(sel, ctx);
        var root = (ctx && ctx[0]) ? ctx[0] : (ctx instanceof Element ? ctx : document);
        this.nodes = [];
        try {
            if (typeof sel === 'string') {
                this.nodes = Array.prototype.slice.call(root.querySelectorAll(sel));
            } else if (sel) {
                this.nodes = sel.nodes ? sel.nodes.slice()
                    : (sel.length !== undefined ? Array.prototype.slice.call(sel) : [sel]);
            }
        } catch (e) { this.nodes = []; }
    }

    Q.prototype = {
        each: function (fn) { this.nodes.forEach(fn); return this; },
        on: function (types, arg2, arg3) {
            var selector = null, handler = arg2;
            if (typeof arg2 === 'string') { selector = arg2; handler = arg3; }
            types.split(/\s+/).forEach(function (t) {
                if (!t) return;
                this.nodes.forEach(function (node) {
                    node.addEventListener(t, function (e) {
                        if (selector) {
                            var target = e.target.closest(selector);
                            if (target && node.contains(target)) handler.call(target, e);
                        } else {
                            handler.call(node, e);
                        }
                    });
                });
            }, this);
            return this;
        },
        html: function (v) {
            if (v === undefined) return this.nodes[0] ? this.nodes[0].innerHTML : '';
            this.nodes.forEach(function (n) { n.innerHTML = v; });
            return this;
        },
        attr: function (name, val) {
            if (val === undefined) return this.nodes[0] ? this.nodes[0].getAttribute(name) : undefined;
            this.nodes.forEach(function (n) { n.setAttribute(name, val); });
            return this;
        },
        val: function (v) {
            if (v === undefined) return this.nodes[0] ? this.nodes[0].value : undefined;
            this.nodes.forEach(function (n) { n.value = v; });
            return this;
        },
        data: function (key) {
            var n = this.nodes[0];
            if (!n) return undefined;
            var v = n.getAttribute('data-' + key);
            try { return JSON.parse(v); } catch (e) { return v; }
        },
        addClass: function (c) { this.nodes.forEach(function (n) { n.classList.add(c); }); return this; },
        removeClass: function (c) { this.nodes.forEach(function (n) { n.classList.remove(c); }); return this; },
        empty: function () { this.nodes.forEach(function (n) { n.innerHTML = ''; }); return this; },
        offset: function () {
            var n = this.nodes[0];
            if (!n) return null;
            var r = n.getBoundingClientRect();
            return { top: r.top + window.scrollY, left: r.left + window.scrollX };
        },
        animate: function (props, dur) {
            if (props.scrollTop !== undefined) {
                var start = window.scrollY, end = props.scrollTop, t0 = performance.now();
                dur = dur || 300;
                (function step(t) {
                    var p = Math.min(1, (t - t0) / dur);
                    window.scrollTo(0, start + (end - start) * p);
                    if (p < 1) requestAnimationFrame(step);
                })(t0);
            }
            return this;
        }
    };

    Q.ajax = function (opts) {
        var method = (opts.type || opts.method || 'GET').toUpperCase();
        var url = opts.url;
        var init = { method: method, headers: { 'X-Requested-With': 'XMLHttpRequest' } };
        if (opts.data) {
            var qs = Object.keys(opts.data).map(function (k) {
                var v = opts.data[k];
                if (typeof v === 'object') v = JSON.stringify(v);
                return encodeURIComponent(k) + '=' + encodeURIComponent(v);
            }).join('&');
            if (method === 'GET') url += (url.indexOf('?') > -1 ? '&' : '?') + qs;
            else { init.body = qs; init.headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8'; }
        }
        var ok = typeof opts.success === 'function' ? opts.success : function () { };
        var fail = typeof opts.error === 'function' ? opts.error : function () { };
        fetch(url, init)
            .then(function (r) { return r.text(); })
            .then(function (text) {
                if (opts.dataType === 'json') { try { ok(JSON.parse(text)); } catch (e) { ok(text); } }
                else ok(text);
            })
            .catch(fail);
    };

    Q.ready = function (fn) { fn(); };
    Q.prototype.ready = function (fn) { fn(); return this; };
    window.jQuery = window.$ = Q;

    /* ---------------- mini-Swiper ----------------
       Supports: slidesPerView (fraction ok), spaceBetween, loop,
       autoplay{delay}, pagination{el, clickable}, breakpoints,
       pointer/touch swipe. */
    function Swiper(container, opts) {
        if (typeof container === 'string') container = document.querySelector(container);
        if (container) container.__swiperInit = (container.__swiperInit || 0) + 1;
        if (!container) return;
        var wrap = container.querySelector('.swiper-wrapper');
        if (!wrap) return;
        var slides = Array.prototype.slice.call(wrap.children);
        if (!slides.length) return;
        opts = opts || {};

        var self = this;
        var index = 0;
        var perView = 1, gap = opts.spaceBetween || 0, slideW = 0;
        var timer = null;
        var vpWidth = container.clientWidth || window.innerWidth;

        // saved-page artifacts: clear old inline transforms/widths
        wrap.style.removeProperty('transform');
        wrap.style.removeProperty('transition-duration');
        slides.forEach(function (s) {
            s.style.removeProperty('width');
            s.style.removeProperty('margin-right');
            s.classList.remove('swiper-slide-prev', 'swiper-slide-active', 'swiper-slide-next');
        });

        function resolveOpts() {
            var o = { slidesPerView: opts.slidesPerView || 1, spaceBetween: opts.spaceBetween || 0 };
            var bps = opts.breakpoints || {};
            Object.keys(bps).map(Number).sort(function (a, b) { return a - b; }).forEach(function (w) {
                if (vpWidth >= w) {
                    if (bps[w].slidesPerView !== undefined) o.slidesPerView = bps[w].slidesPerView;
                    if (bps[w].spaceBetween !== undefined) o.spaceBetween = bps[w].spaceBetween;
                }
            });
            return o;
        }

        function layout() {
            vpWidth = container.clientWidth || window.innerWidth;
            var o = resolveOpts();
            perView = Math.min(o.slidesPerView, slides.length);
            gap = o.spaceBetween;
            slideW = (container.clientWidth - gap * (Math.ceil(perView) - 1)) / perView;
            slides.forEach(function (s) {
                s.style.width = slideW + 'px';
                s.style.marginRight = gap + 'px';
                s.style.flexShrink = '0';
            });
            if (index > maxIndex()) index = maxIndex();
            apply();
        }

        function maxIndex() { return Math.max(0, slides.length - Math.ceil(perView)); }

        function apply() {
            wrap.style.transition = 'transform .45s cubic-bezier(.22,1,.36,1)';
            wrap.style.transform = 'translate3d(' + (-index * (slideW + gap)) + 'px,0,0)';
            slides.forEach(function (s, i) { s.classList.toggle('swiper-slide-active', i === index); });
            if (bullets) {
                bullets.forEach(function (b, i) {
                    b.classList.toggle('swiper-pagination-bullet-active', i === Math.min(index, bullets.length - 1));
                });
            }
        }

        this.slideTo = function (i) {
            index = Math.max(0, Math.min(i, maxIndex()));
            apply();
        };

        // pagination
        var bullets = [];
        var pagEl = (opts.pagination && opts.pagination.el)
            ? (document.querySelector(opts.pagination.el) || container.querySelector('.swiper-pagination'))
            : container.querySelector('.swiper-pagination');
        if (pagEl) {
            pagEl.innerHTML = '';
            var nPages = Math.max(1, slides.length - Math.ceil(perView) + 1);
            for (var i = 0; i < nPages; i++) {
                var b = document.createElement('button');
                b.className = 'swiper-pagination-bullet';
                b.type = 'button';
                b.setAttribute('aria-label', 'Go to slide ' + (i + 1));
                (function (idx) {
                    b.addEventListener('click', function () { self.slideTo(idx); restart(); });
                })(i);
                pagEl.appendChild(b);
                bullets.push(b);
            }
        }

        // swipe
        var startX = null, dragging = false;
        wrap.addEventListener('pointerdown', function (e) {
            startX = e.clientX; dragging = true; stop();
            wrap.style.transition = 'none';
        });
        window.addEventListener('pointermove', function (e) {
            if (!dragging) return;
            var dx = e.clientX - startX;
            wrap.style.transform = 'translate3d(' + (-index * (slideW + gap) + dx) + 'px,0,0)';
        });
        window.addEventListener('pointerup', function (e) {
            if (!dragging) return;
            dragging = false;
            var dx = e.clientX - startX;
            wrap.style.transition = '';
            if (Math.abs(dx) > 40) self.slideTo(index + (dx < 0 ? 1 : -1));
            else self.slideTo(index);
            restart();
        });

        // autoplay
        function stop() { if (timer) { clearInterval(timer); timer = null; } }
        function restart() {
            if (!opts.autoplay || !opts.autoplay.delay) return;
            stop();
            timer = setInterval(function () {
                self.slideTo(index >= maxIndex() ? 0 : index + 1);
            }, opts.autoplay.delay);
        }

        layout();
        restart();
        var rTimer = null;
        function relayout() { clearTimeout(rTimer); rTimer = setTimeout(layout, 150); }
        window.addEventListener('resize', relayout);
        window.addEventListener('orientationchange', relayout);
        if (typeof ResizeObserver !== 'undefined') {
            new ResizeObserver(relayout).observe(container);
        }
    }

    window.Swiper = Swiper;
})();


function addToCartFromRow(productId) {
    var cb = document.querySelector('#cart-row-' + productId + ' input[type="checkbox"]');
    if (cb && !cb.checked) {
        cb.checked = true;
    }
    toggleProductFromCart(productId, true);
}

function changeVariant(productId, sizeId, colorId) {
    var sizes = {};
    var colors = {};
    if (sizeId) sizes[productId] = parseInt(sizeId);
    if (colorId) colors[productId] = parseInt(colorId);
    var selectedIds = [];
    document.querySelectorAll('.lp-cart-row input[type="checkbox"]:checked').forEach(function (cb) {
        var row = cb.closest('.lp-cart-row');
        if (row) {
            var pid = row.id.replace('cart-row-', '');
            selectedIds.push(parseInt(pid));
        }
    });
    if (selectedIds.indexOf(productId) === -1) {
        selectedIds.push(productId);
        var cb = document.querySelector('#cart-row-' + productId + ' input[type="checkbox"]');
        if (cb) cb.checked = true;
    }

    $.ajax({
        type: "POST",
        url: "/cart/bulk-add",
        data: {
            product_ids: selectedIds,
            sizes: sizes,
            colors: colors,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (data) {
                $(".cartlist").html(data);
                cart_count();
            }
        }
    });
}

if (window.jQuery) {
    $('.cart_increment').on('click', function () {
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                type: "GET", data: { 'id': id },
                url: "/cart/increment",
                success: function (data) { if (data) { $(".cartlist").html(data); cart_count(); } }
            });
        }
    });

    $('.cart_decrement').on('click', function () {
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                type: "GET", data: { 'id': id },
                url: "/cart/decrement",
                success: function (data) { if (data) { $(".cartlist").html(data); cart_count(); } }
            });
        }
    });

    function cart_count() {
        $.ajax({
            type: "GET", url: "/cart/count",
            success: function (data) { if (data) { $("#cart-qty").html(data); } else { $("#cart-qty").empty(); } }
        });
    }
}

;
function updateAdvanceBoxForProduct(productId) {
    var box = document.getElementById('landing-advance-box');
    var note = document.getElementById('landing-advance-note');
    var codWrap = document.getElementById('cod-option-wrapper');
    var paymentCod = document.getElementById('payment_cod');

    var card = document.querySelector('.product-card[data-product-id="' + productId + '"]');
    var advance = card ? parseFloat(card.getAttribute('data-advance') || '0') : 0;
    if (isNaN(advance)) advance = 0;

    var hasAdvance = advance > 0;
    var cartEl = document.querySelector('.lp-cart-wrapper[data-has-digital-only]');
    var isDigitalOnly = cartEl && cartEl.getAttribute('data-has-digital-only') === '1';
    var hasPhysical = !isDigitalOnly;

    // COD: শুধুমাত্র ফিজিক্যাল প্রোডাক্ট ও অগ্রিম ছাড়া প্রোডাক্টে দেখাবে
    if (codWrap) {
        if (hasAdvance || !hasPhysical) {
            codWrap.classList.add('hidden');
            if (paymentCod && paymentCod.checked) {
                var firstOnline = document.querySelector('#payment-methods-grid input[name="payment_method"]:not(#payment_cod):not(#payment_manual)');
                if (firstOnline) { firstOnline.checked = true; }
            }
        } else {
            codWrap.classList.remove('hidden');
            if (paymentCod) paymentCod.checked = true;
        }
    }

    if (!hasAdvance) {
        if (box) box.classList.add('hidden');
        if (note) note.classList.add('hidden');
        return;
    }

    var grandTextEl = document.querySelector('#grand_total strong');
    var grandVal = 0;
    if (grandTextEl) {
        grandVal = parseFloat((grandTextEl.innerText || '').replace(/[^\d.]/g, '')) || 0;
    }
    var due = Math.max(0, grandVal - advance);

    if (document.getElementById('landing-advance-amount')) {
        document.getElementById('landing-advance-amount').innerText = '৳ ' + advance.toFixed(2);
    }
    if (document.getElementById('landing-due-amount')) {
        document.getElementById('landing-due-amount').innerText = '৳ ' + due.toFixed(2);
    }
    if (document.getElementById('landing-advance-note-amount')) {
        document.getElementById('landing-advance-note-amount').innerText = '৳ ' + advance.toFixed(2);
    }
    if (box) box.classList.remove('hidden');
    if (note) note.classList.remove('hidden');
}

// Update the cart and highlight the selected card (campaign-style)
// ===== Landing Products Data (for tracking) =====
window.landingProducts = {
};

// ===== Cart Mark Checkbox Handler =====
function toggleProductFromCart(productId, isChecked) {
    var row = document.getElementById('cart-row-' + productId);
    if (row) {
        row.classList.toggle('unchecked', !isChecked);
    }
    // Collect all checked product IDs from cart
    var selectedIds = [];
    document.querySelectorAll('.lp-cart-row input[type="checkbox"]:checked').forEach(function (cb) {
        var r = cb.closest('.lp-cart-row');
        if (r) {
            var pid = r.id.replace('cart-row-', '');
            selectedIds.push(parseInt(pid));
        }
    });

    $.ajax({
        type: "POST",
        url: "/cart/bulk-add",
        data: {
            product_ids: selectedIds.length > 0 ? selectedIds : [0],
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (data) {
                $(".cartlist").html(data);
                cart_count();
                updateAreaVisibility();
            }
        }
    });
}

function updateAreaVisibility() {
    var cartEl = document.querySelector('.lp-cart-wrapper');
    var areaEmpty = document.getElementById('landing-area-empty');
    var areaDigital = document.getElementById('landing-area-digital');
    var areaPhysicalWrap = document.getElementById('landing-area-physical-wrap');
    var areaSelectWrap = document.getElementById('landing-area-select-wrap');
    var freeDeliveryWrap = document.getElementById('landing-free-delivery-wrap');
    var areaSelect = document.getElementById('area');
    var areaInput = document.getElementById('landing_area_input');
    if (cartEl && areaEmpty && areaDigital && areaPhysicalWrap) {
        var isEmpty = cartEl.getAttribute('data-cart-empty') === '1';
        var isDigitalOnly = cartEl.getAttribute('data-has-digital-only') === '1';
        var isFree = cartEl.getAttribute('data-has-all-free-delivery') === '1';
        areaEmpty.classList.add('hidden');
        areaDigital.classList.add('hidden');
        areaPhysicalWrap.classList.remove('hidden');
        areaSelectWrap.classList.toggle('hidden', isFree);
        freeDeliveryWrap.classList.toggle('hidden', !isFree);
        if (areaSelect) areaSelect.toggleAttribute('required', !isFree);
        var zoneEl = document.getElementById('area_zone');
        var zoneInside = !!(zoneEl && zoneEl.value === 'inside');
        if (areaInput) areaInput.value = isFree ? 'inside' : (zoneInside ? 'inside' : (areaSelect ? ((areaSelect.selectedOptions && areaSelect.selectedOptions[0] && areaSelect.selectedOptions[0].getAttribute('data-area')) || 'inside') : 'inside'));
        var districtEl = document.getElementById('landing_district_input');
        if (districtEl && zoneInside && !isFree) districtEl.value = 'Dhaka';
    }
}

function updateAdvanceBoxMultiProduct(productIds) {
    var box = document.getElementById('landing-advance-box');
    var note = document.getElementById('landing-advance-note');
    var codWrap = document.getElementById('cod-option-wrapper');
    var paymentCod = document.getElementById('payment_cod');

    var totalAdvance = 0;
    var hasAnyPhysical = false;
    var hasAnyAdvance = false;

    productIds.forEach(function (pid) {
        var card = document.querySelector('.product-card[data-product-id="' + pid + '"]');
        if (card) {
            var adv = parseFloat(card.getAttribute('data-advance') || '0');
            if (isNaN(adv)) adv = 0;
            totalAdvance += adv;
            if (adv > 0) hasAnyAdvance = true;
            hasAnyPhysical = true;
        }
    });

    // COD: only if physical product and no advance
    if (codWrap) {
        if (hasAnyAdvance || !hasAnyPhysical) {
            codWrap.classList.add('hidden');
            if (paymentCod && paymentCod.checked) {
                var firstOnline = document.querySelector('#payment-methods-grid input[name="payment_method"]:not(#payment_cod):not(#payment_manual)');
                if (firstOnline) { firstOnline.checked = true; }
            }
        } else {
            codWrap.classList.remove('hidden');
            if (paymentCod) paymentCod.checked = true;
        }
    }

    if (!hasAnyAdvance) {
        if (box) box.classList.add('hidden');
        if (note) note.classList.add('hidden');
        return;
    }

    var grandTextEl = document.querySelector('#grand_total strong');
    var grandVal = 0;
    if (grandTextEl) {
        grandVal = parseFloat((grandTextEl.innerText || '').replace(/[^\d.]/g, '')) || 0;
    }
    var due = Math.max(0, grandVal - totalAdvance);

    if (document.getElementById('landing-advance-amount')) {
        document.getElementById('landing-advance-amount').innerText = '৳ ' + totalAdvance.toFixed(2);
    }
    if (document.getElementById('landing-due-amount')) {
        document.getElementById('landing-due-amount').innerText = '৳ ' + due.toFixed(2);
    }
    if (document.getElementById('landing-advance-note-amount')) {
        document.getElementById('landing-advance-note-amount').innerText = '৳ ' + totalAdvance.toFixed(2);
    }
    if (box) box.classList.remove('hidden');
    if (note) note.classList.remove('hidden');
}

// ===== Incomplete Order System (Landing Checkout) =====
var landingCartItems = [];
var landingBaseSubtotal = 0;
var landingDiscount = 0;
var landingIncompleteTimer;
var landingIsSubmitting = false;

function landingCheckFreeDelivery(items) {
    var list = items || landingCartItems;
    for (var i = 0; i < list.length; i++) {
        var item = list[i];
        if (item.is_digital == 1) continue;
        if (item.free_delivery != 1) return false;
    }
    return true;
}

function saveLandingIncompleteOrder() {
    if (landingIsSubmitting) return;
    if (landingIncompleteTimer) clearTimeout(landingIncompleteTimer);

    landingIncompleteTimer = setTimeout(function () {
        var name = document.getElementById('name') ? document.getElementById('name').value.trim() : '';
        var phone = document.getElementById('phone') ? document.getElementById('phone').value.trim() : '';
        var address = document.getElementById('address') ? document.getElementById('address').value.trim() : '';
        if (!name || !phone || !address) return;

        var itemsToSend = landingCartItems;
        var cartEl = document.querySelector('.lp-cart-wrapper[data-cart-items]');
        if (cartEl && cartEl.getAttribute('data-cart-items')) {
            try {
                var parsed = JSON.parse(cartEl.getAttribute('data-cart-items'));
                if (parsed && parsed.length) itemsToSend = parsed;
            } catch (e) { }
        }

        var areaEl = document.getElementById('area');
        var shippingCharge = 0;
        if (areaEl && areaEl.options && areaEl.options[areaEl.selectedIndex]) {
            var opt = areaEl.options[areaEl.selectedIndex];
            if (opt.getAttribute('data-charge')) {
                shippingCharge = parseFloat(opt.getAttribute('data-charge')) || 0;
            }
        }
        if (landingCheckFreeDelivery(itemsToSend)) shippingCharge = 0;
        var total = (landingBaseSubtotal + shippingCharge - landingDiscount).toFixed(2);
        if (cartEl && cartEl.getAttribute('data-grand')) {
            try {
                var g = parseFloat(cartEl.getAttribute('data-grand'));
                if (!isNaN(g)) total = g.toFixed(2);
            } catch (e) { }
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/incomplete-order/store');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : 'xUCZgiihBezSd99HFloc5A3POiIfMNSLGOVjHPsO');
        xhr.send(JSON.stringify({
            name: name,
            phone: phone,
            address: address,
            items: itemsToSend,
            total_amount: total
        }));
    }, 2000);
}

if (window.jQuery) { $(document).ready(function () {
    $('#landing-checkout-form input, #landing-checkout-form select, #landing-checkout-form textarea').on('input change', function () {
        if ($(this).attr('name') !== 'payment_method') saveLandingIncompleteOrder();
    });

    $("#area").on("change", function () {
        var areaInput = document.getElementById('landing_area_input');
        var sel = this;
        // district select → keep the legacy inside/outside hidden field valid
        if (areaInput) {
            areaInput.value = (sel.selectedOptions && sel.selectedOptions[0] && sel.selectedOptions[0].getAttribute('data-area')) || 'inside';
        }
        saveLandingIncompleteOrder();
    });

    // (payment validation moved to the modern handler below)


    $(document).on('change', 'input[name="payment_method"]', function () {
        $('#payment-error').addClass('hidden');
    });

    // Cart loads automatically via AJAX - no default product selection needed

    // Swiper init for product slider
    if (typeof Swiper !== 'undefined') {
        new Swiper('.product-swiper', {
            slidesPerView: 1.2,
            spaceBetween: 12,
            loop: false,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.product-swiper .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2.2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 }
            }
        });

        // Swiper for customer reviews - পুরো স্ক্রিন জুড়ে, অটো স্লাইড
        var reviewsEl = document.querySelector('.reviews-swiper');
        if (reviewsEl) {
            var reviewCount = 5;
            var reviewLoop = reviewCount > 1;
            new Swiper('.reviews-swiper', {
                slidesPerView: 1,
                spaceBetween: 16,
                loop: reviewLoop,
                autoplay: reviewLoop ? { delay: 4000, disableOnInteraction: false } : false,
                pagination: {
                    el: '.reviews-swiper .swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: { slidesPerView: Math.min(2, reviewCount), spaceBetween: 20 },
                    768: { slidesPerView: Math.min(3, reviewCount), spaceBetween: 20 },
                    1024: { slidesPerView: Math.min(4, reviewCount), spaceBetween: 24 }
                }
            });
        }
    }

    // Mini product strip left/right slide buttons
    const miniStrip = document.getElementById('mini-product-strip');
    if (miniStrip) {
        const step = 180;
        const prevBtn = document.querySelector('.mini-product-nav-prev');
        const nextBtn = document.querySelector('.mini-product-nav-next');
        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                miniStrip.scrollBy({ left: -step, behavior: 'smooth' });
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                miniStrip.scrollBy({ left: step, behavior: 'smooth' });
            });
        }
    }
}); }

;
function openVideoModal(embedUrl) {
    var modal = document.getElementById('videoModal');
    var iframe = document.getElementById('videoIframe');
    iframe.src = embedUrl;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeVideoModal(e) {
    if (e && e.target !== document.getElementById('videoModal') && e.type !== 'click') return;
    var modal = document.getElementById('videoModal');
    var iframe = document.getElementById('videoIframe');
    iframe.src = '';
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

// ESC key to close
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeVideoModal(); closeLightbox(); }
});

;
function openTrackModal() {
    document.getElementById('trackModal').classList.remove('hidden');
    document.getElementById('trackModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeTrackModal() {
    document.getElementById('trackModal').classList.add('hidden');
    document.getElementById('trackModal').classList.remove('flex');
    document.body.style.overflow = '';
}
function closeTrackResult() {
    document.getElementById('trackResultModal').classList.add('hidden');
    document.getElementById('trackResultModal').classList.remove('flex');
    document.body.style.overflow = '';
}

function doTrack() {
    var phone = document.getElementById('trackPhone').value.trim();
    var invoice = document.getElementById('trackInvoice').value.trim();
    var errBox = document.getElementById('trackFormError');
    var btn = document.getElementById('trackBtn');

    errBox.classList.add('hidden');
    errBox.textContent = '';

    if (!phone && !invoice) {
        errBox.textContent = 'মোবাইল নাম্বার অথবা ইনভয়েস আইডি দিন।';
        errBox.classList.remove('hidden');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> খুঁজছি...';

    var url = '/order/track-json?';
    if (phone) url += 'phone=' + encodeURIComponent(phone);
    if (invoice) url += (phone ? '&' : '') + 'invoice_id=' + encodeURIComponent(invoice);

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> ট্র্যাক করুন';

            if (!data.success) {
                errBox.textContent = data.message;
                errBox.classList.remove('hidden');
                return;
            }

            renderTrackResult(data.orders);
            closeTrackModal();
            document.getElementById('trackResultModal').classList.remove('hidden');
            document.getElementById('trackResultModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        })
        .catch(function () {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> ট্র্যাক করুন';
            errBox.textContent = 'কানেকশন সমস্যা। আবার চেষ্টা করুন।';
            errBox.classList.remove('hidden');
        });
}

/* tracking card er status timeline — pending → processing → shipped → delivered flow */
function trackTimelineHtml(o) {
    var flow = ['pending', 'processing', 'shipped', 'delivered'];
    var flowLabels = { pending: 'পেন্ডিং', processing: 'প্রসেসিং', shipped: 'শিপড', delivered: 'ডেলিভার্ড' };
    var reached = {};
    (o.timeline || []).forEach(function (t) { reached[t.status] = t.time || ''; });

    if (reached['cancelled']) {
        return '<div style="padding:12px 18px;border-bottom:1px solid #f1f1f1;">'
            + '<div style="font-size:12px;font-weight:700;color:#333;border-bottom:2px solid #f1f1f1;padding-bottom:6px;">অর্ডার স্ট্যাটাস</div>'
            + '<div style="display:flex;gap:8px;align-items:center;font-size:12.5px;color:#dc2626;font-weight:700;padding-top:8px;">'
            + '<span style="width:10px;height:10px;border-radius:50%;background:#dc2626;display:inline-block;"></span> বাতিল'
            + (reached['cancelled'] ? ' — ' + reached['cancelled'] : '')
            + '</div></div>';
    }

    var html = '<div style="padding:12px 18px;border-bottom:1px solid #f1f1f1;">'
        + '<div style="font-size:12px;font-weight:700;color:#333;border-bottom:2px solid #f1f1f1;padding-bottom:6px;margin-bottom:10px;">অর্ডার স্ট্যাটাস টাইমলাইন</div>';

    flow.forEach(function (st, i) {
        var done = reached[st] !== undefined;
        var time = reached[st] || '';
        var dot = done ? '#059669' : '#e5e7eb';
        var txt = done ? '#059669' : '#9ca3af';

        html += '<div style="display:flex;gap:10px;align-items:flex-start;padding:3px 0;">'
            + '<div style="display:flex;flex-direction:column;align-items:center;">'
            + '<span style="width:12px;height:12px;border-radius:50%;background:' + dot + ';flex-shrink:0;"></span>'
            + (i < 3 ? '<span style="width:2px;height:14px;background:' + (done ? '#a7f3d0' : '#e5e7eb') + ';"></span>' : '')
            + '</div>'
            + '<div style="font-size:12.5px;line-height:1.4;"><b style="color:' + txt + '">' + flowLabels[st] + '</b>'
            + (time
                ? '<span style="color:#8b7355;font-size:11px;"> — ' + time + '</span>'
                : ' <span style="color:#cbd5e1;font-size:11px;">(বাকি)</span>')
            + '</div></div>';
    });

    return html + '</div>';
}

function renderTrackResult(orders) {
    var body = document.getElementById('trackResultBody');
    body.innerHTML = '';

    orders.forEach(function (o) {
        var statusColor = 'var(--ds-primary)';

        var itemsHtml = o.items.map(function (item) {
            return '<div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f1f1f1;">'
                + '<img src="' + item.image + '" style="width:44px;height:44px;object-fit:cover;border-radius:6px;border:1px solid #eee;" alt="">'
                + '<div style="flex:1;">'
                + '<div style="font-size:13px;font-weight:600;color:#333;">' + item.name + '</div>'
                + (item.size ? '<span style="font-size:10px;background:#f0f0f0;padding:1px 5px;border-radius:3px;margin-right:4px;">Size: ' + item.size + '</span>' : '')
                + (item.color ? '<span style="font-size:10px;background:#f0f0f0;padding:1px 5px;border-radius:3px;">Color: ' + item.color + '</span>' : '')
                + '</div>'
                + '<div style="text-align:right;font-size:13px;">'
                + '<strong>' + (item.price * item.qty).toLocaleString() + ' ৳</strong>'
                + '<div style="font-size:11px;color:#888;">' + item.price + ' × ' + item.qty + '</div>'
                + '</div></div>';
        }).join('');

        var discountRow = o.discount > 0
            ? '<div style="display:flex;justify-content:space-between;font-size:13px;color:#e53e3e;margin-bottom:4px;"><span>ছাড়</span><span>(-) ' + Number(o.discount).toLocaleString() + ' ৳</span></div>'
            : '';

        var card = '<div style="border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;margin-bottom:0;">'
            + '<div style="background:var(--ds-primary);padding:14px 18px;display:flex;justify-content:space-between;align-items:center;">'
            + '<div>'
            + '<div style="color:#fff;font-weight:700;font-size:15px;">Invoice #' + o.invoice_id + '</div>'
            + '<div style="color:rgba(255,255,255,0.75);font-size:11px;margin-top:2px;">' + o.date + '</div>'
            + '</div>'
            + '<span style="background:#FACC15;color:#000;font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;">' + o.status + '</span>'
            + '</div>'
            + trackTimelineHtml(o)
            + '<div style="padding:14px 18px;display:grid;grid-template-columns:1fr 1fr;gap:12px;border-bottom:1px solid #f1f1f1;">'
            + '<div style="display:flex;gap:8px;align-items:flex-start;">'
            + '<div style="width:34px;height:34px;background:var(--ds-primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0;"><i class="fa-solid fa-user"></i></div>'
            + '<div><div style="font-size:10px;text-transform:uppercase;color:#999;font-weight:700;letter-spacing:.5px;">কাস্টমার</div>'
            + '<div style="font-size:13px;font-weight:600;color:#333;">' + o.customer_name + '</div>'
            + '<div style="font-size:12px;color:#666;">' + o.customer_phone + '</div></div></div>'
            + '<div style="display:flex;gap:8px;align-items:flex-start;">'
            + '<div style="width:34px;height:34px;background:var(--ds-primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0;"><i class="fa-solid fa-map-pin"></i></div>'
            + '<div><div style="font-size:10px;text-transform:uppercase;color:#999;font-weight:700;letter-spacing:.5px;">ঠিকানা</div>'
            + '<div style="font-size:13px;font-weight:600;color:#333;">' + o.area + '</div>'
            + '<div style="font-size:12px;color:#666;">' + o.address + '</div></div></div>'
            + '</div>'
            + '<div style="padding:14px 18px;">'
            + '<div style="font-size:12px;font-weight:700;color:#333;border-bottom:2px solid #f1f1f1;padding-bottom:6px;margin-bottom:4px;">অর্ডার আইটেম</div>'
            + itemsHtml
            + '</div>'
            + '<div style="background:#fafafa;padding:12px 18px;border-top:1px solid #f1f1f1;">'
            + '<div style="max-width:240px;margin-left:auto;">'
            + '<div style="display:flex;justify-content:space-between;font-size:13px;color:#555;margin-bottom:4px;"><span>সাবটোটাল</span><span>' + Number(o.subtotal).toLocaleString() + ' ৳</span></div>'
            + '<div style="display:flex;justify-content:space-between;font-size:13px;color:#555;margin-bottom:4px;"><span>ডেলিভারি চার্জ</span><span>(+) ' + Number(o.shipping_charge).toLocaleString() + ' ৳</span></div>'
            + discountRow
            + '<div style="display:flex;justify-content:space-between;font-size:15px;font-weight:700;color:var(--ds-primary);border-top:1px solid #e1e1e1;padding-top:8px;margin-top:4px;"><span>মোট</span><span>' + Number(o.grand_total).toLocaleString() + ' ৳</span></div>'
            + '</div></div>'
            + '</div>';

        body.innerHTML += card;
    });
}

// ESC to close tracking modals
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeTrackModal(); closeTrackResult(); closeComplaintModal(); }
});

// ========== Complaint Modal Functions ==========
function openComplaintModal() {
    var modal = document.getElementById('complaintModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeComplaintModal() {
    var modal = document.getElementById('complaintModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    // Reset form
    document.getElementById('complaintForm').reset();
    document.getElementById('complaintSuccess').classList.add('hidden');
    document.getElementById('complaintError').classList.add('hidden');
    document.getElementById('complaintBtnText').textContent = 'কমপ্লেইন পাঠান';
    document.getElementById('complaintSubmitBtn').disabled = false;
}

function submitComplaint() {
    var form = document.getElementById('complaintForm');
    var name = document.getElementById('c_name').value.trim();
    var phone = document.getElementById('c_phone').value.trim();
    var desc = document.getElementById('c_description').value.trim();
    var errBox = document.getElementById('complaintError');
    var sucBox = document.getElementById('complaintSuccess');

    // Client-side validation
    errBox.classList.add('hidden');
    if (!name) { errBox.textContent = 'নাম লিখুন।'; errBox.classList.remove('hidden'); return; }
    if (!phone) { errBox.textContent = 'মোবাইল নম্বর লিখুন।'; errBox.classList.remove('hidden'); return; }
    if (!desc) { errBox.textContent = 'কমপ্লেইনের বিবরণ লিখুন।'; errBox.classList.remove('hidden'); return; }

    var btn = document.getElementById('complaintSubmitBtn');
    var btnT = document.getElementById('complaintBtnText');
    btn.disabled = true;
    btnT.textContent = 'পাঠানো হচ্ছে...';

    var formData = new FormData(form);

    fetch('/complaint-store', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : ''
        },
        body: formData
    })
        .then(function (res) {
            if (res.ok) {
                // Show success
                form.classList.add('hidden');
                sucBox.classList.remove('hidden');
            } else {
                return res.json().then(function (data) {
                    var msg = data.message || 'কিছু একটা সমস্যা হয়েছে। আবার চেষ্টা করুন।';
                    if (data.errors) {
                        var msgs = Object.values(data.errors).flat();
                        msg = msgs.join(' ');
                    }
                    errBox.textContent = msg;
                    errBox.classList.remove('hidden');
                    btn.disabled = false;
                    btnT.textContent = 'কমপ্লেইন পাঠান';
                });
            }
        })
        .catch(function () {
            errBox.textContent = 'নেটওয়ার্ক সমস্যা। আবার চেষ্টা করুন।';
            errBox.classList.remove('hidden');
            btn.disabled = false;
            btnT.textContent = 'কমপ্লেইন পাঠান';
        });
}
// ========== End Complaint Modal Functions ==========

;
// Lightbox
var lbPhotos = [];
var lbIndex = 0;


function openLightbox(src, caption) {
    lbIndex = lbPhotos.findIndex(function (p) { return p.src === src; });
    if (lbIndex < 0) lbIndex = 0;
    showLightbox();
}
function showLightbox() {
    var lb = document.getElementById('lightbox');
    if (!lb || !lbPhotos.length) return;
    document.getElementById('lightboxImg').src = lbPhotos[lbIndex].src;
    document.getElementById('lightboxCaption').textContent = lbPhotos[lbIndex].caption;
    lb.classList.remove('hidden');
    lb.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    var lb = document.getElementById('lightbox');
    if (!lb) return;
    lb.classList.add('hidden');
    lb.classList.remove('flex');
    document.body.style.overflow = '';
}
function prevPhoto(e) {
    e.stopPropagation();
    lbIndex = (lbIndex - 1 + lbPhotos.length) % lbPhotos.length;
    showLightbox();
}
function nextPhoto(e) {
    e.stopPropagation();
    lbIndex = (lbIndex + 1) % lbPhotos.length;
    showLightbox();
}

;
(function () {
    var chatToggleBtn = document.getElementById("chatToggle");
    if (chatToggleBtn) chatToggleBtn.addEventListener("click", function () {
        var opts = document.getElementById("chatOptions");
        if (opts) opts.classList.toggle("show");
    });
})();

;
(function () {
    // --- scroll reveal: legacy cards + aurora v2 components ---
    var targets = document.querySelectorAll(
        'section.py-16 .grid > .bg-white, #order-form .grid > div, .reviews-swiper .swiper-slide > div, section.py-16 .bg-white.p-6'
    );
    targets.forEach(function (el, i) {
        el.classList.add('rv');
        el.style.setProperty('--rvd', (i % 4) * 90 + 'ms');
    });

    // aurora v2 reveal set with spring pop for cards
    var v2CardSet = '.ds-product-card, .ds-bento-card, .ds-step, .ds-faq, .ds-seller-card';
    var v2Targets = document.querySelectorAll(
        ['.ds-sec-head', '.ds-filter-wrap', v2CardSet,
         '.ds-hero-copy > *', '.ds-hero-visual', '.ds-stats',
         '.ds-dashboard-mockup', '.ds-seller-stat-card', '.ds-cta'].join(',')
    );
    var seen = new Set(targets);
    v2Targets.forEach(function (el) {
        if (seen.has(el)) return;
        seen.add(el);
        el.classList.add(el.matches(v2CardSet) ? 'rv2-pop' : 'rv2');
    });
    // stagger siblings inside each grid/parent
    v2Targets.forEach(function (el) {
        var sibs = el.parentElement ? Array.prototype.indexOf.call(el.parentElement.children, el) : 0;
        el.style.setProperty('--rvd', (sibs % 6) * 80 + 'ms');
    });

    var all = Array.from(seen);
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.classList.add('in');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        all.forEach(function (el) { io.observe(el); });
    } else {
        all.forEach(function (el) { el.classList.add('in') });
    }

    // --- sticky mobile CTA: show after hero, hide when order form visible ---
    var cta = document.getElementById('stickyCta');
    var hero = document.querySelector('section.bg-primary');
    var form = document.getElementById('order-form');
    function updateCta() {
        if (!cta) return;
        var pastHero = hero && hero.getBoundingClientRect().bottom < 0;
        var nearForm = form && form.getBoundingClientRect().top < window.innerHeight * 0.5;
        cta.classList.toggle('show', pastHero && !nearForm);
    }
    window.addEventListener('scroll', updateCta, { passive: true });
    updateCta();
})();

// ===== HERO SLIDERS: rotating headline + image slideshow =====
(function () {
    function initHeroTextSlider() {
        var slider = document.getElementById('heroH1Slider');
        if (!slider) return;
        var slides = slider.querySelectorAll('.hslide');
        if (slides.length < 2) return;
        var idx = 0;
        setInterval(function () {
            var cur = slides[idx];
            cur.classList.remove('active');
            cur.classList.add('exit-left');
            (function (el) {
                setTimeout(function () { el.classList.remove('exit-left'); }, 780);
            })(cur);
            idx = (idx + 1) % slides.length;
            slides[idx].classList.add('active');
        }, 5000);
    }

    function initHeroImgSlider() {
        var wrap = document.getElementById('heroImgSlider');
        var dots = document.getElementById('heroImgDots');
        var card = wrap ? wrap.closest('.ds-hero-card') : null;
        if (!wrap) return;
        var imgs = wrap.querySelectorAll('.himg');
        if (imgs.length < 2) return;
        var idx = 0, timer = null;

        function show(i) {
            imgs[idx].classList.remove('active');
            idx = (i + imgs.length) % imgs.length;
            imgs[idx].classList.add('active');
            if (dots) {
                dots.querySelectorAll('button').forEach(function (b, bi) {
                    b.classList.toggle('active', bi === idx);
                });
            }
        }
        function next() { show(idx + 1); }
        function prev() { show(idx - 1); }
        function restart() {
            if (timer) clearInterval(timer);
            timer = setInterval(function () { next(); }, 4200);
        }
        function stop() { if (timer) clearInterval(timer); timer = null; }

        window.goHeroImg = function (i) { show(i); restart(); };
        window.heroImgNext = next;
        window.heroImgPrev = prev;

        // arrow buttons
        var nextBtn = wrap.querySelector('.hero-arrow-next');
        var prevBtn = wrap.querySelector('.hero-arrow-prev');
        if (nextBtn) nextBtn.addEventListener('click', function (e) { e.stopPropagation(); next(); restart(); });
        if (prevBtn) prevBtn.addEventListener('click', function (e) { e.stopPropagation(); prev(); restart(); });

        // pause auto-play while hovering the card (desktop)
        if (card) {
            card.addEventListener('mouseenter', stop);
            card.addEventListener('mouseleave', restart);
        }

        // touch swipe
        var touchX = null, touchY = null;
        wrap.addEventListener('touchstart', function (e) {
            touchX = e.touches[0].clientX;
            touchY = e.touches[0].clientY;
            stop();
        }, { passive: true });
        wrap.addEventListener('touchend', function (e) {
            if (touchX === null) return;
            var dx = e.changedTouches[0].clientX - touchX;
            var dy = e.changedTouches[0].clientY - touchY;
            if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy)) {
                if (dx < 0) next(); else prev();
            }
            touchX = null;
            restart();
        }, { passive: true });

        // keyboard arrows when the hero card is on screen
        document.addEventListener('keydown', function (e) {
            if (!card || e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
            var r = card.getBoundingClientRect();
            if (r.bottom < 0 || r.top > window.innerHeight) return;
            if (e.key === 'ArrowRight') next(); else prev();
        });

        restart();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initHeroTextSlider();
            initHeroImgSlider();
        });
    } else {
        initHeroTextSlider();
        initHeroImgSlider();
    }
})();

// ===== PAYMENT METHOD UI SYNC (checkout) =====
(function () {
    function syncPayUI() {
        var grid = document.getElementById('payment-methods-grid');
        if (!grid) return;
        grid.querySelectorAll('label.pay-opt').forEach(function (l) {
            var r = l.querySelector('input[type="radio"]');
            l.classList.toggle('sel', !!(r && r.checked));
        });
        var note = document.getElementById('payOnlineNote');
        if (note) {
            var checked = grid.querySelector('input[name="payment_method"]:checked');
            var online = !!(checked && checked.value !== 'cod');
            note.style.display = online ? 'flex' : 'none';
        }
    }
    document.addEventListener('change', function (e) {
        if (e.target && e.target.name === 'payment_method') syncPayUI();
    });
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', syncPayUI);
    } else {
        syncPayUI();
    }
})();

// toggle online payment options visibility
function toggleOnlinePay() {
    var btn = document.getElementById('onlinePayToggle');
    var wrap = document.getElementById('onlinePayWrap');
    if (!btn || !wrap) return;
    var open = wrap.classList.toggle('open');
    btn.classList.toggle('open', open);
}

/* manual payment (bkash/nagad number e send money) accordion */
function toggleManualPay() {
    var btn = document.getElementById('manualPayToggle');
    var wrap = document.getElementById('manualPayWrap');
    if (!btn || !wrap) return;
    var open = wrap.classList.toggle('open');
    btn.classList.toggle('open', open);
    // accordion khullei manual method select hoy — tarpor TrxID deya lagbe
    if (open) {
        var radio = document.getElementById('payment_manual');
        if (radio && !radio.checked) {
            radio.checked = true;
            radio.dispatchEvent(new Event('change', { bubbles: true }));
        }
        var refInput = document.getElementById('payment_ref');
        if (refInput) refInput.focus();
    }
}

/* number copy button */
window.abCopyText = function (text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function () {
            if (window.showToast) showToast('কপি হয়েছে: ' + text);
        });
        return;
    }
    window.prompt('কপি করুন:', text);
};


// ===== RATING BARS + PROMISE CARD SPOTLIGHT =====
(function () {
    function initRatingBars() {
        var wrap = document.querySelector('.rating-summary');
        var fills = document.querySelectorAll('.rs-fill');
        if (!wrap || !fills.length) return;
        function run() {
            fills.forEach(function (f, i) {
                setTimeout(function () {
                    f.style.width = (f.getAttribute('data-w') || 0) + '%';
                }, i * 130);
            });
        }
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (en) {
                    if (en.isIntersecting) { run(); io.disconnect(); }
                });
            }, { threshold: 0.35 });
            io.observe(wrap);
        } else { run(); }
    }
    function initCardSpotlight() {
        document.querySelectorAll('.ds-seller-section .ds-bento-card').forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                var r = card.getBoundingClientRect();
                card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                card.style.setProperty('--my', (e.clientY - r.top) + 'px');
            });
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { initRatingBars(); initCardSpotlight(); });
    } else { initRatingBars(); initCardSpotlight(); }
})();

// ===== 2026 DESIGN SYSTEM INTERACTIVE LOGIC =====

// 1. Sticky CTA & Header scroll shadow
(function () {
    var cta = document.getElementById('stickyCta');
    var hero = document.querySelector('.ds-hero') || document.querySelector('section.bg-primary');
    var form = document.getElementById('order-form');
    var header = document.getElementById('dsHeader');

    function updateScrollState() {
        if (cta) {
            var pastHero = hero && hero.getBoundingClientRect().bottom < 0;
            var nearForm = form && form.getBoundingClientRect().top < window.innerHeight * 0.5;
            cta.classList.toggle('show', pastHero && !nearForm);
        }
        if (header) {
            header.classList.toggle('scrolled', window.scrollY > 20);
        }

        // Section Scroll Spy
        var sections = ['ds-products', 'ds-why', 'ds-reviews', 'ds-faq'];
        var currentSec = '';
        sections.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) {
                var rect = el.getBoundingClientRect();
                if (rect.top <= 160 && rect.bottom >= 100) {
                    currentSec = id;
                }
            }
        });
        if (currentSec) {
            document.querySelectorAll('.ds-nav-pill, .ds-mob-link').forEach(function (link) {
                var href = link.getAttribute('href');
                if (href === '#' + currentSec) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        }
    }

    window.addEventListener('scroll', updateScrollState, { passive: true });
    updateScrollState();
})();

// 2. Seller Hub Dashboard Tab Switcher
window.switchSellerTab = function (tabName) {
    var buttons = document.querySelectorAll('.ds-mockup-tab-btn');
    buttons.forEach(function (btn) {
        btn.classList.toggle('active', btn.getAttribute('data-tab') === tabName);
    });

    var panels = {
        'analytics': document.getElementById('sellerTabAnalytics'),
        'listing': document.getElementById('sellerTabListing'),
        'payout': document.getElementById('sellerTabPayout')
    };

    Object.keys(panels).forEach(function (key) {
        if (panels[key]) {
            panels[key].classList.toggle('active', key === tabName);
        }
    });
};

// "আরো দেখুন": reveal the products hidden beyond the initial batch
function revealExtraProducts() {
    document.querySelectorAll('.js-extra-product').forEach(function (c) { c.style.display = 'flex'; });
    var b = document.getElementById('seeMoreProducts');
    if (b) b.style.display = 'none';
}

// 3. Universal Category Filter Logic
document.addEventListener('DOMContentLoaded', function () {
    var filterBtns = document.querySelectorAll('.ds-filter-btn');
    var productCards = document.querySelectorAll('.ds-product-card');

    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterBtns.forEach(function (b) { b.classList.remove('active'); });
            this.classList.add('active');

            // category filtering must consider the hidden "see more" batch too
            document.querySelectorAll('.js-extra-product').forEach(function (c) { c.style.display = 'flex'; });
            var seeMore = document.getElementById('seeMoreProducts');
            if (seeMore) seeMore.style.display = 'none';

            var filter = this.getAttribute('data-filter');

            productCards.forEach(function (card) {
                var category = card.getAttribute('data-category');
                if (filter === 'all' || category === filter) {
                    card.style.display = 'flex';
                    setTimeout(function () {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(16px)';
                    setTimeout(function () {
                        card.style.display = 'none';
                    }, 250);
                }
            });
        });
    });
});

// 4. Product Quick View & Cart (bilingual: bn + en)
// Product data is injected per-page from the database via
// window.quickViewProducts = @json($qv) in the Blade views.

var currentQvProductId = null;
var currentQvVariantId = null;

function qvEsc(s) { return String(s == null ? '' : s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'); }

window.openQuickView = function (productId) {
    var prod = window.quickViewProducts[productId];
    if (!prod) return;

    var en = (window.AB && AB.lang === 'en');
    function pick(bn, enVal) { return en ? (enVal || bn) : bn; }

    currentQvProductId = productId;
    currentQvVariantId = null;
    document.getElementById('qvModalTitle').innerHTML = '<i class="fa-solid fa-circle-info"></i> ' + pick(prod.category, prod.category_en);
    document.getElementById('qvModalName').textContent = pick(prod.title, prod.title_en);
    document.getElementById('qvModalCategory').textContent = pick(prod.category, prod.category_en);
    document.getElementById('qvModalOldPrice').textContent = pick(prod.oldPrice, prod.oldPrice_en);
    document.getElementById('qvModalOldPrice').style.display = '';
    document.getElementById('qvModalDiscount').textContent = pick(prod.discount, prod.discount_en);
    document.getElementById('qvModalDesc').textContent = pick(prod.desc, prod.desc_en);
    document.getElementById('qvModalImg').src = prod.img;
    document.getElementById('qvModalImg').alt = prod.alt || prod.title || 'Product';

    /* brand + VAT line — variant select korle oi variant er VAT dekhabe */
    updateQvMeta(prod, null);

    /* variant (size) thakle selector dekhao — price first available variant er */
    var vbox = document.getElementById('qvVariantBox');
    var vgrid = document.getElementById('qvVariantGrid');
    var vs = prod.variants || [];
    if (vbox && vgrid) {
        if (vs.length) {
            vbox.classList.remove('hidden');
            var html = '';
            vs.forEach(function (v) {
                var off = v.stock <= 0;
                var sel = !window.currentQvVariantId && !off; /* prothom available ta selected */
                if (sel) window.currentQvVariantId = v.id;
                html += '<label class="qv-size ' + (sel ? 'sel' : '') + (off ? ' off' : '') + '">' +
                    '<input type="radio" name="qv_variant" value="' + v.id + '"' +
                    ' data-price-bn="' + qvEsc(v.price) + '" data-price-en="' + qvEsc(v.price_en) + '"' +
                    ' data-old-bn="' + qvEsc(v.oldPrice || '') + '" data-old-en="' + qvEsc(v.oldPrice_en || '') + '"' +
                    ' data-discount-bn="' + qvEsc(v.discount || '') + '" data-discount-en="' + qvEsc(v.discount_en || '') + '"' +
                    ' data-vat="' + (v.vat_percent == null ? '' : v.vat_percent) + '"' +
                    ' ' + (off ? 'disabled' : (sel ? 'checked' : '')) + '' +
                    ' onchange="qvPickVariant(this)">' +
                    '<span class="qv-size-name">' + qvEsc(v.size) + '</span>' +
                    '<span class="qv-size-price">' + qvEsc(pick(v.price, v.price_en)) + '</span>' +
                    (off ? '<small>স্টক শেষ</small>' : '') +
                    '</label>';
            });
            vgrid.innerHTML = html;
            var first = vs.find(function (v) { return v.stock > 0; }) || vs[0];
            document.getElementById('qvModalPrice').textContent = pick(first.price, first.price_en);
            document.getElementById('qvModalDiscount').textContent = pick(first.discount, first.discount_en);
            updateQvMeta(prod, first);
        } else {
            vbox.classList.add('hidden');
            document.getElementById('qvModalPrice').textContent = pick(prod.price, prod.price_en);
        }
    }

    var modal = document.getElementById('quickViewModal');
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
};

window.qvPickVariant = function (input) {
    var grid = document.getElementById('qvVariantGrid');
    grid.querySelectorAll('.qv-size').forEach(function (l) { l.classList.remove('sel'); });
    input.closest('.qv-size').classList.add('sel');
    window.currentQvVariantId = parseInt(input.value, 10);
    var en = (window.AB && AB.lang === 'en');
    document.getElementById('qvModalPrice').textContent = en ? (input.dataset.priceEn || input.dataset.priceBn) : input.dataset.priceBn;
    var oldEl = document.getElementById('qvModalOldPrice');
    var oldTxt = en ? (input.dataset.oldEn || input.dataset.oldBn) : input.dataset.oldBn;
    if (oldTxt) {
        oldEl.textContent = oldTxt;
        oldEl.style.display = '';
    } else {
        oldEl.style.display = 'none';
    }
    // oi variant er nijer discount badge
    var badge = input.dataset.discountBn || '';
    document.getElementById('qvModalDiscount').textContent = en ? (input.dataset.discountEn || badge) : badge;
    // meta line (brand + oi variant er VAT) update
    var prod = (window.quickViewProducts || {})[window.currentQvProductId];
    var vid = window.currentQvVariantId;
    var vv = null;
    if (prod && prod.variants) {
        for (var i = 0; i < prod.variants.length; i++) if (prod.variants[i].id === vid) vv = prod.variants[i];
    }
    updateQvMeta(prod, vv);
};

/* modal er brand + VAT line */
window.updateQvMeta = function (prod, v) {
    var el = document.getElementById('qvModalMeta');
    if (!el || !prod) return;
    var parts = [];
    if (prod.brand) parts.push('<span><i class="fa-solid fa-copyright" style="opacity:.6"></i> ব্র্যান্ড: ' + qvEsc(prod.brand) + '</span>');
    var vat = (v && v.vat_percent != null) ? v.vat_percent : prod.vat_percent;
    if (vat != null && parseFloat(vat) > 0) parts.push('<span><i class="fa-solid fa-percent" style="opacity:.6"></i> VAT: ' + parseFloat(vat) + '%</span>');
    if (!parts.length) { el.style.display = 'none'; return; }
    el.innerHTML = parts.join(' <span style="opacity:.4">•</span> ');
    el.style.display = '';
};

window.closeQuickViewModal = function () {
    var modal = document.getElementById('quickViewModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
};

window.orderFromQuickView = function () {
    var pid = currentQvProductId;
    var vid = window.currentQvVariantId;
    closeQuickViewModal();
    if (!pid) {
        var form0 = document.getElementById('order-form');
        if (form0) form0.scrollIntoView({ behavior: 'smooth' });
        return;
    }
    // variant select kora thakle seta diye cart e dhuke, scroll to order form
    if (vid && typeof addToCartVariant === 'function') {
        addToCartVariant(pid, vid);
        var form = document.getElementById('order-form');
        if (form) form.scrollIntoView({ behavior: 'smooth' });
    } else {
        selectProductForOrder(pid);
    }
};

window.selectProductForOrder = function (productId) {
    // pages without the checkout cart (e.g. /products) go to the home checkout
    if (!document.querySelector('.lp-cart-wrapper')) {
        window.location.href = '/#order-form';
        return;
    }
    // variant thakle age size select korte hobe — quick view modal khule dao
    var p = (window.quickViewProducts || {})[productId];
    if (p && p.variants && p.variants.length) {
        window.openQuickView(productId);
        return;
    }
    if (typeof addToCartFromRow === 'function') {
        try { addToCartFromRow(productId); } catch (e) { }
    }
    var form = document.getElementById('order-form');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
};

// 5. Seller Waitlist Modal Functions
window.openSellerWaitlistModal = function () {
    var modal = document.getElementById('sellerWaitlistModal');
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
};

window.closeSellerWaitlistModal = function () {
    var modal = document.getElementById('sellerWaitlistModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
};

window.submitSellerWaitlist = function (e) {
    e.preventDefault();
    var name = document.getElementById('seller_name').value.trim();
    var shop = document.getElementById('seller_shop').value.trim();
    var phone = document.getElementById('seller_phone').value.trim();

    if (!name || !shop || !phone) {
        alert('অনুগ্রহ করে সকল প্রয়োজনীয় তথ্য পূরণ করুন।');
        return;
    }

    var form = document.getElementById('sellerWaitlistForm');
    var successBox = document.getElementById('sellerSuccessMsg');

    if (form) form.style.display = 'none';
    if (successBox) successBox.classList.remove('hidden');
};

// Mobile Menu Toggle
window.toggleMobileNav = function () {
    var drawer = document.getElementById('mobileNavDrawer');
    var btn = document.getElementById('mobileNavToggle');
    var backdrop = document.getElementById('drawerBackdrop');
    if (drawer) {
        var isOpen = drawer.classList.toggle('open');
        if (backdrop) backdrop.classList.toggle('show', isOpen);
        if (btn) {
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            var BARS = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>';
            var XMARK = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>';
            btn.innerHTML = isOpen ? XMARK : BARS;
        }
    }
};

// ESC to close quickview & seller modal & mobile nav
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeQuickViewModal();
        closeSellerWaitlistModal();
        var drawer = document.getElementById('mobileNavDrawer');
        if (drawer && drawer.classList.contains('open')) {
            window.toggleMobileNav();
        }
    }
});

// 6. Merchant Ecosystem & AI Seller Hub Logic
(function () {
    function toBengaliNumerals(numStr) {
        var bnMap = { '0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯' };
        return numStr.toString().replace(/[0-9]/g, function (w) {
            return bnMap[w] || w;
        });
    }

    // Tab switcher function
    window.switchSellerTab = function (tabId) {
        var tabs = document.querySelectorAll('.ds-mockup-tab-btn');
        tabs.forEach(function (btn) {
            if (btn.getAttribute('data-tab') === tabId) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        var panels = document.querySelectorAll('.ds-tab-panel');
        panels.forEach(function (panel) {
            panel.classList.remove('active');
        });

        var targetPanelId = 'sellerTab' + tabId.charAt(0).toUpperCase() + tabId.slice(1);
        if (tabId === 'ai-copilot') targetPanelId = 'sellerTabAiCopilot';

        var targetPanel = document.getElementById(targetPanelId);
        if (targetPanel) {
            targetPanel.classList.add('active');
        }
    };

    // Neural Particle Canvas Simulation
    function initNeuralCanvas() {
        var canvas = document.getElementById('neuralCanvas');
        if (!canvas) return;
        var ctx = canvas.getContext('2d');
        if (!ctx) return;

        var width = canvas.width = canvas.parentElement.offsetWidth || window.innerWidth;
        var height = canvas.height = canvas.parentElement.offsetHeight || 600;

        function resize() {
            if (!canvas.parentElement) return;
            width = canvas.width = canvas.parentElement.offsetWidth;
            height = canvas.height = canvas.parentElement.offsetHeight;
        }
        window.addEventListener('resize', resize);

        var particles = [];
        var particleCount = Math.min(Math.floor(width / 22), 45);

        for (var i = 0; i < particleCount; i++) {
            particles.push({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.6,
                vy: (Math.random() - 0.5) * 0.6,
                radius: Math.random() * 2 + 1.2,
                alpha: Math.random() * 0.5 + 0.3
            });
        }

        function animate() {
            // read theme colors live so the admin theme switcher applies here too
            var cs = getComputedStyle(document.documentElement);
            var accentRgb = cs.getPropertyValue('--ds-accent-rgb').trim() || '234, 88, 12';
            var limeRgb = cs.getPropertyValue('--ds-lime-rgb').trim() || '202, 138, 4';

            ctx.clearRect(0, 0, width, height);

            for (var i = 0; i < particles.length; i++) {
                var p = particles[i];
                p.x += p.vx;
                p.y += p.vy;

                if (p.x < 0) p.x = width;
                if (p.x > width) p.x = 0;
                if (p.y < 0) p.y = height;
                if (p.y > height) p.y = 0;

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(' + accentRgb + ', ' + p.alpha + ')';
                ctx.fill();

                for (var j = i + 1; j < particles.length; j++) {
                    var p2 = particles[j];
                    var dx = p.x - p2.x;
                    var dy = p.y - p2.y;
                    var dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 130) {
                        ctx.beginPath();
                        ctx.moveTo(p.x, p.y);
                        ctx.lineTo(p2.x, p2.y);
                        var lineAlpha = (1 - dist / 130) * 0.25;
                        ctx.strokeStyle = 'rgba(' + limeRgb + ', ' + lineAlpha + ')';
                        ctx.lineWidth = 0.8;
                        ctx.stroke();
                    }
                }
            }
            requestAnimationFrame(animate);
        }
        animate();
    }

    // Scroll-triggered counter animation for #sellerCounters
    function initSellerCountersAnimation() {
        var countersContainer = document.getElementById('sellerCounters');
        if (!countersContainer) return;

        var animated = false;

        function startCounterAnimation() {
            if (animated) return;
            animated = true;

            var statVals = countersContainer.querySelectorAll('.ds-stat-val');
            statVals.forEach(function (el) {
                var target = parseFloat(el.getAttribute('data-target') || '0');
                var type = el.getAttribute('data-counter-type');
                var startTime = performance.now();
                var duration = 1600;

                function update(now) {
                    var elapsed = now - startTime;
                    var progress = Math.min(elapsed / duration, 1);
                    var easeProgress = 1 - Math.pow(1 - progress, 3);
                    var currentVal = target * easeProgress;
                    var bn = !(window.AB && AB.lang === 'en');
                    var num = function (s) { return bn ? toBengaliNumerals(s) : s; };

                    if (type === 'currency') {
                        var formattedStr = Math.floor(currentVal).toLocaleString('en-US');
                        el.textContent = '৳' + num(formattedStr);
                    } else if (type === 'percent') {
                        el.textContent = num(currentVal.toFixed(1)) + '%';
                    } else if (type === 'unit') {
                        el.textContent = num(Math.floor(currentVal).toString()) + (bn ? 'টি' : ' pcs');
                    }

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    }
                }
                requestAnimationFrame(update);
            });
        }

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        startCounterAnimation();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });
            observer.observe(countersContainer);
        } else {
            startCounterAnimation();
        }
    }
    // Live Order Ticker Simulation
    function initLiveOrderTicker() {
        var tickerText = document.getElementById('dsLiveTickerText');
        if (!tickerText) return;

        var simulatedOrders = {
            bn: [
                '⚡ লাইভ অর্ডার সিঙ্ক: তানভীর (ঢাকা) - ৳৪৫০ • আমের কুচি আচার',
                '⚡ লাইভ অর্ডার সিঙ্ক: সুমাইয়া (সিলেট) - ৳৬৫০ • মিক্সড আচার প্যাক',
                '⚡ লাইভ অর্ডার সিঙ্ক: রাইসুল (চট্টগ্রাম) - ৳৯৯০ • সুন্দরবনের মধু',
                '⚡ লাইভ অর্ডার সিঙ্ক: নুসরাত (রাজশাহী) - ৳১,১৯০ • দেশি ঘি',
                '⚡ লাইভ অর্ডার সিঙ্ক: ফাহিম (বগুড়া) - ৳২৯০ • তেঁতুল চাটনি'
            ],
            en: [
                '⚡ Live order sync: Tanvir (Dhaka) - ৳450 • Mango Kuchi Achar',
                '⚡ Live order sync: Sumaiya (Sylhet) - ৳650 • Mixed Pickle Pack',
                '⚡ Live order sync: Raisul (Chattogram) - ৳990 • Sundarban Honey',
                '⚡ Live order sync: Nusrat (Rajshahi) - ৳1,190 • Deshi Ghee',
                '⚡ Live order sync: Fahim (Bogura) - ৳290 • Tamarind Chutney'
            ]
        };

        var index = 0;
        setInterval(function () {
            index = (index + 1) % simulatedOrders.bn.length;
            tickerText.style.transition = 'opacity 0.3s ease';
            tickerText.style.opacity = '0';
            setTimeout(function () {
                var list = (window.AB && AB.lang === 'en') ? simulatedOrders.en : simulatedOrders.bn;
                tickerText.textContent = list[index];
                tickerText.style.opacity = '1';
            }, 300);
        }, 4000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initNeuralCanvas();
            initSellerCountersAnimation();
            initLiveOrderTicker();
        });
    } else {
        initNeuralCanvas();
        initSellerCountersAnimation();
        initLiveOrderTicker();
    }
})();


// ===== sticky CTA ↔ chat FAB coordination (mobile) =====
// When the sticky order bar is visible, body gets .sticky-cta-on so the
// floating chat button lifts above it (see style.css fix layer).
(function () {
    var cta = document.getElementById('stickyCta');
    if (!cta || typeof MutationObserver === 'undefined') return;
    var sync = function () {
        document.body.classList.toggle('sticky-cta-on', cta.classList.contains('show'));
    };
    new MutationObserver(sync).observe(cta, { attributes: true, attributeFilter: ['class'] });
    sync();
})();

// ===== LOCAL DEMO CART (static template — no server needed) =====
// Overrides the earlier server-AJAX versions of toggleProductFromCart /
// submitCoupon so the checkout section works fully in the static preview.
(function () {
    var cart = {};            // { pid: { qty } }
    var coupon = null;        // { code, pct }
    // active coupons injected from the DB via the Blade page (window.AB_COUPONS)
    var COUPONS = window.AB_COUPONS || {};

    function prodData(pid) { return (window.quickViewProducts || {})[pid] || null; }

    /* cart key: "12" = product soho; "12:v5" = product 12 er variant 5 */
    function parseKey(k) {
        var m = /^(\d+):v(\d+)$/.exec(String(k));
        return m ? { pid: parseInt(m[1], 10), vid: parseInt(m[2], 10) } : { pid: parseInt(k, 10), vid: null };
    }
    function makeKey(pid, vid) { return vid ? pid + ':v' + vid : String(pid); }
    function variantOf(p, vid) {
        if (!p || !p.variants || !vid) return null;
        for (var i = 0; i < p.variants.length; i++) if (p.variants[i].id === vid) return p.variants[i];
        return null;
    }
    function bnToNum(s) {
        var out = String(s || '').replace(/[০-৯]/g, function (d) { return '০১২৩৪৫৬৭৮৯'.indexOf(d); });
        var n = parseFloat(out.replace(/[^\d.]/g, ''));
        return isNaN(n) ? 0 : n;
    }
    function fmt(n) { return Math.round(n).toLocaleString('en-US'); }
    function esc(s) { return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'); }

    function ids() { return Object.keys(cart); }

    function deliveryCharge() {
        if (!ids().length) return 0;
        var pick = resolveAreaSelection();

        return (pick && !isNaN(pick.charge)) ? pick.charge : 80;
    }

    /* zone-aware selection — "ঢাকার ভিতরে" hole district list chara-i inside+Dhaka dhore ney */
    function resolveAreaSelection() {
        var zone = document.getElementById('area_zone');
        var sel = document.getElementById('area');
        if (zone && zone.selectedOptions && zone.selectedOptions[0]) {
            var z = zone.selectedOptions[0];
            if (z.value === 'inside') {
                var zc = parseFloat(z.getAttribute('data-charge'));

                return { area: 'inside', district: 'Dhaka', charge: isNaN(zc) ? 80 : zc };
            }
        }
        if (sel && sel.selectedOptions && sel.selectedOptions[0]) {
            var o = sel.selectedOptions[0];
            var c = parseFloat(o.getAttribute('data-charge'));

            return { area: o.getAttribute('data-area') || 'inside', district: sel.value || '', charge: isNaN(c) ? 80 : c };
        }

        return null;
    }

    function render() {
        var wrap = document.querySelector('.lp-cart-wrapper');
        var emptyEl = document.getElementById('lpCartEmpty');
        var countEl = document.getElementById('cart-item-count-label');
        if (!wrap) return;

        var en = (window.AB && AB.lang === 'en');
        function L(bn, enStr) { return en ? enStr : bn; }
        function prodField(pid, bnKey, enKey) {
            var p = prodData(pid);
            if (!p) return '';
            return en ? (p[enKey] || p[bnKey]) : p[bnKey];
        }

        var list = ids();
        var subtotal = 0;
        var rowsHtml = '';
        list.forEach(function (key) {
            var k = parseKey(key);
            var p = prodData(k.pid);
            if (!p) return;
            var v = variantOf(p, k.vid);
            var unit = v ? bnToNum(en ? (v.price_en || v.price) : v.price) : bnToNum(en ? (p.price_en || p.price) : p.price);
            var qty = cart[key].qty;
            subtotal += unit * qty;
            // per-line VAT dekhano — product/variant er nijer % onujayi
            var linePct = (v && v.vat_percent != null) ? parseFloat(v.vat_percent) : (parseFloat(p.vat_percent) || 0);
            var lineVat = Math.round(unit * qty * linePct) / 100;
            var vatLine = linePct > 0
                ? '<small style="display:block;text-align:end;font-weight:600;color:#8b7355">' + L('ভ্যাট', 'VAT') + ' (' + linePct + '%): ৳ ' + fmt(lineVat) + '</small>'
                : '';
            rowsHtml += '<div class="lp-cart-row" id="cart-row-' + key.replace(/\W/g, '_') + '">' +
                '<input type="checkbox" checked onchange="toggleProductFromCart(\'' + key + '\', this.checked)">' +
                '<div class="lp-cart-product"><img src="' + esc(p.img) + '" alt="">' +
                '<div class="lp-cart-product-name">' + esc(prodField(k.pid, 'title', 'title_en')) + (v ? '<small style="display:block;color:#8b7355;font-weight:700">' + esc(v.size) + ' · ' + (en ? (v.price_en || v.price) : v.price) + '</small>' : '') + '</div></div>' +
                '<div class="lp-cart-qty-box">' +
                '<button type="button" class="lp-cart-qty-btn" onclick="landingCartQty(\'' + key + '\',-1)">−</button>' +
                '<span class="lp-cart-qty-val">' + qty + '</span>' +
                '<button type="button" class="lp-cart-qty-btn" onclick="landingCartQty(\'' + key + '\',1)">+</button>' +
                '</div>' +
                '<div style="text-align:end;font-weight:700">৳ ' + fmt(unit * qty) + vatLine + '</div>' +
                '</div>';
        });

        var discount = coupon ? Math.round(subtotal * coupon.pct / 100) : 0;
        var ship = deliveryCharge();
        var vatTotal = 0;
        list.forEach(function (key) {
            var k = parseKey(key);
            var p = prodData(k.pid);
            if (!p) return;
            var v = variantOf(p, k.vid);
            var unit = v ? bnToNum(en ? (v.price_en || v.price) : v.price) : bnToNum(en ? (p.price_en || p.price) : p.price);
            // VAT: variant er nijer ta, na thakle product er ta (server eo same)
            var lineVatPct = (v && v.vat_percent != null) ? parseFloat(v.vat_percent) : (parseFloat(p.vat_percent) || 0);
            // per-line VAT rounded to 2dp — matches OrderController rounding exactly
            vatTotal += Math.round(unit * cart[key].qty * lineVatPct) / 100;
        });
        var grand = Math.max(0, subtotal - discount) + vatTotal + (list.length ? ship : 0);

        var discountRow = coupon
            ? '<div class="lp-cart-total-row"><span>' + L('ডিসকাউন্ট', 'Discount') + ' (' + esc(coupon.code) + ')</span><span style="color:var(--ds-primary)">− ৳ ' + fmt(discount) + '</span></div>'
            : '';

        wrap.innerHTML =
            '<div class="lp-cart-header"><div class="text-center">' + L('মার্ক', 'Mark') + '</div><div>' + L('প্রোডাক্ট', 'Product') + '</div><div class="text-center">' + L('পরিমাণ', 'Qty') + '</div><div class="text-end">' + L('মূল্য', 'Price') + '</div></div>' +
            (rowsHtml || '') +
            '<div class="lp-cart-totals">' +
            '<div class="lp-cart-total-row"><span>' + L('মোট', 'Subtotal') + '</span><span id="net_total">৳ <strong>' + fmt(subtotal) + '</strong></span></div>' +
            discountRow +
            (vatTotal > 0
                ? '<div class="lp-cart-total-row"><span>' + L('ভ্যাট (সব প্রোডাক্ট মিলিয়ে)', 'VAT (all products)') + '</span><span>৳ <strong>' + fmt(vatTotal) + '</strong></span></div>'
                : '') +
            '<div class="lp-cart-total-row"><span>' + L('ডেলিভারি চার্জ', 'Delivery Charge') + '</span><span id="cart_shipping_cost">৳ <strong>' + (list.length ? fmt(ship) : 0) + '</strong></span></div>' +
            '<div class="lp-cart-total-row final"><span>' + L('সর্বমোট', 'Grand Total') + '</span><span id="grand_total">৳ <strong>' + fmt(grand) + '</strong></span></div>' +
            '</div>';

        wrap.setAttribute('data-cart-empty', list.length ? '0' : '1');
        wrap.setAttribute('data-cart-items', JSON.stringify(list.map(function (key) {
            var k = parseKey(key);
            var line = { id: k.pid, qty: cart[key].qty };
            if (k.vid) line.variant_id = k.vid;
            return line;
        })));
        wrap.setAttribute('data-subtotal', String(subtotal));
        wrap.setAttribute('data-grand', String(grand));

        if (emptyEl) emptyEl.hidden = list.length > 0;
        if (countEl) countEl.textContent = list.length
            ? (list.length + (en ? ' item(s)' : ' টি পণ্য'))
            : L('খালি', 'Empty');

        // delivery area placeholder vs select
        var ae = document.getElementById('landing-area-empty');
        var ap = document.getElementById('landing-area-physical-wrap');
        if (ae && ap) {
            ae.classList.toggle('hidden', list.length > 0);
            ap.classList.toggle('hidden', list.length === 0);
        }
        var sel = document.getElementById('area');
        if (sel) sel.toggleAttribute('required', list.length > 0);
        // zone picker ("ঢাকার ভিতরে/বাইরে") thakle district list shudhu "বাইরে" te dekhay
        var zone = document.getElementById('area_zone');
        var pick = resolveAreaSelection();
        if (zone) {
            var insideZone = zone.value === 'inside';
            var outWrap = document.getElementById('landing-outside-wrap');
            if (outWrap) outWrap.classList.toggle('hidden', insideZone);
            if (sel) sel.toggleAttribute('required', list.length > 0 && !insideZone);
        }
        // keep the hidden "area" field in sync (server validates inside|outside)
        var areaInput = document.getElementById('landing_area_input');
        if (areaInput) areaInput.value = (list.length && pick) ? pick.area : 'inside';
        // and the chosen district (server validates it against admin-configured districts)
        var districtInput = document.getElementById('landing_district_input');
        if (districtInput) districtInput.value = (list.length && pick) ? pick.district : '';

        try { landingCartItems = list.map(function (pid) { return parseInt(pid, 10); }); } catch (e) { }
    }

    // keep cart labels in sync when the language is switched
    document.addEventListener('ab:lang', function () { render(); });

    window.landingCartQty = function (key, delta) {
        if (!cart[key]) return;
        cart[key].qty = Math.max(1, Math.min(10, cart[key].qty + delta));
        render();
    };

    window.toggleProductFromCart = function (key, isChecked) {
        if (isChecked) {
            if (!cart[key]) cart[key] = { qty: 1 };
        } else {
            delete cart[key];
        }
        render();
    };

    window.addToCartFromRow = function (productId) {
        productId = parseInt(productId, 10);
        // variant thakle default (prothom active) variant e add hoy
        var p = prodData(productId);
        var key = (p && p.variants && p.variants.length) ? makeKey(productId, p.variants[0].id) : String(productId);
        // already in the cart → bump the quantity instead of doing nothing
        if (cart[key] && cart[key].qty < 10) {
            cart[key].qty++;
            render();
        } else {
            window.toggleProductFromCart(key, true);
        }
    };

    /* size select kore add — quick view modal theke */
    window.addToCartVariant = function (pid, vid) {
        pid = parseInt(pid, 10);
        vid = vid ? parseInt(vid, 10) : null;
        var key = makeKey(pid, vid);
        if (cart[key] && cart[key].qty < 10) {
            cart[key].qty++;
            render();
        } else {
            window.toggleProductFromCart(key, true);
        }
    };

    window.submitCoupon = function () {
        var input = document.getElementById('coupon_input');
        var msg = document.getElementById('couponMsg');
        var code = input ? input.value.trim() : '';
        if (!msg) return;
        msg.hidden = false;
        if (!code) {
            msg.className = 'lp-coupon-msg err';
            msg.textContent = AB.t('কুপন কোড লিখে আবার চেষ্টা করুন।', 'Please enter a coupon code and try again.');
            return;
        }
        if (coupon && coupon.code.toUpperCase() === code.toUpperCase()) {
            coupon = null;
            msg.className = 'lp-coupon-msg ok';
            msg.textContent = AB.t('কুপনটি সরানো হয়েছে।', 'Coupon removed.');
            render();
            return;
        }
        var normalized = code.toUpperCase();
        if (COUPONS[normalized]) {
            coupon = { code: normalized, pct: COUPONS[normalized] };
            msg.className = 'lp-coupon-msg ok';
            msg.textContent = AB.t('কুপন প্রয়োগ হয়েছে — ' + COUPONS[normalized] + '% ডিসকাউন্ট!', 'Coupon applied — ' + COUPONS[normalized] + '% discount!');
        } else {
            coupon = null;
            msg.className = 'lp-coupon-msg err';
            msg.textContent = AB.t('কুপনটি প্রযোজ্য নয়। (ডেমো কুপন: ACHAR10)', 'Coupon not valid. (Demo coupon: ACHAR10)');
        }
        render();
    };

    // coupon chips from the "চালু কুপন" list → fill + apply in one tap
    window.applyCouponFromList = function (code) {
        var input = document.getElementById('coupon_input');
        if (!input) return;
        if (coupon && coupon.code === String(code).toUpperCase()) return; // already applied
        input.value = code;
        window.submitCoupon();
    };

    // delivery area change → recalc totals
    var areaSel = document.getElementById('area');
    if (areaSel) areaSel.addEventListener('change', render);
    var zoneSel = document.getElementById('area_zone');
    if (zoneSel) zoneSel.addEventListener('change', render);

    // real order submit: serialize cart into hidden input, form POSTs to Laravel
    var form = document.getElementById('landing-checkout-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            if (!ids().length) {
                e.preventDefault();
                var old = document.getElementById('lpOrderSuccess');
                if (old) old.remove();
                var banner = document.createElement('div');
                banner.id = 'lpOrderSuccess';
                banner.className = 'lp-order-success';
                banner.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + AB.t('কার্ট খালি — অন্তত একটি প্রোডাক্ট যোগ করুন।', 'Cart is empty — add at least one product.');
                form.parentNode.insertBefore(banner, form);
                banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            // phone: shudhu valid BD mobile — 10 digit/bhul format e order hobe na
            var phoneEl = document.getElementById('phone');
            var phoneVal = phoneEl ? phoneEl.value.trim() : '';
            function abNormPhone(v) {
                var d = (v || '').replace(/\D+/g, '');
                if (d.indexOf('880') === 0) d = '0' + d.slice(3);
                return /^01[3-9]\d{8}$/.test(d) ? d : null;
            }
            if (!abNormPhone(phoneVal)) {
                e.preventDefault();
                var phOld = document.getElementById('lpOrderSuccess');
                if (phOld) phOld.remove();
                var phBanner = document.createElement('div');
                phBanner.id = 'lpOrderSuccess';
                phBanner.className = 'lp-order-success';
                phBanner.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + AB.t('সঠিক মোবাইল নম্বর দিন — ১১ ডিজিটের নম্বর 01 দিয়ে শুরু (যেমন: 01712345678)।', 'Enter a valid mobile number — 11 digits starting with 01 (e.g. 01712345678).');
                form.parentNode.insertBefore(phBanner, form);
                phBanner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            // payment method check (vanilla — reliable)
            var payErr = document.getElementById('payment-error');
            var payChecked = form.querySelector('input[name="payment_method"]:checked');
            if (!payChecked) {
                e.preventDefault();
                if (payErr) payErr.classList.remove('hidden');
                payErr && payErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            // manual payment hole TrxID ABASHYOK — taka pathiye TrxID chara order hobe na
            var payRef = document.getElementById('payment_ref');
            if (payChecked.value === 'manual' && payRef && payRef.value.trim() === '') {
                e.preventDefault();
                if (payErr) {
                    var payErrMsg = payErr.querySelector('span');
                    if (payErrMsg) payErrMsg.textContent = AB.t('টাকা পাঠানোর পর TrxID লিখুন — তারপর অর্ডার করুন।', 'Enter the TrxID after sending the money — then place the order.');
                    payErr.classList.remove('hidden');
                    payErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
            if (payErr) payErr.classList.add('hidden');

            // fill hidden inputs for the server
            var itemsInput = document.getElementById('cart_items_input');
            if (itemsInput) {
                itemsInput.value = JSON.stringify(ids().map(function (key) {
                    var k = parseKey(key);
                    var line = { id: k.pid, qty: cart[key].qty };
                    if (k.vid) line.variant_id = k.vid;
                    return line;
                }));
            }
            var couponInput = document.getElementById('coupon_input');
            var couponHidden = document.getElementById('coupon_hidden_code');
            if (couponHidden) {
                // coupon box sits outside the <form> — copy the applied code in
                couponHidden.value = coupon ? coupon.code : (couponInput ? couponInput.value.trim() : '');
            }
            // natural form POST → server recalculates everything securely
        });
    }

    render();

    /* product-details page theke size select kore asha hole cart e jug kore dao */
    (function () {
        try {
            var pick = JSON.parse(sessionStorage.getItem('abVariantPick') || 'null');
            if (pick && pick.id && prodData(pick.id)) {
                var key = makeKey(pick.id, pick.variant_id || null);
                cart[key] = { qty: Math.max(1, Math.min(10, parseInt(pick.qty, 10) || 1)) };
                sessionStorage.removeItem('abVariantPick');
                render();
            }
        } catch (e) { /* corrupted pick — ignore */ }
    })();
})();
