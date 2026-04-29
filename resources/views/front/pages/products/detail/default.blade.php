<div class="px-3 sm:px-16 md:px-10 lg:px-16">
    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-12">
        <p class="text-sm text-oss-gray-dark">
            <a class="underline hover:text-white" href="{{ route('products.index') }}">Products</a>
            <span class="mx-2 opacity-50">&rsaquo;</span>
            <span>{{ $product->title }}</span>
        </p>
    </section>

    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-16 mb-16">
        <div class="flex flex-col md:flex-row gap-10 md:gap-16 md:items-start">
            <div class="flex-1 min-w-0 space-y-8">
                <h1 class="font-druk uppercase text-[56px] sm:text-[72px] md:text-[96px] lg:text-[120px] leading-[0.85] font-bold mb-6 text-balance">{{ $product->title }}</h1>
                <div class="text-[18px] sm:text-xl text-oss-gray-medium max-w-[520px]">
                    {{ $product->formattedDescription }}
                </div>

                @if($product->action_url)
                    <p class="mt-5">
                        <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}"
                           class="text-lg underline text-oss-green-pale transition-colors hover:text-white">
                            {{ $product->action_label }}
                        </a>
                    </p>
                @elseif ($product->url)
                    <p class="mt-5">
                        <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->url }}"
                           class="text-lg underline text-oss-green-pale transition-colors hover:text-white">
                            {{ Str::after($product->url, 'https://') }}
                        </a>
                    </p>
                @endif
            </div>
            @if($product->getFirstMedia('product-image'))
                <div class="w-full md:w-[420px] flex-shrink-0 rounded-xl overflow-hidden">
                    {{ $product->getFirstMedia('product-image') }}
                </div>
            @endif
        </div>
    </section>

    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mb-12 pt-12 border-t border-white/10">
        <h2 class="font-druk uppercase text-[32px] sm:text-[40px] leading-[0.9] font-bold mb-8">Available licenses</h2>
        <div class="grid sm:grid-cols-2 gap-5 items-stretch">
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

        <p class="text-xs text-oss-gray-dark mt-5">
            Includes a 10% coupon for a follow-up purchase within the next 24 hours.
            @if($product->hasGuarantee())
                &middot; 10 day money-back guarantee.
            @else
                &middot; Sales are final.
            @endif
            &middot; VAT calculated at checkout by <a class="underline" target="_blank" href="https://paddle.com/support/welcome/#vat-tax-handling-and-compliance">Paddle</a>.
        </p>
    </section>

    @if (trim(strip_tags($product->formattedLongDescription)))
        <section id="description" class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 pb-20 pt-12 border-t border-white/10">
            <div class="max-w-[720px] markup markup-titles markup-lists links-underline">
                {{ $product->formattedLongDescription }}
            </div>
        </section>
    @endif
</div>
