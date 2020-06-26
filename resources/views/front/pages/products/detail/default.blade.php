<div class="wrap">
    <x-slot name="description">
        {{ $product->description }}
    </x-slot>

    <h1>{{ $product->title }}</h1>
    <div>{{ $product->description }}</div>

    <div class="wrap">
        @include('front.pages.products.partials.productPurchases', ['purchasesForProduct' => $purchases])

        @if ($licenses->count())
            <h2 class="text-2xl">My licenses</h2>
        @endif
        @foreach ($licenses->groupBy('purchasable.title') as $purchasableTitle => $licensesPerPurchasable)
            <div>
                <h3 class="text-xl">{{ $purchasableTitle }}</h3>
                @foreach ($licensesPerPurchasable as $license)
                    <div>
                        <code class="font-mono">{{ $license->key }}</code>
                        <button class="bg-grey-lighter p-2">Renew</button>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    @foreach($product->purchasables as $purchasable)
        @include('front.pages.products.partials.priceCard')
    @endforeach
</div>
