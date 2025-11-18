@push('head')
    @paddleJS
@endpush

<x-page
        :title="$product->title"
        :description="$product->description"
        :background="$product->getFirstMediaUrl('product-image') ?? '/backgrounds/product-blur.jpg'"
>
    @includeFirst(["front.pages.products.detail.{$product->slug}", "front.pages.products.detail.default"])
</x-page>
