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
                <div class="z-10 | md:col-span-2 | print:hidden">
                    @include('front.pages.videos.partials.sidebar')
                </div>
                <div class="pt-8 | md:pt-0 md:col-start-3 md:col-span-4">
                    <h2 class="title-xl">{{ $series->title }}</h2>

                    <div class="mt-8 text-lg links-underline links-blue markup markup-titles markup-lists">
                        {!! $series->description !!}

                        <p class="mt-4">Pick a topic from the menu to get started.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

</x-page>
