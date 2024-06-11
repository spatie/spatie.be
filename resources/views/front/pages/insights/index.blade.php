<x-page title="Insights" background="/backgrounds/blogs.jpg">
    <section id="banner" class="banner" role="banner">
        Insights
    </section>

    @if($firstPost)
       @include('front.pages.insights.partials.firstPostListItem', ['post' => $firstPost])
    @endif

    <h2>
        More insights
    </h2>

    <section >
        <div class="wrap">
            <div>
                @foreach($posts as $post)
                    @include('front.pages.insights.partials.postListItem')
                @endforeach
            </div>
        </div>
    </section>

    <livewire:newsletter />

    <h2>
        From our team & products
    </h2>

    @foreach($externalFeedItems as $externalFeedItem)
        @include('front.pages.insights.partials.externalFeedItem')
    @endforeach

    <a href="{{ route('external-feed-items') }}">View more</a>


</x-page>
