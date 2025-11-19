@php
    $isBlackFriday = config('black-friday.enabled');

    $sectionClasses = $isBlackFriday ? 'section section-group section-fade bg-white pt-32' : 'section section-group section-fade';
@endphp

<x-page
    title="Websites & web applications in Laravel"
    :background="$isBlackFriday ? '' : '/backgrounds/home-2020.jpg'"
>
    <x-slot name="description">
        Spatie is a digital allrounder: we design solid websites & web applications using Laravel & Vue. No frills, just
        proven expertise. From Antwerp, Belgium
    </x-slot>

    @if($isBlackFriday)
        @include('front.pages.home.partials.bf-banner')
    @else
        @include('front.pages.home.partials.banner')
    @endif

    @if(!$isBlackFriday)
        @include('front.pages.home.partials.news')
    @endif

    <div class="{{ $sectionClasses }}">
        @include('front.pages.home.partials.portfolio')
        @include('front.pages.home.partials.newsletter')
        @include('front.pages.home.partials.clients')
    </div>

    @include('front.pages.home.partials.open-source')

</x-page>
