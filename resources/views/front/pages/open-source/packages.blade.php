<x-page
        title="Packages"
        background="/backgrounds/open-source.jpg"
>
    <x-slot name="description">
        Search in our massive list of open source packages for Laravel & JavaScript.
    </x-slot>

    @include('front.pages.open-source.partials.banner-packages')

    <div class="section section-group pt-0 section-fade">
        <section class="section">
            <livewire:repositories />
        </section>
    </div>

    @include('front.pages.open-source.partials.support')
</x-page>
