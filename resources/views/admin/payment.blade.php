@extends('layouts.admin')

@section('title', 'পেমেন্ট সেটিংস')
@section('page_title', 'পেমেন্ট গেটওয়ে')
@section('page_sub', 'অনলাইন পেমেন্ট চালু/বন্ধ — বিকাশ ও নগদ API')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-wand-magic-sparkles"></i>
        <span>মাস্টার টগল <b>বন্ধ</b> থাকলে কাস্টমার শুধু <b>ক্যাশ অন ডেলিভারি</b> দেখবে। চালু করলে নিচে যে গেটওয়ে চালু ও কনফিগার করা আছে শুধু সেটাই চেকআউটে দেখাবে — কাস্টমার সরাসরি বিকাশ/নগদের পেজে গিয়ে পেমেন্ট করবে।</span>
    </div>

    <div class="card">
        <h3>অনলাইন পেমেন্ট (মাস্টার টগল)</h3>
        <p class="desc">ক্যাশ অন ডেলিভারি সবসময় চালু থাকে — এই টগল পুরো অনলাইন পেমেন্ট নিয়ন্ত্রণ করে</p>
        <form method="POST" action="{{ route('admin.settings.payment.save') }}">
            @csrf
            <div class="pay-toggle-row">
                <div class="pay-toggle-info">
                    <b>অনলাইন পেমেন্ট চালু</b>
                    <span>চালু থাকলে চেকআউটে অনলাইন পেমেন্ট অপশন দেখাবে (কনফিগার করা গেটওয়ে অনুযায়ী)</span>
                </div>
                <label class="pay-switch">
                    <input type="checkbox" name="online_payment_enabled" value="1" id="payToggle" {{ ($settings['online_payment_enabled'] ?? '') === '1' ? 'checked' : '' }}>
                    <span class="pay-slider"></span>
                </label>
            </div>
            <div class="pay-gw-head">
                <span class="gw-logo"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
                <div class="pay-toggle-info">
                    <b>bKash — Tokenized Checkout</b>
                    <span>developer.bka.sh theke app key, app secret, username ও password নিয়ে এখানে বসান</span>
                </div>
                <label class="pay-switch">
                    <input type="checkbox" name="bkash_enabled" value="1" id="bkashToggle" {{ ($settings['bkash_enabled'] ?? '') === '1' ? 'checked' : '' }}>
                    <span class="pay-slider"></span>
                </label>
            </div>
            <div class="gw-fields" id="bkashFields">
                <div class="brand-grid">
                    <div class="a-field">
                        <label>মোড</label>
                        <select class="a-input" name="bkash_mode">
                            <option value="sandbox" {{ ($settings['bkash_mode'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox (টেস্ট)</option>
                            <option value="live" {{ ($settings['bkash_mode'] ?? '') === 'live' ? 'selected' : '' }}>Live (প্রোডাকশন)</option>
                        </select>
                    </div>
                    <div class="a-field">
                        <label>App Key</label>
                        <input class="a-input" name="bkash_app_key" value="{{ $settings['bkash_app_key'] ?? '' }}">
                    </div>
                    <div class="a-field">
                        <label>App Secret</label>
                        <input class="a-input" name="bkash_app_secret" value="{{ $settings['bkash_app_secret'] ?? '' }}">
                    </div>
                    <div class="a-field">
                        <label>Username</label>
                        <input class="a-input" name="bkash_username" value="{{ $settings['bkash_username'] ?? '' }}">
                    </div>
                    <div class="a-field">
                        <label>Password</label>
                        <input class="a-input" type="password" name="bkash_password" value="{{ $settings['bkash_password'] ?? '' }}">
                    </div>
                </div>
                <p class="pay-hint">বিকাশ মার্চেন্ট পোর্টালে এই Callback URL রেজিস্টার করুন: <code>{{ route('payment.callback.bkash', 'ORDER_CODE') }}</code></p>
            </div>
            <div class="pay-gw-head" style="margin-top:18px">
                <span class="gw-logo gw-nagad"><i class="fa-solid fa-bolt"></i></span>
                <div class="pay-toggle-info">
                    <b>নগদ (Nagad) — Payment Gateway</b>
                    <span>নগদ থেকে পাওয়া Merchant ID, Nagad Public Key ও আপনার Private Key বসান</span>
                </div>
                <label class="pay-switch">
                    <input type="checkbox" name="nagad_enabled" value="1" id="nagadToggle" {{ ($settings['nagad_enabled'] ?? '') === '1' ? 'checked' : '' }}>
                    <span class="pay-slider"></span>
                </label>
            </div>
            <div class="gw-fields" id="nagadFields">
                <div class="brand-grid">
                    <div class="a-field">
                        <label>মোড</label>
                        <select class="a-input" name="nagad_mode">
                            <option value="sandbox" {{ ($settings['nagad_mode'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox (টেস্ট)</option>
                            <option value="live" {{ ($settings['nagad_mode'] ?? '') === 'live' ? 'selected' : '' }}>Live (প্রোডাকশন)</option>
                        </select>
                    </div>
                    <div class="a-field">
                        <label>Merchant ID</label>
                        <input class="a-input" name="nagad_merchant_id" value="{{ $settings['nagad_merchant_id'] ?? '' }}">
                    </div>
                </div>
                <div class="a-field" style="margin-top:10px">
                    <label>Nagad Public Key (নগদ থেকে পাবেন)</label>
                    <textarea class="a-input" name="nagad_public_key" rows="3" placeholder="MIIBIjANBgkqh... (PEM হেডার ছাড়াও চলবে)">{{ $settings['nagad_public_key'] ?? '' }}</textarea>
                </div>
                <div class="a-field" style="margin-top:10px">
                    <label>আপনার Private Key (Nagad-এ যে public key দিয়েছেন তার জোড়া)</label>
                    <textarea class="a-input" name="nagad_private_key" rows="3" placeholder="MIIEvQIBADANBg... (PEM হেডার ছাড়াও চলবে)">{{ $settings['nagad_private_key'] ?? '' }}</textarea>
                </div>
                <p class="pay-hint">নগদ মার্চেন্ট পোর্টালে এই Callback URL দিন: <code>{{ route('payment.callback.nagad', 'ORDER_CODE') }}</code></p>
            </div>
            <button class="a-btn" style="margin-top:18px"><i class="fa-solid fa-floppy-disk"></i> সব সেটিংস সেভ করুন</button>
        </form>
    </div>

    <div class="card">
        <h3>পেমেন্ট মেথড ওভারভিউ</h3>
        <p class="desc">কাস্টমার চেকআউটে যা দেখবে</p>
        <div class="pay-methods-row">
            @php
                $bkashState = ! \App\Services\Payment\BkashGateway::enabled()
                    ? 'বন্ধ'
                    : (\App\Services\Payment\BkashGateway::configured()
                        ? 'চালু — ' . (\App\Services\Payment\BkashGateway::baseUrl() === 'https://tokenized.pay.bka.sh/v1.2.0-beta' ? 'live' : 'sandbox')
                        : 'কনফিগার নেই');
            @endphp
            <div class="pay-method-chip {{ \App\Services\Payment\BkashGateway::ready() ? 'on' : '' }}">
                <span class="img-chip"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
                <div>
                    <b>bKash</b>
                    <span>API — {{ $bkashState }}</span>
                </div>
            </div>
            <div class="pay-method-chip {{ \App\Services\Payment\NagadGateway::ready() ? 'on' : '' }}">
                <span class="img-chip"><img src="{{ asset('assets/img/pay/nagad.svg') }}" alt="Nagad"></span>
                <div>
                    <b>Nagad</b>
                    <span>API — {{ \App\Services\Payment\NagadGateway::enabled() ? (\App\Services\Payment\NagadGateway::configured() ? 'চালু' : 'কনফিগার নেই') : 'বন্ধ' }}</span>
                </div>
            </div>
            <div class="pay-method-chip always">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <div>
                    <b>ক্যাশ অন ডেলিভারি</b>
                    <span>সবসময় চালু (ইউনিভার্সাল)</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pay-toggle-row {
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
            background: rgba(5, 150, 105, .04); border: 1px solid rgba(5, 150, 105, .12);
            border-radius: 14px; padding: 16px 18px; flex-wrap: wrap;
        }
        .pay-toggle-info b { display: block; font-size: 14px; color: #12261d; }
        .pay-toggle-info span { display: block; font-size: 12px; color: #8b7355; margin-top: 3px; }
        .pay-switch { position: relative; display: inline-block; width: 53px; height: 28px; flex-shrink: 0; }
        .pay-switch input { opacity: 0; width: 0; height: 0; }
        .pay-slider {
            position: absolute; cursor: pointer; inset: 0; border-radius: 999px;
            background: #d1d5db; transition: .25s;
        }
        .pay-slider:before {
            content: ""; position: absolute; height: 22px; width: 22px; left: 3px; top: 3px;
            background: #fff; border-radius: 50%; transition: .25s; box-shadow: 0 2px 6px rgba(0,0,0,.2);
        }
        input:checked + .pay-slider { background: #059669; }
        input:checked + .pay-slider:before { transform: translateX(24px); }
        .pay-gw-head {
            display: flex; align-items: center; gap: 12px; margin-top: 16px;
            border-top: 1px dashed rgba(5, 150, 105, .18); padding-top: 16px; flex-wrap: wrap;
        }
        .pay-gw-head .pay-toggle-info { flex: 1; min-width: 200px; }
        .gw-logo { width: 40px; height: 40px; border-radius: 10px; background: #fff; border: 1px solid rgba(5,150,105,.14); display: grid; place-items: center; flex-shrink: 0; }
        .gw-logo img { width: 30px; height: 30px; object-fit: contain; }
        .gw-logo.gw-nagad { color: #f6921e; font-size: 18px; }
        .gw-fields { margin-top: 12px; padding-left: 52px; transition: opacity .2s; }
        .gw-fields.off { opacity: .45; }
        .gw-fields textarea.a-input { font-family: monospace; font-size: 12px; }
        .pay-hint { font-size: 11.5px; color: #8b7355; margin: 10px 0 0; word-break: break-all; }
        .pay-hint code { background: rgba(5,150,105,.08); padding: 2px 6px; border-radius: 6px; font-size: 11px; }
        .pay-methods-row { display: flex; gap: 12px; flex-wrap: wrap; }
        .pay-method-chip {
            display: flex; align-items: center; gap: 10px;
            border: 1px solid rgba(5, 150, 105, .14); border-radius: 12px; padding: 10px 14px; min-width: 180px;
        }
        .pay-method-chip .img-chip { width: 34px; height: 34px; }
        .pay-method-chip .img-chip img { width: 100%; height: 100%; object-fit: contain; }
        .pay-method-chip i { font-size: 20px; color: #059669; }
        .pay-method-chip b { display: block; font-size: 13.5px; color: #12261d; }
        .pay-method-chip span { display: block; font-size: 11.5px; color: #8b7355; }
        .pay-method-chip.always { border-style: dashed; }
        @media (max-width: 700px) {
            .pay-methods-row { flex-direction: column; }
            .gw-fields { padding-left: 0; }
        }
    </style>
@endsection

@push('scripts')
    <script>
        // dim a gateway's fields when its switch is off
        (function () {
            [['bkashToggle', 'bkashFields'], ['nagadToggle', 'nagadFields']].forEach(function (pair) {
                var t = document.getElementById(pair[0]);
                var box = document.getElementById(pair[1]);
                if (t && box) {
                    var sync = function () { box.classList.toggle('off', !t.checked); };
                    t.addEventListener('change', sync);
                    sync();
                }
            });
        })();
    </script>
@endpush
