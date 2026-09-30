@extends('layouts.admin')

@section('title', 'Debug')
@section('page_title', 'Debug Panel')
@section('page_sub', 'Error findout — .env chara, directly system theke')

@section('content')
    <div class="note-banner" style="background:#fffbeb;border-color:#fcd34d">
        <i class="fa-solid fa-bug" style="color:#b45309"></i>
        <span>এই পেজটা <b>শুধু মূল অ্যাডমিন (admin@khorak.shop)</b> দেখতে পায়। <b>.env এ APP_DEBUG on/off করা আর লাগবে না</b> — কোনো error হলে সরাসরি এখান থেকেই দেখুন (message, file/line, stack trace সহ)। অন্য কোনো admin/user এর কাছে এটা অস্তিত্বই নেই।</span>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.debug.toggle') }}" style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
            @csrf
            <div class="pay-toggle-info">
                <b>Debug Mode</b>
                <span>{{ $debugOn ? 'চালু — নিচে parse করা error গুলো দেখা যাচ্ছে' : 'বন্ধ — error দেখতে চালু করুন (আবার বন্ধ করে রাখতে পারেন)' }}</span>
    </div>
            <label class="pay-switch">
                <input type="checkbox" onchange="this.form.submit()" name="debug_panel" value="1" {{ $debugOn ? 'checked' : '' }}>
                <span class="pay-slider"></span>
            </label>
        </form>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-microchip"></i> System Info</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,220px),1fr));gap:8px">
            @foreach ($info as $label => $value)
                <div style="background:rgba(5,150,105,.05);border:1px solid rgba(5,150,105,.14);border-radius:10px;padding:9px 12px">
                    <div style="font-size:10.5px;font-indent:0;font-weight:800;color:#8b7355;text-transform:uppercase;letter-spacing:.5px">{{ $label }}</div>
                    <div style="font-size:13px;font-weight:800;color:#1f2937;margin-top:2px;
                        {{ $value === 'FAIL' || str_starts_with((string) $value, 'MISSING') ? 'color:#dc2626' : ($value === 'OK' || $value === 'ON' ? 'color:#059669' : '') }}">{{ $value }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card" id="errbox">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap">
            <div>
                <h3 style="margin-bottom:2px"><i class="fa-solid fa-triangle-exclamation"></i> Error গুলো <span class="pill {{ $errorCount > 0 ? 'red' : 'ok' }}">{{ $errorCount }}টি error</span></h3>
                <p class="desc" style="margin:0">{{ $logFile !== '' ? basename($logFile) . ' — ' . $logSize . ' • সর্বশেষ ৬০টি entry, নতুন থেকে পুরনো' : 'কোনো log file নেই' }}</p>
            </div>
            @if ($debugOn && $errors !== [])
            <div style="display:flex;gap:6px">
                <button type="button" class="filter-tab active" data-lvl="all" onclick="filterDebug('all', this)">সব</button>
                <button type="button" class="filter-tab" data-lvl="error" onclick="filterDebug('error', this)">শুধু Error</button>
                <button type="button" class="filter-tab" data-lvl="info" onclick="filterDebug('info', this)">Info</button>
            </div>
            @endif
        </div>

        @if (! $debugOn)
            <p style="color:#8b7355;font-size:13px;margin:14px 0 0">Debug mode বন্ধ — উপরের switch চালু করলে error গুলো দেখা যাবে।</p>
        @elseif ($errors === [])
            <p style="color:#059669;font-size:13px;margin:14px 0 0"><i class="fa-solid fa-circle-check"></i> দুর্দান্ত! কোনো error নেই — সব শান্ত। 🎉</p>
        @else
            <div id="debugList" style="margin-top:14px;display:flex;flex-direction:column;gap:10px">
                @foreach ($errors as $e)
                    <div class="dbg-item" data-lvl="{{ $e['level'] }}" style="border:1px solid {{ $e['level'] === 'error' ? 'rgba(220,38,38,.25)' : 'rgba(180,83,9,.3)' }};border-left-width:4px;border-radius:12px;background:{{ $e['level'] === 'error' ? '#fef2f2' : '#fffbeb' }};overflow:hidden">
                        <div style="padding:10px 14px">
                            <div style="display:flex;justify-content:space-between;gap:8px;align-items:center;flex-wrap:wrap">
                                <span style="font-size:10px;font-weight:800;letter-spacing:.5px;color:{{ $e['level'] === 'error' ? '#dc2626' : '#b45309' }}">{{ $e['level_name'] }}</span>
                                <small style="color:#8b7355;font-size:10.5px">{{ $e['time'] }}</small>
                            </div>
                            <div style="font-size:12.5px;font-weight:700;color:#1f2937;margin-top:4px;word-break:break-word">{{ $e['message'] }}</div>
                            @if ($e['stack'] !== '')
                                <details style="margin-top:6px">
                                    <summary style="cursor:pointer;font-size:11.5px;font-weight:800;color:#059669">Stack trace দেখুন</summary>
                                    <pre style="margin:8px 0 0;font-family:Consolas,monospace;font-size:10.5px;line-height:1.6;white-space:pre-wrap;word-break:break-word;color:#4b5563;background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:10px">{{ $e['stack'] }}</pre>
                                </details>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <script>
                function filterDebug(lvl, btn) {
                    document.querySelectorAll('.filter-tab[data-lvl]').forEach(function (b) { b.classList.remove('active'); });
                    btn.classList.add('active');
                    document.querySelectorAll('.dbg-item').forEach(function (el) {
                        el.style.display = (lvl === 'all' || el.dataset.lvl === lvl || (lvl === 'info' && el.dataset.lvl === 'warning')) ? '' : 'none';
                    });
                }
            </script>
    @endif
    </div>
@endsection
