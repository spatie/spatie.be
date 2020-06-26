@php
    /** @var \App\Models\License $license */

    $payLink = auth()->user()->chargeProduct($license->purchasable->paddle_product_id)
@endphp

<div class="flex flex-row justify-between">
    <code class="font-mono">{{ $license->key }}</code>

    <div>Expires at {{ $license->expires_at->format('d/m/Y') }}</div>

    <x-paddle-button :url="$payLink" data-theme="none">
        Renew
    </x-paddle-button>

    <span class="text-lg leading-none">
        <span class="" data-id="current-currency-{{ $license->purchasable->id }}"></span>
        <span class="" data-id="current-price-{{ $license->purchasable->id }}"></span>
    </span>
</div>


<script type="text/javascript">
    function indexOfFirstDigitInString(string) {
        let firstDigit = string.match(/\d/);

        return string.indexOf(firstDigit);
    }

    Paddle.Product.Prices({{ $license->purchasable->paddle_product_id }}, function(prices) {
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
