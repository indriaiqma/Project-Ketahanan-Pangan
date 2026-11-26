<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }} - Bakorwil III Malang
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
Bakorwil III Malang - Pemerintah Provinsi Jawa Timur
Email ini dikirim otomatis oleh sistem, mohon tidak membalas.
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
