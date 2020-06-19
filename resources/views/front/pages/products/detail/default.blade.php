<div class="wrap">
    <x-slot name="description">
        {{ $product->description }}
    </x-slot>

    @foreach($product->purchasables as $purchasable)
            @include('front.pages.products.partials.priceCard')
    @endforeach
</div>
