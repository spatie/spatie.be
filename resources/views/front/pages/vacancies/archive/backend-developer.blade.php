<x-page
        title="Backend developer vacancy"
        background="/backgrounds/vacancies.jpg"
        description="Vacancy for a Laravel backend developer. Location: Antwerp."
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Backend developer
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacancies overview</a>
                {{-- <span class="ml-2 line-l"><a class="link-underline link-blue" href="/vacancies/backend-developer-nl">Nederlandse versie</a></span> --}}
            </p>
        </div>
    </section>

    <div class="section-group pt-0 section-fade">
        <section id="intro" class="section">
            <div class="wrap-6">
                <div class="sm:spanx-4">
                    <div class="markup links-underline links-blue">
                        <h2 class="font-serif text-3xl text-green line-l">
                            Say out loud:
                            <br>
                            I can build modern web applications with Laravel!
                        </h2>

                        <div class="mt-16">
                            @include('front.pages.vacancies.partials.clients')
                        </div>

                        <div class="mt-16">
                            <h3 class="title">Personal growth is not an empty promise here</h3>
                            <ul class="bullets bullets-green">
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span>Get €1500,- personal
                                    budget every year for trainings &amp; conferences like Laracon EU and US, DDD
                                    Europe, PHP Benelux, PHPUKConference, DPC, PHPDay ...
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Become a real expert in
                                    Laravel and PHP — have a look at our <a href="#stack">technology stack</a></li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Spend half a day each
                                    week on experimentation and open source work
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Be part of a team with
                                    an excellent reputation in the Laravel community
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="offer" class="section">
            @include('front.pages.vacancies.partials.offer')
        </section>
    </div>

    <div class="section-group">
        @include('front.pages.web-development.partials.stack')
        @include('front.pages.vacancies.partials.cta', ["github" => true])
    </div>

</x-page>
