@push('head')
    @php($vendor = ['vendor' => (int) config('cashier.vendor_id')])
    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
@endpush

<x-page
        :title="$bundle->title"
        background="/backgrounds/product-blur.jpg"
>
    @includeFirst(["front.pages.bundles.buy.{$bundle->slug}", "front.pages.bundles.buy.default"])
</x-page>
