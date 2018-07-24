@extends('layout.default', [
        'background' => '/backgrounds/vacancies.jpg',
    'title' => 'Backend developer vacancy',
    'description' => 'Vacancy for a backend developer. Location: Antwerp.',
])

@section('content')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Backend developer
            </h1>
            <p class="mt-4">
                <i class="far fa-angle-left mr-2 opacity-50 text-blue"></i> <a href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacancies overview</a>
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
                            I can build modern web applications in Laravel!
                        </h2>

                        <div class="mt-16">
                            @include('pages.vacancies.partials.clients')
                        </div>

                        <div class="mt-16">
                            <h3 class="title">The best part first</h3>
                            <ul class="bullets bullets-green">
                                <li>Get €1500,- personal budget every year for trainings &amp; conferences like Laracon EU and US, DDD Europe, PHP Benelux, PHPUKConference, DPC, PHPDay</li>
                                <li>Spend 4h/week on experiment and open source work (that's more than at Airbnb)</li>
                                <li>Be part of a team that has made its name in open source</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="offer" class="section">
            @include('pages.vacancies.partials.offer')
        </section>
    </div>

    <div class="section-group">
        @include('pages.laravel.partials.stack')
        @include('pages.vacancies.partials.cta', ["github" => true])
    </div>

@endsection
