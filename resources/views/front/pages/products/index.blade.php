<x-page
    ogImage="https://spatie.be/images/og-store.png"
    title="Applications and digital courses built for modern developers"
    background="/backgrounds/product.jpg"
    description="Welcome in our store, by artisans for artisans. Get access to our paid products, courses and ebooks"
>
    <section id="banner" class="banner bg-trueblack " role="banner">
        <div class="wrap text-white">

            <h1 class="banner-slogan">
                Our annual <br><span class="no-underline text-yellow">Black Friday</span> sale
            </h1>


            {{--
            <h1 class="banner-slogan">
                Our products
            </h1>
            --}}

            <p class="banner-intro pt-4">
                ⚡️ <strong>Get 30% off</strong> on all our applications and courses.
            </p>


            <div class="mt-2">
                @php
                    $expirationDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', '2023-11-26 23:59' );

                @endphp

                <div
                    class="flex bg-trueblack text-white text-base banner-intro">

                    Offer ends in&nbsp;
                    <x-countdown class="inline-block" :expires="$expirationDate">
                            <span>
                                <span class="font-semibold  font-mono" x-text="timer.days">{{ $component->days()
                                    }}</span><span class="text-white">d</span>
                            </span>
                        <span>
                                <span class="font-semibold font-mono" x-text="timer.hours">{{ $component->hours()
                                    }}</span><span class="text-white">h</span>
                            </span>
                        <span>
                                <span class="font-semibold font-mono" x-text="timer.minutes">{{ $component->minutes()
                                    }}</span><span class="text-white">m</span>
                            </span>
                        <span>
                                <span class="font-semibold font-mono" x-text="timer.seconds">{{ $component->seconds()
                                    }}</span><span class="text-white">s</span>
                            </span>
                    </x-countdown>
                </div>
            </div>

            <div class="underline text-base mt-4">
                <a href="/black-friday-deals">Watch our promo movie</a>
            </div>

            @once
                @push('scripts')
                    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
                @endpush
            @endonce

        </div>

        <!--
        <p class="banner-intro">
            Applications and digital courses built for modern developers
        </p>
        -->
        </div>
    </section>

    {{-- @include('front.pages.products.partials.ctaLaraconEU') --}}

    <div class="section section-group">


        <section class="section overflow-visible">
            @if (count($bundles))
                <div class="wrap">
                    <h2 class="title line-after mb-12">All of our products</h2>
                </div>
            @endif
            <div class="wrap">
                <div class="grid col-gap-24 row-gap-24 | sm:grid-cols-2 items-stretch">
                    @foreach ($products as $product)
                        <div class="my-6">
                            @if($product->external && $product->action_url)
                                <a target="_blank" rel="nofollow noreferrer noopener" href="{{ $product->action_url }}"
                                   class="group">
                                    @else
                                        <a href="{{ route('products.show', $product) }}" class="group">
                                            @endif
                                            <div
                                                class="-mt-8 pb-6 transition-transform transform ease-in-out group-hover:-translate-y-2 duration-200">
                                                <div
                                                    class="shadow-md group-hover:shadow-lg">{{ $product->getFirstMedia('product-image') }}</div>
                                            </div>

                                            <h2 class="title-sm link-black link-underline-hover">{{ $product->title }}</h2>
                                            @if(! $product->visible && current_user()?->hasAccessToUnReleasedProducts())
                                                <p class="mt-2 text-orange text-sm">This product is currently set to
                                                    non-visible, it is visible to users that have access to unreleased
                                                    products.</p>
                                            @endif
                                        </a>

                                        <p class="my-4 flex items-center space-x-4">
                                            @if($product->external && $product->action_url)
                                                <a target="_blank" rel="nofollow noreferrer noopener"
                                                   href="{{ $product->action_url }}">
                                                    <x-button>{{ $product->action_label }}</x-button>
                                                </a>
                                            @else
                                                <a href="{{ route('products.show', $product) }}">
                                                    <x-button>{{ $product->action_label }}</x-button>
                                                </a>
                                            @endif
                                        </p>

                                        @if ($purchasable = $product->purchasableWithDiscount())
                                            <p class="mt-4">
                                                Now at <b>-{{ $purchasable->displayableDiscountPercentage() }}%</b>
                                            </p>
                                        @endif



                                        <p class="mt-4">{{ $product->formattedDescription }}</p>


                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        @if (count($bundles))
            <section class="section overflow-visible">
                <div class="wrap">
                    <h2 class="title line-after mb-12">Check our bundle promotions!</h2>
                </div>
                <div class="wrap">
                    <div class="grid col-gap-24 row-gap-24 | sm:grid-cols-2 items-stretch">
                        @foreach ($bundles as $bundle)
                            <div class="my-6">
                                <a href="{{ route('bundles.show', $bundle) }}" class="group">
                                    <div
                                        class="-mt-8 pb-6 transition-transform transform ease-in-out group-hover:-translate-y-2 duration-200">
                                        <div
                                            class="shadow-md group-hover:shadow-lg">{{ $bundle->getFirstMedia('image') }}</div>
                                    </div>
                                    <h2 class="title-sm link-black link-underline-hover">{{ $bundle->title }}</h2>
                                </a>

                                <p class="my-4 flex items-center space-x-4">
                                    <a href="{{ route('bundles.show', $bundle) }}">
                                        <x-button>Buy Bundle</x-button>
                                    </a>
                                </p>

                                <p class="mt-4">{{ $bundle->formattedDescription }}</p>

                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>

</x-page>
