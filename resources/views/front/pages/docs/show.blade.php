@php
    /** @var \App\Docs\Repository $repository */
@endphp

<x-page title="{{ $page->title }} | {{ $repository->slug }}" background="/backgrounds/docs.jpg">
{{--    @push('head')--}}
{{--        <link--}}
{{--                rel="stylesheet"--}}
{{--                href="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.css"--}}
{{--        />--}}
{{--    @endpush--}}

    <x-slot name="description">
        {{ $repository->slug }}
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan flex items-center justify-between">
                {{ ucfirst($repository->slug) }}
                <div class="text-base font-normal leading-normal select">
                    <select name="alias">
                        @foreach($repository->aliases as $alias)
                            <option value="{{ $alias->slug }}">
                                {{ $alias->slug }} ({{ $alias->branch }})
                            </option>
                        @endforeach
                    </select>
                    <span class="select-arrow">
                    {{ svg('icons/far-angle-down') }}</span>
                </div>
            </h1>
            <div class="banner-intro ">
                {{ $alias->slogan }}
            </div>
        </div>
    </section>

    <section class="section pt-0">
        <div class="wrap">
            <div class="grid grid-cols-1 sm:grid-cols-3 sm:gap-16">
                <div class="col-span-1">
                    @include('front.pages.docs.partials.navigation')
                </div>
                <div class="col-span-2 markup markup-titles markup-lists markup-links markup-code">
                    <h2 class="title text-4xl">{{ $page->title }}</h2>

                    {!! $page->contents !!}

                    <p>
                        <a href="{{ $alias->githubUrl }}/blob/{{$alias->slug}}/docs/{{ $page->slug }}.md"
                           target="_blank">Edit on github</a>
                    </p>
                </div>
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

