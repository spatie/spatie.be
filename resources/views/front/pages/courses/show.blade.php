<x-page
    :title="$lesson->title"
    :description="$lesson->content->description"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>

    @include('layout.partials.bg-color')

    @if($series->type === \App\Domain\Shop\Enums\SeriesType::Video || $series->type === \App\Domain\Shop\Enums\SeriesType::VideoAndEbook)
        @include('front.pages.courses.content.video.detail', ['video' => $lesson->content])
    @endif

    @if($series->type === \App\Domain\Shop\Enums\SeriesType::Html)
        @include('front.pages.courses.content.html.detail', ['htmlLesson' => $lesson->content])
    @endif
</x-page>
