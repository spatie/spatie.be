<x-page
    title="Site under maintenance"
    background="/backgrounds/error.jpg"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
>

    <header class="wrapper-lg px-7 sm:px-16 mt-6 sm:mt-12">
        <div class="max-w-[1080px] mx-auto px-8 sm:px-12 md:px-16">
            <x-headers.h1 class="text-balance">
                Our site<br>is under maintenance
            </x-headers.h1>
            <p class="mt-7 text-2xl text-oss-royal-blue-light font-medium max-w-[600px]">
                We're currently making this site better. Please come back in a couple of minutes!
            </p>
        </div>
    </header>

    <section class="wrapper-lg px-7 sm:px-16 mt-8 sm:mt-12 mb-16 lg:mb-24">
        <div class="max-w-[1080px] mx-auto">
            <div class="bg-white rounded-2xl p-8 sm:p-12 md:p-16">
                <h2 class="text-2xl font-semibold text-oss-royal-blue">
                    Get in touch
                </h2>
                <p class="text-xl mt-2 text-oss-royal-blue-light">
                    Even though our site is having a little break, you can still reach us.
                </p>
                @include('front.pages.about.partials.banner-contact')
            </div>
        </div>
    </section>

</x-page>
