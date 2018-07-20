@extends('layout.default', [
        'background' => '/backgrounds/open-source.jpg',
        'title' => 'Postcards',
        'description' => 'This is our postcardware license in action.',
])

@section('content')

    @include('pages.open-source.partials.banner-postcards')

    <div class="section-group py-0">
        @include('pages.open-source.partials.postcard-intro')

        @if (count($countries))
            @include('pages.open-source.partials.postcard-countries')
        @endif
    </div>

    @include('pages.open-source.partials.postcards')


@endsection
