<x-page
    title="Our blog"
    background="/backgrounds/blog-index.jpg"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
    footerCta
    livewire
>
    <header class="wrapper-lg px-7 sm:px-16 mt-4 lg:mt-12">
        <x-headers.super class="md:text-[96px] md:text-right text-white drop-shadow-2xl">
            Blog
        </x-headers.super>
    </header>

    @if($highlight)
        <x-blog.highlight :post="$highlight" class="mt-8" />
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
                        <a href="{{ route('blog.all', ['page' => $posts->currentPage() + 1]) }}" wire:navigate.hover class="flex w-full items-center justify-center py-6 text-blue text-base bg-link-card-light border border-gray/25 rounded">
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
