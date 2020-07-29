@if($purchasable->requires_license)
    <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
       class="bg-gray-lighter p-2">
        Manage licenses
    </a>
@else
    <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
       class="bg-gray-lighter p-2">
        Show details
    </a>
@endif

@if($purchasable->type === \App\Enums\PurchasableType::TYPE_VIDEOS)
    <a href="{{ action([\App\Http\Controllers\ProductsController::class, 'show'], $product) }}"
       class="bg-gray-lighter p-2">
        Watch videos
    </a>
@endif
