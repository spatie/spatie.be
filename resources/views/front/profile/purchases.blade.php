<x-page
        title="Purchases"
        background="/backgrounds/auth.jpg"
>
    @include('front.profile.partials.subnav')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Purchases
            </h1>
            @forelse ($purchasesPerProduct as $purchase)
            @empty
                <p class="banner-intro">No purchases yet, take a look at <a class="link-underline link-blue" href="{{ route('products.index') }}">our products</a>.</p>
            @endforelse
        </div>
    </section>

    <section class="section section-group pt-0">
        <div class="wrap">
                <ul class="grid gap-6">
                    @foreach ($purchasesPerProduct as $productId => $purchasesForProduct)
                        @php
                            /** @var \App\Models\Product $product */
                            $product = $purchasesForProduct->first()['product'];
                        @endphp
                        <li>
                            @include('front.pages.products.partials.productPurchases')
                        </li>
                    @endforeach
                </ul>
        </div>
    </section>
</x-page>
