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
        /** @var \App\Domain\Shop\Models\Purchasable $purchasable */
        $purchasable = session()->get('sold_purchasable');

        /** @var \App\Domain\Shop\Models\Purchase $purchase */
        $purchase = session()->get('latest_purchase')

    @endphp

    <section id="cta" class="pb-16">
        <div class="wrap">
            <div class="card gradient gradient-green text-white">
                <div class="wrap-card grid md:grid-cols-2 md:items-center">
                    <h2 class="title-xl">
                        Thank you!
                    </h2>
                    <p class="text-xl">
                        Thanks for buying {{ $product->title }}. You can view details and manage your purchase below this page.

                        <br /><br />
                        @if(optional($purchase)->unlocksRayLicense())
                            Your purchase also unlocked <a href="/products/ray">a license for Ray</a>.
                            <br/><br />
                        @endif
                        Here's a little bonus: you will get a 10% discount on purchases in the next 24 hours!
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
    <section class="wrap mb-16 pt-0">
        @if($assignments->count() && $getting_started_description = $assignments->first()->purchasable->getting_started_description)
            {!! $getting_started_description !!}
        @endif
    </section>

    @include('front.pages.products.partials.purchasedLicenses', ['licenses' => $licenses])

    @if (!$licenses->count())
        @include('front.pages.products.partials.purchasedProducts', ['assignments' => $assignments])
    @endif
@endauth

@if($assignments->count() === 0 || $product->purchasables()->first()->type !== 'videos' )
    <section class="md:-mt-8 mb-24 pt-0 section-fade">
        <div class="wrap">
            @if ($licenses->count() || $assignments->count())
                <h2 class="title line-after mt-16 mb-12">Buy extra licenses</h2>
            @endif
            <div class="md:-mx-2 md:grid md:grid-flow-col items-stretch justify-start">
                @foreach($product->purchasablesWithoutRenewals as $purchasable)
                    @if ($purchasable->released)
                    @include('front.pages.products.partials.priceCard', ["first" => $loop->first])
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <div class="section md:-mt-12 pt-0 pb-16 wrap">
        <div class="flex-0 text-xs text-gray mt-6">
            Includes a 10% coupon for a follow-up purchase within the next 24 hours.
            <br />
            @if($product->hasGuarantee())
            On this product, we offer a 10 day money-back guarantee
            <br />
            @endif
            VAT will be calculated during checkout by <a class="underline" target="_blank" href="https://paddle.com/support/welcome/#vat-tax-handling-and-compliance">Paddle</a>

        </div>
    </div>
@endif

<div class="section pt-0">
    <div class="wrap grid gap-12 sm:grid-cols-2 items-start">
        <div class="markup markup-titles markup-lists links-blue links-underline | sm:grid-text-right">
            {{ $product->formattedLongDescription }}

            <p class="mt-4 flex items-center space-x-4">
                @if($product->action_url)
                    <a target="_blank" class="no-underline" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}">
                        <x-button>{{ $product->action_label }}</x-button>
                    </a>
                @elseif ($product->url)
                    <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->url }}">
                        <span class="icon fill-current text-pink-dark mr-2">{{ svg('icons/far-angle-right') }}</span>{{ Str::after($product->url, 'https://') }}
                    </a>
                @endif
            </p>
        </div>
        <div class="illustration is-left" title="Project">
            {{ $product->getFirstMedia('product-image') }}
        </div>
    </div>
</div>

