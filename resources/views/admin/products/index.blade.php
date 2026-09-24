@extends('layouts.admin')

@section('title', 'প্রোডাক্ট')
@section('page_title', 'প্রোডাক্ট')
@section('page_sub', 'ল্যান্ডিং পেজে দেখানো প্রোডাক্টগুলো')

@section('content')
    <div class="card">
        <h3>প্রোডাক্ট লিস্ট</h3>
        <p class="desc">মোট {{ $products->count() }}টি সক্রিয় প্রোডাক্ট (ডেমো — এডিট প্রোডাকশনে আসবে)</p>
        <table class="tbl">
            <thead>
                <tr><th>প্রোডাক্ট</th><th>ক্যাটাগরি</th><th>দাম</th><th>রেটিং</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                    <tr>
                        <td><img class="pimg" src="{{ asset($p->image) }}" alt=""><b>{{ $p->name }}</b></td>
                        <td><span class="pill mut">{{ $p->category }}</span></td>
                        <td><b>৳{{ number_format($p->price) }}</b></td>
                        <td style="color:#f59e0b">★ {{ number_format($p->rating, 1) }}</td>
                        <td>
                            @if ($p->is_active)
                                <span class="pill ok">লাইভ</span>
                            @else
                                <span class="pill red">অফ</span>
                            @endif
                        </td>
                        <td><a class="side-link" style="background:rgba(5,150,105,.08);color:#1f4234;border-radius:10px;padding:7px 13px;width:auto;text-decoration:none" href="{{ route('product.show', $p->slug) }}" target="_blank"><i class="fa-solid fa-eye"></i> দেখুন</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
