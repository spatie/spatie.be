<article class="flex gap-8">
    <figure class="pt-1">
        {{-- @todo Image --}}
        <div class="w-[120px] h-[120px] bg-oss-green-pale rounded-8"></div>
    </figure>
    <div>
        <h3 class="text-24 font-bold hover:text-oss-spatie-blue">
            <a href="{{ route('insights.show', $insight->slug) }}">
                {{ $insight->title }}
            </a>
        </h3>
        <div class="mt-3 [&_p]:mt-2 [&_code]:text-16 [&_code]:bg-transparent">
            {!! $insight->summary !!}
        </div>
        <div class="mt-4 flex gap-3 text-14">
            @isset($insight->date)
                <a href="{{ route('insights.show', $insight->slug) }}">
                    <time datetime="{{ $insight->date->format('Y-m-d') }}">
                        {{ $insight->date->format('F d, Y') }}
                    </time>
                </a>
            @endisset
            {{-- @todo Tags --}}
            <ul class="contents font-bold">
                <li>#postgresql</li>
                <li>#backend</li>
                <li>#databases</li>
            </ul>
        </div>
    </div>
</article>
