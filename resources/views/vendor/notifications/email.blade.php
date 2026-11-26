<x-mail::message>
{{-- Sapaan --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
# Halo,
@endif

{{-- Isi --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Tombol aksi --}}
@isset($actionText)
<x-mail::button :url="$actionUrl" :color="$level === 'error' ? 'error' : 'primary'">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Penutup --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salam --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Salam,<br>
Bakorwil III Malang
@endif

{{-- Tautan cadangan bila tombol tidak dapat diklik --}}
@isset($actionText)
<x-slot:subcopy>
Jika tombol "{{ $actionText }}" tidak dapat diklik, salin dan tempel tautan berikut ke peramban (browser) Anda:
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
