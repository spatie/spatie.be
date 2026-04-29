<x-page
    title="Web development"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
    footerCta
>
    <x-slot name="description">
        Tailor-made web development in Laravel for companies that value quality. Accelerated by AI, reviewed by experienced developers.
    </x-slot>

    @include('layout.partials.gradient-background', [
        'color1' => '#197593',
        'color2' => '#412BBD',
        'color3' => '#54B183',
        'rotationZ' => '-145',
        'positionX' => '0.5',
        'positionY' => '-0.3',
        'uDensity' => '1.6',
        'uFrequency' => '4.5',
        'uStrength' => '2.5',
    ])

    @include('front.pages.web-development.partials.banner')

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 space-y-16 sm:space-y-32 pb-20">
        @include('front.pages.web-development.partials.about')
        {{-- @include('front.pages.web-development.partials.clients') --}}
        @include('front.pages.web-development.partials.stack')

        {{-- @include('front.pages.web-development.partials.intro') --}}
        {{-- @include('front.pages.web-development.partials.cta') --}}
        {{-- @include('front.pages.web-development.partials.building') --}}
        {{-- @include('front.pages.web-development.partials.greenhouse') --}}
        {{-- @include('front.pages.web-development.partials.brief') --}}
    </div>

    @include('layout.partials.modal-match', ["caption" => "Time to talk?"])
</x-page>
