@extends('layouts.landing')

@section('title', 'আমার অর্ডারসমূহ')

@section('content')
    @php
        $labels = \App\Models\Order::statusLabels();
        $pillClass = ['pending' => 'rgba(220,38,38,.08);color:#dc2626;border-color:rgba(220,38,38,.2)',
            'processing' => 'rgba(217,119,6,.1);color:#b45309;border-color:rgba(217,119,6,.22)',
            'shipped' => 'rgba(59,130,246,.1);color:#2563eb;border-color:rgba(59,130,246,.22)',
            'delivered' => 'rgba(22,163,74,.1);color:#15803d;border-color:rgba(22,163,74,.22)',
            'cancelled' => 'rgba(90,90,90,.08);color:#5a5a5a;border-color:rgba(90,90,90,.2)'];
    @endphp
    <section style="min-height:70vh; padding:34px 16px 60px" class="max-w-3xl mx-auto w-full">
        <div class="mb-6" style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
            <div>
                <h1 class="text-2xl font-extrabold" style="margin:0">আমার অর্ডারসমূহ</h1>
                <p class="text-sm text-gray-500" style="margin:4px 0 0">আপনার সব অর্ডারের স্ট্যাটাস ও ইনভয়েস এক জায়গায়</p>
            </div>
            <a href="{{ route('account') }}" class="ds-btn ds-btn-ghost" style="text-decoration:none">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                প্রোফাইল
            </a>
        </div>

        @forelse ($orders as $o)
            <div class="bg-white rounded-2xl shadow-xl mb-4" style="border:1px solid rgba(5,150,105,.12);padding:18px 20px">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap">
                    <div>
                        <b style="font-size:15px">#{{ $o->order_code }}</b>
                        <p class="text-xs text-gray-500" style="margin:3px 0 0">{{ $o->created_at->format('d M Y, h:i A') }} — {{ $o->items->sum('quantity') }} টি আইটেম</p>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                        <b class="text-lg text-emerald-600">৳{{ bn_num($o->total) }}</b>
                        <span class="text-xs font-bold"
                            style="padding:4px 12px;border-radius:999px;border:1px solid {{ $pillClass[$o->status] }};background:{{ explode(';', $pillClass[$o->status])[0] }};color:{{ explode(';', $pillClass[$o->status])[1] }}">
                            {{ $labels[$o->status] ?? $o->status }}
                        </span>
                    </div>
                </div>

                <ul style="list-style:none;margin:12px 0 0;padding:10px 0 0;border-top:1px dashed rgba(5,150,105,.18)">
                    @foreach ($o->items as $item)
                        <li style="display:flex;justify-content:space-between;gap:10px;padding:4px 0;font-size:13px">
                            <span>{{ $item->product_name }} × {{ bn_num($item->quantity) }}</span>
                            <b>৳{{ bn_num($item->line_total) }}</b>
                        </li>
                    @endforeach
                </ul>

                <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;margin-top:12px;padding-top:12px;border-top:1px solid rgba(5,150,105,.1);flex-wrap:wrap">
                    <span class="text-xs text-gray-500">পেমেন্ট: {{ $o->payment_method === 'cod' ? 'ক্যাশ অন ডেলিভারি' : strtoupper($o->payment_method) }}</span>
                    <a href="{{ route('order.invoice', $o->order_code) }}" class="ds-btn ds-btn-ghost" style="text-decoration:none;padding:8px 16px;font-size:13px">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                        ইনভয়েস PDF
                    </a>
                </div>

                {{-- latest notification message from the shop --}}
                @php $latestNote = $o->notifications()->latest()->first(); @endphp
                @if ($latestNote)
                    <div class="rounded-xl text-xs mt-3 px-3" style="padding-top:10px;padding-bottom:10px;background:rgba(5,150,105,.06);border:1px solid rgba(5,150,105,.16);color:#1f4234">
                        <b>{{ $latestNote->title }}:</b> {{ $latestNote->message }}
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-xl text-center" style="border:1px solid rgba(5,150,105,.12);padding:44px 20px">
                <p class="text-gray-500 text-sm mb-4">এখনো কোনো অর্ডার করেননি — ল্যান্ডিং পেজ থেকে অর্ডার করুন, সেগুলো এখানে দেখা যাবে।</p>
                <a href="{{ route('home') }}" class="ds-btn" style="text-decoration:none">অর্ডার করুন</a>
            </div>
        @endforelse

        @if ($orders->hasPages())
            <div style="display:flex;gap:8px;justify-content:center;margin-top:18px">
                {{ $orders->links() }}
            </div>
        @endif
    </section>
@endsection
