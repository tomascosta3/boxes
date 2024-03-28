@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
{{-- @if (trim($slot) === 'Laravel') --}}
<img src="http://solidocs.com.ar/wp-content/uploads/2022/11/logo-solidocs.svg" class="logo" alt="SolidoCS Logo">
{{-- @else
{{ $slot }}
@endif --}}
</a>
</td>
</tr>
