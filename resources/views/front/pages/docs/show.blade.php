@php
    /** @var \App\Docs\Repository $repository */
@endphp

<x-page title="{{ $page->title }} | {{ $repository->slug }}" background="/backgrounds/docs-blur.jpg">
{{--    @push('head')--}}
{{--        <link--}}
{{--                rel="stylesheet"--}}
{{--                href="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.css"--}}
{{--        />--}}
{{--    @endpush--}}

    <x-slot name="description">
        {{ $repository->slug }}
    </x-slot>

    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4">
                <a href="{{ route('docs')}}" class="link-underline link-blue">Docs</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                <span>{{ ucfirst($repository->slug) }}</span>
                @foreach($navigation as $key => $section)
                    @foreach($section['pages'] as $navItem)
                        @if($page->slug === $navItem->slug)
                            <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                            <span>{{ $navItem->title }}</span>
                        @endif
                    @endforeach
                @endforeach
            </p>
        </div>
    </section>

    <section class="wrap grid pb-24 gap-8 md:grid-cols-3 items-stretch">
        <div class="z-10 | print:hidden">
             @include('front.pages.docs.partials.navigation')
        </div>
        <div class="md:col-span-2">
            {{-- Only show for intro page --}}
            <div class="mb-16">
                <h1 class="banner-slogan text-6xl">
                    {{ ucfirst($repository->slug) }}
                </h1>
                <div class="banner-intro flex items-center justify-start">
                    {{ $alias->slogan }}  
                </div>
            </div>
            <h2 class="title text-4xl mb-8">{{ $page->title }}</h2>

            {{-- Else
                <h1 class="title text-4xl mb-8">{{ $page->title }}</h1>
            --}}

            {{-- Endif --}}

            <div class="markup-titles markup-lists markup-code links-blue links-underline">
                {!! $page->contents !!}
            </div>
        </div>
    </section>

    

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

