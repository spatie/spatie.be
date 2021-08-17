@if ($licenses->count())
    <section id="purchases" class="mb-16 pt-0">
        @foreach ($licenses->groupBy('assignment.purchasable.title') as $purchasableTitle => $licensesPerPurchasable)
            <div class="mb-8">
                <h3 class="title-sm">{{ $purchasableTitle }}</h3>
                @foreach ($licensesPerPurchasable as $license)
                    @include('front.pages.products.partials.purchasedLicense', ['license' => $license])
                @endforeach
            </div>
        @endforeach
    </section>
@endif

