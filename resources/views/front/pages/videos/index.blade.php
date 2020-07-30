<x-page
        title="Videos"
        background="/backgrounds/video.jpg"
        description="Learn Laravel best practices from open source veterans SPATIE"
>

    @include('front.pages.videos.partials.banner')

    <div class="section section-group pt-0 section-fade-sm z-10">
        @include('front.pages.videos.partials.series')
    </div>

    <div class="section section-group">
        @include('front.pages.videos.partials.intro')
        
        <div class="mt-16">
            @include('front.profile.partials.sponsor')
        </div>
    </div>

</x-page>
