<section id="news">
    <div class="wrap-6 items-start">
        <div class="sm:spanx-3 | line-l">
            <h2 class="title-sm">
                <a href="{{ route('open-source.laracon-eu') }}">Visit our booth at Laracon EU!</a>
                <div class="title-subtext text-pink-dark">
                    29 - 31 August 2018
                </div>
            </h2>

            <p class="mt-4">
                What are you using our packages for?
            </p>
            <p class="mt-4">
                Come say hi and talk to us about your projects. We have a fresh batch of fine goodies!<br>
                 <a class="link-underline link-blue" href="{{ route('open-source.laracon-eu') }}">Learn more</a>
            </p>

            {{--
            <h2 class="title-sm">
                Work with us!
                <div class="title-subtext text-pink-dark">
                    Currently looking for …
                </div>
            </h2>

            @include('pages.vacancies.partials.list', ['showInterns' => true])

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
