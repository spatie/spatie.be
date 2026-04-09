@push('head')
    @paddleJS
@endpush

<x-page
    :title="$product->title"
    :description="Str::limit(strip_tags($product->long_description), 165)"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    <x-og-image view="og-image.product" :data="[
        'title' => $product->title,
    ]" />

    @include('layout.partials.bg-color')

    @includeFirst(["front.pages.products.detail.{$product->slug}", "front.pages.products.detail.default"])
</x-page>
