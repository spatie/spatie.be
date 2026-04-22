<x-page
    title="Insights"
    background="/backgrounds/legal-blurred.jpg"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
    footerCta
>
    <x-slot name="description">
        Contact us on info@spatie.be or +32 3 292 56 79. See our contact details, vacancies and get to know our team.
    </x-slot>

    {{-- @include('layout.partials.gradient-background', [
        'color1' => '#B21E4E',
        'color2' => '#197593',
        'color3' => '#735AFF',
        'rotationZ' => '45',
        'positionX' => '1.2',
        'positionY' => '-0.3',
        'uDensity' => '1.3',
        'uFrequency' => '4.8',
        'uStrength' => '2.6',
    ]) --}}

    @include('front.pages.about.partials.banner')

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 space-y-16 sm:space-y-32 pb-20">
        @include('front.pages.about.partials.team')
        {{-- @include('front.pages.about.partials.cta') --}}
    </div>

    <div class="px-3 bg-gradient-to-b from-oss-gray to-white sm:px-16 md:px-10 lg:px-16 space-y-16 sm:space-y-32 pb-20">
        @include('front.pages.about.partials.outro')
    </div>

</x-page>
