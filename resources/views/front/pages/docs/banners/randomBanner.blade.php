@switch($repository->slug)
    @case('laravel-medialibrary')
        @include('front.pages.docs.banners.medialibrary')
    @break

    @default
        @include(\Illuminate\Support\Arr::random(['front.pages.docs.banners.medialibrary', 'front.pages.docs.banners.crud']))
@endswitch

