@if ($licenses->count())
    <section id="purchases" class="wrap mb-16 pt-0">
        <h2 class="title line-after mb-12">My licenses</h2>

        @foreach ($licenses->groupBy('purchasable.title') as $purchasableTitle => $licensesPerPurchasable)
            <div class="mb-8">
                <h3 class="title-sm">{{ $purchasableTitle }}</h3>
                @foreach ($licensesPerPurchasable as $license)
                    @include('front.pages.products.partials.purchasedLicense', ['license' => $license])
                @endforeach
            </div>
        @endforeach

        <h2 class="title line-after mt-16 mb-12">Buy additional licenses</h2>
    </section>
@endif

