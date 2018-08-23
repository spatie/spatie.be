@extends('layout.default', [
        'background' => '/backgrounds/open-source.jpg',
        'title' => 'Open source',
        'description' => 'Get to know our packages and side projects for Laravel & JavaScript. Read insights from the team and learn how to support us.',
])

@section('content')

    @include('pages.open-source.partials.banner')

    <div class="section-group pt-0 section-fade">
        <section id="laracon" class="section -mb-8 | sm:-mb-16">
            <div class="wrap text-center">
                <div class="inset-blue inline-block ml-auto">
                    <p class="text-2xl">
                        <a class="link-black link-underline" href="{{ route('open-source.laracon-eu') }}">
                            We'll be attending <strong>Laracon EU 2018</strong>!
                        </a>
                    </p>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="wrap">
                <h3 class="title-sm text-grey mb-4">Our current favorites</h3>
            </div>
            <div data-repositories="{{ json_encode($repositories) }}"></div>
            <div class="wrap pt-8">
                <a href="{{ route('open-source.packages') }}" class="link-underline link-blue text-xl">Search all packages…</a>
            </div>
        </section>

        @include('pages.open-source.partials.resources')
        @include('pages.open-source.partials.news')
    </div>

    @include('pages.open-source.partials.support')

@endsection
