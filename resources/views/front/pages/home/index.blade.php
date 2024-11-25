@php
    $image = image("/backgrounds/bf-24-hero.jpg");
@endphp

@push('startBody')
    <div class="wallpaper">
        <img srcset="{{ $image->getSrcset() }}" src="{{ $image->getUrl() }}" width="2400" sizes="100vw" alt="" class="h-svh object-cover">
    </div>
@endpush

<x-page
        title="Websites & webapplications in Laravel"
        background=""
        bodyClass="bg-bf-dark-gray">
    <x-slot name="description">
        Spatie is a digital allrounder: we design solid websites & web applications using Laravel & Vue. No frills, just
        proven expertise. From Antwerp, Belgium
    </x-slot>

    {{-- @include('front.pages.home.partials.banner') --}}
    @include('front.pages.home.partials.bf-banner')

    <div class="mb-8">
        <a href="{{ route('products.index') }}">
        {{-- @include('front.pages.products.partials.ctaLaraconEU') --}}
        </a>
    </div>

    {{-- @include('front.pages.home.partials.news') --}}

    <div class="section section-group section-fade bg-white">
        @include('front.pages.home.partials.portfolio')
        @include('front.pages.home.partials.newsletter')
        @include('front.pages.home.partials.clients')
    </div>

    @include('front.pages.home.partials.open-source')

</x-page>
