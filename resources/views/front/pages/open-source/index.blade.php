<x-page
        title="Open source"
        background="/backgrounds/open-source.jpg"

>
    <x-slot name="description">
        Get to know our packages and side projects for Laravel & JavaScript. Read insights from the team and learn how
        to support us.
    </x-slot>

    @include('front.pages.open-source.partials.menu')
    
    @include('front.pages.open-source.partials.banner')

    <div class="section section-group pt-0 section-fade">
        <section class="section">
            <div class="wrap">
                <h3 class="title-sm mb-4">Our current favorites</h3>
            </div>

            <livewire:repositories
                    type="packages"
                    :highlighted="true"
                    :filterable="false"
                    sort="stars"
            />

            <div class="wrap pt-8">
                <a href="{{ route('open-source.packages') }}" class="link-underline link-blue text-xl">Search all
                    packages…</a>
            </div>
        </section>

        @include('front.pages.open-source.partials.resources')
        @include('front.pages.open-source.partials.news')
    </div>

    @include('front.pages.open-source.partials.support')

</x-page>
