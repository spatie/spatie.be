<div class="block bg-white shadow p-4 mb-4">
    <a href="{{ route('products.show', $product) }}">
        <h2>{{ $product->title }}</h2>
    </a>

    @foreach($purchasesForProduct as $purchase)
        @php
            /** @var \App\Models\Purchasable $purchasable */
            $purchasable = $purchase->purchasable;
        @endphp

        <div class="flex justify-between">
            <a href="{{ route('products.show', $product) }}">
                <h2>{{ $purchasable->title }}</h2>
            </a>

            @include('front.pages.products.partials.purchaseActions')
        </div>
    @endforeach
</div>
