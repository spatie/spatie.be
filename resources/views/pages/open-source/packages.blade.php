<x-page
        title="Packages"
        background="/backgrounds/open-source.jpg"
>
    <x-slot name="description">
        Search in our massive list of open source packages for Laravel & JavaScript.
    </x-slot>

    @include('pages.open-source.partials.banner-packages')

    <div class="section-group pt-0 section-fade">
        <section class="section">
            <livewire:repositories />
        </section>
    </div>

    @include('pages.open-source.partials.support')
</x-page>
