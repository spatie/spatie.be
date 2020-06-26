@if ($licenses->count())
    <h2 class="text-2xl">My licenses</h2>

    @foreach ($licenses->groupBy('purchasable.title') as $purchasableTitle => $licensesPerPurchasable)
        <div>
            <h3 class="text-xl">{{ $purchasableTitle }}</h3>
            @foreach ($licensesPerPurchasable as $license)
                <div>
                    <code class="font-mono">{{ $license->key }}</code>
                    <button class="bg-grey-lighter p-2">Renew</button>
                </div>
            @endforeach
        </div>
    @endforeach
@endif
