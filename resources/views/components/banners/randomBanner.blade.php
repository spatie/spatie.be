@php
    $banner = ($repositoryModel ?? null)?->adBannerView()
        ?? \Illuminate\Support\Arr::random([
            'components.banners.medialibrary',
            'components.banners.crud',
            'components.banners.flare',
            'components.banners.mailcoach',
            'components.banners.ray',
            'components.banners.agency-expertise',
            'components.banners.agency-chat',
            'components.banners.agency-tailor-made',
            // 'components.banners.testingLaravel',
            // 'components.banners.writing-readable-php',
        ]);
@endphp

@include($banner)
