<x-page
        title="Products"
        background="/backgrounds/product.jpg"
        description="Section with all our paid products"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Our products
            </h1>
            <p class="banner-intro">
            Welcome to our little shop
            </p>
        </div>
    </section>


    <section class="section section-group">


            <div class="wrap">
                @auth
                    @includeWhen($purchasesPerProduct->isNotEmpty(), "front.pages.products.partials.purchases", ['purchasesPerProduct' => $purchasesPerProduct])

                    @if($purchasesPerProduct->isNotEmpty())
                        <h2 class="mt-16 title line-after mb-12">All products</h2>
                    @endif
                @endauth    

                <div class="grid col-gap-6 row-gap-16 | sm:grid-cols-2 items-stretch">
                    @foreach ($products as $product)
                        <div class="line-l">
                            <a href="{{ route('products.show', $product) }}">
                                {{ $product->getFirstMedia('product-image') }}
                                <h2 class="title-sm link-black link-underline">{{ $product->title }}</h2>
                                <p class="mt-4">{{ $product->description }}</p>
                            </a>
                            <p class="mt-2">
                                <a class="link-blue link-underline text-xs" target="_blank" href="{{ $product->url }}">{{ $product->url }}</a>
                            </p>
                            <p class="mt-4">
                                <a href="{{ $product->action_url }}">
                                    <x-button>{{ $product->action_label }}</x-button>
                                </a>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>    
    
</x-page>
