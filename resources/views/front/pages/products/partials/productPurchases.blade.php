<div class="mb-8">

        <div class="flex items-baseline space-x-4">
            <h2 class="title-sm mb-0">
                {{ $product->title }}     
            </h2>

            <a href="{{ route('products.show', $product) }}#purchases"
            class="link-blue link-underline">
                Manage 
                {{ \Illuminate\Support\Str::plural('purchase', $purchasesForProduct->count()) }}
            </a>

            <span class="mx-2 text-gray-light">|</span>
            <a href=""
            class="link-blue link-underline">
                Watch course
            </a>
        </div>


    @foreach($purchasesForProduct as $purchase)
        @php
            /** @var \App\Models\Purchasable $purchasable */
            $purchasable = $purchase->purchasable;
        @endphp

        <div class="cells grid-cols-2">
            <div class="cell-l">
                <a class="link-black link-underline" href="{{ route('products.show', $product) }}#purchases">
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
                {{-- @include('front.pages.products.partials.purchaseActions') --}}
            </span>
        </div>
    @endforeach
</div>
