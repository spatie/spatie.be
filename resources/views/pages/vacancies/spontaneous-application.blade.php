@extends('layout.default', [
    'background' => '/backgrounds/vacancies.jpg',
    'title' => 'Free application',
    'description' => 'Free job application at spatie.be. Location: Antwerp.',
])

@section('content')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Your job title here
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-blue">{{ svg('icons/far-angle-left') }}</span> <a href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section-group pt-0 section-fade">
        <section id="intro" class="section">
            <div class="wrap-6">
                <div class="sm:spanx-4">
                    <div class="markup links-underline links-blue">
                        <p class="text-2xl">
                            Even if there is no vacancy, we're always interested in new talent with job titles we haven't heard of.
                        </p>

                        <div class="mt-16">
                            @include('pages.vacancies.partials.clients')
                        </div>

                        <div class="mt-16">
                            <h3 class="title">The best part first</h3>
                            <ul class="bullets bullets-green">
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Get €1500,- personal budget every year for trainings &amp; conferences</li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Take the lead, literally. We are open for your way of working</li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Be part of a team that has made its name in open source</li>
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
        @include('pages.vacancies.partials.cta')
    </div>

@endsection
