<div class="mb-12 py-6 md:-mt-8 md:py-10 md:z-10 md:mb-0 md:mx-2 max-w-sm flex flex-col bg-white  shadow-lg px-8" style="bottom: -2rem">
    <h2 class="flex-0 flex items-center font-bold text-2xl mb-4 min-h-10">
        {{ $bundle->title }}
        <span class="bottom-full left-0 absolute px-1 bg-blue text-white text-xxs uppercase tracking-wider">Bundle promo</span>
    </h2>

    <div class="flex-grow markup markup-lists markup-lists-compact text-xs">
        <p>
            You can get a good deal when buying these products combined:
        </p>
        <ul>
            @foreach($bundle->purchasables as $purchasable)
                <li>
                @if($purchasable->product->title !== $product->title)
                <a class="link-black link-underline" href="{{ route('products.show', $purchasable->product) }}">{{ $purchasable->product->title }}
                </a>
                @else
                <span class="font-semibold">{{ $purchasable->product->title }}</span>
                @endif

                </li>
            @endforeach
        </ul>
    </div>


    <div class="flex-0 mt-6 flex justify-center">
        <div class="w-full flex justify-center">
            <a href="{{ route('bundles.show', $bundle) }}">
                <button class="cursor-pointer
bg-green-dark bg-opacity-75 hover:bg-opacity-100 rounded-sm
border-2 border-transparent
justify-center flex items-center
px-4 min-h-12 text-xl shadow-lg
font-sans-bold text-white
transition-bg duration-300
focus:outline-none focus:border-blue-light whitespace-no-wrap">
                    <span class="font-normal">Buy Bundle for&nbsp;</span>
                    <span>{{ $bundle->getPriceForCurrentRequest()->formattedPrice() }}</span>
                </button>
            </a>
        </div>
    </div>
</div>
