@php
    $priceWithoutDiscount = $license->assignment->purchasable->getPriceWithoutDiscountForCurrentRequest();
    $price = $license->assignment->purchasable->getPriceForCurrentRequest();
@endphp

<div class="cells grid-cols-auto-1fr">
    <div class="cell-l">
        <div class="grid grid-flow-col gap-4 justify-start">
            @if ($license->assignment->purchasable->getting_started_url)
                <a class="link-blue link-underline" href="{{ $license->assignment->purchasable->getting_started_url }}">
                    Getting started
                </a>
            @endif

            @if ($license->assignment->purchasable->series->count())
                <a class="link-blue link-underline"
                   href="{{ route('series.show', $license->assignment->purchasable->series->first()) }}">
                    Videos
                </a>
            @endif

            @if ($license->assignment->purchasable->repository_access)
                @if ($license->hasRepositoryAccess())
                    <a class="link-blue link-underline"
                       href="https://github.com/{{ $license->assignment->purchasable->repository_access }}">
                        Repository
                    </a>
                @else
                    <a class="link-blue link-underline" href="{{ route('github-login') }}">
                        Connect to GitHub to access repo
                    </a>
                @endif
            @endif
        </div>

        <div class="mt-6">
            <h4 class="title-subtext">License key</h4>
            <div class="mt-4 text-xs text-gray">
                <code
                    class="break-all font-mono text-blue bg-blue-lightest bg-opacity-25 px-2 py-1 rounded-sm"
                >{{ $license->key }}<span class="pl-2 underline select-none cursor-pointer" onclick="copyLicense(this, '{{ $license->key }}')">copy</span></code>

                <div class="mt-2">
                @if (! $license->supportsActivations())
                    <livewire:domain :license="$license"/>
                @endif

                @if ($license->isExpired())
                    <span class="text-pink-dark">Expired since {{ $license->expires_at->format('Y-m-d') }}</span>
                @else
                    <span>Expires on {{ $license->expires_at->format('Y-m-d') }}</span>
                @endif
                </div>
            </div>

        </div>

        @if($license->supportsActivations())
            <div class="mt-6">
                <h4 class="title-subtext">Activations</h4>

                <livewire:activations :license="$license"/>
            </div>
        @endif
    </div>

    <span class="cell-r grid gap-4 justify-start md:justify-end">
        @if ($license->assignment->purchasable->renewalPurchasable)
            <a href="{{ route('products.buy', [$license->assignment->purchasable->product, $license->assignment->purchasable->renewalPurchasable, $license]) }}">
                <x-button>
                    @if ($license->isExpired())
                        Renew for
                    @else
                        Extend for
                    @endif
                    <span class="ml-1 text-lg leading-none">
                        {{ $price->formattedPrice() }}
                    </span>
                </x-button>
            </a>
        @endif
    </span>
</div>

<script type="text/javascript">
    function copyLicense(element, licenseKey) {
        navigator.clipboard.writeText(licenseKey)

        element.classList.add('text-green');
        element.innerText = 'copied!';

        setTimeout(() => {
            element.classList.remove('text-green');
            element.innerText = 'copy';
        }, 2000);
    }
</script>
