<div class="cells grid-cols-2">
    <div class="cell-l">
        <code class="font-mono text-blue bg-blue-lightest bg-opacity-25 px-2 py-1 rounded-sm">{{ $license->key }}</code>
        <div class="text-xs text-gray">
            @if ($license->domain)
                {{ $license->domain }}
                <span class="char-searator mx-1">•</span>
            @endif
            @if ($license->isExpired())
                <span class="text-pink-dark">Expired since {{ $license->expires_at->format('Y-m-d') }}</span>
            @else
                Expires at {{ $license->expires_at->format('Y-m-d') }}
            @endif
        </div>
    </div>

    <span  class="cell-r flex justify-end space-x-4">
        @if ($license->purchasable->renewalPurchasable)
            <x-paddle-button
                    :url="auth()->user()->getPayLinkForProductId($license->purchasable->renewalPurchasable->paddle_product_id)"
                    data-theme="none">
                <x-button>
                        Renew for
                        <span class="ml-1 text-lg leading-none">
                            <span class="" data-id="current-currency-{{ $license->purchasable->renewalPurchasable->id }}"></span>
                            <span class="" data-id="current-price-{{ $license->purchasable->renewalPurchasable->id }}"></span>
                        </span>
                    </x-button>
            </x-paddle-button>
        @endif

        @if ($license->purchasable->series->count())
            <a href="{{ route('series.show', $license->purchasable->series->first()) }}" class="cell-r flex justify-end space-x-4">
            <x-button>
                Watch videos
            </x-button>
        </a>
        @endif
    </span>
</div>


<script type="text/javascript">
    function indexOfFirstDigitInString(string) {
        let firstDigit = string.match(/\d/);

        return string.indexOf(firstDigit);
    }

    Paddle.Product.Prices({{ $license->purchasable->renewalPurchasable->paddle_product_id }}, function(prices) {
        console.log('license renewal', prices);
        let priceString = prices.price.net;

        let indexOFirstDigitInString = indexOfFirstDigitInString(priceString);

        let price = priceString.substring(indexOFirstDigitInString);
        price = price.replace('.00', '');

        let currencySymbol = priceString.substring(0,indexOFirstDigitInString);
        currencySymbol = currencySymbol.replace('US', '');

        document.querySelector('[data-id="current-currency-{{ $license->purchasable->id}}"]').innerHTML = currencySymbol;
        document.querySelector('[data-id="current-price-{{ $license->purchasable->id }}"]').innerHTML = price;
    });
</script>
