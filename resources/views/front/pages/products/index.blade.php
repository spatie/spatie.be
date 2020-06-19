<x-page
        title="Products"
        background="/backgrounds/home.jpg"
>
    @includeWhen($purchases && $purchases->isNotEmpty(), "front.pages.products.partials.purchases", ['purchases' => $purchases])

    <div class="section-group wrap flex grid grid-cols-3 gap-4">
        @foreach ($products as $product)
            <div class="block bg-white shadow p-4">
                <a href="{{ route('products.show', $product) }}">
                    {{ $product->getFirstMedia('product-image') }}
                    <h2>{{ $product->title }}</h2>
                    <p>{{ $product->description }}</p>
                </a>
                <a class="block" href="{{ $product->url }}">{{ $product->url }}</a>
                <a class="block" href="{{ $product->action_url }}">{{ $product->action_label }}</a>
            </div>
        @endforeach
    </div>
</x-page>
