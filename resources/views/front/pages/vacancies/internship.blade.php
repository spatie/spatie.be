<x-page
        title="Internship"
        background="/backgrounds/jobs.jpg"

>
    <x-slot name="description">
        We are looking for interns in the field of digital design and development. Location: Antwerp.
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Webdevelopment <br>Internship <br>in Antwerp
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section section-group pt-0">
        <section id="interns" class="section">
            <div class="wrap wrap-6">
                <div class="sm:col-span-4">
                    <div class="markup links-underline links-blue">
                        <h3 class="title">Backend, frontend or full-stack student?</h3>
                        <p class="text-xl">
                            We'd like to meet you. During an internship, you'll be working on actual client projects,
                            open source components or side projects. You learn from our daily routine, and we get
                            triggered by your fresh insights. 
                        </p>
                    </div>
                </div>
            </div>
        </section>

        @include('front.pages.web-development.partials.stack')
        @include('front.pages.vacancies.partials.cta', ["github" => true])

    </div>

</x-page>
