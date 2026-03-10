<x-page title="Newsletter" body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased">

    <x-og-image view="og-image.default" :data="[
        'title' => 'Newsletter',
        'url' => 'spatie.be/newsletter',
        'image' => image('/backgrounds/guidelines_new.jpg')
    ]" />

    @push('startBody')
        <div aria-hidden="true" class="wallpaper newsletter-wallpaper"></div>
    @endpush

    <x-slot name="description">
        Get the latest from Spatie in your inbox.
    </x-slot>

    <header class="wrapper-lg px-7 sm:px-16 mt-4 lg:mt-12 md:mb-16">
        <x-headers.super class="md:text-[96px] md:text-center text-white drop-shadow-2xl">
            Newsletter
        </x-headers.super>
    </header>

    @include('front.pages.newsletter.partials.intro')

    <section class="wrapper-lg sm:px-16 mt-8 sm:mt-12 xl:mt-16 mb-16">
        <livewire:newsletter :show-description="false" />
    </section>
</x-page>
