<div class="my-8">
    @auth
        @php($payLink = auth()->user()->chargeProduct($purchasable->paddle_product_id))

        <section id="cta" class="section">
            <div class="wrap">
                <div class="inset-green">
                    <div class="wrap-inset md:items-end" style="--cols: 1fr 2fr">
                        <div class="links-underline links-white">
                            <p class="text-2xl">
                                {{ $purchasable->title }}
                            </p>
                        </div>
                        <h2 class="title-xl | grid-text-right">
                            <x-paddle-button :url="$payLink" data-theme="none">
                                Buy
                            </x-paddle-button>
                            <span class="text-lg leading-none">
                                <span class="" data-id="current-currency"></span>
                                <span class="" data-id="current-price"></span>
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="wrap">
            <div class="inset-green">
                <div class="wrap-inset md:items-end" style="--cols: 1fr 2fr">
                    <div class="links-underline links-white">
                        <p class="text-2xl">
                            Please log in to purchase {{ $purchasable->title }}
                        </p>
                    </div>
                    <h2 class="title-xl | grid-text-right">
                        <a href="{{ route('login') }}">Log in</a>
                    </h2>
                </div>
            </div>
        </div>
    @endauth
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

        document.querySelector('[data-id="current-currency"]').innerHTML = currencySymbol;
        document.querySelector('[data-id="current-price"]').innerHTML = price;
    });
</script>
