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
                    of the team
                </span>
            </h2>


            @foreach ($externalFeedItems->slice(0, 2) as $insight)
                <p class="mt-4">
                    <a class="link link-black" href="{{ $insight->url }}" target="_blank"
                       rel="noreferrer noopener">{{ $insight->title }}</a>
                    <br>
                    <span class="text-xs text-gray">
                    {{ $insight->created_at->format('M jS Y') }}
                    <span class="char-separator">•</span>
                    <a class="link-underline link-blue" href="{{ $insight->url }}" target="_blank"
                       rel="noreferrer noopener">{{ $insight->website }}</a>
                </span>
                </p>
            @endforeach
        </div>
        <div class="sm:col-span-3 | line-l">
            @foreach ($externalFeedItems->slice(2, 2) as $insight)
                <p class="mt-4">
                    <a class="link link-black" href="{{ $insight->url }}" target="_blank"
                       rel="noreferrer noopener">{{ $insight->title }}</a>
                    <br>
                    <span class="text-xs text-gray">
                       {{ $insight->created_at->format('M jS Y') }}
                       <span class="char-separator">•</span>
                       <a class="link-underline link-blue" href="{{ $insight->url }}" target="_blank"
                          rel="noreferrer noopener">{{ $insight->website }}</a>
                   </span>
                </p>
            @endforeach
        </div>
        <div>
            <a class="link-blue link-underline" href={{route('blog')}}>Read more</a>
        </div>
    </div>
</section>
