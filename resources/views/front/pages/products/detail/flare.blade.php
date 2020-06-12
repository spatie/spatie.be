<div class="wrap">
    <x-slot name="description">
        {{ $product->description }}
    </x-slot>

    This is the Flare specific blade template

    {{ $product->getFirstMedia('product-image') }}

    <h1>{{ $product->title }}</h1>

    {{ $product->description }}

    <a class="block" href="{{ $product->url }}">{{ $product->url }}</a>
    <a class="block" href="{{ $product->action_url }}">{{ $product->action_label }}</a>

</div>
