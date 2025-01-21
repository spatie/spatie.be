<x-page
    title="{{ $post->title }}"
    background="/backgrounds/blog-post.png"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium antialiased"
>
    <article>
        <header class="wrapper-lg sm:wrapper-inset-lg mt-6 sm:mt-12 -mb-12 relative z-10">
            <div class="pr-12 flex flex-col sm:flex-row sm:gap-8 gap-20">
                <div class="flex-1 sm:pb-28">
                    <time datetime="{{ $post->date?->format('Y-m-d') }}" class="text-oss-royal-blue">
                        {{ $post->date?->format('F d, Y') ?? 'Preview' }}
                    </time>
                    <h1 class="my-6 md:mt-6 md:mb-9 font-druk font-bold text-[64px] md:text-[96px] leading-[90%] text-balance uppercase">
                        {!! $post->title !!}
                    </h1>
                    <div class="mt-6 md:mt-9 font-semibold text-oss-royal-blue">
                        @foreach ($post->tags as $tag)
                            #{{ strtolower($tag) }}
                        @endforeach
                    </div>
                </div>
                <div class="w-3/5 sm:w-2/5 ml-auto sm:mr-0 mt-auto flex-shrink-0 aspect-square bg-oss-green-pale rounded-8 shadow-big">
                    @if($post->header_image)
                        <img class="w-full rounded-8" alt="" src="{{ $post->header_image }}"/>
                    @endif
                </div>
            </div>
        </header>

        <section class="wrapper-lg">
            <div class="pt-12 md:pt-12 pb-16 md:pb-20 bg-white rounded-2xl">
                <div class="wrapper-sm px-9">
                    <aside class="mb-10 flex items-center gap-6">
                        @foreach ($post->authors as $author)
                            <div class="flex items-center gap-3">
                                <img src="{{ $author->gravatar_url }}" alt="" class="flex-shrink-0 size-9 rounded-full bg-indigo-50">
                                <div class="text-base leading-none text-oss-royal-blue font-bold">
                                    {{ $author->name }}
                                </div>
                            </div>
                        @endforeach
                    </aside>

                    <div @class([
                        'markup markup-titles markup-lists markup-tables markup-embeds links-blue links-underline docs-markup',
                        'md:[&_>.insights-list-item]:-mx-12 md:[&_>.insights-list-item]:px-12 md:[&_>.insights-list-item]:my-8',
                        'md:[&_>pre]:-mx-12 md:[&_>pre]:px-12',
                        '[&_>pre]:bg-oss-gray-light',
                    ])>
                        {!! $content !!}
                    </div>
                </div>
            </div>
        </section>
    </article>

    @if(count($otherPosts))
        <div class="wrapper-inset-lg mt-16 sm:mt-24">
            <div class="grid gap-6 sm:grid-cols-[1fr,3fr]">
                <h2 class="text-24 font-bold text-center sm:text-left">Continue reading</h2>
                <div class="sm:-mt-9">
                    @foreach($otherPosts as $otherPost)
                        <x-insights.list-item :insight="$otherPost" />
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="my-12">
        <livewire:newsletter />
    </div>
</x-page>
