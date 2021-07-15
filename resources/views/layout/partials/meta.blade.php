<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

<link rel="dns-prefetch" href="https://cloud.typography.com">
<link rel="dns-prefetch" href="https://pro.fontawesome.com">

<title>{!! $title ?? '' !!} | Spatie</title>

<meta name="description" content="{{ $description ?? '' }}">
<meta property="og:title" content="{{ $ogTitle ?? $title ?? '' }}"/>
<meta property="og:description" content="{{ $ogDescription ?? $description ?? '' }}"/>
<meta property="og:image" content="{{ $ogImage ?? url('/images/og-image.jpg') }}"/>
<meta property="og:url" content="{{ request()->getUri() }}"/>
<meta property="og:type" content="website" />

@if (isset($canonical) && $canonical)
    <link rel="canonical" href="{{ $canonical }}" />
@endif

@if (isset($noIndex) && $noIndex)
    <meta name="robots" content="noindex">
@endif
