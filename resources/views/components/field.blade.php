{{-- Satu isian form lengkap: label, input, petunjuk, dan pesan error --}}
@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'hint' => null,
    'suffix' => null,
    'icon' => null,
])

@php($invalid = $errors->has($name))
<div {{ $attributes->only('class')->class(['field']) }}>
    <label for="f-{{ $name }}">{{ $label }}@if ($required)<span class="req">*</span>@endif</label>

    @if ($type === 'textarea')
        <textarea id="f-{{ $name }}" name="{{ $name }}" @class(['textarea', 'is-invalid' => $invalid])
            {{ $attributes->except('class') }} @required($required)>{{ old($name, $value) }}</textarea>
    @elseif ($type === 'select')
        <select id="f-{{ $name }}" name="{{ $name }}" @class(['select', 'is-invalid' => $invalid])
            {{ $attributes->except('class') }} @required($required)>{{ $slot }}</select>
    @else
        <div class="input-group">
            @if ($icon)<i class="bi bi-{{ $icon }} lead"></i>@endif
            <input id="f-{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
                @class(['input', 'is-invalid' => $invalid, 'has-trail' => $suffix || $type === 'password'])
                {{ $attributes->except('class') }} @required($required)>
            @if ($type === 'password')
                <button type="button" class="trail" data-toggle-password>Lihat</button>
            @elseif ($suffix)
                <span class="trail">{{ $suffix }}</span>
            @endif
        </div>
    @endif

    @if ($invalid)
        <div class="error"><i class="bi bi-exclamation-circle"></i>{{ $errors->first($name) }}</div>
    @elseif ($hint)
        <div class="hint">{{ $hint }}</div>
    @endif
</div>
