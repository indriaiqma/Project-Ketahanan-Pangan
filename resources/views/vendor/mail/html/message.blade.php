<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
**Badan Koordinasi Wilayah (Bakorwil) III Malang**<br>
Pemerintah Provinsi Jawa Timur<br>
Sistem Informasi Ketahanan Pangan Malang Selatan

Email ini dikirim otomatis oleh sistem, mohon tidak membalas email ini.<br>
© {{ date('Y') }} Bakorwil III Malang
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
