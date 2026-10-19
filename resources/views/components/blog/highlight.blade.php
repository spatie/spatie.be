@props(['post'])
<?php /** @var \Spatie\ContentApi\Data\Post $post */ ?>
<article {{ $attributes->merge(['class' => 'wrapper-lg px-7 sm:px-16']) }}>
    <a href="{{ route('blog.show', $post->slug) }}" wire:navigate.hover class="group flex flex-col md:flex-row gap-8 md:gap-24">
        <div class="flex-shrink-0 self-start sm:w-[455px] sm:h-[455px] rounded-8 overflow-hidden">
            @if ($post->header_image)
                <picture>
                    <?php /** @var \Spatie\ContentApi\Data\ImagePreset $image */ ?>
                    <source srcset="
                        @foreach ($post->header_image_presets as $image)
                        https://content.spatie.be{{ $image->url }} {{ $image->width }}w{{ $loop->last ? '' : ',' }}
                        @endforeach
                    ">
                    <img
                        src="{{ $post->header_image }}"
                        alt="{{ $post->title }}"
                        class="transition duration-300 object-cover group-hover:scale-[1.0125]"
                    >
                </picture>
            @else
                <div class="w-[220px] h-[220px] sm:w-[440px] sm:h-[440px] bg-oss-green-pale rounded-8"></div>
            @endif
        </div>
        <div class="sm:pt-24 flex flex-col gap-6 sm:gap-9">
            <p class="flex items-center gap-3 text-sm">
                <span class="bg-oss-green-pale font-semibold rounded-8 px-2 py-1.5 leading-none">
                    Latest post
                </span>
                <time datetime="{{ $post->date->format('Y-m-d') }}">
                    {{ $post->date->format('F d, Y') }}
                </time>
                @if ($post->authors->isNotEmpty())
                    <span aria-hidden="true" class="opacity-50">·</span>
                    <span>{{ $post->authors->pluck('name')->join(', ', ' & ') }}</span>
                @endif
            </p>
            <x-headers.h2 class="transition duration-150 text-balance group-hover:text-oss-spatie-blue">
                {{ $post->title }}
            </x-headers.h2>
            <div>
                {!! $post->summary !!}
            </div>
        </div>
    </a>
</article>
