<div class="px-3 sm:px-16 md:px-10 lg:px-16">
    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-12">
        <p class="text-sm text-oss-gray-dark">
            <a class="underline hover:text-white" href="{{ route('products.index') }}">Products</a>
            <span class="mx-2 opacity-50">&rsaquo;</span>
            <span>{{ $bundle->title }}</span>
        </p>
    </section>

    <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-16 mb-16">
        <div class="flex flex-col md:flex-row gap-10 md:gap-16 md:items-start">
            <div class="flex-1 min-w-0 space-y-8">
                <h1 class="font-druk uppercase text-[56px] sm:text-[72px] md:text-[96px] lg:text-[120px] leading-[0.85] font-bold mb-6 text-balance">{{ $bundle->title }}</h1>
                <div class="text-[18px] sm:text-xl text-oss-gray-medium max-w-[520px]">{{ $bundle->formattedDescription }}</div>
            </div>
            <div class="w-full md:w-[480px] flex-shrink-0">
                @include('front.pages.products.partials.priceCard', [
                    'payLink' => $payLink,
                    'purchasable' => $bundle,
                ])

                <p class="text-xs text-oss-gray-dark mt-5">
                    Includes a 10% coupon for a follow-up purchase within the next 24 hours.
                    &middot; Sales are final.
                    &middot; VAT calculated at checkout by <a class="underline" target="_blank" href="https://paddle.com/support/welcome/#vat-tax-handling-and-compliance">Paddle</a>.
                </p>
            </div>
        </div>
    </section>
</div>
