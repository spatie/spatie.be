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
        <section class="w-full max-w-[1080px] mx-auto mt-8 sm:mt-20 md:mt-32 mb-24 md:mb-52 px-7 lg:px-0">
            <h1 class="font-druk uppercase text-[72px] lg:text-[144px] leading-[0.8] font-bold mb-10">Welcome in<br>our store</h1>
        </section>
    @endif

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 flex flex-col gap-y-16 sm:gap-y-20 pb-20">
        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
            <div class="grid gap-12 sm:grid-cols-2">
                @foreach ($products as $product)
                    <div>
                        @if($product->external && $product->action_url)
                            <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}" class="group block">
                        @else
                            <a href="{{ route('products.show', $product) }}" class="group block">
                        @endif
                            @if($product->getFirstMedia('product-image'))
                                <div class="mb-6 rounded-[20px] overflow-hidden shadow-oss-card transition-transform transform ease-in-out group-hover:-translate-y-1 duration-200">
                                    {{ $product->getFirstMedia('product-image') }}
                                </div>
                            @endif
                            <h2 class="font-bold text-xl group-hover:underline">{{ $product->title }}</h2>
                            @if(! $product->visible && current_user()?->hasAccessToUnReleasedProducts())
                                <p class="mt-2 text-orange text-sm">This product is currently set to non-visible.</p>
                            @endif
                        </a>

                        <p class="my-4">
                            @if($product->external && $product->action_url)
                                <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}" class="inline-flex items-center gap-x-2 underline hover:text-white">
                                    <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                                    {{ $product->action_label }}
                                </a>
                            @else
                                <a href="{{ route('products.show', $product) }}" class="inline-flex items-center gap-x-2 underline hover:text-white">
                                    <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                                    {{ $product->action_label }}
                                </a>
                            @endif
                        </p>

                        @if ($purchasable = $product->purchasableWithDiscount())
                            <p class="mt-2 text-oss-green font-bold">
                                Now at -{{ $purchasable->displayableDiscountPercentage() }}%
                            </p>
                        @endif

                        <p class="mt-4 text-oss-gray-dark">{{ $product->formattedDescription }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        @if (!$isBlackFriday && count($bundles))
            <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
                <h2 class="font-druk uppercase text-[40px] sm:text-[72px] leading-[0.9] mb-16">Bundle promotions</h2>
                <div class="grid gap-12 sm:grid-cols-2">
                    @foreach ($bundles as $bundle)
                        <div>
                            <a href="{{ route('bundles.show', $bundle) }}" class="group block">
                                @if($bundle->getFirstMedia('image'))
                                    <div class="mb-6 rounded-[20px] overflow-hidden shadow-oss-card transition-transform transform ease-in-out group-hover:-translate-y-1 duration-200">
                                        {{ $bundle->getFirstMedia('image') }}
                                    </div>
                                @endif
                                <h2 class="font-bold text-xl group-hover:underline">{{ $bundle->title }}</h2>
                            </a>
                            <p class="my-4">
                                <a href="{{ route('bundles.show', $bundle) }}" class="inline-flex items-center gap-x-2 underline hover:text-white">
                                    <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                                    Buy Bundle
                                </a>
                            </p>
                            <p class="mt-4 text-oss-gray-dark">{{ $bundle->formattedDescription }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

</x-page>
