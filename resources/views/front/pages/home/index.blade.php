@php
    $isBlackFriday = config('black-friday.enabled');
@endphp

<x-page
    title="Websites & web applications in Laravel & AI"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    <x-slot name="description">
        Spatie builds solid websites & web applications in Laravel. With AI, we focus on solutions, not boilerplate. From Antwerp, Belgium
    </x-slot>

    @include('layout.partials.gradient-background', [
        'color1' => '#197593',
        'color2' => '#0A2540',
        'color3' => '#21B989',
        'rotationZ' => '145',
        'positionX' => '0.5',
        'positionY' => '-0.3',
        'uDensity' => '1.6',
        'uFrequency' => '4.5',
        'uStrength' => '2.5',
    ])

    @if($isBlackFriday)
        @include('front.pages.home.partials.bf-banner')
    @else
        @include('front.pages.home.partials.banner')
    @endif

    <div class="mt-16 sm:mt-20 px-3 sm:px-16 md:px-10 lg:px-16 flex flex-col gap-y-16 sm:gap-y-20">
        @include('front.pages.home.partials.portfolio')
        @include('front.pages.home.partials.web-development')
        @include('front.pages.home.partials.open-source')
        @include('front.pages.home.partials.newsletter')

        @if(!$isBlackFriday)
            @include('front.pages.home.partials.news')
        @endif
    </div>

</x-page>
