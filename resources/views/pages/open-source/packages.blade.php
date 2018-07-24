@extends('layout.default', [
        'background' => '/backgrounds/open-source.jpg',
        'title' => 'Open source packages',
        'description' => 'Search in our massive list of packages for Laravel & JavaScript.',
])

@section('content')

    @include('pages.open-source.partials.banner-packages')

    <div class="section-group pt-0 section-fade">
        <section class="section">
            <div
                data-repositories="{{ json_encode($repositories) }}"
                data-filterable
            ></div>
        </section>
    </div>

    @include('pages.open-source.partials.support')

@endsection
