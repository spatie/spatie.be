<x-page
    title="Web development"
    background="/backgrounds/web-development.jpg"
>

    <x-slot name="description">
        Tailor-made web development in Laravel, amplified by AI. We build with AI, we build for AI, and every line of code gets human review.
    </x-slot>

    @include('front.pages.web-development.partials.banner')

    <div class="section section-group pt-0 section-fade">
        @include('front.pages.web-development.partials.intro')
        @include('front.pages.web-development.partials.workflow')
        @include('front.pages.web-development.partials.cta')
        @include('front.pages.web-development.partials.clients')
        @include('front.pages.web-development.partials.building')
        @include('front.pages.web-development.partials.greenhouse')
        @include('front.pages.web-development.partials.stack')
    </div>

    @include('front.pages.web-development.partials.brief')

    @include('layout.partials.modal-match', ["caption" => "Time to talk?"])
</x-page>
