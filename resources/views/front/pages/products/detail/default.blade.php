
    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4 links-underline links-blue">
                <a href="{{ route('products.index')}}">Products</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                <span>{{ $product->title }}</span>
            </p>
        </div>
    </section>

    <section id="banner" class="md:pt-0 banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $product->title }}
            </h1>
            <div class="banner-intro">
                {{ $product->formattedDescription }}
            </div>
        </div>
    </section>

    @auth
        @include('front.pages.products.partials.purchasedLicenses', ['licenses' => $licenses])
    @endauth

    @auth
        @include('front.pages.products.partials.purchasedProducts', ['purchases' => $purchases])
    @endauth

    @if($product->purchasablesWithoutRenewals->count())
        <section class="md:-mt-8 mb-16 pt-0 section-fade">
            <div class="wrap">
                <h2 class="title line-after mt-16 mb-12">Buy additional licenses</h2>
                <div class="md:-mx-3 md:flex items-stretch justify-center">
                @foreach($product->purchasablesWithoutRenewals as $purchasable)
                    @include('front.pages.products.partials.priceCard')
                @endforeach
                </div>

            </div>
        </section>
    @endif

        <div class="section pt-0 wrap wrap-8 sm:grid-flow-col-dense">
            <div class="sm:col-start-5 sm:col-span-4 | md:col-start-5 md:col-span-3 md:ml-16 md:-mr-32">
                <div class="illustration is-left" title="Project">
                    {{ $product->getFirstMedia('product-image') }}
                </div>
            </div>
            <div class="sm:col-start-2 sm:col-span-3">
                <div class="markup markup-lists links-blue links-underline | sm:grid-text-right">
                    {{ $product->formattedLongDescription }}

                    <p class="mt-4 flex items-center space-x-4">
                        @if($product->action_url)
                            <a target="_blank" class="no-underline" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}">
                                <x-button>{{ $product->action_label }}</x-button>
                            </a>
                        @elseif ($product->url)
                            <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->url }}">
                                <span class="icon fill-current text-pink-dark">{{ svg('icons/far-angle-right') }}</span> {{ $product->url }}
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>

