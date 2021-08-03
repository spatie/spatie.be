@if ($purchases->count())
    <section id="purchases" class="wrap mb-16 pt-0">
        <h2 class="title line-after mb-12">My purchases</h2>

        @foreach ($purchases as $purchase)
            @php /** @var \App\Models\Purchase $purchase */ @endphp
            <div class="mb-8">
                <h3 class="title-sm">{{ $purchase->getPurchasablesForProduct($product)->first()->title }}</h3>
                @include('front.pages.products.partials.purchasedProduct', ['purchase' => $purchase])
            </div>
        @endforeach
    </section>
@endif

