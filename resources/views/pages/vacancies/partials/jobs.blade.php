<section id="jobs">
    <div class="wrap-6 | items-start">
        <div class="sm:spanx-3 | line-l">
            <h2 class="title-sm">
                Vacancies at Spatie
                <div class="title-subtext text-pink-dark">
                   Currently looking for…
                </div>
            </h2>
            @include('pages.vacancies.partials.list')
        </div>
        <div class="sm:spanx-3 | line-l">
            <h2 class="title-sm">
                Internships
                <div class="title-subtext text-pink-dark">
                    Backend or frontend
                </div>
            </h2>
            <p class="mt-4">
                Are you looking to get really good in Laravel, Vue.js, PostCSS or Tailwind? We have slots available for students starting September 2018.
            </p>
            <p class="mt-4">
                <a class="link-underline link-blue" href="{{ route('vacancies.internship') }}">
                    Apply for an internship
                </a>
            </p>
        </div>
    </div>
</section>
