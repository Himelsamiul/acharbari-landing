{{-- Per-admin permission checkbox grid — $allPerms (key=>label), $selected (array of keys), optional $gridId --}}
@php
    $gridId = $gridId ?? 'perm-grid';
    $selected = $selected ?? [];
@endphp

<div class="perm-grid" id="{{ $gridId }}">
    @foreach ($allPerms as $key => $label)
        <label class="perm-item">
            <input type="checkbox" name="permissions[]" value="{{ $key }}" @checked(in_array($key, $selected))>
            <span>{{ $label }}</span>
        </label>
    @endforeach
</div>
