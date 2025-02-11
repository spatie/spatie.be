<?php /** @var \Spatie\ContentApi\Data\Post $insight */ ?>
<div wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="insights-list-item relative cursor-pointer flex flex-col sm:flex-row gap-6 sm:gap-8 group mx-0 sm:p-9 {{ $class ?? '' }}">
    <div class="transition-opacity duration-150 absolute inset-0 rounded-[20px] pointer-events-none w-full h-full opacity-0 border bg-link-card-light-hover border-oss-gray-dark md:group-hover:opacity-50"></div>
    <figure>
        <a wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="size-36 sm:size-[120px] text-oss-royal-blue no-underline block bg-oss-green-pale rounded-8">
            @if ($insight->header_image)
                <picture>
                    <?php /** @var \Spatie\ContentApi\Data\ImagePreset $image */ ?>
                    <source srcset="
                        @foreach ($insight->header_image_presets as $image)
                        https://content.spatie.be{{ $image->url }} {{ $image->width }}w{{ $loop->last ? '' : ',' }}
                        @endforeach
                    " sizes="144px">
                    <img class="w-full h-full object-cover rounded-8" src="{{ $insight->header_image }}" alt="">
                </picture>
            @endif
        </a>
    </figure>
    <div>
        <h3 class="text-24/tight font-bold normal-case mb-3 group-hover:text-oss-spatie-blue hover:text-oss-spatie-blue">
            <a wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="text-oss-royal-blue no-underline">
                {{ $insight->title }}
            </a>
        </h3>
        <a wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="text-oss-royal-blue no-underline block mt-3 text-base sm:text-18 [&_p]:mt-2 [&_code]:text-16 [&_code]:bg-transparent">
            {!! $insight->summary !!}
        </a>
        <a wire:navigate href="{{ route('blog.show', $insight->slug) }}" class="text-oss-royal-blue no-underline mt-4 flex gap-3 text-14">
            @isset($insight->date)
                <time datetime="{{ $insight->date->format('Y-m-d') }}">
                    {{ $insight->date->format('F d, Y') }}
                </time>
            @endisset
            @if (count($insight->tags))
                <ul class="lowercase contents font-bold">
                    @foreach ($insight->tags as $tag)
                    <li>#{{ $tag }}</li>
                    @endforeach
                </ul>
            @endif
        </a>
    </div>
</div>
