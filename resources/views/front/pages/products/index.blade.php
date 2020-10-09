<x-page
        title="Products"
        background="/backgrounds/product.jpg"
        description="Welcome in our store, by artisans for artisans. Get access to our paid products, courses and ebooks"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Welcome in <br>our store
            </h1>
            <p class="banner-intro">
                By artisans for artisans
            </p>
        </div>
    </section>

    <section class="section overflow-visible section-group">
            <div class="wrap">
                @auth
                    @includeWhen($purchasesPerProduct->isNotEmpty(), "front.pages.products.partials.purchases", ['purchasesPerProduct' => $purchasesPerProduct])

                    @if($purchasesPerProduct->isNotEmpty())
                        <h2 class="mt-16 title line-after mb-12">All products</h2>
                    @endif
                @endauth    

                <div class="grid col-gap-6 row-gap-16 | sm:grid-cols-2 items-stretch">
                    @foreach ($products as $product)
                        <div class="flex flex-col line-l line-l-green p-4 bg-green-lightest bg-opacity-50">
                            <a href="{{ route('products.show', $product) }}">
                                <div class="-mt-8 pb-8 px-12">
                                    <div class="shadow-lg">{{ $product->getFirstMedia('product-image') }}</div>
                                </div>
                                <h2 class="title-sm link-black link-underline">{{ $product->title }}</h2>
                                <p class="mt-4">{{ $product->formattedDescription }}</p>
                            </a>

                            <p class="mt-4 flex items-center space-x-4">
                                @if($product->external && $product->action_url)
                                    <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}">
                                        <x-button>{{ $product->action_label }}</x-button>
                                    </a>
                                    <a class="link-green link-underline" href="{{ route('products.show', $product) }}">
                                        Read more
                                    </a>
                                @else
                                    <a href="{{ route('products.show', $product) }}">
                                        <x-button>{{ $product->action_label }}</x-button>
                                    </a>
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>    
    
</x-page>
