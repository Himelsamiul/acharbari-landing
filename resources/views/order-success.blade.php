<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অর্ডার সফল — আচারবাড়ি</title>
    <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/fontawesome.min.css?v=5">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Plus Jakarta Sans', 'Hind Siliguri', sans-serif;
            background:
                radial-gradient(700px 420px at 12% 0%, rgba(16, 185, 129, .14), transparent 60%),
                linear-gradient(160deg, #064e3b, #022c22 70%);
        }

        .success-card {
            width: 100%;
            max-width: 560px;
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 40px 90px -20px rgba(0, 0, 0, .5);
        }

        .success-top {
            text-align: center;
            padding: 38px 30px 26px;
            background: linear-gradient(180deg, #f2faf5, #fff);
        }

        .success-ic {
            width: 76px;
            height: 76px;
            margin: 0 auto 16px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 34px;
            color: #fff;
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 18px 40px -12px rgba(5, 150, 105, .7);
        }

        .success-top h1 {
            margin: 0 0 6px;
            font-size: 23px;
            color: #12261d;
        }

        .success-top p {
            margin: 0;
            font-size: 13.5px;
            color: #5f7a6d;
        }

        .order-code {
            display: inline-block;
            margin-top: 14px;
            padding: 8px 22px;
            border-radius: 999px;
            background: #f2faf5;
            border: 1.5px dashed #059669;
            font-weight: 800;
            letter-spacing: 1px;
            color: #047857;
        }

        .success-body {
            padding: 24px 30px 30px;
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 9px 0;
            font-size: 13.5px;
            border-bottom: 1px dashed #eef2ec;
        }

        .sum-row span:first-child {
            color: #5f7a6d;
            font-weight: 600;
        }

        .sum-row span:last-child {
            font-weight: 700;
            color: #12261d;
            text-align: right;
        }

        .sum-row.total span {
            font-size: 16px;
            color: #047857;
            border: none;
        }

        .btn-home {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 14px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff;
            font-weight: 800;
            font-size: 15px;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 14px 30px -12px rgba(5, 150, 105, .7);
        }
    </style>
</head>

<body>
    <div class="success-card">
        <div class="success-top">
            <div class="success-ic"><i class="fa-solid fa-check"></i></div>
            <h1>অর্ডার সফলভাবে গৃহীত! 🎉</h1>
            <p>আমাদের প্রতিনিধি শীঘ্রই ফোন করে অর্ডার কনফার্ম করবেন।</p>
            <div class="order-code">অর্ডার নং: {{ $order->order_code }}</div>
        </div>
        <div class="success-body">
            <div class="sum-row"><span>নাম</span><span>{{ $order->customer_name }}</span></div>
            <div class="sum-row"><span>মোবাইল</span><span>{{ $order->phone }}</span></div>
            <div class="sum-row"><span>ঠিকানা</span><span>{{ $order->address }}</span></div>
            @foreach ($order->items as $item)
                <div class="sum-row"><span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                    <span>৳{{ number_format($item->line_total) }}</span></div>
            @endforeach
            <div class="sum-row"><span>সাবটোটাল</span><span>৳{{ number_format($order->subtotal) }}</span></div>
            @if ($order->discount > 0)
                <div class="sum-row"><span>ডিসকাউন্ট {{ $order->coupon_code }}</span><span>−৳{{ number_format($order->discount) }}</span></div>
            @endif
            <div class="sum-row"><span>ডেলিভারি চার্জ</span><span>৳{{ number_format($order->shipping_cost) }}</span></div>
            <div class="sum-row total"><span>সর্বমোট ({{ strtoupper($order->payment_method) }})</span>
                <span>৳{{ number_format($order->total) }}</span></div>
            <a class="btn-home" href="{{ url('/') }}"><i class="fa-solid fa-house"></i> হোমে ফিরে যান</a>
        </div>
    </div>
</body>

</html>
