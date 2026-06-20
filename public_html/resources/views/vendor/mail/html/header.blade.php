@props(['url'])
<tr>
<td class="header">
<a href="{{ url('/') }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ url('users/images/logoc.png') }}" class="web_logo" alt="RN Valves & Faucets - Logo" style="width:100px">
@else
<img src="{{ url('users/images/logoc.png') }}" class="web_logo" alt="RN Valves & Faucets - Logo" style="width:100px">
@endif
</a>
</td>
</tr>
