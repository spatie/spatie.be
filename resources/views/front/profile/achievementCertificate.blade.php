@php
/** @var \App\Domain\Experience\Projections\UserAchievementProjection $achievement */
@endphp

<x-page
    title="{{ $achievement->title }}"
    background="/backgrounds/auth.jpg"
>
    {{-- TODO: Add styling --}}
    @include('front.profile.partials.subnav')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $achievement->title }}
            </h1>
        </div>
    </section>

    <section class="section section-group pt-0">
        <div class="wrap">
            @if($achievement->hasCertificate())
                <a class="underline hover:no-underline" href="{{ $achievement->getCertificateUrl() }}">Download certificate</a>
            @else
                <p>
                    Your certificate is still being generated, please wait a few moments and refresh this page.
                </p>
            @endif
        </div>
    </section>
</x-page>
