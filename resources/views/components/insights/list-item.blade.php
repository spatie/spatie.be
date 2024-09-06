<?php /** @var \Spatie\ContentApi\Data\Post $insight */ ?>
<article class="relative flex gap-8 group p-9">
    <div class="absolute inset-0 rounded-[20px] pointer-events-none w-full h-full opacity-50 border border-transparent group-hover:bg-link-card-light-hover group-hover:border-oss-gray-dark"></div>
    <a wire:navigate href="{{ route('insights.show', $insight->slug) }}">
        <figure class="pt-1">
            <div class="w-[120px] h-[120px] bg-oss-green-pale rounded-8">
                @if ($insight->header_image)
                    <img class="w-full h-full object-cover" src="{{ $insight->header_image }}" alt="">
                @endif
            </div>
        </figure>
    </a>
    <div>
        <h3 class="text-24 font-bold group-hover:text-oss-spatie-blue hover:text-oss-spatie-blue">
            <a wire:navigate href="{{ route('insights.show', $insight->slug) }}">
                {{ $insight->title }}
            </a>
        </h3>
        <div class="mt-3 [&_p]:mt-2 [&_code]:text-16 [&_code]:bg-transparent">
            <a wire:navigate href="{{ route('insights.show', $insight->slug) }}">
                {!! $insight->summary !!}
            </a>
        </div>
        <div class="mt-4 flex gap-3 text-14">
            @isset($insight->date)
                <a wire:navigate href="{{ route('insights.show', $insight->slug) }}">
                    <time datetime="{{ $insight->date->format('Y-m-d') }}">
                        {{ $insight->date->format('F d, Y') }}
                    </time>
                </a>
            @endisset
            @if (count($insight->tags))
                <ul class="contents font-bold">
                    @foreach ($insight->tags as $tag)
                    <li>#{{ $tag }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</article>
