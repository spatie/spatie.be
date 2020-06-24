<div class="section-group wrap">
    <h2>Purchases</h2>

    <div>
        @foreach ($purchasesPerProduct as $productId => $purchasesForProduct)
            @php
                /** @var \App\Models\Product $product */
                $product = $purchasesForProduct->first()->purchasable->product;
            @endphp

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

                        @if($purchasable->requires_license)
                            <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
                               class="bg-grey-lighter p-2">
                                Manage licenses
                            </a>
                        @else
                            <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
                               class="bg-grey-lighter p-2">
                                Show details
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
