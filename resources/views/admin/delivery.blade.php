@extends('layouts.admin')

@section('title', 'ডেলিভারি এরিয়া')
@section('page_title', 'ডেলিভারি এরিয়া')
@section('page_sub', 'কোন কোন জেলায় ডেলিভারি হবে আর চার্জ কত — সব আপনি ঠিক করুন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-truck-fast"></i>
        <span>যেই জেলার পাশের বক্সে টিক দেবেন, <b>শুধু সেই জেলাগুলোতে</b> ডেলিভারি চালু থাকবে — কাস্টমার অর্ডার ফর্মে শুধু ওই জেলাগুলোই দেখতে পাবে। টিক না থাকা জেলার কাস্টমার অর্ডার করতে পারবে না। চার্জ ০ দিলে ওই জেলায় ফ্রি ডেলিভারি।</span>
    </div>

    <div class="card" style="max-width:820px">
        <h3><i class="fa-solid fa-map-location-dot"></i> জেলা-ভিত্তিক ডেলিভারি চার্জ</h3>
        <p class="desc">চেকবক্স = ডেলিভারি চালু, ঘরের সংখ্যা = ডেলিভারি চার্জ (৳)</p>

        <form method="POST" action="{{ route('admin.settings.delivery.save') }}" id="deliveryForm">
            @csrf
            <input type="text" class="a-input" id="districtSearch" placeholder="🔍 জেলা খুঁজুন…" style="max-width:280px;margin-bottom:12px">

            <div style="max-height:460px;overflow-y:auto;border:1px solid #e5e7eb;border-radius:10px">
                <table style="width:100%;border-collapse:collapse;font-size:14px">
                    <thead style="position:sticky;top:0;background:#f9fafb;z-index:1">
                        <tr style="text-align:left;color:#374151">
                            <th style="padding:10px 14px;border-bottom:1px solid #e5e7eb">চালু</th>
                            <th style="padding:10px 14px;border-bottom:1px solid #e5e7eb">জেলা</th>
                            <th style="padding:10px 14px;border-bottom:1px solid #e5e7eb">চার্জ (৳)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allDistricts as $i => $d)
                            @php($configured = collect($districts)->first(fn ($c) => strcasecmp($c['en'], $d['en']) === 0))
                            <tr class="district-row" data-name="{{ $d['en'] }} {{ $d['bn'] }}" style="border-bottom:1px solid #f3f4f6">
                                <td style="padding:8px 14px">
                                    <input type="checkbox" class="district-check accent-emerald-600"
                                           data-row="{{ $i }}" {{ $configured ? 'checked' : '' }}>
                                </td>
                                <td style="padding:8px 14px">
                                    <b>{{ $d['bn'] }}</b> <span style="color:#9ca3af">{{ $d['en'] }}</span>
                                </td>
                                <td style="padding:8px 14px">
                                    <input type="number" class="a-input district-charge" data-row="{{ $i }}"
                                           min="0" max="5000" style="width:110px;padding:6px 10px"
                                           value="{{ $configured['charge'] ?? 150 }}"
                                           {{ $configured ? '' : 'disabled' }}>
                                    <!-- real submitted fields, filled from the row above -->
                                    <input type="hidden" name="districts[{{ $i }}][en]" class="district-en" data-row="{{ $i }}" value="{{ $d['en'] }}" disabled>
                                    <input type="hidden" name="districts[{{ $i }}][charge]" class="district-charge-field" data-row="{{ $i }}" disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @error('districts')
                <p style="color:#dc2626;font-size:13px;margin-top:10px">{{ $message }}</p>
            @enderror

            <div style="display:flex;gap:10px;margin-top:14px;flex-wrap:wrap">
                <button class="a-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> সেভ করুন</button>
                <span style="align-self:center;color:#6b7280;font-size:13px">চালু আছে: <b id="districtCount">{{ count($districts) }}</b> টি জেলা</span>
            </div>
        </form>
    </div>

    <script>
        // enable/disable a district row
        document.querySelectorAll('.district-check').forEach(function (cb) {
            cb.addEventListener('change', function () {
                var row = cb.getAttribute('data-row');
                document.querySelector('.district-charge[data-row="' + row + '"]').disabled = !cb.checked;
                updateCount();
            });
        });

        // before submit: disable unchecked rows, mirror charges into submitted fields
        document.getElementById('deliveryForm').addEventListener('submit', function () {
            document.querySelectorAll('.district-check').forEach(function (cb) {
                var row = cb.getAttribute('data-row');
                var on = cb.checked;
                document.querySelector('.district-en[data-row="' + row + '"]').disabled = !on;
                var chargeField = document.querySelector('.district-charge-field[data-row="' + row + '"]');
                chargeField.disabled = !on;
                if (on) {
                    chargeField.value = document.querySelector('.district-charge[data-row="' + row + '"]').value || 0;
                }
            });
        });

        function updateCount() {
            document.getElementById('districtCount').textContent =
                document.querySelectorAll('.district-check:checked').length;
        }

        // simple search filter
        document.getElementById('districtSearch').addEventListener('input', function () {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll('.district-row').forEach(function (tr) {
                tr.style.display = tr.getAttribute('data-name').toLowerCase().indexOf(q) !== -1 ? '' : 'none';
            });
        });
    </script>
@endsection
