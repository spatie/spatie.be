<x-page
    title="{{ $post->title }}"
    background="/backgrounds/blog-post.png"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium antialiased"
>
    <article class="px-3 sm:px-12">
        <x-layout.wrapper as="header" class="relative z-10 px-10 md:px-28 mt-6 sm:mt-12 md:mt-24 -mb-8 md:-mb-16 flex gap-20">
            <div class="flex-1 pb-24">
                <time datetime="{{ $post->date?->format('Y-m-d') }}">
                    {{ $post->date?->format('F d, Y') ?? 'Preview' }}
                </time>

                <h1 class="my-6 md:my-9 font-druk font-bold text-[64px] md:text-[96px] leading-[90%] text-balance uppercase">
                    {!! $post->title !!}
                </h1>

                <div class="mt-6 md:mt-9 text-base font-bold">
                    @foreach ($post->tags as $tag)
                        <span>#{{ $tag }}</span>
                    @endforeach
                </div>
            </div>

            <div class="border border-black/10 shadow-big mt-auto w-2/5 aspect-square bg-oss-green-pale rounded-8 flex-shrink-0">
                @if($post->header_image)
                    <img class="w-full rounded-md my-4" alt="" src="{{ $post->header_image }}"/>
                @endif
            </div>
        </x-layout.wrapper>

        <x-layout.wrapper as="section" class="px-6 lg:px-0 pt-6 pb-6 md:py-20 max-w-layout mx-auto bg-white rounded-2xl">
            <div class="max-w-md mx-auto">
                <aside class="mb-8 flex items-center gap-6">
                    @foreach ($post->authors as $author)
                        <div class="flex items-center gap-3">
                            <img src="{{ $author->gravatar_url }}" alt="" class="flex-shrink-0 size-9 rounded-full bg-indigo-50">
                            <div class="text-base leading-none text-oss-royal-blue font-bold">
                                {{ $author->name }}
                            </div>
                        </div>
                    @endforeach
                </aside>

                <div class="
                    markup markup-titles markup-lists markup-tables markup-embeds links-blue links-underline docs-markup
                    md:[&_>.insights-list-item]:-mx-12
                    md:[&_>pre]:-mx-12 [&_>pre]:bg-oss-gray-light
                ">
                    {!! $content !!}
                </div>
            </div>
        </x-layout.wrapper>
    </article>

    @if(count($otherPosts))
        <x-layout.wrapper class="mt-24 mb-20 pr-20">
            <div class="flex">
                <h2 class="w-1/4 text-24 font-bold">Continue reading</h2>
                <div class="flex-1 flex flex-col -mt-9 pl-9">
                    @foreach($otherPosts as $otherPost)
                        <x-insights.list-item :insight="$otherPost" />
                    @endforeach
                </div>
            </div>
        </x-layout.wrapper>
    @endif

    <x-layout.wrapper class="px-3 sm:px-12 my-6 sm:my-12 md:my-24">
        <livewire:newsletter />
    </x-layout.wrapper>
</x-page>
