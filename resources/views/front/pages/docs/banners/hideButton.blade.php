
@php
    use Carbon\Carbon;
@endphp

<button class="absolute top-0 right-0 mr-2 opacity-50" 
onClick="document.cookie = 'banner=hidden; expires={{ Carbon::now()->addWeek(1)->toCookieString() }}; path=/; ';this.parentElement.remove();">&times;</button>
