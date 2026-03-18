<div class="mb-12 py-6 md:py-10 md:z-10 md:mb-0 max-w-sm flex flex-col bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] px-8">
    <span class="top-0 mt-3 left-0 absolute pl-8 pr-3 py-1 rounded-br-lg text-xxs font-semibold uppercase tracking-widest" style="background: rgba(130,216,175,0.2); color: #82D8AF;">Bundle promo</span>
    <h2 class="flex-0 font-bold text-white text-2xl leading-tight mb-4 min-h-10">
        {{ $bundle->title }}
    </h2>

    <div class="flex-grow markup markup-lists markup-lists-compact text-xs text-oss-gray">
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

    <div class="flex-0 mt-6 flex justify-center">
        <div class="w-full flex justify-center">
            <a href="{{ route('bundles.show', $bundle) }}">
                <x-button large>
                    <span class="font-normal">Buy Bundle for&nbsp;</span>
                    <span>{{ $bundle->getPriceForCurrentRequest()->formattedPrice() }}</span>
                </x-button>
            </a>
        </div>
    </div>
</div>
