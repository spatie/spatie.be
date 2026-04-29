@php
    $isBlackFriday = config('black-friday.enabled');

    $image = image("/backgrounds/bf-25-hero-alt.jpg");
    $productsCopy = $isBlackFriday ? 'Get 30% off on these courses & products' : 'All of our products';
@endphp

@if ($isBlackFriday)
    @push('startBody')
        <div class="wallpaper fixed">
            <img srcset="{{ $image->getSrcset() }}" src="{{ $image->getUrl() }}" width="2400" sizes="100vw" alt="" class="h-svh object-cover">
            <canvas class="absolute w-full h-full inset-0 js-asteroids z-[9] opacity-50"></canvas>
        </div>
    @endpush
@endif

<x-page
    title="Applications and digital courses built for modern developers"
    description="Welcome in our store, by artisans for artisans. Get access to our paid products, courses and ebooks"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
    footerCta
>

    @unless($isBlackFriday)
        @include('layout.partials.gradient-background', [
            'color1' => '#0E3B5E',
            'color2' => '#0A2540',
            'color3' => '#1A5276',
            'rotationZ' => '80',
            'positionX' => '-0.8',
            'positionY' => '0.6',
            'uDensity' => '1.4',
            'uFrequency' => '5.0',
            'uStrength' => '2.8',
        ])
    @endunless

    @if ($isBlackFriday)
        @include('front.pages.home.partials.bf-banner', array('button' => false, 'showBackground' => false))
    @else
        <section class="w-full max-w-[1080px] mx-auto mt-8 sm:mt-20 md:mt-24 mb-24 md:mb-32 px-7 lg:px-0">
            <h1 class="font-druk uppercase text-[72px] lg:text-[144px] leading-[0.8] font-bold mb-10">Our Products <br /> &amp; Courses</h1>
        </section>
    @endif

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 space-y-16 sm:space-y-32 pb-20">

        <section class="w-full max-w-[1320px] mx-auto">
            <div class="grid gap-8 sm:gap-20 sm:grid-cols-2">
                @foreach ($products as $product)
                    @if($product->external && $product->action_url)
                        <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}" class="group flex flex-col border border-white/10 rounded-xl overflow-hidden transition-colors hover:border-white/20 hover:bg-white/[0.02]">
                    @else
                        <a href="{{ route('products.show', $product) }}" class="group flex flex-col border border-white/10 rounded-xl overflow-hidden transition-colors hover:border-white/20 hover:bg-white/[0.02]">
                    @endif
                        @if($product->getFirstMedia('product-image'))
                            <div class="overflow-hidden aspect-[16/10] [&_img]:object-cover [&_img]:size-full">
                                {{ $product->getFirstMedia('product-image') }}
                            </div>
                        @endif
                        <div class="p-9 flex flex-col grow">
                            <h2 class="text-4xl font-druk uppercase text-white leading-tight">{{ $product->title }}</h2>
                            @if(! $product->visible && current_user()?->hasAccessToUnReleasedProducts())
                                <p class="mt-1 text-orange text-sm">This product is currently set to non-visible.</p>
                            @endif
                            @if ($purchasable = $product->purchasableWithDiscount())
                                <p class="mt-2 text-oss-green text-sm font-medium tabular-nums">
                                    -{{ $purchasable->displayableDiscountPercentage() }}% off
                                </p>
                            @endif
                            <div class="mt-4 text-lg text-oss-gray-dark">{{ $product->formattedDescription }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        @if (!$isBlackFriday && count($bundles))
            <section class="w-full max-w-[1320px] mx-auto">
                <h2 class="font-druk uppercase text-[40px] sm:text-[72px] leading-[0.9] mb-16">Bundle promotions</h2>
                <div class="grid gap-8 sm:gap-20 sm:grid-cols-2">
                    @foreach ($bundles as $bundle)
                        <a href="{{ route('bundles.show', $bundle) }}" class="group flex flex-col border border-white/10 rounded-xl overflow-hidden transition-colors hover:border-white/20 hover:bg-white/[0.02]">
                            @if($bundle->getFirstMedia('image'))
                                <div class="overflow-hidden">
                                    {{ $bundle->getFirstMedia('image') }}
                                </div>
                            @endif
                            <div class="p-6 flex flex-col grow">
                                <h2 class="text-4xl font-druk uppercase text-white leading-tight">{{ $bundle->title }}</h2>
                                <div class="mt-4 text-lg text-oss-gray-dark">{{ $bundle->formattedDescription }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

</x-page>
