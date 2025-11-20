@push('head')
    @paddleJS
@endpush

<x-page
        :title="$product->title"
        :description="Str::limit(strip_tags($product->long_description), 165)"
        :background="'/backgrounds/product-blur.jpg'"
        :og-image="url($product->getFirstMediaUrl('product-image')) ?: asset('/images/og-image.jpg')"
>
    @includeFirst(["front.pages.products.detail.{$product->slug}", "front.pages.products.detail.default"])
</x-page>
