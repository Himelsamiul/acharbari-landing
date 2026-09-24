/* ============================================================
   AcharBari — brand.js
   Shared controller for landing page + demo admin dashboard.
   Handles: color theme presets, custom logo, brand name and
   BN/EN language switching. Everything persists in localStorage
   so the admin changes reflect on the landing page instantly.
   ============================================================ */
(function () {
    'use strict';

    var LS = {
        lang: 'ab_lang',
        logo: 'ab_logo',
        brand: 'ab_brand',
        theme: 'ab_theme',
        custom: 'ab_custom'
    };

    /* ---------------- Theme Presets ---------------- */
    var THEMES = {
        herbal: {
            bn: 'হার্বাল গ্রিন', en: 'Herbal Green',
            primary: '#059669', hover: '#047857', dark: '#064e3b', xdark: '#022c22',
            accent: '#10b981', accentLight: '#34d399',
            lime: '#84cc16', limeNeon: '#a3e635', limeDeep: '#65a30d',
            teal: '#14b8a6', tealLight: '#5eead4'
        },
        spice: {
            bn: 'মসলা অ্যাম্বার', en: 'Spice Amber',
            primary: '#d97706', hover: '#b45309', dark: '#7c2d12', xdark: '#431407',
            accent: '#ea580c', accentLight: '#fb923c',
            lime: '#ca8a04', limeNeon: '#fbbf24', limeDeep: '#a16207',
            teal: '#dc2626', tealLight: '#fca5a5'
        },
        chili: {
            bn: 'চিলি রেড', en: 'Chili Red',
            primary: '#dc2626', hover: '#b91c1c', dark: '#7f1d1d', xdark: '#450a0a',
            accent: '#ef4444', accentLight: '#f87171',
            lime: '#c2410c', limeNeon: '#fb923c', limeDeep: '#9a3412',
            teal: '#ea580c', tealLight: '#fdba74'
        },
        mango: {
            bn: 'ম্যাঙ্গো ফ্রেশ', en: 'Mango Fresh',
            primary: '#ca8a04', hover: '#a16207', dark: '#713f12', xdark: '#422006',
            accent: '#eab308', accentLight: '#facc15',
            lime: '#84cc16', limeNeon: '#a3e635', limeDeep: '#65a30d',
            teal: '#65a30d', tealLight: '#bef264'
        },
        jamun: {
            bn: 'জামুন পার্পল', en: 'Jamun Purple',
            primary: '#7c3aed', hover: '#6d28d9', dark: '#4c1d95', xdark: '#2e1065',
            accent: '#8b5cf6', accentLight: '#a78bfa',
            lime: '#c026d3', limeNeon: '#e879f9', limeDeep: '#a21caf',
            teal: '#9333ea', tealLight: '#d8b4fe'
        },
        neel: {
            bn: 'নীল ব্লু', en: 'Neel Blue',
            primary: '#2563eb', hover: '#1d4ed8', dark: '#1e3a8a', xdark: '#172554',
            accent: '#3b82f6', accentLight: '#60a5fa',
            lime: '#0891b2', limeNeon: '#22d3ee', limeDeep: '#0e7490',
            teal: '#0ea5e9', tealLight: '#7dd3fc'
        }
    };

    /* ---------------- Defaults ---------------- */
    var DEFAULT_BRAND = {
        bn1: 'আচার', bn2: 'বাড়ি',
        en1: 'Achar', en2: 'Bari'
    };

    /* ---------------- helpers ---------------- */
    function get(k, fallback) {
        try {
            var v = localStorage.getItem(k);
            return v === null ? fallback : v;
        } catch (e) { return fallback; }
    }
    function set(k, v) {
        try { localStorage.setItem(k, v); } catch (e) { }
    }
    function getJSON(k, fallback) {
        try {
            var v = localStorage.getItem(k);
            return v ? JSON.parse(v) : fallback;
        } catch (e) { return fallback; }
    }
    function hexToRgbTriplet(hex) {
        var h = String(hex || '').replace('#', '');
        if (h.length === 3) h = h[0] + h[0] + h[1] + h[1] + h[2] + h[2];
        var n = parseInt(h, 16);
        if (isNaN(n)) return '0, 0, 0';
        return ((n >> 16) & 255) + ', ' + ((n >> 8) & 255) + ', ' + (n & 255);
    }
    function esc(s) {
        return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    /* ---------------- AB namespace ---------------- */
    var AB = {
        THEMES: THEMES,
        DEFAULT_BRAND: DEFAULT_BRAND,

        getThemeId: function () { return get(LS.theme, 'herbal'); },
        getTheme: function () {
            var id = this.getThemeId();
            if (id === '__custom') {
                var c = getJSON(LS.custom, null);
                if (c && c.primary) {
                    var base = THEMES.herbal;
                    for (var k in base) if (base.hasOwnProperty(k) && !c[k]) c[k] = base[k];
                    c.bn = 'কাস্টম'; c.en = 'Custom';
                    return c;
                }
                return THEMES.herbal;
            }
            return THEMES[id] || THEMES.herbal;
        },

        /* Apply a theme's palette to CSS variables */
        applyTheme: function (t) {
            if (!t) return;
            var s = document.documentElement.style;
            s.setProperty('--ds-primary', t.primary);
            s.setProperty('--ds-primary-hover', t.hover);
            s.setProperty('--ds-primary-dark', t.dark);
            s.setProperty('--ds-primary-xdark', t.xdark);
            s.setProperty('--ds-accent', t.accent);
            s.setProperty('--ds-accent-light', t.accentLight);
            s.setProperty('--ds-lime', t.lime);
            s.setProperty('--ds-lime-neon', t.limeNeon);
            s.setProperty('--ds-lime-deep', t.limeDeep);
            s.setProperty('--ds-teal', t.teal);
            s.setProperty('--ds-teal-light', t.tealLight);

            s.setProperty('--ds-primary-rgb', hexToRgbTriplet(t.primary));
            s.setProperty('--ds-primary-dark-rgb', hexToRgbTriplet(t.dark));
            s.setProperty('--ds-primary-xdark-rgb', hexToRgbTriplet(t.xdark));
            s.setProperty('--ds-accent-rgb', hexToRgbTriplet(t.accent));
            s.setProperty('--ds-lime-rgb', hexToRgbTriplet(t.lime));
            s.setProperty('--ds-lime-neon-rgb', hexToRgbTriplet(t.limeNeon));
            s.setProperty('--ds-teal-rgb', hexToRgbTriplet(t.teal));

            var meta = document.querySelector('meta[name="theme-color"]');
            if (meta) meta.setAttribute('content', t.primary);
        },

        setTheme: function (id, custom) {
            if (id === '__custom' && custom) {
                set(LS.custom, JSON.stringify(custom));
                set(LS.theme, '__custom');
                this.applyTheme(custom);
            } else if (THEMES[id]) {
                set(LS.theme, id);
                this.applyTheme(THEMES[id]);
            }
            document.dispatchEvent(new CustomEvent('ab:theme'));
        },

        getCustom: function () { return getJSON(LS.custom, null); },

        resetTheme: function () {
            set(LS.theme, 'herbal');
            try { localStorage.removeItem(LS.custom); } catch (e) { }
            this.applyTheme(THEMES.herbal);
            document.dispatchEvent(new CustomEvent('ab:theme'));
        },

        /* ---------------- Brand name & logo ---------------- */
        getBrand: function () {
            var b = getJSON(LS.brand, null);
            if (!b || !b.bn1) b = JSON.parse(JSON.stringify(DEFAULT_BRAND));
            return b;
        },

        setBrand: function (b) {
            set(LS.brand, JSON.stringify(b));
            this.applyBrand();
            document.dispatchEvent(new CustomEvent('ab:brand'));
        },

        resetBrand: function () {
            try { localStorage.removeItem(LS.brand); } catch (e) { }
            this.applyBrand();
            document.dispatchEvent(new CustomEvent('ab:brand'));
        },

        /* Full brand display name in current language */
        brandName: function (lang) {
            var b = this.getBrand();
            var l = lang || this.lang;
            return l === 'en' ? (b.en1 + (b.en2 || '')) : (b.bn1 + (b.bn2 || ''));
        },

        /* Apply logo + brand name to any page (landing + admin) */
        applyBrand: function () {
            var b = this.getBrand();
            var l = this.lang;
            var p1 = (l === 'en') ? b.en1 : b.bn1;
            var p2 = (l === 'en') ? b.en2 : b.bn2;
            var html = esc(p1) + (p2 ? '<em>' + esc(p2) + '</em>' : '');
            var plain = this.brandName(l);

            // logo text slots
            document.querySelectorAll('[data-ab-brand-logo]').forEach(function (el) {
                el.innerHTML = html;
            });
            // plain brand-name slots (e.g. "Store: XYZ")
            document.querySelectorAll('[data-ab-brand-name]').forEach(function (el) {
                el.textContent = plain;
            });

            // logo image slots
            var logo = get(LS.logo, '');
            document.querySelectorAll('[data-ab-logo-slot]').forEach(function (el) {
                if (!el._abDefault) el._abDefault = el.innerHTML; // remember default icon
                if (logo) {
                    el.innerHTML = '<img class="ds-logo-img" alt="logo" src="' + esc(logo) + '">';
                } else {
                    el.innerHTML = el._abDefault; // restore default inline SVG/icon
                }
            });

            // favicon follows custom logo
            if (logo) {
                var fav = document.querySelector('link[rel="icon"]');
                if (fav) fav.href = logo;
            }

            // document title per language
            var t = document.body.getAttribute('data-title-' + (l === 'en' ? 'en' : 'bn'));
            if (t) document.title = t.replace('{brand}', plain);
        },

        getLogo: function () { return get(LS.logo, ''); },
        setLogo: function (dataUrl) {
            if (dataUrl) set(LS.logo, dataUrl);
            else { try { localStorage.removeItem(LS.logo); } catch (e) { } }
            this.applyBrand();
            document.dispatchEvent(new CustomEvent('ab:brand'));
        },

        /* ---------------- Language ---------------- */
        lang: get(LS.lang, 'bn') === 'en' ? 'en' : 'bn',

        applyLang: function () {
            var self = this;
            var en = this.lang === 'en';
            document.documentElement.setAttribute('lang', en ? 'en' : 'bn');

            document.querySelectorAll('[data-en]').forEach(function (el) {
                if (!el.getAttribute('data-bn')) el.setAttribute('data-bn', el.textContent);
                el.textContent = en ? el.getAttribute('data-en') : el.getAttribute('data-bn');
            });
            document.querySelectorAll('[data-en-ph]').forEach(function (el) {
                if (!el.getAttribute('data-bn-ph')) el.setAttribute('data-bn-ph', el.getAttribute('placeholder') || '');
                el.setAttribute('placeholder', en ? el.getAttribute('data-en-ph') : el.getAttribute('data-bn-ph'));
            });
            document.querySelectorAll('[data-en-val]').forEach(function (el) {
                if (!el.getAttribute('data-bn-val')) el.setAttribute('data-bn-val', el.value || '');
                el.value = en ? el.getAttribute('data-en-val') : el.getAttribute('data-bn-val');
            });
            document.querySelectorAll('[data-en-html]').forEach(function (el) {
                if (!el.getAttribute('data-bn-html')) el.setAttribute('data-bn-html', el.innerHTML);
                el.innerHTML = en ? el.getAttribute('data-en-html') : el.getAttribute('data-bn-html');
            });

            // toggle button states
            document.querySelectorAll('[data-lang-btn]').forEach(function (btn) {
                btn.classList.toggle('on', btn.getAttribute('data-lang-btn') === self.lang);
            });

            // brand name depends on language (server-rendered pages handle their own)
            if (window.AB_MODE !== 'server') {
                this.applyBrand();
            }
            document.dispatchEvent(new CustomEvent('ab:lang'));
        },

        setLang: function (l) {
            this.lang = (l === 'en') ? 'en' : 'bn';
            set(LS.lang, this.lang);
            this.applyLang();
        },

        toggleLang: function () {
            this.setLang(this.lang === 'en' ? 'bn' : 'en');
        },

        /* pick bn/en string by current language: AB.t('বাংলা','English') */
        t: function (bn, en) {
            return this.lang === 'en' ? en : bn;
        },

        /* initialize on page load */
        init: function () {
            this.applyTheme(this.getTheme());
            this.applyLang(); // also calls applyBrand
        }
    };

    window.AB = AB;
})();
