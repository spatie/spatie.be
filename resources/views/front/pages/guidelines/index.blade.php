<x-page title="Guidelines" background="/backgrounds/guidelines_new.jpg" body-class="bg-oss-gray"
    main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased">
    <x-slot name="description">
        A set of guidelines we use to bring our projects to a good end.
        Consistency is the key to writing maintainable software.
    </x-slot>

    <header class="wrapper-lg px-7 sm:px-16 mt-4 lg:mt-12 md:mb-16">
        <x-headers.super class="md:text-[96px] md:text-center text-white drop-shadow-2xl">
            Coding <br> Guidelines
        </x-headers.super>
    </header>

    <section>
        <div class="wrapper-lg px-7 sm:px-16 mt-8">
            <div class="sm:col-span-6 max-w-screen-sm mx-auto">
                <div class="markup links-underline links-blue">
                    <p class="text-lg">
                        Most projects are not created or maintained by one person.
                        Instead, a group of people work together, each with their own preferences.
                        If everyone used their own style, projects would be difficult to maintain.
                    </p>
                    <p class="text-lg">
                        Our team often discusses the pros and cons of our different programming styles.
                        When we agree on something, we write it down in these guidelines and explain why we chose that
                        approach.
                    </p>

                    <p class="text-lg">
                        We like to think of our guidelines as a living document.
                        People, teams and opinions change over time.
                        We don't adhere strictly to old rules, but constantly challenge them.
                        New experiences lead to better guidelines.
                    </p>

                    <div class="mt-8">
                        @include('front.pages.guidelines.partials.writing-readable-php-short-cta')
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-group">
        <div class="wrapper-lg">
            <div class="grid gap-x-6 gap-y-16 | sm:grid-cols-3 items-stretch">
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
