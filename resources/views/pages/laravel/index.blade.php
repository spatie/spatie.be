@extends('layout.default', [
    'background' => '/backgrounds/laravel.jpg',
    'title' => 'Laravel & Vue',
    'description' => 'About our preferred tools to build modern web applications. Read more on our technology stack and hire us as a team for your Laravel project',
])

@section('content')

    @include('pages.laravel.partials.banner')

    <div class="section-group pt-0 section-fade | sm:-mt-16">
        @include('pages.laravel.partials.intro')
        @include('pages.laravel.partials.proof')
        @include('pages.laravel.partials.stack')
    </div>

    @include('pages.laravel.partials.hire')

@endsection
