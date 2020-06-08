<x-page
        title="Videos"
        background="/backgrounds/videos.jpg"
        description="Learn Laravel best practices from open source veterans SPATIE"
>

    @include('pages.videos.partials.banner')

    <div class="section-group pt-0 section-fade-sm z-10">
        @include('pages.videos.partials.intro')
    </div>

    @include('pages.videos.partials.sponsor')

    @include('pages.videos.partials.series')
</x-page>
