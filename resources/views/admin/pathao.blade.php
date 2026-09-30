@extends('layouts.admin')

@section('title', 'Pathao API')
@section('page_title', 'Pathao Courier API')
@section('page_sub', 'অর্ডার পাঠানো ও ডেলিভারি স্ট্যাটাস — Pathao Courier')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-truck-fast"></i>
        <span>Pathao Merchant হিসেবে <b>developer.pathao.com</b> থেকে API credentials নিয়ে এখানে বসান। চালু থাকলে প্রতিটা অর্ডার পেজ থেকে এক ক্লিকে <b>Pathao তে পাঠানো</b> যাবে, আর ডেলিভারি স্ট্যাটাস টেনে আনা যাবে। বন্ধ বা কনফিগার না থাকলে কিছুই বদলাবে না — অর্ডার আগের মতোই।</span>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-plug-circle-check"></i> API Settings</h3>
        <form method="POST" action="{{ route('admin.settings.pathao.save') }}">
            @csrf
            <div class="pay-gw-head">
                <span class="gw-logo" style="background:#fef3c7;color:#b45309"><i class="fa-solid fa-truck-fast"></i></span>
                <div class="pay-toggle-info">
                    <b>Pathao Courier চালু</b>
                    <span>চালু করলে অর্ডার পেজে "Pathao তে পাঠান" বাটন দেখা যাবে</span>
                </div>
                <label class="pay-switch">
                    <input type="checkbox" name="pathao_enabled" value="1" {{ ($settings['pathao_enabled'] ?? '') === '1' ? 'checked' : '' }}>
                    <span class="pay-slider"></span>
                </label>
            </div>
            <div class="gw-fields">
                <div class="brand-grid">
                    <div class="a-field">
                        <label>মোড</label>
                        <select class="a-input" name="pathao_mode">
                            <option value="sandbox" {{ ($settings['pathao_mode'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox (টেস্ট)</option>
                            <option value="live" {{ ($settings['pathao_mode'] ?? '') === 'live' ? 'selected' : '' }}>Live (প্রোডাকশন)</option>
                        </select>
                    </div>
                    <div class="a-field">
                        <label>Username (মার্চেন্ট ফোন)</label>
                        <input class="a-input" name="pathao_username" value="{{ $settings['pathao_username'] ?? '' }}" maxlength="60" placeholder="Pathao merchant login phone">
                    </div>
                </div>
                <div class="brand-grid" style="margin-top:10px">
                    <div class="a-field">
                        <label>Client ID</label>
                        <input class="a-input" name="pathao_client_id" value="{{ $settings['pathao_client_id'] ?? '' }}" maxlength="120">
                    </div>
                    <div class="a-field">
                        <label>Client Secret</label>
                        <input class="a-input" type="password" name="pathao_client_secret" value="{{ $settings['pathao_client_secret'] ?? '' }}" maxlength="190">
                    </div>
                </div>
                <div class="a-field" style="margin-top:10px">
                    <label>Password</label>
                    <input class="a-input" type="password" name="pathao_password" value="{{ $settings['pathao_password'] ?? '' }}" maxlength="120">
                </div>
                <p class="pay-hint">Base URL অটো বসে — Sandbox: courier-api-sandbox.pathao.com • Live: courier-api.pathao.com</p>
            </div>
            <div style="display:flex;gap:10px;margin-top:14px;flex-wrap:wrap">
                <button class="a-btn" style="padding:11px 24px"><i class="fa-solid fa-floppy-disk"></i> সেভ করুন</button>
                <button type="submit" formaction="{{ route('admin.settings.pathao.test') }}" class="a-btn ghost" style="padding:11px 24px"><i class="fa-solid fa-satellite-dish"></i> সংযোগ টেস্ট করুন</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-list-check"></i> Pathao তে পাঠানো অর্ডার</h3>
        <p class="desc">সর্বশেষ ৩০টা — অর্ডার পেজ থেকে "Pathao তে পাঠান" চাপলে এখানে চলে আসবে</p>
        @if ($sentOrders->isEmpty())
            <p class="desc" style="margin:0">এখনো কোনো অর্ডার Pathao তে পাঠানো হয়নি।</p>
        @else
            <div style="overflow-x:auto">
                <table class="a-table" style="width:100%;border-collapse:collapse;font-size:12.5px">
                    <thead>
                        <tr style="text-align:left;color:#6b7355">
                            <th style="padding:8px 6px">অর্ডার</th>
                            <th style="padding:8px 6px">কাস্টমার</th>
                            <th style="padding:8px 6px">Consignment</th>
                            <th style="padding:8px 6px">Pathao Status</th>
                            <th style="padding:8px 6px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sentOrders as $o)
                            <tr style="border-top:1px solid rgba(5,150,105,.12)">
                                <td style="padding:8px 6px"><a href="{{ route('admin.orders.show', $o) }}" style="color:#047857;font-weight:800;text-decoration:none">#{{ $o->order_code }}</a></td>
                                <td style="padding:8px 6px">{{ $o->customer_name }}<br><small style="color:#8b7355">{{ $o->phone }}</small></td>
                                <td style="padding:8px 6px"><code>{{ $o->pathao_consignment_id }}</code></td>
                                <td style="padding:8px 6px"><b>{{ $o->pathao_status }}</b></td>
                                <td style="padding:8px 6px">
                                    <form method="POST" action="{{ route('admin.orders.pathao.status', $o) }}">
                                        @csrf
                                        <button class="a-btn ghost" style="font-size:11px;padding:5px 10px"><i class="fa-solid fa-rotate"></i> রিফ্রেশ</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-circle-info"></i> যেভাবে কাজ করে</h3>
        <p class="desc" style="margin:0">
            ১. উপরে credentials বসিয়ে <b>সংযোগ টেস্ট</b> চালান — token ঠিকভাবে আসলে সব ঠিক।<br>
            ২. অর্ডার খুলুন (অর্ডারসমূহ → অর্ডার) — নিচে <b>"Pathao তে পাঠান"</b> বাটন পাবেন।<br>
            ৩. পাঠালে Consignment ID অর্ডারের সাথে জমা থাকে, আর এই পেজের লিস্টে চলে আসে।<br>
            ৪. <b>রিফ্রেশ</b> চাপলে Pathao থেকে লেটেস্ট delivery status এসে বসে (Picked up, Delivered ইত্যাদি)।
        </p>
    </div>
@endsection
