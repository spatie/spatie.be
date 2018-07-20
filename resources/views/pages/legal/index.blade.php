@extends('layout.default', [
    'background' => '/backgrounds/legal.jpg',
    'title' => 'Legal',
    'description' => 'General conditions, policies & disclaimers. A lot of difficult sentences.',
])

@section('content')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Legal stuff
            </h1>
            <p class="banner-intro">
                Please don't sue us
            </p>
        </div>
    </section>
    <div class="section-group pt-0">
        <section id="jobs">
            <div class="wrap-6 | items-start">
                <div class="sm:spanx-3 | line-l">
                    <h2 class="title-sm">
                        General conditions
                    </h2>
                    <ul class="links-underline links-blue">
                        <li class=mt-4>
                            <a href="/downloads/algemenevoorwaarden.pdf" download><i class="fal fa-arrow-to-bottom mr-1"></i>General Conditions</a>
                            <span class="ml-2 text-xs text-grey">PDF - Dutch</span></li>
                        <li class=mt-4>
                            <a href="/downloads/gdpr-addendum.pdf" download><i class="fal fa-arrow-to-bottom mr-1"></i>GDPR addendum</a>
                            <span class="ml-2 text-xs text-grey">PDF - Dutch</span>
                        </li>
                    </ul>
                </div>
                <div class="sm:spanx-3 | line-l">
                    <h2 class="title-sm">
                        Policies & disclaimers
                    </h2>
                    <ul class="links-underline links-blue">
                        <li class=mt-4>
                            <a href="{{ route('legal.disclaimer')}}">Disclaimer</a>
                        </li>
                        <li class=mt-4>
                            <a href="{{ route('legal.privacy')}}">Privacy policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </div>

@endsection
