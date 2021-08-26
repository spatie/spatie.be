<x-page
        :title="$title"
        background="/backgrounds/video-blur.jpg"
        :description="$description"
>
    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4 links-underline links-blue">
                <a href="{{ route('videos.index')}}">Videos</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>

                <span>{{ $series->title }}</span>
            </p>
        </div>
    </section>

    <div class="pb-16 md:pb-24 xl:pb-32">
        <section id="video">
            <div class="wrap wrap-6 items-stretch">
                <div class="z-10 | sm:col-span-2 | print:hidden">
                    @include('front.pages.videos.partials.sidebar')
                </div>
                <div class="pt-8 | md:pt-0 sm:col-start-3 sm:col-span-4">
                    <h2 class="title-xl">{{ $series->title }}</h2>

                    <div class="mt-8 text-lg links-underline links-blue markup markup-titles markup-lists">
                        <x-markdown>{!! $series->description !!}</x-markdown>

                        <p class="mt-4">Pick a topic from the menu to get started.</p>
                    </div>

                    <hr class="-ml-4 mt-12 line-after"/>

                    <div
                        class="mt-4 w-full overflow-hidden | md:flex justify-between links-blue links-underline text-xs">
                        @if ($series->videos->first())
                            <a class="mb-2 md:w-1/2 md:pl-4 flex items-center md:justify-end ml-auto"
                               href="{{ $series->videos->first()->url }}">
                                <span class="truncate"><span class="font-semibold md:hidden"></span>{{ $series->videos->first()->title  }}</span>
                                <span class="w-1 fill-current text-blue ml-1 hidden | md:inline-block">
                                    {{ svg('icons/far-angle-right') }}
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

</x-page>
