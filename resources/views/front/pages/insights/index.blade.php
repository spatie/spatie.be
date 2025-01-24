<x-page
    title="Insights"
    background="/backgrounds/blog-index.png"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
>
    <header class="wrapper-lg sm:mt-20 md:mt-28">
        <x-headers.h1 class="text-right text-white">
            Blog
        </x-headers.h1>
    </header>

    @if($highlight)
        <article class="wrapper-lg flex flex-col sm:flex-row gap-8 sm:gap-16 mt-8">
            <a href="{{ route('insights.show', $highlight->slug) }}" class="flex-shrink-0">
                @if ($highlight->header_image)
                    <img
                        src="{{ $highlight->header_image }}"
                        alt="{{ $highlight->title }}"
                        class="w-[220px] h-[220px] sm:w-[440px] sm:h-[440px] object-cover rounded-8"
                    >
                @else
                    <div class="w-[220px] h-[220px] sm:w-[440px] sm:h-[440px] bg-oss-green-pale rounded-8"></div>
                @endif
            </a>
            <div class="sm:pt-24 flex flex-col gap-6 sm:gap-9">
                <p class="flex items-center gap-3 text-sm">
                    <a href="{{ route('insights.show', $highlight->slug) }}" class="bg-oss-green-pale font-semibold rounded-8 px-2 py-1.5">
                        Latest post
                    </a>
                    <a href="{{ route('insights.show', $highlight->slug) }}">
                        <time datetime="{{ $highlight->date->format('Y-m-d') }}">
                            {{ $highlight->date->format('F d, Y') }}
                        </time>
                    </a>
                </p>
                <x-headers.h2>
                    <a href="{{ route('insights.show', $highlight->slug) }}" class="hover:text-oss-spatie-blue">
                        {{ $highlight->title }}
                    </a>
                </x-headers.h2>
                <div>
                    {!! $highlight->summary !!}
                </div>
            </div>
        </article>
        <hr class="sm:hidden mx-3 my-16 h-px bg-oss-gray-medium">
    @endif

    @if($posts->isNotEmpty())
        <div class="wrapper-lg mt-12 sm:mt-16 lg:mt-32">
            <div class="grid sm:grid-cols-[1fr,2fr] gap-8">
                <h2 class="hidden sm:block text-24 font-bold pt-9">More posts</h2>
                <div class="grid gap-16">
                    @foreach($posts as $post)
                        <x-insights.list-item :insight="$post" />
                        @if(!$loop->last)
                            <hr class="sm:hidden h-px bg-oss-gray-medium">
                        @endif
                    @endforeach
                    @if ($posts->hasMorePages())
                        <a href="{{ route('insights.all') }}" wire:navigate.hover class="flex w-full items-center justify-center py-6 text-blue bg-link-card-light border border-gray/25 rounded">
                            View more
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="wrapper-lg my-16">
        <livewire:newsletter />
    </div>

    @isset($externalFeedItems)
        <div class="wrapper-lg mt-24 mb-20">
            <div class="grid sm:grid-cols-[1fr,2fr] gap-8">
                <h2 class="text-24 font-bold leading-snug text-center sm:text-left">From our team <br class="hidden sm:inline"> &&nbsp;products</h2>
                <div class="pt-1.5 grid gap-8">
                    @foreach($externalFeedItems as $externalFeedItem)
                        @include('front.pages.insights.partials.externalFeedItem')
                    @endforeach
                    @if($externalFeedItems->hasMorePages())
                        <p class="pt-2">
                            <a href="{{ route('external-feed-items') }}" wire:navigate.hover class="flex w-full items-center justify-center py-4 text-blue bg-link-card-light border border-gray/25 rounded">
                                View more
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endisset
</x-page>
