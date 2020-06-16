<div class="section-group wrap flex grid grid-cols-3 gap-4">
    @foreach ($purchases as $purchase)
        @php
            $product = $purchase->product
        @endphp

        <div class="block bg-white shadow p-4">
            <a href="{{ route('products.show', $purchase->product) }}">
                {{ $product->getFirstMedia('product-image') }}
                <h2>{{ $product->title }}</h2>
                <p>{{ $product->description }}</p>
            </a>
            <a class="block" href="{{ $product->url }}">{{ $product->url }}</a>
            <a class="block" href="{{ $product->action_url }}">{{ $product->action_label }}</a>
        </div>
    @endforeach
</div>
