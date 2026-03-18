<x-page
    :title="$title"
    :description="$description"
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

    @include("front.pages.courses.content.{$series->type->value}.index")

</x-page>
