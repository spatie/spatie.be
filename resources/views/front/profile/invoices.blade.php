<x-page
        title="Invoices"
        background="/backgrounds/auth.jpg"
>
    <?php /** @var \Laravel\Paddle\Transaction $transaction */?>

    @include('front.profile.partials.subnav')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Invoices
            </h1>
            @forelse ($transactions as $transaction)
            @empty
                <p class="banner-intro">No invoices yet, take a look at <a class="link-underline link-blue" href="{{ route('products.index') }}">our products</a>.</p>
            @endforelse
        </div>
    </section>

    <section class="section section-group pt-0">
        <div class="wrap">
               
            @forelse ($transactions as $transaction)
                <div class="grid grid-cols-3 py-3 border-b-2 border-gray-lighter">
                    <span class="font-bold">{{ $transaction->paid_at->toFormattedDateString() }}</span>
                    <span>{{ $transaction->amount() }}</span>
                    <span><a class="link-underline link-blue" href="{{ $transaction->receipt_url }}" target="_blank">Download</a></span>
                </div>
            @empty
            @endforelse
        </div>
    </section>
</x-page>
