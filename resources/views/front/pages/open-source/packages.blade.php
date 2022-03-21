<x-page
        title="Laravel, PHP and JavaScript Packages"
        background="/backgrounds/100-million.jpg"
>
    
    <x-slot name="description">
        Search in our massive list of open source packages for Laravel & JavaScript.
    </x-slot>

    

    @include('front.pages.open-source.partials.menu')

    @include('front.pages.open-source.partials.banner-packages')
    
    
    <div class="section section-group pt-0 section-fade">
        <section class="section">
            @include('front.pages.open-source.partials.sponsors')

            <livewire:repositories />
            
            @include('front.pages.open-source.partials.packages-intro')
            
            @include('front.pages.open-source.partials.hero-packages')
        
        </section>
    </div>

    @include('front.pages.open-source.partials.support')
</x-page>
