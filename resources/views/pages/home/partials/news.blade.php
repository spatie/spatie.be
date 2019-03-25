<section id="news">
    <div class="wrap-6 items-start">
        <div class="sm:spanx-3 | line-l">
            <h2 class="title-sm">
                Work with us!
                <div class="title-subtext text-pink-dark">
                    Currently looking for …
                </div>
            </h2>

            @include('pages.vacancies.partials.list', ['showInterns' => true])

            {{--
            <p class="mt-4">
                <a class="link-underline link-blue" href="{{ route('vacancies.internship') }}">Web development interns</a>
                <br>
                <span class="text-xs text-grey">Antwerp / Minimum 8 weeks</span>
            </p>
            --}}
        </div>
        <div class="sm:spanx-3 | line-l">
            @include('pages.open-source.partials.insights')
        </div>
    </div>
</section>
