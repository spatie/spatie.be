<x-page
    title="Invoices"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    <?php /** @var \Laravel\Paddle\Transaction $transaction */?>

    @include('layout.partials.gradient-background', [
        'color1' => '#50E69B',
        'color2' => '#197593',
        'color3' => '#735AFF',
        'rotationZ' => '50',
        'positionX' => '-1.0',
        'positionY' => '-0.3',
        'uDensity' => '1.8',
        'uFrequency' => '3.8',
        'uStrength' => '2.2',
    ])

    @include('front.profile.partials.subnav')

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 pb-20">
        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-16">
            <h1 class="font-druk uppercase text-[50px] sm:text-[72px] leading-[0.9] font-bold mb-10">Invoices</h1>

            @forelse ($transactions as $transaction)
                @if($transaction->purchase)
                    <div class="grid grid-cols-4 py-3 border-b border-white/10">
                        <span class="font-bold">{{ $transaction->paid_at->toFormattedDateString() }}</span>
                        @if ($transaction->purchase->purchasable_id)
                            <span>{{ $transaction->purchase->purchasable->product->title }} - {{ $transaction->purchase->purchasable->title }}</span>
                        @elseif($transaction->purchase->bundle_id)
                            <span>{{ $transaction->purchase->bundle->title }}</span>
                        @endif
                        <span>{{ $transaction->amount() }}</span>
                        <span><a class="underline hover:text-white" href="{{ $transaction->receipt_url }}" target="_blank">Download</a></span>
                    </div>
                @endif
            @empty
                <p class="text-xl">No invoices yet, take a look at <a class="underline hover:text-white" href="{{ route('products.index') }}">our products</a>.</p>
            @endforelse
        </section>
    </div>
</x-page>
