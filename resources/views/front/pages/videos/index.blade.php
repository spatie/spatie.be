<x-page
        title="Videos"
        background="/backgrounds/videos.jpg"
        description="Learn Laravel best practices from open source veterans SPATIE"
>

    @include('front.pages.videos.partials.banner')

    <div class="section section-group pt-0 section-fade-sm z-10">
        @include('front.pages.videos.partials.intro')
    </div>

    @include('front.pages.videos.partials.sponsor')

    @include('front.pages.videos.partials.series')
</x-page>
