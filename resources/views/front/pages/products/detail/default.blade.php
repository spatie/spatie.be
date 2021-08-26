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

@if (auth()->check() && auth()->user()->ownsAny($product->purchasables))
    <div class="wrap flex w-full mb-20">
        <div
            class="w-full bg-orange-dark text-white flex flex-col justify-between items-end sm:flex-row sm:items-center justify-center rounded p-2 pr-6 shadow-light text-xs sm:text-sm">
            <div class="flex items-center">
                <div
                    class="mr-2 text-lg icon bg-black bg-opacity-25 text-white rounded-full w-8 flex items-center justify-center h-8">
                    {{ svg('icons/fal-exclamation-circle') }}
                </div>
                <div>
                    <div>
                        Looking to manage your existing purchases? They've moved to <strong>your profile</strong>.
                    </div>
                </div>
            </div>
            <a href="{{ route('purchases') }}">
                <button
                    class="mt-2 md:mt-0 ml-4 px-2 py-1 rounded text-orange-dark bg-white uppercase tracking-wide font-semibold">
                    Purchases
                </button>
            </a>
        </div>
    </div>
@endauth

<section class="md:-mt-8 mb-24 pt-0 section-fade">
    <div class="wrap">
        <div class="md:-mx-2 md:grid md:grid-flow-col items-stretch justify-start">
            @foreach($product->purchasablesWithoutRenewals as $purchasable)
                @if ($purchasable->released)
                    @include('front.pages.products.partials.priceCard', ["first" => $loop->first])
                @endif
            @endforeach

            {{--
            @foreach($product->bundles() as $bundle)
                @include('front.pages.products.partials.priceCard', [
                   'payLink' => current_user()?->getPayLinkForBundle($bundle),
                   'purchasable' => $bundle,
               ])
            @endforeach
            --}}
        </div>
    </div>
</section>

<div class="section md:-mt-12 pt-0 pb-16 wrap">
    <div class="flex-0 text-xs text-gray mt-6">
        Includes a 10% coupon for a follow-up purchase within the next 24 hours.
        <br/>
        @if($product->hasGuarantee())
            On this product, we offer a 10 day money-back guarantee
            <br/>
        @endif
        VAT will be calculated during checkout by <a class="underline" target="_blank"
                                                     href="https://paddle.com/support/welcome/#vat-tax-handling-and-compliance">Paddle</a>
    </div>
</div>

<div class="section pt-0">
    <div class="wrap grid gap-12 sm:grid-cols-2 items-start">
        <div class="markup markup-titles markup-lists links-blue links-underline | sm:grid-text-right">
            {{ $product->formattedLongDescription }}

            <p class="mt-4 flex items-center space-x-4">
                @if($product->action_url)
                    <a target="_blank" class="no-underline" rel="nofollow noreferrer noopener"
                       href="{{ $product->action_url }}">
                        <x-button>{{ $product->action_label }}</x-button>
                    </a>
                @elseif ($product->url)
                    <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->url }}">
                        <span
                            class="icon fill-current text-pink-dark mr-2">{{ svg('icons/far-angle-right') }}</span>{{ Str::after($product->url, 'https://') }}
                    </a>
                @endif
            </p>
        </div>
        <div class="illustration is-left" title="Project">
            {{ $product->getFirstMedia('product-image') }}
        </div>
    </div>
</div>

