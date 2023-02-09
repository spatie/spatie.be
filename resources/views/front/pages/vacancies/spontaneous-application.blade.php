<x-page
        title="Free application"
        background="/backgrounds/jobs.jpg"
        description="Free job application at spatie.be. Location: Antwerp."
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Your job title here
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section section-group pt-0 section-fade">
        <section id="spontaneous" class="section -mb-16">
            <div class="wrap wrap-6">
                <div class="sm:col-span-4">
                    <div class="markup links-underline links-blue">
                        <p class="text-xl">
                            Even if there's no job description that currently fits you, we're always open for spontaneous applications.
                            People before degrees!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="intro" class="section">
            @include('front.pages.vacancies.partials.about', ['hideRick'=> true])

            <div class="wrap wrap-6">
                <div class="mt-16 sm:col-span-4 markup links-underline links-blue">
                    @include('front.pages.vacancies.partials.clients', ['profile' => 'front'])
                </div>
            </div>

            @include('front.pages.vacancies.partials.stagnation-decline', ['profile' => 'front'])
        </section>
        <section id="offer" class="section">
            @include('front.pages.vacancies.partials.offer')
        </section>
    </div>

    <div class="section section-group">
        @include('front.pages.web-development.partials.stack')
        @include('front.pages.vacancies.partials.cta')
    </div>

</x-page>
