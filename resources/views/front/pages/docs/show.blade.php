@php
    /** @var \App\Docs\Repository $repository */
    $latestVersion = $repository->aliases->first()
@endphp

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-clipboard@2.x.x/dist/alpine-clipboard.js"
            defer></script>
@endpush
<x-page
    title="{{ $page->title }} | {{ $repository->slug }}"
    body-class="bg-oss-gray font-pt antialiased font-medium text-oss-royal-blue leading-[1.4]"
    :no-index="$page->alias !== $latestVersion->slug"
    canonical="{{ url('/docs/' . $repository->slug . '/' . $latestVersion->slug . '/' . $page->slug) }}"
>
    <x-slot name="description">
        {{ $repository->slug }}
    </x-slot>

    <div class="px-3 sm:px-12">
        @include('front.pages.docs.partials.breadcrumbs')

        <section class="max-w-screen-xl mx-auto w-full md:grid pb-24 gap-16 md:grid-cols-10 items-stretch md:mt-10">
            <div class="z-10 | md:col-span-3 | lg:col-span-2 | print:hidden">
                @include('front.pages.docs.partials.navigation')
            </div>
            <article class="md:col-span-7 lg:col-span-6">
                @if($repository->aliases->first()->slug !== $alias->slug)
                    <div class="mb-10 p-5 flex text-sm bg-oss-green-pale rounded-[8px] markup-code">
                        <svg class="w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 36 36">
                            <rect width="36" height="36" fill="#fff" fill-opacity=".4" rx="18"/>
                            <path fill="#0A8867"
                                  d="M22.931 17.667A5.937 5.937 0 0 0 24 14.25a6 6 0 1 0-12 0c0 1.275.394 2.452 1.069 3.417.173.249.38.53.6.83.604.83 1.326 1.823 1.865 2.803.488.89.736 1.819.858 2.695H14.11a5.377 5.377 0 0 0-.553-1.617c-.464-.844-1.04-1.636-1.617-2.428a49.073 49.073 0 0 1-.722-1.003A8.199 8.199 0 0 1 9.75 14.25a8.25 8.25 0 1 1 15.028 4.702c-.234.337-.478.67-.722 1.003-.576.787-1.153 1.58-1.617 2.428A5.377 5.377 0 0 0 21.886 24h-2.273c.121-.877.37-1.81.857-2.695.54-.98 1.261-1.974 1.866-2.803.22-.3.422-.582.595-.83v-.005ZM18 12a2.25 2.25 0 0 0-2.25 2.25c0 .412-.338.75-.75.75a.752.752 0 0 1-.75-.75A3.749 3.749 0 0 1 18 10.5c.413 0 .75.338.75.75s-.337.75-.75.75Zm0 18a3.749 3.749 0 0 1-3.75-3.75v-.75h7.5v.75A3.749 3.749 0 0 1 18 30Z"/>
                        </svg>
                        <div class="ml-4">
                            <p>
                                You are viewing the documentation for <strong>an older version</strong> of this package.
                                You can check the version you are using with the following command:
                            </p>
                            <div class="mt-4">
                                <code class="rounded bg-white/80 px-3 py-1.5">
                                    composer show spatie/{{ $repository->slug }}
                                    <button class="h-4 w-3 text-oss-gray-dark" x-data x-on:click="() => {
                                        $el.classList.remove('text-oss-gray-dark');
                                        $el.classList.add('text-blue');
                                        $clipboard('composer show spatie/{{ $repository->slug }}');
                                        setTimeout(() => {
                                            $el.classList.add('text-oss-gray-dark');
                                            $el.classList.remove('text-blue');
                                        }, 1000)
                                    }">
                                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 14 16">
                                            <path d="m11 0 3 3v9H5V0h6ZM2 4h2v2H2v8h6v-1h2v3H0V4h2Z"/>
                                        </svg>
                                    </button>
                                </code>
                            </div>
                        </div>
                    </div>
                @endif

                @if($showBigTitle)
                    @if($showBrandedHeader)
                        @include('front.pages.docs.partials.branded-header')
                    @else
                        @include('front.pages.docs.partials.big-title')
                    @endif
                    <h2 class="text-[36px] font-bold mb-5">{{ $page->title }}</h2>
                @else
                    <h1 class="text-[36px] font-bold mb-6 leading-none">{{ $page->title }}</h1>
                @endif

                @if(count($tableOfContents))
                    <div class="lg:hidden mb-8">
                        <h3 class="text-base font-bold mb-2">
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
                    <div class="markup markup-titles markup-lists markup-tables markup-embeds markup-code links-blue links-underline content-markup text-base md:text-lg">
                        {!! $page->contents !!}
                    </div>
                </div>

                <div
                    class="border border-gray/25 p-6 rounded-md mt-10 flex justify-between items-center bg-link-card-light md:text-lg">
                    <div class="w-full">
                        @if($prevPage)
                            <a class="flex items-center gap-x-2 text-blue hover:underline" href="{{ $prevPage->url }}"
                               wire:navigate.hover>
                                <svg class="w-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12">
                                    <path fill="#197593"
                                          d="m.313 5.623.53.53 4.5 4.5.531.532 1.062-1.062-.53-.53-3.97-3.97 3.968-3.97.532-.53L5.874.062l-.53.532-4.5 4.5-.531.53Z"/>
                                </svg>
                                <span class="leading-none mb-px">{{ $prevPage->title }}</span>
                            </a>
                        @endif
                    </div>
                    <div class="h-5 w-px bg-oss-gray-dark"></div>
                    <div class="w-full flex justify-end">
                        @if($nextPage)
                            <a class="flex items-center gap-x-2 text-blue hover:underline" href="{{ $nextPage->url }}"
                               wire:navigate.hover>
                                <span class="leading-none mb-px">{{ $nextPage->title }}</span>
                                <svg class="w-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12">
                                    <path fill="#197593"
                                          d="m6.686 5.623-.53.53-4.5 4.5-.532.532-1.062-1.062.53-.53 3.97-3.97-3.967-3.97-.532-.53L1.123.062l.53.53 4.5 4.5.532.531Z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
                <a href="{{ $alias->githubUrl }}/blob/{{$alias->branch}}/docs/{{ $page->slug }}.md" target="_blank"
                   class="ml-auto inline-flex items-center gap-3 mt-10 hover:underline lg:hidden">
                    <span class="w-5 h-5">
                        {{ app_svg('github') }}
                    </span>
                    <span>
                        Help us improve this page
                    </span>
                </a>
            </article>
            <aside class="hidden lg:block w-full pb-16 col-span-2 print-hidden">
                <div class="sticky top-[1rem]">
                    @if(count($tableOfContents))
                        <h3 class="text-base font-bold mb-2">
                            On this page
                        </h3>
                        <ul class="grid gap-2 mb-10">
                            @foreach($tableOfContents as $fragment => $title)
                                <li class="text-sm">
                                    <a href="#{{ $fragment }}" class="docs-submenu-item">
                                        {{ $title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @include('components.banners.randomBanner', ['repository' => $repository])

                    <a href="{{ $alias->githubUrl }}/blob/{{$alias->branch}}/docs/{{ $page->slug }}.md" target="_blank"
                       class="text-sm inline-flex items-center gap-3 mt-10 hover:underline">
                        <span class="w-5 h-5">
                            {{ app_svg('github') }}
                        </span>
                        <span>
                            Help us improve this page
                        </span>
                    </a>
                </div>
            </aside>
        </section>
    </div>

    @livewire('spotlight')
</x-page>

