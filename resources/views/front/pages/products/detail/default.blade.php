
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

    @if(session()->has('sold_purchasable'))
        @php
            /** @var \App\Models\Purchasable $purchasable */
            $purchasable = session()->get('sold_purchasable')
        @endphp  

        <section id="cta" class="pb-16">
            <div class="wrap">
                <div class="card gradient gradient-green text-white">
                    <div class="wrap-card grid md:grid-cols-2 md:items-center">
                        <h2 class="title-xl">
                            A Big Thanks!
                        </h2>
                        <p class="text-xl">
                            Thanks for buying {{ $product->title }}. You can view details and manage your purchase below this page.
                            
                            @if ($purchasable->getting_started_url)
                                <br>
                                <a class="link-white link-underline" href="{{ $purchasable->getting_started_url }}">
                                    Get started
                                </a>
                                right away!
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </section>

    @endif

    @auth
        @include('front.pages.products.partials.purchasedLicenses', ['licenses' => $licenses])

        @if (!$licenses->count())
            @include('front.pages.products.partials.purchasedProducts', ['purchases' => $purchases])
        @endif
    @endauth

    @if($product->purchasablesWithoutRenewals->count())
        <section class="md:-mt-8 mb-24 pt-0 section-fade">
            <div class="wrap">
                @if ($licenses->count() || $purchases->count())
                    <h2 class="title line-after mt-16 mb-12">Buy extra licenses</h2>
                @endif
                <div class="md:-mx-2 md:grid md:grid-flow-col items-stretch justify-center">
                    @foreach($product->purchasablesWithoutRenewals as $purchasable)
                        @include('front.pages.products.partials.priceCard', ["first" => $loop->first])
                    @endforeach
                </div>
            </div>
        </section>

        <div class="section md:-mt-8 pt-0 pb-16 wrap">
            <div class="flex-0 text-xs text-gray-light mt-6">
                Prices exclusive of VAT for buyers without a valid VAT number.
            </div>
        </div>
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

