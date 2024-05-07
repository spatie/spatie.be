<x-page
    :title="$lesson->title"
    background="/backgrounds/video-blur.jpg"
    :description="$lesson->content->description"
>
{{--x
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
--}}
    @if($series->type === \App\Domain\Shop\Enums\SeriesType::Video || $series->type === \App\Domain\Shop\Enums\SeriesType::VideoAndEbook)
        @include('front.pages.courses.content.video.detail', ['video' => $lesson->content])
    @endif

    @if($series->type === \App\Domain\Shop\Enums\SeriesType::Html)
        @include('front.pages.courses.content.html.detail', ['htmlLesson' => $lesson->content])
    @endif
</x-page>
