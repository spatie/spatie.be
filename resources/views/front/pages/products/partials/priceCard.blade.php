@php
    $priceWithoutDiscount = $purchasable->getPriceWithoutDiscountForCurrentRequest();
    $price = $purchasable->getPriceForCurrentRequest()
@endphp
<div
    class="{{ $first? 'mb-12 py-6 md:-mt-8 md:py-10 md:z-10' : 'mb-8 py-6' }} md:mb-0 md:mx-2 max-w-md flex flex-col bg-white shadow-lg px-8"
    style="bottom: {{ $first? '-2rem' : '-1rem' }}">
    <h2 class="flex-0 flex items-center font-bold {{ $first? 'text-2xl' : 'text-lg'}} mb-4 min-h-10">
        {{ $purchasable->title }}
    </h2>

    <div class="flex-grow markup markup-lists markup-lists-compact text-xs">
        {!! $purchasable->formattedDescription !!}
    </div>

    @if ($purchasable->hasActiveDiscount())
        <div class="-mx-6 px-2 py-3 bg-green-lightest mt-4 text-black text-sm text-center">
            <div>{{ $purchasable->discount_name }}</div>
            Now <span class="font-semibold">{{ $purchasable->discount_percentage }}%</span> off

            <div
                class="mt-1 text-green-dark text-xs"
                style="font-variant-numeric:tabular-nums">
                <x-countdown :expires="$purchasable->discount_expires_at">
                    <span><span
                            x-text="timer.days" class="font-mono font-semibold">{{ $component->days() }}</span> <span>days</span></span>
                    <span><span
                            x-text="timer.hours" class="font-mono font-semibold">{{ $component->hours() }}</span> <span>hours</span></span>
                    <span><span
                            x-text="timer.minutes"
                            class="font-mono font-semibold">{{ $component->minutes() }}</span> <span>minutes</span></span>
                    <span><span
                            x-text="timer.seconds"
                            class="font-mono font-semibold">{{ $component->seconds() }}</span> <span>seconds</span></span>
                </x-countdown>
            </div>

        </div>
    @endif

    <div class="flex-0 mt-6 flex justify-center">
        <div>
            @if($purchasable->hasActiveDiscount())
                <span style="top:50%; transform: translateY(-50%)" class="absolute right-full mr-2">
            <span
                class="font-semibold line-through">{{ $priceWithoutDiscount->formattedPrice() }}</span>
        </span>
            @endif
            @auth
                <x-paddle-button :url="auth()->user()->getPayLinkForProductId($purchasable->paddle_product_id)"
                                 data-theme="none">
                    <x-button :large="true">
                        <span class="font-normal">Buy for&nbsp;</span>
                        <span>{{ $price->formattedPrice() }}</span>
                    </x-button>
                </x-paddle-button>
            @else
                <a href="{{ route('login') }}?next={{ url()->current() }}">
                    <x-button :large="true">
                        <span class="font-normal">Buy for&nbsp;</span>
                        <span>{{ $price->formattedPrice() }}</span>
                    </x-button>
                </a>
            @endauth
        </div>
    </div>
</div>
