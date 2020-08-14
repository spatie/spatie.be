@auth
    @php($payLink = auth()->user()->chargeProduct($purchasable->paddle_product_id))
@endauth

<div class="bg-white shadow-lg px-8 py-6">
    <h2 class="title-sm mb-6">{{ $purchasable->title }}</h2>
    
    <div class="markup-lists markup-lists-compact text-xs">
        <ul>
            <li>Is valid for one domain or subdomain</li>
            <li>Includes the package, app and videos</li>
            <li>Includes 1 year of updates and access to our private repository</li>
            <li>Is renewable if you want to stay on the latest release</li>
        </ul>
    </div>

    <div class="mt-6 flex justify-center">
        @auth
            <x-paddle-button :url="$payLink" data-theme="none">
                <span>Buy for&nbsp;</span>
                <span class="leading-none">
                    <span class="" data-id="current-currency-{{ $purchasable->id }}"></span>
                    <span class="" data-id="current-price-{{ $purchasable->id }}"></span>
                </span>
            </x-paddle-button>
        @else
            <a href="{{ route('login') }}">
                <x-button>
                    <span>Buy for&nbsp;</span>
                    <span class="leading-none">
                        <span class="" data-id="current-currency-{{ $purchasable->id }}"></span>
                        <span class="" data-id="current-price-{{ $purchasable->id }}"></span>
                    </span>
                </x-button>
            </a>
        @endauth
    </div>
</div>

<script type="text/javascript">
    function indexOfFirstDigitInString(string) {
        let firstDigit = string.match(/\d/);

        return string.indexOf(firstDigit);
    }

    Paddle.Product.Prices({{ $purchasable->paddle_product_id }}, function(prices) {
        console.log(prices);
        let priceString = prices.price.net;

        let indexOFirstDigitInString = indexOfFirstDigitInString(priceString);

        let price = priceString.substring(indexOFirstDigitInString);
        price = price.replace('.00', '');

        let currencySymbol = priceString.substring(0,indexOFirstDigitInString);
        currencySymbol = currencySymbol.replace('US', '');

        document.querySelector('[data-id="current-currency-{{ $purchasable->id}}"]').innerHTML = currencySymbol;
        document.querySelector('[data-id="current-price-{{ $purchasable->id }}"]').innerHTML = price;
    });
</script>
