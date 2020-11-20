<x-page
        title="Websites & webapplications in Laravel"
        background="/backgrounds/home-black-friday.jpg">
    <x-slot name="description">
        Spatie is a digital allrounder: we design solid websites & web applications using Laravel & Vue. No frills, just
        proven expertise. From Antwerp, Belgium
    </x-slot>

    @include('front.pages.home.partials.banner')
    
    <div class="mb-8">
        @include('front.pages.products.partials.ctaBlackFriday')
    </div>

    @include('front.pages.home.partials.news')

    <div class="section section-group section-fade">
        @include('front.pages.home.partials.portfolio')
        @include('front.pages.home.partials.cta')
        @include('front.pages.home.partials.clients')
    </div>

    @include('front.pages.home.partials.open-source')

</x-page>
