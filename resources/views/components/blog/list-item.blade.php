<?php /** @var \Spatie\ContentApi\Data\Post $insight */ ?>
<div wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="insights-list-item relative cursor-pointer flex flex-col sm:flex-row gap-3 sm:gap-8 group mx-0 sm:p-9 {{ $class ?? '' }}">
    <div class="absolute inset-0 rounded-[20px] pointer-events-none w-full h-full opacity-50 border {{ ($border ?? false) ? 'bg-link-card-light-hover border-oss-gray-dark' : 'border-transparent' }} group-hover:bg-link-card-light-hover group-hover:border-oss-gray-dark"></div>
    <figure>
        <a wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="text-oss-royal-blue no-underline block w-[120px] h-[120px] bg-oss-green-pale rounded-8">
            @if ($insight->header_image)
                <img class="w-full h-full object-cover rounded-8" src="{{ $insight->header_image }}" alt="">
            @endif
        </a>
    </figure>
    <div>
        <h3 class="text-24 leading-snug font-bold normal-case mb-3 group-hover:text-oss-spatie-blue hover:text-oss-spatie-blue">
            <a wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="text-oss-royal-blue no-underline">
                {{ $insight->title }}
            </a>
        </h3>
        <a wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="text-oss-royal-blue no-underline block mt-3 [&_p]:mt-2 [&_code]:text-16 [&_code]:bg-transparent">
            {!! $insight->summary !!}
        </a>
        <a wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="text-oss-royal-blue no-underline mt-4 flex gap-3 text-14">
            @isset($insight->date)
                <time datetime="{{ $insight->date->format('Y-m-d') }}">
                    {{ $insight->date->format('F d, Y') }}
                </time>
            @endisset
            @if (count($insight->tags))
                <ul class="contents font-bold">
                    @foreach ($insight->tags as $tag)
                    <li>#{{ $tag }}</li>
                    @endforeach
                </ul>
            @endif
        </a>
    </div>
</div>
