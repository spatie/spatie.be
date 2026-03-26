@push('head')
    @paddleJS
@endpush

<x-page
    :title="$product->title"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    @include('layout.partials.gradient-background', [
        'color1' => '#0E3B5E',
        'color2' => '#0A2540',
        'color3' => '#1A5276',
        'rotationZ' => '80',
        'positionX' => '-0.8',
        'positionY' => '0.6',
        'uDensity' => '1.4',
        'uFrequency' => '5.0',
        'uStrength' => '2.8',
    ])

    @includeFirst(["front.pages.products.buy.{$product->slug}", "front.pages.products.buy.default"])
</x-page>
