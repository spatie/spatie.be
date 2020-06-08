<x-page
        title="Internship"
        background="/backgrounds/internship.jpg"

>
    <x-slot name="description">
        We are looking for interns in the field of digital design and development. Location: Antwerp.
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Internships <br>in Antwerp
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section-group pt-0">
        <section id="intro" class="section">
            <div class="wrap-6">
                <div class="sm:spanx-4">
                    <div class="markup links-underline links-blue">
                        <h3 class="title">Backend, frontend or full-stack student?</h3>
                        <p class="text-lg">
                            We'd like to meet you. During an internship, you'll be working on actual client projects,
                            open source components or side projects. You learn from our daily routine, and we get
                            triggered by your fresh insights. Who knows you'll stick with us!
                        </p>
                        <p class="text-lg">
                            We are looking for internships with a minimum duration of <strong
                                    class="whitespace-no-wrap">8 weeks</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        @include('pages.web-development.partials.stack')
        @include('pages.vacancies.partials.cta', ["github" => true])

    </div>

</x-page>
