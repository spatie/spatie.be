@extends('layout.default', [
        'background' => '/backgrounds/open-source.jpg',
        'title' => 'Open source',
        'description' => 'Get to know our packages and side projects for Laravel & JavaScript. Read insights from the team and learn how to support us.',
])

@section('content')

    @include('pages.open-source.partials.banner')

    <div class="section-group pt-0 section-fade">
        <section class="section">
            <div data-repositories="{{ json_encode($repositories) }}"></div>
        </section>

        @include('pages.open-source.partials.resources')
        @include('pages.open-source.partials.news')
    </div>

    @include('pages.open-source.partials.support')

@endsection
