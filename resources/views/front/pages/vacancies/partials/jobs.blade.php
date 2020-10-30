<section id="jobs">
    <div class="wrap wrap-6 | items-start">
        <div class="sm:col-span-3 | line-l">
            <h2 class="title-sm">
                Vacancies at Spatie
                <span class="title-subtext text-pink-dark block">
                   Currently looking for…
                </span>
            </h2>
            @include('front.pages.vacancies.partials.list')
        </div>
        <div class="sm:col-span-3 | line-l">
            <h2 class="title-sm">
                Internships
                <span class="title-subtext text-pink-dark block">
                    Backend or frontend
                </span>
            </h2>
            <p class="mt-4">
                Are you looking to get really good in Laravel, Vue.js, PostCSS or Tailwind? We have slots available for students.
            </p>
            <p class="mt-4">
                <a class="link-underline link-blue" href="{{ route('vacancies.internship') }}">
                    Apply for an internship
                </a>
                <br>
    <span class="text-xs text-gray">Antwerp</span>
            </p>
        </div>
    </div>
</section>
