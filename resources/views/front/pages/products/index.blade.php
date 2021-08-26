<x-page
        ogImage="https://spatie.be/images/og-store.png"
        title="Applications and digital courses built for modern developers"
        background="/backgrounds/product.jpg"
        description="Welcome in our store, by artisans for artisans. Get access to our paid products, courses and ebooks"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Welcome in <br>our store
            </h1>
            <p class="banner-intro">
                Applications and digital courses built for modern developers
            </p>
        </div>
    </section>

   {{-- @include('front.pages.products.partials.ctaLaraconEU') --}}

    <div class="section section-group">
    @if (count($bundles))
        <section class="section overflow-visible">
            <div class="wrap">
                <h2 class="title line-after mb-12">Check our bundle promotions!</h2>
            </div>
            <div class="wrap">
                <div class="grid col-gap-16 row-gap-24 | sm:grid-cols-2 items-stretch">
                    @foreach ($bundles as $bundle)
                        <div class="p-6">
                            <a href="{{ route('bundles.show', $bundle) }}" class="group">
                                <div class="-mt-8 pb-8 px-12 transition-transform transform ease-in-out group-hover:-translate-y-2 duration-200">
                                    <div class="shadow-md group-hover:shadow-lg">{{ $bundle->getFirstMedia('image') }}</div>
                                </div>
                                <h2 class="title-sm link-black link-underline-hover">{{ $bundle->title }}</h2>
                                <p class="mt-4">{{ $bundle->formattedDescription }}</p>
                            </a>

                            <p class="mt-4 flex items-center space-x-4">
                                <a href="{{ route('bundles.show', $bundle) }}">
                                    <x-button>Buy</x-button>
                                </a>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section overflow-visible">
            @if (count($bundles))
            <div class="wrap">
                <h2 class="title line-after mb-12">All of our products</h2>
            </div>
            @endif
            <div class="wrap">
                <div class="grid col-gap-16 row-gap-24 | sm:grid-cols-2 items-stretch">
                    @foreach ($products as $product)
                        <div class="p-6">
                            <a href="{{ route('products.show', $product) }}" class="group">
                                <div class="-mt-8 pb-8 px-12 transition-transform transform ease-in-out group-hover:-translate-y-2 duration-200">
                                    <div class="shadow-md group-hover:shadow-lg">{{ $product->getFirstMedia('product-image') }}</div>
                                </div>
                                <h2 class="title-sm link-black link-underline-hover">{{ $product->title }}</h2>
                                <p class="mt-4">{{ $product->formattedDescription }}</p>
                            </a>

                            @if ($purchasable = $product->purchasableWithDiscount())
                                <p class="mt-4">
                                    Now at <b>-{{ $purchasable->displayableDiscountPercentage() }}%</b>
                                </p>
                                @endif

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
        </div>

</x-page>
