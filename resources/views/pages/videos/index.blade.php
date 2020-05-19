@extends('layout.default', [
    'background' => '/backgrounds/videos.jpg',
    'title' => 'Videos',
    'description' => 'Learn Laravel best practices from open source veterans SPATIE',
])

@section('content')
    @include('pages.videos.partials.banner')

    <div class="section-group pt-0 section-fade z-10">
        @include('pages.videos.partials.intro')
        @include('pages.videos.partials.sponsor')
        @include('pages.videos.partials.series')
    </div>

@endsection
