@push('head')
    @php($vendor = ['vendor' => (int) config('cashier.vendor_id')])
    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
@endpush

<x-page
        :title="$product->title"
        background="/backgrounds/product-blur.jpg"
>
    @includeFirst(["front.pages.products.buy.{$product->slug}", "front.pages.products.buy.default"])
</x-page>
