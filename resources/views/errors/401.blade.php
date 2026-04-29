<x-page
    title="No access"
    background="/backgrounds/error.jpg"
    body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
>

    <header class="wrapper-lg px-7 sm:px-16 mt-6 sm:mt-12">
        <div class="max-w-[1080px] mx-auto px-8 sm:px-12 md:px-16">
            <x-headers.h1 class="text-balance">
                Entering<br>private territory
            </x-headers.h1>
            <p class="mt-7 text-2xl text-oss-royal-blue-light font-medium max-w-[600px]">
                Seems like you don't have access to this page.
            </p>
        </div>
    </header>

    <section class="wrapper-lg px-7 sm:px-16 mt-8 sm:mt-12 mb-16 lg:mb-24">
        <div class="max-w-[1080px] mx-auto">
            <div class="bg-white rounded-2xl p-8 sm:p-12 md:p-16 space-y-12">
                <div>
                    <h2 class="text-2xl font-semibold text-oss-royal-blue">
                        A few suggestions
                    </h2>
                    <ul class="text-xl mt-4 space-y-2">
                        <li><a href="{{ route('home') }}" class="underline hover:no-underline">Homepage</a></li>
                        <li><a href="{{ route('open-source.packages') }}" class="underline hover:no-underline">Open source packages</a></li>
                        <li><a href="{{ route('about') }}" class="underline hover:no-underline">About us</a></li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-oss-royal-blue">
                        Get in touch
                    </h2>
                    <p class="text-xl mt-2 text-oss-royal-blue-light">
                        Need to get in asap? We're here to help.
                    </p>
                    @include('front.pages.about.partials.banner-contact')
                </div>
            </div>
        </div>
    </section>

</x-page>
