<x-page
        title="Postcards"
        background="/backgrounds/open-source.jpg"
        description="This is our postcardware license in action."
>
    @include('front.pages.open-source.partials.banner-postcards')

    <div class="section-group py-0">
        @include('front.pages.open-source.partials.postcard-intro')

        @if (count($countries))
            @include('front.pages.open-source.partials.postcard-countries')
        @endif
    </div>

    @include('front.pages.open-source.partials.postcards')
</x-page>
