@extends('layout.default', [
    'background' => '/backgrounds/about.jpg',
    'title' => 'About us',
    'description' => 'Contact us on info@spatie.be or +32 3 292 56 79. See our contact details, vacancies and get to know our team.',
])

@section('content')

    @include('pages.about.partials.banner')

    <div class="mt-4 section-group section-fade">
        @include('pages.vacancies.partials.jobs')
        @include('pages.about.partials.team')
    </div>

    <div class="section-group">
        @include('pages.about.partials.outro')
        @include('pages.about.partials.cta')
    </div>

@endsection
