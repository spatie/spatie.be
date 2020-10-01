@if(isset($repository) && $repository->slug === 'laravel-medialibrary')
    @include('front.pages.docs.banners.medialibrary')
@else
    @include(\Illuminate\Support\Arr::random([
        'front.pages.docs.banners.medialibrary',
        'front.pages.docs.banners.crud',
        'front.pages.docs.banners.flare',
        'front.pages.docs.banners.mailcoach',
    ]))
@endif

