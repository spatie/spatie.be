<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

<link rel="publisher" href="https://plus.google.com/115651694673948212718">

<link rel="dns-prefetch" href="//cloud.typography.com">
<link rel="dns-prefetch" href="//pro.fontawesome.com">

<title>{{ $title ?? '' }} | Spatie</title>

<meta name="description" content="{{ $description ?? '' }}">
<meta property="og:title" content="{{ $ogTitle ?? $title ?? '' }}"/>
<meta property="og:description" content="{{ $ogDescription ?? $description ?? '' }}"/>
<meta property="og:image" content="{{ $ogImage ?? url('/images/og-image.jpg') }}"/>
<meta property="og:url" content="{{ request()->getUri() }}"/>
<meta property="og:type" content="website" />
