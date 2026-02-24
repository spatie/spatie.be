@push('head')
    @paddleJS
@endpush

<x-page
        :title="$product->title"
        :description="Str::limit(strip_tags($product->long_description), 165)"
        :background="'/backgrounds/product-blur.jpg'"
>
    <x-og-image view="og-image.product" :data="[
        'title' => $product->title,
        'description' => strip_tags($product->long_description ?? $product->description),
    ]" />
    @includeFirst(["front.pages.products.detail.{$product->slug}", "front.pages.products.detail.default"])
</x-page>
