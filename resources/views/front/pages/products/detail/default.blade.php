<div class="wrap">
    <x-slot name="description">
        {{ $product->description }}
    </x-slot>

    <h1>{{ $product->title }}</h1>
    <div>{{ $product->description }}</div>

    @foreach($product->purchasables as $purchasable)
        @include('front.pages.products.partials.priceCard')
    @endforeach
</div>
