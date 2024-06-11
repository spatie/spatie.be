<x-page title="From our team and products" background="/backgrounds/blogs.jpg">
    <h1>From our team and products</h1>


    @foreach($externalFeedItems as $externalFeedItem)
        @include('front.pages.insights.partials.externalFeedItem')
    @endforeach

    {{ $externalFeedItems->links() }}
</x-page>
