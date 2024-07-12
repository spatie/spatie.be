@php
    /** @var Spatie\ContentApi\Data\Post $insight */
@endphp

<x-layout.wrapper as="article" :class="twMerge(['flex gap-16', $attributes->get('class')])">
    <figure>
        {{-- @todo Thumbnail --}}
        <div class="w-[440px] h-[440px] bg-oss-green-pale rounded-8 shadow-oss-card"></div>
    </figure>
    <div class="pt-28 flex flex-col gap-9">
        <p class="flex items-center gap-3">
            <a href="{{ route('insights.show', $insight->slug) }}" class="bg-oss-green-pale font-semibold rounded-8 px-2 py-0.5">
                Latest article
            </a>
            <a href="{{ route('insights.show', $insight->slug) }}">
                <time datetime="{{ $insight->date->format('Y-m-d') }}">
                    {{ $insight->date->format('F d, Y') }}
                </time>
            </a>
        </p>
        <x-headers.h2 class="w-2/3">
            <a href="{{ route('insights.show', $insight->slug) }}">
                {{ $insight->title }}
            </a>
        </x-headers.h2>
        <div class="w-3/4">
            {!! $insight->summary  !!}
        </div>
    </div>
</x-layout.wrapper>
