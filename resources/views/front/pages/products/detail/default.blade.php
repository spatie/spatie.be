<div class="wrap">
    <x-slot name="description">
        {{ $product->description }}
    </x-slot>

    @if ($product->paddle_product_id)
        @include('front.pages.products.partials.priceCard')
    @endif
</div>
