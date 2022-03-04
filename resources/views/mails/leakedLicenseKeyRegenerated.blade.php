@component('mail::message')
Hi,

we detected that a license key of your Spatie product has been leaked.

To prevent abuse, we've revoked the license key that we found [on this URL]({{ $foundOnUrl }}).

Note that you shouldn't post license keys on public available URLs.

In your spatie.be account, you'll find a new license key that you can use. Make sure that you keep this key private.

Take care,<br>
All of us at Spatie
@endcomponent
