<x-page
    title="Web development"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    <x-slot name="description">
        Tailor-made web development in Laravel, amplified by AI. We build with AI, we build for AI, and every line of code gets human review.
    </x-slot>

    @include('layout.partials.gradient-background', [
        'color1' => '#735AFF',
        'color2' => '#197593',
        'color3' => '#50E69B',
        'rotationZ' => '310',
        'positionX' => '1.0',
        'positionY' => '0.4',
        'uDensity' => '1.0',
        'uFrequency' => '6.0',
        'uStrength' => '3.5',
    ])

    @include('front.pages.web-development.partials.banner')

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 flex flex-col gap-y-16 sm:gap-y-20 pb-20">
        @include('front.pages.web-development.partials.intro')
        @include('front.pages.web-development.partials.workflow')
        @include('front.pages.web-development.partials.cta')
        @include('front.pages.web-development.partials.clients')
        @include('front.pages.web-development.partials.building')
        @include('front.pages.web-development.partials.greenhouse')
        @include('front.pages.web-development.partials.stack')
        @include('front.pages.web-development.partials.brief')
    </div>

    @include('layout.partials.modal-match', ["caption" => "Time to talk?"])
</x-page>
