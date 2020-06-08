<x-page
        title="Vacancies"
        background="/backgrounds/vacancies.jpg"
>
    <x-slot name="description">
        Vacancies for frontend and backend developers, project managers and the like. We are always looking for interns
        as well.
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Come <br>work with us
            </h1>
            <p class="banner-intro">
                It's fun, actually
            </p>
        </div>
    </section>
    <div class="section-group pt-0">
        @include('pages.vacancies.partials.jobs')
    </div>

</x-page>
