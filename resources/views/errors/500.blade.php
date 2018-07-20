@extends('layout.default', [
    'background' => '/backgrounds/error.jpg',
    'title' => 'Server error',
    ])

    @section('content')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Our server <br>is confused
            </h1>
            <p class="banner-intro">
                Our server seems to have a little trouble building this page… <br>
                We'll get to the bottom of this asap!
            </p>
        </div>
    </section>

    <div class="section-group pt-0">
        @include('errors.partials.suggestions')

        <section class=section>
            <div class="wrap">
                <p class="text-2xl">
                    If you have a burning question at this point, <br>just contact us so we can help you out.
                </p>

                @include('pages.about.partials.banner-contact')
            </div>
        </section>
    </div>

    @endsection
