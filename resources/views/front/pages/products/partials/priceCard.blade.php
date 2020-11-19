<div class="{{ $first? 'mb-12 py-6 md:-mt-8 md:py-10 md:z-10' : 'mb-8 py-6' }} md:mb-0 md:mx-2 max-w-md flex flex-col bg-white shadow-lg px-8" 
    style="bottom: {{ $first? '-2rem' : '-1rem' }}">
    <h2 class="flex-0 flex items-center font-bold {{ $first? 'text-2xl' : 'text-lg'}} mb-4 min-h-10">
        {{ $purchasable->title }}
    </h2>
    
    <div class="flex-grow markup markup-lists markup-lists-compact text-xs">
        {!! $purchasable->formattedDescription !!}
    </div>

    @if ($product->hasActiveCoupon())
        <div class="-mx-6 px-2 py-3 bg-green-lightest mt-4 text-black text-sm text-center">
            Use <code class="px-1 font-semibold">{{ $product->coupon_code }}</code>
            <br>to get <span class="font-semibold">{{ $product->coupon_percentage }}%</span> off during checkout
        
            <div
                class="mt-1 text-green-dark text-xs"
                style="font-variant-numeric:tabular-nums">
                <x-countdown :expires="$product->coupon_expires_at">
                    <span class="font-semibold"><span
                            x-text="timer.days">{{ $component->days() }}</span> <span class="font-normal">days</span></span>
                    <span class="font-semibold"><span
                            x-text="timer.hours">{{ $component->hours() }}</span> <span class="font-normal">hours</span></span>
                    <span class="font-semibold"><span
                            x-text="timer.minutes">{{ $component->minutes() }}</span> <span class="font-normal">minutes</span></span>
                    <span class="font-semibold"><span
                            x-text="timer.seconds">{{ $component->seconds() }}</span> <span class="font-normal">seconds</span></span>
                </x-countdown>
            </div>
        
        </div>
    @endif


    <div class="flex-0 mt-6 flex justify-center">
        <div>
        <span data-id="original-display-{{ $purchasable->paddle_product_id }}" style="top:50%; transform: translateY(-50%)" class="hidden absolute right-full mr-2">
            <sup class="text-xs" data-id="original-currency-{{ $purchasable->paddle_product_id }}"></sup><span
                class="font-semibold line-through" data-id="original-price-{{ $purchasable->paddle_product_id }}">—</span>
        </span>
        @auth
            <x-paddle-button :url="auth()->user()->getPayLinkForProductId($purchasable->paddle_product_id)" data-theme="none">
                <x-button :large="true">
                    <span class="font-normal">Buy for&nbsp;</span>
                    <span class="font-normal" data-id="current-currency-{{ $purchasable->paddle_product_id }}"></span>
                    <span data-id="current-price-{{ $purchasable->paddle_product_id }}"></span>
                </x-button>
            </x-paddle-button>
        @else
            <a href="{{ route('login') }}?next={{ url()->current() }}">
                <x-button :large="true">
                    <span class="font-normal">Buy for&nbsp;</span>
                    <span class="font-normal" data-id="current-currency-{{ $purchasable->paddle_product_id }}"></span>
                    <span data-id="current-price-{{ $purchasable->paddle_product_id }}"></span>
                </x-button>
            </a>
        @endauth
        </div>
    </div>
</div>

<script type="text/javascript">
    function indexOfFirstDigitInString(string) {
        let firstDigit = string.match(/\d/);

        return string.indexOf(firstDigit);
    }

    function displayPaddleProductPrice(productId) {
        Paddle.Product.Prices(productId, function(prices) {
            let priceString = prices.price.net;

            let factor = {{ $product->hasActiveCoupon() ? (100 - $product->coupon_percentage)/100 : 1 }};

            let indexOFirstDigitInString = indexOfFirstDigitInString(priceString);

            let price = priceString.substring(indexOFirstDigitInString);
            price = price.replace('.00', '').replace(/,/g, '');

            let currencySymbol = priceString.substring(0, indexOFirstDigitInString);
            currencySymbol = currencySymbol.replace('US', '');

            document.querySelector(`[data-id="original-currency-${productId}"]`).innerHTML = currencySymbol;
            document.querySelector(`[data-id="original-price-${productId}"]`).innerHTML = price;

            document.querySelector(`[data-id="current-currency-${productId}"]`).innerHTML = currencySymbol;
            document.querySelector(`[data-id="current-price-${productId}"]`).innerHTML = Math.ceil(price * factor);
            
            if(factor < 1) {
                document.querySelector(`[data-id="original-display-${productId}"]`).classList.remove('hidden');
            }
        });
    }

    displayPaddleProductPrice({{ $purchasable->paddle_product_id }});

</script>

<script src="/alpine/alpine.js" defer></script>
