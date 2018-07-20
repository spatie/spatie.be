@extends('layout.default', [
    'background' => '/backgrounds/home-short.jpg',
    'title' => 'Websites & webapplications in Laravel',
    'description' => 'Spatie is a digital allrounder: we design solid websites & web applications using Laravel & Vue. No frills, just proven expertise. From Antwerp, Belgium',
])

@section('content')

    @include('pages.home.partials.banner')
    @include('pages.home.partials.news')

    <div class="section-group section-fade">
        @include('pages.home.partials.portfolio')
        @include('pages.home.partials.cta')
        @include('pages.home.partials.clients')
    </div>

    @include('pages.home.partials.open-source')

@endsection
