@props(['url'])
{{-- Kepala email: logo Bakorwil III Malang (URL publik agar tampil di semua klien email) --}}
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;" target="_blank" rel="noopener">
<img src="{{ config('mail.logo_url') }}" class="logo" width="240" alt="Bakorwil III Malang · Provinsi Jawa Timur" style="width:240px;max-width:100%;height:auto;border:0;">
</a>
</td>
</tr>
