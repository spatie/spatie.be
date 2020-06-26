@push('head')
    @paddleJS
@endpush

<x-page
        :title="$product->title"
        background="/backgrounds/home.jpg"
>
    @include('front.pages.products.partials.productPurchases', ['purchasesForProduct' => $purchases])

    @includeFirst(["front.pages.products.detail.{$product->slug}", "front.pages.products.detail.default"])
</x-page>
