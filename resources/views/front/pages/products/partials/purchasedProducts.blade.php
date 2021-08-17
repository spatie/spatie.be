@if ($assignments->count())
    <section id="purchases" class="wrap mb-16 pt-0">
        <h2 class="title line-after mb-12">My purchases</h2>

        @foreach ($assignments as $assignment)
            @php /** @var \App\Models\PurchaseAssignment $assignment */ @endphp
            <div class="mb-8">
                <h3 class="title-sm">{{ $assignment->purchasable->title }}</h3>
                @include('front.pages.products.partials.purchasedProduct', ['assignment' => $assignment])
            </div>
        @endforeach
    </section>
@endif

