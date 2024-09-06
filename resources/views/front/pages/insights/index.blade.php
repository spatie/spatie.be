<x-page
    title="Insights"
    background="/backgrounds/blog-index.png"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
>
    <x-layout.wrapper class="mt-8 sm:mt-20 md:mt-28 px-7 lg:px-0">
        <x-headers.h1 class="text-right text-white">
            Insights
        </x-headers.h1>
    </x-layout.wrapper>

    @if($highlight)
        <x-insights.highlight :insight="$highlight" class="-mt-8" />
    @endif

    <x-layout.wrapper class="mt-20">
        <div class="flex">
            <h2 class="w-1/4 text-24 font-bold mt-9">More insights</h2>
            <div class="flex-1 flex flex-col gap-6">
                @foreach($insights as $insight)
                    <x-insights.list-item :insight="$insight" />
                @endforeach

            </div>
        </div>
        @if ($insights->hasMorePages())
            <div class="mt-6 w-3/4 ml-auto pl-9">
                <a href="{{ route('insights.all') }}" wire:navigate.hover class="flex w-full items-center justify-center py-6 text-blue bg-link-card-light border border-gray/25 rounded">
                    View more
                </a>
            </div>
        @endif
    </x-layout.wrapper>

    <x-layout.wrapper class="my-24">
        <livewire:newsletter />
    </x-layout.wrapper>

    @isset($externalFeedItems)
        <x-layout.wrapper class="mt-24 mb-20">
            <div class="flex">
                <h2 class="w-1/4 text-24 font-bold">From our team &&nbsp;products</h2>
                <div class="flex-1 flex flex-col gap-10 pl-9">
                    @foreach($externalFeedItems as $externalFeedItem)
                        @include('front.pages.insights.partials.externalFeedItem')
                    @endforeach
                </div>
            </div>
            @if ($externalFeedItems->hasMorePages())
                <div class="mt-6 w-3/4 ml-auto pl-9">
                    <a href="{{ route('external-feed-items') }}" wire:navigate.hover class="flex w-full items-center justify-center py-6 text-blue bg-link-card-light border border-gray/25 rounded">
                        View more
                    </a>
                </div>
            @endif
        </x-layout.wrapper>
    @endisset
</x-page>
