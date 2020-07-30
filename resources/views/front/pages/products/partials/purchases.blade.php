<h2 class="title line-after mb-12">Your purchases</h2>

<ul class="grid gap-6">
    @foreach ($purchasesPerProduct as $productId => $purchasesForProduct)
        @php
            /** @var \App\Models\Product $product */
            $product = $purchasesForProduct->first()->purchasable->product;
        @endphp
        <li>
            @include('front.pages.products.partials.productPurchases')
        </li>
    @endforeach
</ul>
