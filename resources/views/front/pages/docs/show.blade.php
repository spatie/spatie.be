@php
    /** @var \App\Docs\Repository $repository */
@endphp

<x-page title="{{ $page->title }} | {{ $repository->slug }}" background="/backgrounds/docs-blur.jpg">

    <x-slot name="description">
        {{ $repository->slug }}
    </x-slot>

    @include('front.pages.docs.partials.breadcrumbs')

    <section class="wrap md:grid pb-24 gap-12 md:grid-cols-10 items-stretch">
        <div class="z-10 | md:col-span-3 | lg:col-span-2 | print:hidden">
             @include('front.pages.docs.partials.navigation')
        </div>
        <article class="md:col-span-7 lg:col-span-6">
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

            @if(count($tableOfContents))
                <div class="lg:hidden p-6 bg-blue-lightest rounded-sm bg-opacity-25 mb-8">
                    <h3 class="mb-2 text-gray font-semibold uppercase tracking-wider text-xs">
                        On this page
                    </h3>
                    <ol class="grid gap-1">
                        @foreach($tableOfContents as $fragment => $title)
                            <li class="text-sm">
                                <a href="#{{ $fragment }}">
                                    {{ $title }}
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endif

            <div class="markup markup-titles markup-lists markup-tables markup-code links-blue links-underline">
                {!! $page->contents !!}
            </div>

        </article>
        @if(count($tableOfContents))
            <aside class="hidden lg:block pt-16 w-full pb-16 col-span-2 print-hidden">
                <div class="sticky top-0 py-6">
                    <div class="pl-4 border-l-2 border-gray-lighter">
                        <h3 class="mb-3 text-gray font-semibold uppercase tracking-wider text-xs">
                            On this page
                        </h3>
                        <ul class="grid gap-2">
                            @foreach($tableOfContents as $fragment => $title)
                                <li class="text-sm">
                                    <a href="#{{ $fragment }}" class="docs-submenu-item">
                                        {{ $title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>
        @endif
    </section>

     @include('front.pages.docs.banners.randomBanner', ['repository' => $repository])

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

