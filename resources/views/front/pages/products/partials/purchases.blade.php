<div class="section section-group wrap">
    <h2>Purchases</h2>

    <div>
        @foreach ($purchasesPerProduct as $productId => $purchasesForProduct)
            @php
                /** @var \App\Models\Product $product */
                $product = $purchasesForProduct->first()->purchasable->product;
            @endphp

            @include('front.pages.products.partials.productPurchases')
        @endforeach
    </div>
</div>
