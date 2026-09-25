@extends('layouts.admin')

@section('title', 'কমপ্লেইন')
@section('page_title', 'কমপ্লেইন')
@section('page_sub', 'কাস্টমারদের কমপ্লেইন দেখুন ও সমাধান করুন')

@section('content')
    <div class="card">
        <h3>সব কমপ্লেইন <span style="color:#8b7355;font-weight:400">({{ $complaints->total() }}টি)</span></h3>
        <p class="desc">ল্যান্ডিং পেজের "কমপ্লেইন" ফর্ম থেকে আসা অভিযোগ — সমাধান হলে টগল করুন।</p>

        @if ($complaints->count())
            <table class="tbl">
                <thead>
                    <tr>
                        <th>কাস্টমার</th>
                        <th>বিবরণ</th>
                        <th>স্ট্যাটাস</th>
                        <th>সময়</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($complaints as $complaint)
                        <tr>
                            <td>
                                <b>{{ $complaint->name }}</b><br>
                                <a href="tel:{{ $complaint->phone }}" style="color:#8b7355;text-decoration:none">{{ $complaint->phone }}</a>
                                @if ($complaint->order_code)
                                    <br><code style="font-size:11px">{{ $complaint->order_code }}</code>
                                @endif
                            </td>
                            <td style="max-width:420px;white-space:pre-wrap">{{ $complaint->description }}</td>
                            <td>
                                @if ($complaint->is_resolved)
                                    <span style="display:inline-block;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:700;background:rgba(22,163,74,.12);color:#16a34a">সমাধান হয়েছে</span>
                                @else
                                    <span style="display:inline-block;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:700;background:rgba(220,38,38,.1);color:#dc2626">অমীমাংসিত</span>
                                @endif
                            </td>
                            <td style="white-space:nowrap;color:#8b7355">{{ $complaint->created_at->format('d M, h:i A') }}</td>
                            <td style="white-space:nowrap">
                                <form method="POST" action="{{ route('admin.complaints.toggle', $complaint) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn" style="padding:6px 12px;font-size:12px">
                                        {{ $complaint->is_resolved ? 'পুনরায় খুলুন' : 'সমাধান হয়েছে' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.complaints.destroy', $complaint) }}" style="display:inline"
                                    onsubmit="return confirm('কমপ্লেইনটি মুছে ফেলবেন?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="padding:6px 12px;font-size:12px;background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.3);color:#dc2626">মুছুন</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:14px">{{ $complaints->withQueryString()->links() }}</div>
        @else
            <p style="color:#8b7355;padding:18px 0">এখনো কোনো কমপ্লেইন আসেনি।</p>
        @endif
    </div>
@endsection
