
@php
    use Carbon\Carbon;
@endphp

<button class="absolute text-2xl top-0 right-0 mr-5 mt-5"
onClick="document.cookie = 'banner=hidden; expires={{ Carbon::now()->addWeek(1)->toCookieString() }}; path=/; ';this.parentElement.remove();">&times;</button>
