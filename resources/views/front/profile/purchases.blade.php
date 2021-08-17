<x-page
        title="Purchases"
        background="/backgrounds/auth.jpg"
>
    @include('front.profile.partials.subnav')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Purchases
            </h1>
            @if (!$purchases->count() && !$assignments->count())
                <p class="banner-intro">No purchases yet, take a look at <a class="link-underline link-blue" href="{{ route('products.index') }}">our products</a>.</p>
            @endif
        </div>
    </section>

    <section class="section section-group pt-0">
        <div class="wrap">
                <h2 class="title line-after mb-12">Your purchases</h2>
                <ul class="grid gap-6">
                    @foreach ($purchases as $purchase)
                        <li>
                            @if ($purchase->bundle)
                                <h3 class="text-lg font-bold line-after mb-4">{{ $purchase->bundle->title }}</h3>
                            @else
                                <h3 class="text-lg font-bold line-after mb-4">{{ $purchase->purchasable->getFullTitle() }}</h3>
                            @endif


                            @php
                                $otherUsers = $purchase->assignments
                                        ->map(fn ($assignment) => $assignment->user)
                                        ->reject(fn ($user) => $user->is(auth()->user()))
                                        ->unique('id');
                            @endphp
                            @if ($otherUsers->count())
                                <div>
                                    <span>Assigned to: </span>
                                    @foreach ($otherUsers as $user)
                                        <span class="bg-blue-lightest text-blue rounded px-2 py-1 text-xs">{{ $user->is(auth()->user()) ? 'You' : $user->name }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @foreach ($purchase->assignments as $assignment)
                                @if ($assignment->licenses->count())
                                    @include('front.pages.products.partials.purchasedLicenses', ['licenses' => $assignment->licenses, 'assignment' => $assignment])
                                @elseif ($assignment->user->is(auth()->user()))
                                    @include('front.pages.products.partials.purchasedProduct', ['assignment' => $assignment])
                                @endif
                            @endforeach
                        </li>
                    @endforeach
                    {{--
                            @foreach ($purchasesPerProduct as $productId => $purchasesForProduct)
                            @php
                                /** @var \App\Domain\Shop\Models\Product $product */
                                $product = $purchasesForProduct->first()['product'];
                            @endphp
                            <li>
                                @include('front.pages.products.partials.productPurchases')
                            </li>
                        @endforeach
                    --}}
                </ul>

            <h2 class="text-xl font-bold">Your assigned products</h2>
            @foreach ($assignments as $product => $items)
                <h3 class="text-lg font-bold">{{ $product }}</h3>
                <ul class="grid gap-6">
                    @foreach ($items as $assignment)
                        <li>
                            <p>{{ $assignment->purchasable->getFullTitle() }}</p>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </section>
</x-page>
