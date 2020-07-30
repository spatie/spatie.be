<div class="wrap">
    
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $product->title }}
            </h1>
            <p class="banner-intro">
                {{ $product->description }}
            </p>
            <p class="mt-4">
                <a href="{{ $product->url }}" target="_blank" class="link-underline link-blue">{{ $product->url }}</a>
            </p>
        </div>
    </section>

    @auth
        <div class="wrap">
            @include('front.pages.products.partials.purchasedLicenses', ['licenses' => $licenses])
        </div>
    @endauth

    @foreach($product->purchasables as $purchasable)
        @include('front.pages.products.partials.priceCard')
    @endforeach
</div>
