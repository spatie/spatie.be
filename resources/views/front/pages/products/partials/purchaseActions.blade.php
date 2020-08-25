<span class="flex items-center">
    @if(true or $purchasable->type === \App\Enums\PurchasableType::TYPE_VIDEOS)
        <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
        class="link-blue link-underline">
            Watch course
        </a>
    @endif
</span>
