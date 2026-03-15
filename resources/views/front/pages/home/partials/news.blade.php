<section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
    <h2 class="font-druk uppercase text-white text-[40px] sm:text-[72px] leading-[0.9] mb-10">
        News &amp;<wbr/> insights
    </h2>

    <div class="grid sm:grid-cols-2 gap-8">
        <div>
            @if($latestBlogPost)
                <a class="block group" href="{{ route('blog.show', $latestBlogPost->slug) }}">
                    <span class="text-lg font-bold group-hover:underline">{{ $latestBlogPost->title }}</span>
                    <span class="block text-sm text-oss-gray-dark mt-1">
                        {{ $latestBlogPost->date->format('M jS Y') }} &bull; spatie.be
                    </span>
                </a>
            @endif
            @foreach($externalFeedItems->slice(...($latestBlogPost ? [0, 1] : [0, 2])) as $insight)
                <a class="block group mt-6" href="{{ $externalFeedItems->first()->url }}" target="_blank" rel="noreferrer noopener">
                    <span class="text-lg font-bold group-hover:underline">{{ $externalFeedItems->first()->title }}</span>
                    <span class="block text-sm text-oss-gray-dark mt-1">
                        {{ $externalFeedItems->first()->created_at->format('M jS Y') }} &bull; {{ $externalFeedItems->first()->website }}
                    </span>
                </a>
            @endforeach
        </div>
        <div>
            @foreach($externalFeedItems->slice(...($latestBlogPost ? [1, 2] : [2, 2])) as $insight)
                <a class="block group @unless($loop->first) mt-6 @endunless" href="{{ $insight->url }}" target="_blank" rel="noreferrer noopener">
                    <span class="text-lg font-bold group-hover:underline">{{ $insight->title }}</span>
                    <span class="block text-sm text-oss-gray-dark mt-1">
                        {{ $insight->created_at->format('M jS Y') }} &bull; {{ $insight->website }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <a class="inline-flex items-center gap-x-2 mt-8 underline hover:text-white" href="{{ route('blog') }}">
        <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
        <span>Read more</span>
    </a>
</section>
