<div class="line-l">
    <a class="link-underline link-black" href="{{ route('products.show', $product) }}">
        <h2 class="title-sm">{{ $product->title }}</h2>
    </a>

    @foreach($purchasesForProduct as $purchase)
        @php
            /** @var \App\Models\Purchasable $purchasable */
            $purchasable = $purchase->purchasable;
        @endphp

        <div class="mt-4 flex justify-start">
            <a href="{{ route('products.show', $product) }}">
                {{ $purchasable->title }}
            </a>

            <span class="ml-4">
                @include('front.pages.products.partials.purchaseActions')
            </span>
        </div>
    @endforeach
</div>
