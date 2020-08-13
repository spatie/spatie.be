<span class="flex items-center">
    @if($purchasable->requires_license)
        <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
        class="link-blue link-underline">
            Manage license
        </a>
    @else
        <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
        class="link-blue link-underline">
            Show details
        </a>
    @endif

    @if($purchasable->type === \App\Enums\PurchasableType::TYPE_VIDEOS)
        <span class="mx-2 text-gray-light">|</span>
        <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
        class="link-blue link-underline">
            Watch course
        </a>
    @endif
</span>
