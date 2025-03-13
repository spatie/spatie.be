<x-page
    title="Insights"
    background="/backgrounds/blog-index.jpg"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
>
    <header class="wrapper-lg px-7 sm:px-16 mt-4 lg:mt-12">
        <x-headers.super class="md:text-[96px] md:text-right text-white drop-shadow-2xl">
            Blog
        </x-headers.super>
    </header>

    @if($highlight)
        <article class="wrapper-lg px-7 sm:px-16 mt-8">
            <a href="{{ route('blog.show', $highlight->slug) }}" class="group flex flex-col sm:flex-row gap-8 sm:gap-24">
                <div href="{{ route('blog.show', $highlight->slug) }}" class="flex-shrink-0 self-start sm:w-[440px] sm:h-[440px] rounded-8 overflow-hidden ">
                    @if ($highlight->header_image)
                        <picture>
                            <?php /** @var \Spatie\ContentApi\Data\ImagePreset $image */ ?>
                            <source srcset="
                                @foreach ($highlight->header_image_presets as $image)
                                https://content.spatie.be{{ $image->url }} {{ $image->width }}w{{ $loop->last ? '' : ',' }}
                                @endforeach
                            " sizes="440px">
                            <img
                                src="{{ $highlight->header_image }}"
                                alt="{{ $highlight->title }}"
                                class="transition duration-300 object-cover group-hover:scale-[1.0125]"
                            >
                        </picture>
                    @else
                        <div class="w-[220px] h-[220px] sm:w-[440px] sm:h-[440px] bg-oss-green-pale rounded-8"></div>
                    @endif
                </div>
                <div href="{{ route('blog.show', $highlight->slug) }}" class="sm:pt-24 flex flex-col gap-6 sm:gap-9">
                    <p class="flex items-center gap-3 text-sm">
                        <span class="bg-oss-green-pale font-semibold rounded-8 px-2 py-1.5 leading-none">
                            Latest post
                        </span>
                        <time datetime="{{ $highlight->date->format('Y-m-d') }}">
                            {{ $highlight->date->format('F d, Y') }}
                        </time>
                    </p>
                    <x-headers.h2 class="transition duration-150 text-balance group-hover:text-oss-spatie-blue">
                        {{ $highlight->title }}
                    </x-headers.h2>
                    <div>
                        {!! $highlight->summary !!}
                    </div>
                </div>
            </a>
        </article>
        <hr class="sm:hidden mx-3 my-8 h-px bg-oss-gray-medium">
    @endif

    @if($posts->isNotEmpty())
        <div class="wrapper-lg px-7 sm:px-16 mt-8 sm:mt-16 lg:mt-24">
            <div class="grid gap-8 sm:grid-cols-[1fr,3fr]">
                <h2 class="hidden sm:block text-24 font-bold pt-9">More posts</h2>
                <div class="space-y-8 sm:space-y-0">
                    @foreach($posts as $post)
                        <x-blog.list-item :insight="$post" />
                        @if(!$loop->last)
                            <hr class="sm:hidden h-px bg-oss-gray-medium">
                        @endif
                    @endforeach
                    @if ($posts->hasMorePages())
                        <a href="{{ route('blog.all') }}" wire:navigate.hover class="flex w-full items-center justify-center py-6 text-blue text-base bg-link-card-light border border-gray/25 rounded">
                            View more
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="wrapper-lg sm:px-16 my-16 lg:my-24">
        <livewire:newsletter />
    </div>

    @isset($externalFeedItems)
        <div class="wrapper-lg px-7 sm:px-16 my-16 lg:my-24">
            <div class="grid gap-8 sm:grid-cols-[1fr,3fr]">
                <h2 class="text-2xl/tight font-bold">From our team <br class="hidden sm:inline"> &&nbsp;products</h2>
                <div class="sm:px-9 grid gap-8">
                    @foreach($externalFeedItems as $externalFeedItem)
                        @include('front.pages.blog.partials.externalFeedItem')
                    @endforeach
                    @if($externalFeedItems->hasMorePages())
                        <p class="pt-2">
                            <a href="{{ route('external-feed-items') }}" wire:navigate.hover class="flex w-full items-center justify-center py-4 text-blue text-base bg-link-card-light border border-gray/25 rounded">
                                View more
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endisset
</x-page>
