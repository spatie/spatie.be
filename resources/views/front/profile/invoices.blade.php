<x-page
        title="Invoices"
        background="/backgrounds/home.jpg"
>

    <div class="wrap flex">
        @include('front.profile.partials.sidebar')

        <div class="ml-4">
            <h1>Invoices</h1>

            <?php /** @var \Laravel\Paddle\Transaction $transaction */?>
            @forelse ($transactions as $transaction)
                <div>
                    <span>{{ $transaction->date()->toDayDateTimeString() }}</span>
                    <span>{{ $transaction->amount() }}</span>
                    <span><a href="{{ $transaction->receipt() }}" target="_blank">Download</a></span>
                </div>
            @empty
                <p>No invoices yet, take a look at our <a href="{{ route('products.index') }}">products</a>!</p>
            @endforelse
        </div>
    </div>
</x-page>
