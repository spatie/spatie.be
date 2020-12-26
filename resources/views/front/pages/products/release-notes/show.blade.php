<x-page
    :title="$product->title . ' release notes'"
    background="/backgrounds/product-blur.jpg"
>
    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4 links-underline links-blue">
                <a href="{{ route('products.index')}}">Products</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                <a href="{{ route('products.show', $product) }}">{{ $product->title }}</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                <span>Release notes</span>
            </p>
        </div>
    </section>

    <section id="banner" class="md:pt-0 banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $product->title }}
            </h1>
            <div class="banner-intro">
                Release notes
            </div>
        </div>
    </section>

    @foreach($releases as $release)
        <section class="wrap mb-16 pt-0">
            <h2 id="{{ $release->version }}" class="title line-after mb-12">{{ $release->version }}
                @if($release->released_at)
                - {{ $release->released_at->format('Y-m-d') }}
                @endif
            </h2>

            {!! $release->notes_html !!}
        </section>
    @endforeach
</x-page>
