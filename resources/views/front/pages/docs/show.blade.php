@php
    /** @var \App\Docs\Repository $repository */
@endphp

<x-page title="{{ $page->title }} | {{ $repository->slug }}" background="/backgrounds/docs-blur.jpg">

    <x-slot name="description">
        {{ $repository->slug }}
    </x-slot>

    @include('front.pages.docs.partials.breadcrumbs')

    <section class="wrap md:grid pb-24 gap-12 md:grid-cols-10 items-stretch">
        <div class="z-10 | md:col-span-3 | print:hidden">
             @include('front.pages.docs.partials.navigation')
        </div>
        <div class="md:col-span-7">

            @if($showBigTitle)
                <div class="mb-16">
                    <h1 class="banner-slogan">
                        {{ ucfirst($repository->slug) }}
                    </h1>
                    <div class="banner-intro flex items-center justify-start">
                        {{ $alias->slogan }}
                    </div>
                </div>

                <h2 class="title-xl mb-8">{{ $page->title }}</h2>

            @else
                <h1 class="title-xl mb-8">{{ $page->title }}</h1>
            @endif

            <div class="markup markup-titles markup-lists markup-tables markup-code links-blue links-underline">
                {!! $page->contents !!}
            </div>
        </div>
    </section>

    {{-- @include('front.pages.docs.banners.randomBanner', ['repository' => $repository]) --}}

    <script src="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.js"></script>

    <script>
        docsearch({
            apiKey: '7a1f56fb06bd42e657e82bdafe86cef3',
            indexName: 'spatie_be',
            inputSelector: '#algolia-search',
            debug: true,

            algoliaOptions: {
                'hitsPerPage': 5,
                'facetFilters': ['project:{{ $repository->slug }}', 'version:{{ $alias->slug }}']
            }
        });
    </script>
</x-page>

