<x-page title="Insights" background="/backgrounds/blogs.jpg" main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140">
    <x-layout.wrapper class="mt-8 sm:mt-20 md:mt-28 px-7 lg:px-0">
        <x-headers.h1 class="text-right text-white">
            Insights
        </x-headers.h1>
    </x-layout.wrapper>

    @if($highlight)
        <x-insights.highlight :insight="$highlight" class="-mt-8" />
    @endif

    <x-layout.wrapper class="flex mt-20">
        <h2 class="w-1/4 text-24 font-bold">More insights</h2>
        <div class="flex-1 flex flex-col gap-16">
            @foreach($insights as $insights)
                <x-insights.list-item :insight="$insights" />
            @endforeach
        </div>
    </x-layout.wrapper>

    <x-layout.wrapper>
        <livewire:newsletter />
    </x-layout.wrapper>

    <h2>
        From our team & products
    </h2>

    @foreach($externalFeedItems as $externalFeedItem)
        @include('front.pages.insights.partials.externalFeedItem')
    @endforeach

    <a href="{{ route('external-feed-items') }}">View more</a>


</x-page>
