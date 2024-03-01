<section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
    <div class="wrap">
        <p class="mt-4 links-underline links-blue">
            <a href="{{ route('products.index')}}">Products</a>
            <span class="icon mx-2 opacity-50 fill-current text-blue">{{ app_svg('icons/far-angle-right') }}</span>
            <span>{{ $bundle->title }}</span>
        </p>
    </div>
</section>

<section id="banner" class="md:pt-0 banner" role="banner">
    <div class="wrap">
        <h1 class="banner-slogan">
            {{ $bundle->title }}
        </h1>
        <div class="banner-intro">
            {{ $bundle->formattedDescription }}
        </div>
    </div>
</section>

<div class="section pt-0 wrap grid sm:gap-6 md:gap-8 grid-cols-9 sm:grid-flow-col-dense">
    <div class="col-span-9 sm:col-start-5 sm:col-span-5">
        <section class="mb-16 pt-0">
            <div class="md:-mx-2 md:grid md:grid-flow-col items-stretch justify-start">
                @include('front.pages.products.partials.priceCard', [
                    'payLink' => $payLink,
                    'purchasable' => $bundle,
                ])
            </div>
        </section>

        <div class="section md:-mt-12 pt-0 pb-16">
            <div class="flex-0 text-xs text-gray md:mt-6">
                Includes a 10% coupon for a follow-up purchase within the next 24 hours.
                <br/>
                Sales are final and are not eligible for a refund.
                <br/>
                VAT will be calculated during checkout by
                <a class="underline" target="_blank"
                   href="https://paddle.com/support/welcome/#vat-tax-handling-and-compliance">Paddle</a>.
            </div>
        </div>
    </div>
    <div class="col-span-9 sm:col-start-1 sm:col-span-4" style="bottom: -1rem">
        <style>.illustration img {
                width: 100%;
            }</style>
        <div class="illustration is-left mb-12" title="Project">
            {{ $bundle->getFirstMedia('image') }}
        </div>

        <div class="markup markup-titles markup-lists links-blue links-underline | sm:grid-text-right">
            {{ $bundle->formattedLongDescription }}
        </div>
    </div>
</div>

