<section id="news">
    {{--
    <div class="wrap gap-y-0 items-end">
        <div class="mb-8 flex items-start">
            <a href="{{ route('vacancies.index') }}" class="text-2xl px-4 -my-2 py-2 bg-blue-darker hover:bg-blue-dark text-white rounded-sm">
                <strong class="font-semibold">Now hiring</strong>: JavaScript Developer
            </a>
        </div>
    </div>
    --}}

    <div class="wrap wrap-6 gapy-0 items-end">
        <div class="sm:col-span-3 | line-l">
            <h2 class="title-sm">
                <a href={{route('blog')}}>News &amp; insights</a>
                <span class="title-subtext text-pink-dark block">
                    from our blog, team, and products
                </span>
            </h2>

            @if($latestBlogPost)
                @include('front.pages.home.partials.newsItem', [
                    'url' => route('blog.show', $latestBlogPost->slug),
                    'title' => $latestBlogPost->title,
                    'date' => $latestBlogPost->date,
                    'website' => 'spatie.be',
                ])
            @endif
            @foreach($externalFeedItems->slice(...($latestBlogPost ? [0, 1] : [0, 2])) as $insight)
                @include('front.pages.home.partials.newsItem', [
                    'url' => $externalFeedItems->first()->url,
                    'title' => $externalFeedItems->first()->title,
                    'date' => $externalFeedItems->first()->created_at,
                    'website' => $externalFeedItems->first()->website,
                ])
          @endforeach
        </div>
        <div class="sm:col-span-3 | line-l">
            @foreach($externalFeedItems->slice(...($latestBlogPost ? [1, 2] : [2, 2])) as $insight)
                @include('front.pages.home.partials.newsItem', [
                    'url' => $insight->url,
                    'title' => $insight->title,
                    'date' => $insight->created_at,
                    'website' => $insight->website,
                ])
            @endforeach
        </div>
        <div>
            <a class="link-blue link-underline" href={{route('blog')}}>Read more</a>
        </div>
    </div>
</section>
