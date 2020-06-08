<x-page
        title="Web development"
        background="/backgrounds/web-development.jpg"
>
    <x-slot name="description">
        Tailor-made web development is what we do best. Read about our strengths, our thoughtful process and our beloved clients.
    </x-slot>

    @include('front.pages.web-development.partials.banner')

    <div class="section-group pt-0 section-fade">
        @include('front.pages.web-development.partials.intro')
        @include('front.pages.web-development.partials.cta')
        @include('front.pages.web-development.partials.clients')
        @include('front.pages.web-development.partials.greenhouse')
        @include('front.pages.web-development.partials.proof')
        @include('front.pages.web-development.partials.stack')
    </div>

    @include('front.pages.web-development.partials.brief')
</x-page>
