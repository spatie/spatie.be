<x-page
        title="Projects"
        background="/backgrounds/open-source.jpg"
        description="Search in our how-grown open source projects, written in Laravel & JavaScript."
>
    @include('front.pages.open-source.partials.banner-projects')

    <div class="section pt-0 section-fade">
        <livewire:repositories type="projects" />
    </div>

    @include('front.pages.open-source.partials.support')
</x-page>
