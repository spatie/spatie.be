@if(Illuminate\Support\Str::startsWith($tag->name, 'purchased-'))
    @if(Illuminate\Support\Str::startsWith($tag->name, 'purchased-purchasable-'))
        <span class="tag">
            <i class="fas fa-shopping-cart inline-block -ml-2 py-1 px-2 mr-1 rounded-full bg-blue-400"></i>
            {{ str_replace(['purchased-product-', 'purchased-purchasable-'], '', $tag->name) }}
        </span>
    @endif
@else
    <span class="tag">{{ $tag->name }}</span>
@endif
