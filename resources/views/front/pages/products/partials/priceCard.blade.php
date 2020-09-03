<div class="{{ $first? 'mb-12 py-6 md:-mt-8 md:py-10 md:z-10' : 'mb-8 py-6' }} md:mb-0 md:mx-2 max-w-md flex flex-col bg-white shadow-lg px-8" 
    style="bottom: {{ $first? '-2rem' : '-1rem' }}">
    <h2 class="flex-0 flex items-center font-bold {{ $first? 'text-2xl' : 'text-lg'}} mb-4 min-h-10">
        {{ $purchasable->title }}
    </h2>
    
    <div class="flex-grow markup markup-lists markup-lists-compact text-xs">
        {!! $purchasable->formattedDescription !!}
    </div>

    <div class="flex-0 mt-6 flex justify-center">
        @auth
            <x-paddle-button :url="auth()->user()->getPayLinkForProductId($purchasable->paddle_product_id)" data-theme="none">
                <x-button>
                    <span class="font-normal">Buy for&nbsp;</span>
                    <span data-id="current-currency-{{ $purchasable->id }}"></span>
                    <span data-id="current-price-{{ $purchasable->id }}"></span>
                </x-button>
            </x-paddle-button>
        @else
            <a href="{{ route('login') }}">
                <x-button>
                    <span class="font-normal">Buy for&nbsp;</span>
                    <span data-id="current-currency-{{ $purchasable->id }}"></span>
                    <span data-id="current-price-{{ $purchasable->id }}"></span>
                </x-button>
            </a>
        @endauth
    </div>

    <div class="flex-0 text-xs text-gray-light mt-6">
        Prices exclusive of VAT <br>for buyers without a valid VAT number
    </div>
</div>

<script type="text/javascript">
    function indexOfFirstDigitInString(string) {
        let firstDigit = string.match(/\d/);

        return string.indexOf(firstDigit);
    }

    Paddle.Product.Prices({{ $purchasable->paddle_product_id }}, function(prices) {
        let priceString = prices.price.net;
        let indexOFirstDigitInString = indexOfFirstDigitInString(priceString);
        let price = priceString.substring(indexOFirstDigitInString);
        price = price.replace('.00', '');

        let currencySymbol = priceString.substring(0,indexOFirstDigitInString);
        currencySymbol = currencySymbol.replace('US', '');

        document.querySelectorAll('[data-id="current-currency-{{ $purchasable->id}}"]').forEach((element) => {
            element.innerHTML = currencySymbol;
        });
        document.querySelectorAll('[data-id="current-price-{{ $purchasable->id }}"]').forEach((element) => {
            element.innerHTML = price;
        });
    });
</script>
