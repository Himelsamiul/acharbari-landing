<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অর্ডার ট্র্যাক করুন — আচারবাড়ি</title>
    <link rel="icon" href="{{ asset($settings['favicon_path'] ?: 'assets/img/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome.min.css') }}">
    <style>
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            padding: 20px; font-family: 'Plus Jakarta Sans', 'Hind Siliguri', sans-serif;
            background:
                radial-gradient(700px 420px at 12% 0%, rgba(16,185,129,.14), transparent 60%),
                linear-gradient(160deg, #064e3b, #022c22 70%);
        }
        .track-card {
            width: 100%; max-width: 620px;
            background: #fff; border-radius: 24px; overflow: hidden;
            box-shadow: 0 40px 90px -20px rgba(0,0,0,.5);
        }
        .track-top { text-align: center; padding: 32px 30px 20px; background: linear-gradient(180deg, #f2faf5, #fff); }
        .track-top .ic {
            width: 66px; height: 66px; margin: 0 auto 14px; border-radius: 50%;
            display: grid; place-items: center; font-size: 28px; color: #fff;
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 18px 40px -12px rgba(5,150,105,.7);
        }
        h1 { margin: 0 0 6px; font-size: 22px; color: #12261d; }
        p.sub { margin: 0; font-size: 13px; color: #5f7a6d; }
        .track-body { padding: 24px 30px 30px; }
        .track-body form { display: flex; gap: 10px; }
        .track-body input {
            flex: 1; border: 1.5px solid rgba(5,150,105,.3); border-radius: 12px;
            padding: 12px 14px; font-size: 14px; font-family: inherit; outline: none;
        }
        .track-body input:focus { border-color: #059669; }
        .track-body button {
            border: none; cursor: pointer; font-family: inherit;
            background: linear-gradient(135deg, #059669, #10b981); color: #fff;
            font-weight: 800; font-size: 14px; padding: 12px 22px; border-radius: 12px;
        }
        .result { margin-top: 22px; }
        .order-box { border: 1.5px solid rgba(5,150,105,.3); border-radius: 16px; overflow: hidden; }
        .order-head {
            background: #064e3b; color: #fff; padding: 14px 18px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .order-head b { font-size: 15px; }
        .status-pill { padding: 5px 14px; border-radius: 999px; font-size: 11.5px; font-weight: 800; }
        .status-pending { background: #fee2e2; color: #dc2626; }
        .status-processing { background: #fef3c7; color: #b45309; }
        .status-shipped { background: #dbeafe; color: #2563eb; }
        .status-delivered { background: #d1fae5; color: #059669; }
        .status-cancelled { background: #f3f4f6; color: #6b7280; }
        .order-items { padding: 14px 18px; }
        .item-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; color: #374151; }
        .item-total { padding: 10px 18px; background: #f2faf5; display: flex; justify-content: space-between; font-weight: 800; color: #047857; }
        .note { text-align: center; margin-top: 18px; font-size: 12px; color: #5f7a6d; }
        .not-found { text-align: center; color: #dc2626; font-weight: 700; padding: 10px 0; }
        .back-link { display: block; text-align: center; margin-top: 16px; color: #a3e635; font-size: 12.5px; font-weight: 700; text-decoration: none; }
        @media (max-width: 640px) { .track-body form { flex-direction: column; } }
    </style>
</head>

<body>
    <div class="track-card">
        <div class="track-top">
            <div class="ic"><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/><path d="M11 8a3 3 0 0 1 3 3"/></svg></div>
            <h1>অর্ডার ট্র্যাক করুন</h1>
            <p class="sub">ট্র্যাকিং কোড ও অর্ডারের মোবাইল নম্বর — দুটোই দিন</p>
        </div>
        <div class="track-body">
            <form method="GET" action="{{ route('track') }}">
                <input type="text" name="code" value="{{ $code }}" placeholder="ট্র্যাকিং কোড (যেমন: AB-XXXXXX)" required>
                <input type="tel" inputmode="numeric" name="phone" value="{{ $phone }}" placeholder="অর্ডারের মোবাইল নম্বর (017XXXXXXXX)" required>
                <button type="submit"><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg> ট্র্যাক</button>
            </form>

            @if ($code !== '' && $phone !== '')
                @if ($order)
                    <div class="result">
                        <div class="order-box">
                            <div class="order-head">
                                <b>#{{ $order->order_code }}</b>
                                <span class="status-pill status-{{ $order->status }}">
                                    {{ \App\Models\Order::statusLabels()[$order->status] }}
                                </span>
                            </div>
                            <div class="order-items">
                                <div style="font-size:12px;color:#6b7280;margin-bottom:6px">
                                    {{ $order->created_at->format('d M Y, h:i A') }} • {{ $order->customer_name }}
                                </div>
                                @foreach ($order->items as $item)
                                    <div class="item-row">
                                        <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                                        <span>৳{{ number_format($item->line_total) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="item-total">
                                <span>সর্বমোট ({{ strtoupper($order->payment_method) }})</span>
                                <span>৳{{ number_format($order->total) }}</span>
                            </div>
                        </div>
                        <p class="note">আপনার অর্ডারের সর্বশেষ অবস্থা উপরে দেখানো হয়েছে।</p>
                    </div>
                @else
                    <div class="not-found" style="margin-top:16px">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        এই কোড ও নম্বরে কোনো অর্ডার মেলেনি — কোড ও ফোন নম্বর দুটোই অর্ডারের সাথে মিলছে কিনা দেখুন।
                    </div>
                @endif
            @endif

            <a class="back-link" href="{{ url('/') }}">← হোমে ফিরে যান</a>
        </div>
    </div>
</body>

</html>
