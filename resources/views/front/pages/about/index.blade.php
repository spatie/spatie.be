<x-page
    title="About us"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    <x-slot name="description">
        Contact us on info@spatie.be or +32 3 292 56 79. See our contact details, vacancies and get to know our team.
    </x-slot>

    @include('layout.partials.gradient-background', [
        'color1' => '#B21E4E',
        'color2' => '#197593',
        'color3' => '#735AFF',
        'rotationZ' => '45',
        'positionX' => '1.2',
        'positionY' => '-0.3',
        'uDensity' => '1.3',
        'uFrequency' => '4.8',
        'uStrength' => '2.6',
    ])

    @include('front.pages.about.partials.banner')

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 flex flex-col gap-y-16 sm:gap-y-20 pb-20">
        @include('front.pages.about.partials.team')
        @include('front.pages.about.partials.outro')
        @include('front.pages.about.partials.cta')
    </div>

</x-page>
