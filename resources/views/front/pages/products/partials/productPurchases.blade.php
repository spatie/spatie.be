<div class="mb-8">

        <div class="flex items-baseline space-x-4">
            <h2 class="title-sm mb-0">
                {{ $product->title }}     
            </h2>

            <a href="{{ route('products.show', $product) }}#purchases"
            class="link-blue link-underline">
                Manage 
                {{ \Illuminate\Support\Str::plural('purchase', $purchasesForProduct->count()) }}
            </a>

            @if ($purchasesForProduct->filter(fn (\App\Models\Purchase $purchase) => $purchase->hasAccessToVideos())->count() > 0)
                <span class="mx-2 text-gray-light">|</span>
                <a href="{{ $purchasesForProduct->first()->purchasable->series->first()->url }}" class="link-blue link-underline">
                    Watch course
                </a>
            @endif
        </div>


    @foreach($purchasesForProduct as $purchase)
        @php
            /** @var \App\Models\Purchasable $purchasable */
            $purchasable = $purchase->purchasable;
        @endphp

        @if ($purchase->license)
        <div class="cells">
            <div class="cell-l">
                <a class="link-black link-underline" href="{{ route('products.show', $product) }}#purchases">
                    {{ $purchasable->title }}
                </a>
                
                <div class="text-xs text-gray">
                    @if ($purchase->license->domain)
                        {{ $purchase->license->domain }}
                        <span class="char-searator mx-1">•</span>
                    @endif
                    @if ($purchase->license->isExpired())
                        <span class="text-pink-dark">Expired since {{ $purchase->license->expires_at->format('Y-m-d') }}</span>
                    @else
                        Valid until {{ $purchase->license->expires_at->format('Y-m-d') }}
                    @endif
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>
