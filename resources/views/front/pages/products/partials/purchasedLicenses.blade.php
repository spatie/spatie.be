@if ($licenses->count())
    <h2 class="text-2xl">My licenses</h2>

    @foreach ($licenses->groupBy('purchasable.title') as $purchasableTitle => $licensesPerPurchasable)
        <div>
            <h3 class="text-xl">{{ $purchasableTitle }}</h3>
            @foreach ($licensesPerPurchasable as $license)
                @include('front.pages.products.partials.purchasedLicense', ['license' => $license])
            @endforeach
        </div>
    @endforeach
@endif
