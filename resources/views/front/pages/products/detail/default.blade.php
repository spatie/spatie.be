<div class="wrap">
    <x-slot name="description">
        {{ $product->description }}
    </x-slot>

    {{ $product->getFirstMedia('product-image') }}
    <h1>{{ $product->title }}</h1>
    <div>{{ $product->description }}</div>

    @auth
        <div class="wrap">
            @include('front.pages.products.partials.purchasedLicenses', ['licenses' => $licenses])
        </div>
    @endauth

    @foreach($product->purchasables as $purchasable)
        @include('front.pages.products.partials.priceCard')
    @endforeach
</div>
