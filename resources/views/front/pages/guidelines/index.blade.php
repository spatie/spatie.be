<x-page title="Guidelines" body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased">

    <x-og-image view="og-image.default" :data="[
        'title' => 'Coding Guidelines',
        'url' => 'spatie.be',
        'image' => image('/backgrounds/guidelines_new.jpg')
    ]" />

    @push('startBody')
        <div aria-hidden="true" class="wallpaper guidelines-wallpaper"></div>
    @endpush

    <x-slot name="description">
        A set of guidelines we use to bring our projects to a good end.
        Consistency is the key to writing maintainable software.
    </x-slot>

    <header class="wrapper-lg px-7 sm:px-16 mt-4 lg:mt-12 md:mb-16">
        <x-headers.super class="md:text-[96px] md:text-center text-white drop-shadow-2xl">
            Coding <br> Guidelines
        </x-headers.super>
    </header>

    @include('front.pages.guidelines.partials.intro')

    <section class="section section-group">
        <div class="wrapper-lg">
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-16">
                @foreach ($pages as $page)
                    @include('front.pages.guidelines.partials.page', ['page' => $page])
                @endforeach
            </div>
        </div>
    </section>

    <div class="wrapper-lg sm:px-16 mb-16">
        <livewire:newsletter />
    </div>
</x-page>
