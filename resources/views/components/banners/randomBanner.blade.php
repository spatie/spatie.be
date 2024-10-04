@if(isset($repository) && $repository->slug === 'laravel-medialibrary')
    @include('components.banners.medialibrary')
@elseif(isset($repository) && $repository->slug === 'laravel-event-sourcing')
    @include('components.banners.event-sourcing')
@else
    @include(\Illuminate\Support\Arr::random([
        'components.banners.medialibrary',
        'components.banners.crud',
        'components.banners.flare',
        'components.banners.mailcoach',
        'components.banners.ray',
        'components.banners.testingLaravel',
        'components.banners.writing-readable-php',
    ]))
@endif
