@props(['icon', 'label', 'value', 'unit' => null, 'href' => null, 'tone' => null])

@php($tag = $href ? 'a' : 'div')
<{{ $tag }} @if ($href) href="{{ $href }}" @endif {{ $attributes->class(['card', 'stat']) }}>
    <span @class(['ico', $tone])><i class="bi bi-{{ $icon }}"></i></span>
    <span>
        <span class="label">{{ $label }}</span>
        <div class="value">{{ $value }}</div>
        @if ($unit)
            <span class="unit">{{ $unit }}</span>
        @endif
    </span>
    @if ($href)
        <i class="bi bi-chevron-right go"></i>
    @endif
</{{ $tag }}>
