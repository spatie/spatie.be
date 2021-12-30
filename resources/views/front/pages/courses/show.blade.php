<x-page
    :title="$lesson->title"
    background="/backgrounds/video-blur.jpg"
    :description="$lesson->content->description"
>
    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4 links-underline links-blue">
                <a href="{{ route('courses.index')}}">Courses</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>

                <a href="{{ route('series.show', $series) }}" class="">{{ $series->title }}</a>

                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-right') }}</span>
                <span>{{ $lesson->title }}</span>
            </p>
        </div>
    </section>

    @include('front.pages.courses.content.videos.detail', ['video' => $lesson->content])
</x-page>
