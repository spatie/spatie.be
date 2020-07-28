<x-page
        title="Products"
        background="/backgrounds/home.jpg"
>
    @auth
        @includeWhen($purchasesPerProduct->isNotEmpty(), "front.pages.products.partials.purchases", ['purchasesPerProduct' => $purchasesPerProduct])
    @endauth

    <div class="section section-group wrap flex grid grid-cols-3 gap-4">
        @foreach ($products as $product)
            <div class="flex flex-col bg-white shadow">
                <a class="mb-4" href="{{ route('products.show', $product) }}">
                    {{ $product->getFirstMedia('product-image') }}
                    <div class="p-4">
                        <h2 class="text-2xl mb-2">{{ $product->title }}</h2>
                        <p class="text-base">{{ $product->description }}</p>
                    </div>
                </a>
                <a class="text-blue underline px-4 mb-4" href="{{ $product->url }}">{{ $product->url }}</a>
                <a class="mr-auto mt-auto ml-4 mb-4 bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" href="{{ $product->action_url }}">{{ $product->action_label }}</a>
            </div>
        @endforeach
    </div>
</x-page>
