<x-page
    title="Network unavailable"
    backgroundOffline="/images/offline.jpg"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
>

    <header class="wrapper-lg px-7 sm:px-16 mt-6 sm:mt-12">
        <div class="max-w-[1080px] mx-auto px-8 sm:px-12 md:px-16">
            <x-headers.h1 class="text-balance">
                Your connection<br>seems down
            </x-headers.h1>
        </div>
    </header>

    <section class="wrapper-lg px-7 sm:px-16 mt-8 sm:mt-12 mb-16 lg:mb-24">
        <div class="max-w-[1080px] mx-auto">
            <div class="bg-white rounded-2xl p-8 sm:p-12 md:p-16">
                <h2 class="text-2xl font-semibold text-oss-royal-blue">
                    Get in touch
                </h2>
                <p class="text-xl mt-2 text-oss-royal-blue-light">
                    You might want to call us from a phone booth or come visit us in person.
                </p>
                @include('front.pages.about.partials.banner-contact')
            </div>
        </div>
    </section>

</x-page>
