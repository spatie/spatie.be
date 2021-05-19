<x-page
    title="Used technologies"
    background="/backgrounds/about.jpg">
    <x-slot name="description">
        We use a lot of different tools to get our work done.
        Here’s a list of our global company setup, so you can see how we run things at the office (or at home!).
    </x-slot>

    @include('front.pages.technologies.partials.banner')

    <div class="mt-4 section section-group section-fade">
        @include('front.pages.technologies.partials.frontend')
        @include('front.pages.technologies.partials.backend')
        @include('front.pages.technologies.partials.devops')
    </div>

</x-page>
