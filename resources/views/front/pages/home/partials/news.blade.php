<div class="space-y-8 mt-2">
    @foreach($newsItems as $newsItem)
        @include('front.pages.home.partials.newsItem', ['newsItem' => $newsItem])
    @endforeach
</div>
