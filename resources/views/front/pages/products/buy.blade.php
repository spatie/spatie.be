@push('head')
    @paddleJS
@endpush

<x-page
    :title="$product->title"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    @include('layout.partials.bg-color')

    @includeFirst(["front.pages.products.buy.{$product->slug}", "front.pages.products.buy.default"])
</x-page>
