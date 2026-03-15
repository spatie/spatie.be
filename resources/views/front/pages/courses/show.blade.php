<x-page
    :title="$lesson->title"
    :description="$lesson->content->description"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    @include('layout.partials.gradient-background', [
        'color1' => '#21B989',
        'color2' => '#015389',
        'color3' => '#197593',
        'rotationZ' => '190',
        'positionX' => '0.8',
        'positionY' => '-0.5',
        'uDensity' => '1.8',
        'uFrequency' => '4.0',
        'uStrength' => '2.0',
    ])

    @if($series->type === \App\Domain\Shop\Enums\SeriesType::Video || $series->type === \App\Domain\Shop\Enums\SeriesType::VideoAndEbook)
        @include('front.pages.courses.content.video.detail', ['video' => $lesson->content])
    @endif

    @if($series->type === \App\Domain\Shop\Enums\SeriesType::Html)
        @include('front.pages.courses.content.html.detail', ['htmlLesson' => $lesson->content])
    @endif
</x-page>
