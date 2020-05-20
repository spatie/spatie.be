@extends('layout.default', [
        'background' => '/backgrounds/open-source.jpg',
        'title' => 'Open source',
        'description' => 'Get to know our packages and side projects for Laravel & JavaScript. Read insights from the team and learn how to support us.',
])

@section('content')

    @include('pages.open-source.partials.banner')

    <div class="section-group pt-0 section-fade">
        <section class="section">
            <div class="wrap">
                <h3 class="title-sm mb-4">Our current favorites</h3>
            </div>

            @livewire('repositories', [
                'type' => 'packages',
                'highlighted' => true,
                'filterable' => false,
                'sort' => 'stars',
            ])

            <div class="wrap pt-8">
                <a href="{{ route('open-source.packages') }}" class="link-underline link-blue text-xl">Search all packages…</a>
            </div>
        </section>

        @include('pages.open-source.partials.resources')
        @include('pages.open-source.partials.news')
    </div>

    @include('pages.open-source.partials.support')

@endsection
