<div class="wrap">
    
    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4 links-underline links-blue">
                <a href="{{ route('products.index')}}">Products</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                <span class="font-sans-bold">{{ $product->title }}</span>
            </p>
        </div>
    </section>

    <section id="banner" class="pt-0 banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $product->title }}
            </h1>
            <p class="banner-intro">
                {{ $product->description }}
            </p>
            <p class="mt-0">
                <a href="{{ $product->url }}" target="_blank" class="link-underline link-black">{{ $product->url }}</a>
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
