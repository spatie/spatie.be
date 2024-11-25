@php
    $image = image("/backgrounds/bf-24-hero-alt.jpg");
@endphp

@push('startBody')
    <div class="wallpaper">
        <img srcset="{{ $image->getSrcset() }}" src="{{ $image->getUrl() }}" width="2400" sizes="100vw" alt="" class="h-screen object-cover">
    </div>
@endpush

<x-page
    ogImage="https://spatie.be/images/og-store.png"
    title="Applications and digital courses built for modern developers"
    description="Welcome in our store, by artisans for artisans. Get access to our paid products, courses and ebooks"
    bodyClass="bg-bf-dark-gray"
>
    {{-- <section id="banner" class="banner" role="banner">
         <div class="wrap">
             <h1 class="banner-slogan">
                 Welcome in <br>our store
             </h1>

            <!--
            <p class="banner-intro">
                Applications and digital courses built for modern developers
            </p>
            -->
        </div>
    </section> --}}

    @include('front.pages.products.partials.bf-banner')

   {{-- @include('front.pages.products.partials.ctaLaraconEU') --}}

    <div class="section section-group">

    <section class="section overflow-visible text-white">
            @if (count($bundles))
            <div class="wrap">
                <h2 class="title line-after mb-12">All of our products</h2>
            </div>
            @endif
            <div class="wrap">
                <div class="grid gap-x-24 gap-y-24 | sm:grid-cols-2 items-stretch">
                    @foreach ($products as $product)
                        <div class="my-6">
                            @if($product->external && $product->action_url)
                            <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}" class="group">
                            @else
                            <a href="{{ route('products.show', $product) }}" class="group">
                            @endif
                                <div class="-mt-8 pb-6 transition-transform transform ease-in-out group-hover:-translate-y-2 duration-200">
                                    <div class="shadow-md group-hover:shadow-lg">{{ $product->getFirstMedia('product-image') }}</div>
                                </div>

                                <h2 class="title-sm link-white link-underline-hover">{{ $product->title }}</h2>
                                @if(! $product->visible && current_user()?->hasAccessToUnReleasedProducts())<p class="mt-2 text-orange text-sm">This product is currently set to non-visible, it is visible to users that have access to unreleased products.</p>@endif
                            </a>

                            <p class="my-4 flex items-center space-x-4">
                                @if($product->external && $product->action_url)
                                    <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}">
                                        <x-button>{{ $product->action_label }}</x-button>
                                    </a>
                                @else
                                    <a href="{{ route('products.show', $product) }}">
                                        <x-button>{{ $product->action_label }}</x-button>
                                    </a>
                                @endif
                            </p>

                            @if ($purchasable = $product->purchasableWithDiscount())
                                <p class="mt-4">
                                    Now at <b>-{{ $purchasable->displayableDiscountPercentage() }}%</b>
                                </p>
                            @endif

                            <div class="mt-4 text-gray-light">{{ $product->formattedDescription }}</div>

                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        @if (count($bundles))
        <section class="section overflow-visible text-white">
            <div class="wrap">
                <h2 class="title line-after mb-12">Check our bundle promotions!</h2>
            </div>
            <div class="wrap">
                <div class="grid gap-x-24 gap-y-24 | sm:grid-cols-2 items-stretch">
                    @foreach ($bundles as $bundle)
                        <div class="my-6">
                            <a href="{{ route('bundles.show', $bundle) }}" class="group">
                                <div class="-mt-8 pb-6 transition-transform transform ease-in-out group-hover:-translate-y-2 duration-200">
                                    <div class="shadow-md group-hover:shadow-lg">{{ $bundle->getFirstMedia('image') }}</div>
                                </div>
                                <h2 class="title-sm link-white link-underline-hover">{{ $bundle->title }}</h2>
                            </a>

                            <p class="my-4 flex items-center space-x-4">
                                <a href="{{ route('bundles.show', $bundle) }}">
                                    <x-button>Buy Bundle</x-button>
                                </a>
                            </p>

                             <div class="mt-4 text-gray-light">{{ $bundle->formattedDescription }}</div>

                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
        </div>

</x-page>
