<x-page
    title="Technology Stack"
    background="/backgrounds/uses.jpg">
    <x-slot name="description">
        Tools we use to get our work done –at home or in the office
    </x-slot>

    @include('front.pages.uses.partials.banner')

    <div class="mt-4 section section-group section-fade">
        @include('front.pages.uses.partials.frontend')
        @include('front.pages.uses.partials.backend')
        @include('front.pages.uses.partials.devops')
        @include('front.pages.uses.partials.tools')
        @include('front.pages.uses.partials.integrations')
    </div>

</x-page>
