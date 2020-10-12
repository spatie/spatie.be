<x-page
        title="About us"
        background="/backgrounds/about.jpg">
    <x-slot name="description">
        Contact us on info@spatie.be or +32 3 292 56 79. See our contact details, vacancies and get to know our team.
    </x-slot>

    @include('front.pages.about.partials.banner')

    <div class="mt-4 section section-group section-fade">
        @include('front.pages.vacancies.partials.jobs')
        @include('front.pages.about.partials.team')
    </div>

    <div class="section section-group">
        @include('front.pages.about.partials.outro')
        @include('front.pages.about.partials.cta')
    </div>

</x-page>
