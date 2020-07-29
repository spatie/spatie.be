<section id="news">
    <div class="wrap wrap-6 gapy-0 items-end">
        <div class="sm:col-span-3 | line-l">
                <h2 class="title-sm">
                        Latest insights
                        <div class="title-subtext text-pink-dark">
                            From the team
                        </div>
                    </h2>

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
    </div>
</section>
