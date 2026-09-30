@extends('layouts.admin')

@section('title', 'Debug')
@section('page_title', 'Debug Panel')
@section('page_sub', 'Error findout — system info ar latest log')

@section('content')
    <div class="note-banner" style="background:#fffbeb;border-color:#fcd34d">
        <i class="fa-solid fa-bug" style="color:#b45309"></i>
        <span>এই পেজটা <b>শুধু মূল অ্যাডমিন (admin@khorak.shop)</b> দেখতে পায় — অন্য কোনো admin/user এর কাছে এটা অস্তিত্বই নেই।</span>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.debug.toggle') }}" style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
            @csrf
            <div class="pay-toggle-info">
                <b>Debug Mode</b>
                <span>{{ $debugOn ? 'চালু — নিচে latest error log দেখা যাচ্ছে' : 'বন্ধ — error log দেখতে চালু করুন' }}</span>
            </div>
            <label class="pay-switch">
                <input type="checkbox" name="debug_panel" value="1" {{ $debugOn ? 'checked' : '' }} onchange="this.form.submit()">
                <span class="pay-slider"></span>
            </label>
        </form>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-microchip"></i> System Info</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,220px),1fr));gap:8px">
            @foreach ($info as $label => $value)
                <div style="background:rgba(5,150,105,.05);border:1px solid rgba(5,150,105,.14);border-radius:10px;padding:9px 12px">
                    <div style="font-size:10.5px;font-weight:800;color:#8b7355;text-transform:uppercase;letter-spacing:.5px">{{ $label }}</div>
                    <div style="font-size:13px;font-weight:800;color:#1f2937;margin-top:2px;
                        {{ $value === 'FAIL' || $value === 'MISSING (setup.php chalano hoyni?)' ? 'color:#dc2626' : ($value === 'OK' || $value === 'ON' ? 'color:#059669' : '') }}">{{ $value }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-file-lines"></i> Latest Error Log</h3>
        <p class="desc">{{ $logFile !== '' ? basename($logFile) . ' — ' . $logSize : 'কোনো log file নেই' }} @if ($debugOn && $logLines !== [])— শেষ {{ count($logLines) }} লাইন@endif</p>

        @if (! $debugOn)
            <p style="color:#8b7355;font-size:13px;margin:0">Debug mode বন্ধ — উপরের switch চালু করলে error log দেখা যাবে।</p>
        @elseif ($logLines === [])
            <p style="color:#059669;font-size:13px;margin:0"><i class="fa-solid fa-circle-check"></i> দুর্দান্ত — log এ কোনো লেখা নেই (কোনো error পড়েনি)।</p>
        @else
            <div style="max-height:520px;overflow:auto;background:#0b1f17;border-radius:12px;padding:14px">
                @foreach ($logLines as $line)
                    @php
                        $isError = str_contains($line, 'ERROR') || str_contains($line, 'CRITICAL') || str_contains($line, 'ALERT') || str_contains($line, 'EMERGENCY');
                        $isWarn = str_contains($line, 'WARNING');
                    @endphp
                    <div style="font-family:Consolas,monospace;font-size:11px;line-height:1.7;white-space:pre-wrap;word-break:break-word;color:{{ $isError ? '#fca5a5' : ($isWarn ? '#fcd34d' : '#86efac') }}">{{ $line }}</div>
                @endforeach
            </div>
            <p class="desc" style="margin:8px 0 0">🔴 error • 🟡 warning • 🟢 স্বাভাবিক লাইন</p>
        @endif
    </div>
@endsection
