<div class="mb-8">
    <a class="link-underline link-black" href="{{ route('products.show', $product) }}">
        <h2 class="title-sm">{{ $product->title }}</h2>
    </a>

    @foreach($purchasesForProduct as $purchase)
        @php
            /** @var \App\Models\Purchasable $purchasable */
            $purchasable = $purchase->purchasable;
        @endphp

        <div class="cells grid-cols-2">
            <div class="cell-l">
                <a href="{{ route('products.show', $product) }}">
                    {{ $purchasable->title }}
                </a>
                <div class="text-xs text-gray">
                    vanbockstal.be
                    <span class="char-searator mx-1">•</span>
                    Valid until 03/09/2020
                    <span class="text-pink-dark">Expired since 03/09/2020</span>
                </div>
            </div>

            <span  class="cell-r flex justify-end">
                @include('front.pages.products.partials.purchaseActions')
            </span>
        </div>
    @endforeach
</div>
