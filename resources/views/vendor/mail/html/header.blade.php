@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
{{-- @if (trim($slot) === 'Laravel') --}}
<img src="{{ asset('images/logo-solidocs-mail.png') }}" class="logo" alt="SolidoCS Logo">
{{-- @else
{{ $slot }}
@endif --}}
</a>
</td>
</tr>
