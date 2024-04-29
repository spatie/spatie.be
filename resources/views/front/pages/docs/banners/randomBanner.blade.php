@if(isset($repository) && $repository->slug === 'laravel-medialibrary')
    @include('front.pages.docs.banners.medialibrary')
@elseif(isset($repository) && $repository->slug === 'laravel-event-sourcing')
    @include('front.pages.docs.banners.event-sourcing')
@else
    @include(\Illuminate\Support\Arr::random([
        'front.pages.docs.banners.medialibrary',
        'front.pages.docs.banners.crud',
        'front.pages.docs.banners.flare',
        'front.pages.docs.banners.mailcoach',
        'front.pages.docs.banners.ray',
        'front.pages.docs.banners.testingLaravel',
        'front.pages.docs.banners.writing-readable-php',
    ]))
@endif
