@php
    /** @var \App\Docs\Repository $repository */
    $latestVersion = $repository->aliases->first()
@endphp

<x-page
    title="{{ $page->title }} | {{ $repository->slug }}"
    background="/backgrounds/docs-blur.jpg"
    :no-index="$page->alias !== $latestVersion->slug"
    canonical="{{ url('/docs/' . $repository->slug . '/' . $latestVersion->slug . '/' . $page->slug) }}"
>
    <x-slot name="description">
        {{ $repository->slug }}
    </x-slot>

    @include('front.pages.docs.partials.breadcrumbs')

    <section class="wrap md:grid pb-24 gap-12 md:grid-cols-10 items-stretch">
        <div class="z-10 | md:col-span-3 | lg:col-span-2 | print:hidden">
            @include('front.pages.docs.partials.navigation')
        </div>
        <article class="md:col-span-7 lg:col-span-6">
            @if(count($repository->aliases) > 1)
                <div class="mb-12 p-4 flex text-sm bg-white bg-opacity-50 rounded-sm md:shadow-light markup-shiki">
                    <div
                        class="flex-none h-6 w-6 text-orange fill-current">{{ svg('icons/fal-exclamation-circle') }}</div>
                    <div class="ml-4">
                        <p>
                            This is the documentation for
                            <strong>{{ $page->alias }}</strong>@if($page->alias !== $latestVersion->slug)
                                but the latest version is
                                <strong>{{ $latestVersion->slug }}</strong>
                            @endif.
                            You can switch versions in the menu <span class="hidden md:inline">on the left</span><span
                                class="hidden">/</span><span class="inline md:hidden">at the top</span>.
                            Check your current version with the following command:
                        </p>
                        <div class="mt-2">
                            <code class="bg-blue-lightest bg-opacity-50 px-2 py-1">
                                composer show spatie/{{ $repository->slug }}
                            </code>
                        </div>
                    </div>
                </div>
            @endif

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

            <div id="site-search-docs-content">
                <div class="markup markup-titles markup-lists markup-tables markup-shiki markup-embeds
             links-blue links-underline">
                    {!! $page->contents !!}
                </div>
            </div>

        </article>
        @if(count($tableOfContents))
            <aside class="hidden lg:block w-full pb-16 col-span-2 print-hidden">
                <div class="sticky top-0 py-6">
                    <div class="pl-4 border-l-2 border-gray-light border-opacity-50">
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

    @livewire('spotlight')
</x-page>

