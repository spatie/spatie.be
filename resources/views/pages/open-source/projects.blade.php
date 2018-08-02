@extends('layout.default', [
        'background' => '/backgrounds/open-source.jpg',
        'title' => 'Projects',
        'description' => 'Search in our how-grown open source projects, written in Laravel & JavaScript.',
])

@section('content')

    @include('pages.open-source.partials.banner-projects')

    <div class="section pt-0 section-fade">
        <div
            data-repositories="{{ json_encode($repositories) }}"
            data-label="projects"
            data-filterable
        ></div>
    </div>

    @include('pages.open-source.partials.support')

@endsection
