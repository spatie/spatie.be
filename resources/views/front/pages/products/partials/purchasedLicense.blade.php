<div class="cells grid-cols-auto-1fr">
    <div class="cell-l">
        <div class="grid grid-flow-col gap-4 justify-start">
            @if ($license->purchasable->getting_started_url)
                <a class="link-blue link-underline" href="{{ $license->purchasable->getting_started_url }}">
                    Getting started
                </a>
            @endif

            @if ($license->purchasable->series->count())
                <a class="link-blue link-underline"
                   href="{{ route('series.show', $license->purchasable->series->first()) }}">
                    Videos
                </a>
            @endif

            @if ($license->purchasable->repository_access)
                @if ($license->hasRepositoryAccess())
                    <a class="link-blue link-underline"
                       href="https://github.com/{{ $license->purchasable->repository_access }}">
                        Repository
                    </a>
                @else
                    <a class="link-blue link-underline" href="{{ route('github-login') }}">
                        Connect to GitHub to access repo
                    </a>
                @endif
            @endif
        </div>

        <div class="mt-2">
            <div class="flex items-center text-xs text-gray">
                <span>License key</span>
                <span class="char-separator mx-2">•</span>

                @if (! $license->supportsActivations())
                <livewire:domain :license="$license"/>
                @endif

                @if ($license->isExpired())
                    <span class="text-pink-dark">Expired since {{ $license->expires_at->format('Y-m-d') }}</span>
                @else
                    <span>Expires on {{ $license->expires_at->format('Y-m-d') }}</span>
                @endif
            </div>

            <code
                class="break-all font-mono text-blue bg-blue-lightest bg-opacity-25 px-2 py-1 rounded-sm">{{ $license->key }}</code>
        </div>

        @if($license->supportsActivations())
            <div class="mt-2">
                <div class="items-center text-xs text-gray">
                    <div>Activations</div>

                    <livewire:activations :license="$license"/>
                </div>
            </div>
        @endif


    </div>

    <span class="cell-r grid gap-4 justify-start md:justify-end">
        @if ($license->purchasable->renewalPurchasable)
            <x-paddle-button
                :url="auth()->user()->getPayLinkForProductId($license->purchasable->renewalPurchasable->paddle_product_id)"
                data-theme="none">
            <x-button>
                Renew for
                <span class="ml-1 text-lg leading-none">
                    <span class="" data-id="current-currency-{{ $license->id }}"></span>
                    <span class="" data-id="current-price-{{ $license->id }}"></span>
                </span>
            </x-button>
        </x-paddle-button>
        @endif


    </span>
</div>


<script type="text/javascript">
    function indexOfFirstDigitInString(string) {
        let firstDigit = string.match(/\d/);

        return string.indexOf(firstDigit);
    }

    Paddle.Product.Prices(
        {{
            $license->purchasable->renewalPurchasable->paddle_product_id
        }}, function (prices) {
            console.log('license renewal', prices);
            let priceString = prices.price.net;

            let indexOFirstDigitInString = indexOfFirstDigitInString(priceString);

            let price = priceString.substring(indexOFirstDigitInString);
            price = price.replace('.00', '');

            let currencySymbol = priceString.substring(0, indexOFirstDigitInString);
            currencySymbol = currencySymbol.replace('US', '');

            document.querySelector('[data-id="current-currency-{{ $license->id}}"]').innerHTML = currencySymbol;
            document.querySelector('[data-id="current-price-{{ $license->id }}"]').innerHTML = price;
        });

</script>
