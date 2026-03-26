<div class="px-3 sm:px-16 md:px-10 lg:px-16">
    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-12">
        <p class="text-sm text-oss-gray-dark">
            <a class="underline hover:text-white" href="{{ route('products.index') }}">Products</a>
            <span class="mx-2 opacity-50">&rsaquo;</span>
            <span>{{ $product->title }}</span>
        </p>
    </section>

    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-16 mb-16">
        <h1 class="font-druk uppercase text-[50px] sm:text-[72px] md:text-[96px] leading-[0.9] font-bold mb-6">{{ $product->title }}</h1>
        <p class="text-xl text-oss-gray-dark max-w-[640px]">{{ $product->formattedDescription }}</p>
    </section>

    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mb-16">
        <div class="md:grid md:grid-flow-col gap-6 items-stretch justify-start">
            @foreach($product->purchasablesWithoutRenewals as $purchasable)
                @if ($purchasable->released)
                    @include('front.pages.products.partials.priceCard', ["first" => $loop->first])
                @endif
            @endforeach

            @foreach($product->bundles() as $bundle)
                @if ($bundle->visible)
                    @include('front.pages.products.partials.bundleCard', ["bundle" => $bundle])
                @endif
            @endforeach
        </div>

        <div class="text-xs text-oss-gray-dark mt-6">
            Includes a 10% coupon for a follow-up purchase within the next 24 hours.
            <br/>
            @if($product->hasGuarantee())
                On this product, we offer a 10 day money-back guarantee.
            @else
                Sales are final and are not eligible for a refund.
            @endif
            <br/>
            VAT will be calculated during checkout by <a class="underline" target="_blank"
                                                         href="https://paddle.com/support/welcome/#vat-tax-handling-and-compliance">Paddle</a>.
        </div>
    </section>

    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 pb-20">
        <div class="flex flex-col md:flex-row gap-16 md:items-start">
            <div class="w-full max-w-[640px] markup markup-titles markup-lists links-underline text-lg">
                {{ $product->formattedLongDescription }}

                <p class="mt-8">
                    @if($product->action_url)
                        <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}"
                           class="inline-flex items-center gap-x-2 underline hover:text-white">
                            <svg aria-hidden="true" class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                            {{ $product->action_label }}
                        </a>
                    @elseif ($product->url)
                        <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->url }}"
                           class="inline-flex items-center gap-x-2 underline hover:text-white">
                            <svg aria-hidden="true" class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                            {{ Str::after($product->url, 'https://') }}
                        </a>
                    @endif
                </p>
            </div>
            @if($product->getFirstMedia('product-image'))
                <div class="hidden sm:block w-full max-w-[400px] flex-shrink-0 rounded-[20px] overflow-hidden shadow-oss-card">
                    {{ $product->getFirstMedia('product-image') }}
                </div>
            @endif
        </div>
    </section>
</div>
