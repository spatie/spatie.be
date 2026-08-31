@php
    $banner = ($repositoryModel ?? null)?->adBannerView()
        ?? \Illuminate\Support\Arr::random([
            'components.banners.medialibrary',
            'components.banners.crud',
            'components.banners.flare',
            'components.banners.mailcoach',
            'components.banners.ray',
            // 'components.banners.testingLaravel',
            // 'components.banners.writing-readable-php',
        ]);
@endphp

@include($banner)
