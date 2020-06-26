@push('head')
    @paddleJS
@endpush

<x-page
        :title="$product->title"
        background="/backgrounds/home.jpg"
>
    @auth
        <div class="wrap">
            @if($product->requiresLicense())
                <h2>Licenses</h2>

                <ul>
                @foreach($purchases->where('purchasable.requires_license', true) as $purchase)
                    <li>{{ $purchase->purchasable->title }}</li>
                @endforeach
                </ul>
            @endif
        </div>
    @endauth

    @includeFirst(["front.pages.products.detail.{$product->slug}", "front.pages.products.detail.default"])
</x-page>
