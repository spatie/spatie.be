<x-page title="Blog" background="/backgrounds/blogs.jpg">
    <!-- @todo replace background -->

    <section id="banner" class="banner" role="banner">
        Insights
    </section>

    @if($firstPost)
       @include('front.pages.insights.partials.firstPostListItem', ['post' => $firstPost])
    @endif

    <h2>
        More insights
    </h2>

    <section class="section section-group">
        <div class="wrap">
            <div class="max-w-md grid gap-6">
                @foreach($posts as $post)
                    @include('front.pages.insights.partials.postListItem')
                @endforeach
            </div>
            <div class="mt-12">
                {{ $posts->onEachSide(1)->links() }}
            </div>
        </div>
    </section>

    <livewire:newsletter />

    <h2>
        From our team & products
    </h2>

    @foreach($externalFeedItems as $externalFeedItem)
        @include('front.pages.insights.partials.externalFeedItems')
    @endforeach


</x-page>
