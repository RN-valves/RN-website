@component('mail::message')

Hello! <b class="text-dark">{{ $user->name??'' }}</b>

<p>Please click the button below to verify your email address.</p>

<p>
@component('mail::button', ['url'=>url('activate/'.base64_encode($user->id))])
Verify Email Address
@endcomponent
</p>

<p>If you did not create an account, no further action is required.</p>
<p>Regards,</p>
<p>RN Valves & Faucets</p>

@endcomponent