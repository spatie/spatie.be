<x-page
    title="Vacancies"
    background="/backgrounds/jobs.jpg"
    body-class="bg-white"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
>
    <x-slot name="description">
        Vacancies for developers, project managers and the like. We are always looking for interns
        as well.
    </x-slot>

    <header class="wrapper-lg px-7 sm:px-16 mt-6 sm:mt-12">
        <div class="max-w-[1080px] mx-auto px-8 sm:px-12 md:px-16">
            <x-headers.h1 class="text-balance">
                Come work<br>with us
            </x-headers.h1>
            <p class="mt-7 text-2xl text-oss-royal-blue-light font-medium max-w-[600px]">
                It's fun, actually
            </p>
        </div>
    </header>

    <section class="wrapper-lg px-7 sm:px-16 mt-8 sm:mt-12 mb-16 lg:mb-24">
        <div class="max-w-[1080px] mx-auto">
            <div class="bg-white rounded-2xl p-8 sm:p-12 md:p-16">
                @include('front.pages.vacancies.partials.jobs')
            </div>
        </div>
    </section>

</x-page>
