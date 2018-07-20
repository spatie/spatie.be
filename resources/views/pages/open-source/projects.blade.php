@extends('layout.default', [
        'background' => '/backgrounds/open-source.jpg',
        'title' => 'Open source projects',
        'description' => 'Search in our how-grown projects, written in Laravel & JavaScript.',
])

@section('content')

    @include('pages.open-source.partials.banner-projects')

    <div class="section pt-0 section-fade">
        <div class="wrap mt-8">
            <div class="cells" style="--cols: 1fr 1fr auto">
                @foreach($repositories as $repository)
                    @include('pages.open-source.partials.repository')
                @endforeach
            </div>
        </div>
    </div>

    @include('pages.open-source.partials.support')

@endsection
