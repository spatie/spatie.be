<x-page
    title="{{ $post->title }}"
    background="/backgrounds/blog-post.png"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium antialiased"
>
    <article>
        <x-layout.wrapper as="header" class="relative z-10 px-28 mt-24 -mb-16 flex gap-20">
            <div class="pb-32">
                <time datetime="{{ $post->date?->format('Y-m-d') }}">
                    {{ $post->date?->format('F d, Y') ?? 'Preview' }}
                </time>

                <h1 class="my-9 font-druk font-bold text-[96px] leading-[77px] uppercase">
                    {!! str($post->title)->replaceLast(' ', '&nbsp;') !!}
                </h1>

                <div class="mt-9 text-base font-bold">
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

        <x-layout.wrapper as="section" class="py-20 max-w-layout mx-auto bg-white rounded-2xl">
            <div class="max-w-md mx-auto">
                <aside class="mb-8">
                    @foreach ($post->authors as $author)
                        <div class="flex items-center gap-3">
                            <img src="{{ $author->gravatar_url }}" alt="" class="flex-shrink-0 size-9 rounded-full bg-indigo-50">
                            <div class="text-base leading-none text-oss-royal-blue font-bold">
                                {{ $author->name }}
                            </div>
                        </div>
                    @endforeach
                </aside>

                <main class="markup markup-titles markup-lists markup-tables markup-embeds markup-code links-blue links-underline docs-markup">
                    {!! $post->content !!}
                </main>
            </div>
        </x-layout.wrapper>
    </article>

    <a href="{{ route('insights') }}">Back to insights</a>

    @if(count($otherPosts))
        <h2>Continue reading</h2>
        @foreach($otherPosts as $otherPost)
            <a href="{{ route('insights.show', $otherPost->slug) }}">
                {{ $otherPost->title }}
                {{ htmlspecialchars_decode(strip_tags($post->summary)) }}
            </a>
        @endforeach
    @endif

    <livewire:newsletter />
</x-page>
