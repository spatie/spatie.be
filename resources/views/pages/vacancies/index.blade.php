@extends('layout.default', [
    'background' => '/backgrounds/vacancies.jpg',
    'title' => 'Vacancies',
    'description' => 'Vacancies for frontend and backend developers, project managers and the like. We are always looking for interns as well.',
])

@section('content')

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

@endsection
