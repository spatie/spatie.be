@push('head')
    @paddleJS
@endpush

<x-page
        :title="$product->title"
        background="/backgrounds/home.jpg"
>
    @include('front.pages.products.partials.productPurchases', ['purchasesForProduct' => $purchases])

    @foreach ($licenses as $license)
        <div>
            <span>{{ $license->purchasable->title }}</span>
            <code class="font-mono">{{ $license->key }}</code>
            <button class="bg-grey-lighter p-2">Renew</button>
        </div>
    @endforeach

    @includeFirst(["front.pages.products.detail.{$product->slug}", "front.pages.products.detail.default"])
</x-page>
