@if(request('newsletter') === 'subscribed')
    <div class="leading-snug">
        <h2 class="font-semibold text-oss-green-pale">Thank you for subscribing!</h2>
        <p class="text-oss-gray-light text-base">You'll receive a confirmation email shortly.</p>
    </div>
@else
    <form class="w-full space-y-2.5 text-base" action="{{ route('newsletter.subscribe') }}" method="POST">
        <div class="flex-1">
            <input
                class="bg-white/[0.07] w-full border border-white/10 px-4 py-3 placeholder-oss-gray-dark rounded-lg transition focus:border-oss-green-pale/25 focus:outline-none"
                name="email"
                type="email"
                placeholder="Email address"
                autocomplete="email"
                required
            >

            @if(request('newsletter') === 'invalid-email')
                <p class="mt-1 text-oss-red text-xs">Please enter a valid email address.</p>
            @endif
        </div>

        <button class="bg-oss-green-pale w-full px-4 py-3 text-center text-oss-gray-extra-dark rounded-lg transition hover:opacity-90" type="submit">
            <span class="font-bold">Subscribe</span>
        </button>
    </form>
@endif
