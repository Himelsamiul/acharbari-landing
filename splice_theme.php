<?php
// Insert industry CSS into theme page <style> block and JS into its script push.
$file = __DIR__ . '/resources/views/admin/theme.blade.php';
$s = file_get_contents($file);

$css = <<<'CSS'
        /* ===== industry preset tiles ===== */
        .industry-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 168px), 1fr)); gap: 12px; margin-top: 10px; }
        .industry-tile {
            position: relative; border: 2px solid rgba(5,150,105,.15); border-radius: 14px; padding: 14px 12px;
            background: #fff; cursor: pointer; text-align: center; font-family: inherit;
            display: flex; flex-direction: column; align-items: center; gap: 3px;
            transition: transform .15s, border-color .2s, box-shadow .2s;
        }
        .industry-tile:hover { transform: translateY(-3px); border-color: #059669; box-shadow: 0 14px 28px -16px rgba(6,78,59,.4); }
        .industry-tile.active { border-color: #059669; background: rgba(5,150,105,.04); }
        .it-ic {
            width: 42px; height: 42px; border-radius: 12px; display: grid; place-items: center;
            font-size: 17px; margin-bottom: 6px;
            background: linear-gradient(135deg, rgba(5,150,105,.14), rgba(163,230,53,.18));
            color: #047857;
        }
        .industry-tile b { font-size: 12.5px; color: #12261d; line-height: 1.3; }
        .industry-tile small { font-size: 10px; color: #8b7355; }
        .it-swatch { display: flex; gap: 4px; margin-top: 6px; }
        .it-swatch i { width: 13px; height: 13px; border-radius: 50%; display: block; border: 1px solid rgba(0,0,0,.08); }
        .it-active { display: none; margin-top: 6px; font-size: 10.5px; font-weight: 800; color: #059669; }
        .industry-tile.active .it-active { display: inline-flex; gap: 4px; align-items: center; }
        .industry-tile.active::after {
            content: ''; position: absolute; inset: -6px; border-radius: 18px; pointer-events: none;
            border: 1.5px dashed rgba(5,150,105,.45);
        }
        .ind-confirm {
            margin-top: 14px; background: #fffbeb; border: 1.5px dashed #f59e0b;
            border-radius: 14px; padding: 14px 16px;
        }
        .ind-confirm p { margin: 0 0 6px; font-size: 13px; color: #92400e; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .ind-confirm-note { font-size: 11.5px; color: #a16207; }
        .ind-confirm-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
CSS;

$js = <<<'JS'
        /* ===== industry preset apply ===== */
        var IND_SELECTED = null;
        var IND_URL = '{{ route('admin.settings.industry.apply') }}';
        var IND_CLEAR_URL = '{{ route('admin.settings.industry.clear') }}';

        function pickIndustry(key) {
            IND_SELECTED = key;
            document.getElementById('indConfirmTitle').textContent =
                '"' + key + '" ইন্ডাস্ট্রি প্রিসেট প্রয়োগ করতে চান?';
            document.getElementById('indConfirm').hidden = false;
            document.getElementById('indConfirm').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
        function cancelIndustry() {
            IND_SELECTED = null;
            document.getElementById('indConfirm').hidden = true;
        }
        function applyIndustry(mode) {
            if (!IND_SELECTED) return;
            var buttons = [document.getElementById('indApplyFull'), document.getElementById('indApplyVisual')];
            buttons.forEach(function (b) { b.disabled = true; });
            var fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('industry', IND_SELECTED);
            fd.append('mode', mode);
            fetch(IND_URL, { method: 'POST', headers: { 'Accept': 'application/json' }, body: fd })
                .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, json: j }; }); })
                .then(function (res) {
                    showToast(res.json.message || (res.ok ? 'প্রয়োগ হয়েছে' : 'ব্যর্থ'));
                    if (res.ok) setTimeout(function () { window.location.reload(); }, 800);
                    else buttons.forEach(function (b) { b.disabled = false; });
                })
                .catch(function () {
                    buttons.forEach(function (b) { b.disabled = false; });
                    showToast('নেটওয়ার্ক সমস্যা — আবার চেষ্টা করুন');
                });
        }
        function clearIndustry() {
            if (!confirm('ডিফল্ট আচারবাড়ি লুকে ফিরে যেতে হবে? (থিম হার্বাল গ্রিন হবে)')) return;
            var fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fetch(IND_CLEAR_URL, { method: 'POST', headers: { 'Accept': 'application/json' }, body: fd })
                .then(function (r) { return r.json(); })
                .then(function (j) { showToast(j.message); setTimeout(function () { window.location.reload(); }, 700); })
                .catch(function () { showToast('ব্যর্থ'); });
        }
JS;

if (strpos($s, 'industry-tile') !== false && strpos($s, 'applyIndustry(mode)') !== false) { echo "already fully present\n"; exit(0); }

$styleClose = strrpos($s, '</style>', strpos($s, '<style>'));
$s = substr_replace($s, $css . "\n    ", $styleClose, 0);

$pushPos = strrpos($s, '@endpush');
$insert = "\n    <script>\n" . $js . "\n    </script>\n";
$s = substr_replace($s, $insert, $pushPos, 0);

file_put_contents($f, $s);
echo "inserted\n";
