<section id="news">
    <div class="wrap wrap-6 gapy-0 items-end">
        <div class="sm:col-span-3 | line-l">
            <h2 class="title-sm">
                <a href={{route('blog')}}>News &amp; insights</a>
                <span class="title-subtext text-pink-dark block">
                    of the team
                </span>
            </h2>

            {{--
            <p class="mt-4">
                <a class="llink link-black" href="{{ route('vacancies.show', 'frontend-designer') }}"><strong class="font-semibold">Now hiring</strong>: Frontend designer</a>
                <br>
                <span class="text-xs text-gray">Antwerp / Partially remote</span>
            </p>
            --}}

            @foreach ($insights->slice(0, 2) as $insight)
                <p class="mt-4">
                   <a class="link link-black" href="{{ $insight->url }}" target="_blank" rel="noreferrer noopener">{{ $insight->title }}</a>
                   <br>
                   <span class="text-xs text-gray">
                       {{ $insight->created_at->format('M jS Y') }}
                       <span class="char-separator" >•</span>
                       <a class="link-underline link-blue" href="{{ $insight->url }}" target="_blank" rel="noreferrer noopener">{{ $insight->website }}</a>
                   </span>
               </p>
           @endforeach
        </div>
        <div class="sm:col-span-3 | line-l">
            @foreach ($insights->slice(2, 2) as $insight)
                <p class="mt-4">
                   <a class="link link-black" href="{{ $insight->url }}" target="_blank" rel="noreferrer noopener">{{ $insight->title }}</a>
                   <br>
                   <span class="text-xs text-gray">
                       {{ $insight->created_at->format('M jS Y') }}
                       <span class="char-separator" >•</span>
                       <a class="link-underline link-blue" href="{{ $insight->url }}" target="_blank" rel="noreferrer noopener">{{ $insight->website }}</a>
                   </span>
               </p>
           @endforeach
        </div>
        <div>
             <a class="link-blue link-underline" href={{route('blog')}}>Read more</a>
        </div>
    </div>
</section>
