<div class="relative flex flex-col border border-white/10 rounded-xl px-7 py-7">
    <span class="absolute top-0 right-0 mt-3 mr-3 px-2 py-0.5 rounded-full text-xs font-medium bg-oss-green/10 text-oss-green">Bundle</span>
    <h2 class="flex-0 font-pt font-medium text-white text-xl mb-4">
        {{ $bundle->title }}
    </h2>

    <div class="flex-grow markup markup-lists markup-lists-compact text-sm text-oss-gray-dark">
        <p>
            You can get a good deal when buying these products combined:
        </p>
        <ul>
            @foreach($bundle->purchasables as $purchasable)
                <li>
                @if($purchasable->product->title !== $product->title)
                <a class="font-semibold underline hover:text-white" href="{{ route('products.show', $purchasable->product) }}">{{ $purchasable->product->title }}
                </a>
                @else
                <span class="font-semibold text-white">{{ $purchasable->product->title }}</span>
                @endif
                </li>
            @endforeach
        </ul>
    </div>

    <div class="flex-0 mt-6">
        <div class="w-full">
            <a href="{{ route('bundles.show', $bundle) }}">
                <x-button>
                    <span>Buy bundle for&nbsp;</span>
                    <span>{{ $bundle->getPriceForCurrentRequest()->formattedPrice() }}</span>
                </x-button>
            </a>
        </div>
    </div>
</div>
