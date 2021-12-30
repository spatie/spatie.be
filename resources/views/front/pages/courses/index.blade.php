<x-page
        title="Videos"
        background="/backgrounds/video.jpg"
        description="Learn Laravel best practices from open source veterans SPATIE"
>

    @include('front.pages.courses.partials.banner')

    <div class="section overflow-visible section-group pt-0 section-fade-sm z-10">
        @include('front.pages.courses.partials.series')
    </div>

    <div class="section section-group">
        @include('front.pages.courses.partials.intro')

        <div class="mt-16">
            @include('front.profile.partials.sponsor')
        </div>
    </div>

</x-page>
