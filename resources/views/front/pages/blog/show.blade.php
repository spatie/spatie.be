<x-page
    :title="$post->title"
    background="/backgrounds/blog-post.jpg"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
    :og-image="$post->og_image"
    :description="strip_tags($post->summary)"
>
    <article>
        <header class="wrapper-lg sm:wrapper-inset-lg mt-6 sm:mt-12 -mb-6 sm:-mb-12 relative z-10">
            <div class="px-4 flex flex-col sm:flex-row gap-8">
                <div class="flex-1 sm:pb-28">
                    <time datetime="{{ $post->date?->format('Y-m-d') }}" class="text-oss-royal-blue text-base">
                        {{ $post->date?->format('F d, Y') ?? 'Preview' }}
                    </time>
                    <x-headers.h1 class="mt-6 text-balance">
                        {!! $post->title !!}
                    </x-headers.h1>
                    <div class="mt-6 md:mt-9 font-semibold text-oss-royal-blue">
                        @foreach ($post->tags as $tag)
                            #{{ strtolower($tag) }}
                        @endforeach
                    </div>
                </div>
                <div class="sm:w-2/5 sm:ml-auto sm:mr-0 mt-auto flex-shrink-0 aspect-square bg-oss-green-pale rounded-8 shadow-big">
                    @if($post->header_image)
                        <picture>
                            <?php /** @var \Spatie\ContentApi\Data\ImagePreset $image */ ?>
                            <source srcset="
                                @foreach ($post->header_image_presets as $image)
                                https://content.spatie.be{{ $image->url }} {{ $image->width }}w{{ $loop->last ? '' : ',' }}
                                @endforeach
                            " sizes="325px">
                            <img class="w-full rounded-8" alt="" src="{{ $post->header_image }}"/>
                        </picture>
                    @endif
                </div>
            </div>
        </header>

        <section class="wrapper-lg sm:px-16">
            <div class="pt-12 md:pt-16 pb-12 md:pb-20 bg-white rounded-2xl">
                <div class="wrapper-sm px-6">
                    <aside class="mb-10 flex flex-col gap-3">
                        @foreach ($post->authors->sortBy('name') as $author)
                            <div class="flex items-center gap-2">
                                <img src="{{ $author->gravatar_url }}" alt="" class="flex-shrink-0 size-6 rounded-full bg-indigo-50">
                                <div class="text-base leading-none text-oss-royal-blue font-bold">
                                    @php
                                        echo match ($author->name) {
                                            'Alex' => 'Alex Vanderbist',
                                            'Freek' => 'Freek Van der Herten',
                                            'Jef' => 'Jef Van der Voort',
                                            'Niels' => 'Niels Vanpachtenbeke',
                                            'Ruben' => 'Ruben Van Assche',
                                            'Sebastian' => 'Sebastian De Deyne',
                                            'Sébastien' => 'Sébastien Henau',
                                            'Tim' => 'Tim Van Dijck',
                                            'Wouter' => 'Wouter Brouwers',
                                            default => $author->name,
                                        };
                                    @endphp
                                </div>
                            </div>
                        @endforeach
                    </aside>

                    <div @class([
                        'text-base sm:text-lg markup markup-lists markup-tables markup-embeds links-blue links-underline content-markup',
                        'md:[&_>.insights-list-item]:-mx-12 md:[&_>.insights-list-item]:px-12 md:[&_>.insights-list-item]:my-8',
                        'md:[&_>pre]:-mx-12 md:[&_>pre]:px-12',
                        '[&_>:not(pre)>code]:text-14 [&_>:not(pre)>code]:p-[2px]',
                        '[&_>pre]:bg-oss-gray-light',
                        '[&_>pre]:p-6',
                        'sm:[&_>:not(pre)>code]:text-16 [&_>:not(pre)>code]:p-[2px]',
                    ])>
                        {!! $content !!}
                    </div>
                </div>
            </div>
        </section>
    </article>

    @if(count($otherPosts))
        <div class="wrapper-lg px-7 sm:px-16 my-16 lg:my-24">
            <div class="grid gap-8 sm:grid-cols-[1fr,3fr]">
                <h2 class="text-24 font-bold">Continue reading</h2>
                <div class="space-y-8 sm:space-y-0 sm:-mt-9">
                    @foreach($otherPosts as $otherPost)
                        <x-blog.list-item :insight="$otherPost" />
                        @if(!$loop->last)
                            <hr class="sm:hidden h-px bg-oss-gray-medium">
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
    @endif

    <div class="wrapper-lg sm:px-16 my-16 lg:my-24">
        <livewire:newsletter />
    </div>
</x-page>
