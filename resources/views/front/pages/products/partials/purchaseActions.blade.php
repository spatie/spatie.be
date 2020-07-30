@if($purchasable->requires_license)
    <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
       class="link-blue link-underline">
        Manage licenses
    </a>
@else
    <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
       class="link-blue link-underline">
        Show details
    </a>
@endif

@if($purchasable->type === \App\Enums\PurchasableType::TYPE_VIDEOS)
    <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
       class="link-blue link-underline">
        Watch videos
    </a>
@endif
