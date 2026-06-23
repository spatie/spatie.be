<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
<meta name="color-scheme" content="dark light">
<meta name="theme-color" content="#050508">
<meta name="msvalidate.01" content="66E6FAFC3E214E528EECBD04ECA4804C" />

<link rel="dns-prefetch" href="https://pro.fontawesome.com">

<title>{!! $title ?? '' !!} | Spatie</title>

<meta name="description" content="{!! $description ?? '' !!}">
<meta property="og:title" content="{!! $ogTitle ?? $title ?? '' !!}"/>
<meta property="og:description" content="{!! $ogDescription ?? $description ?? '' !!}"/>
<meta property="og:url" content="{{ request()->getUri() }}"/>
<meta property="og:type" content="website" />

<link rel="canonical" href="{{ $canonical ?? request()->url() }}" />

@if (isset($noIndex) && $noIndex)
    <meta name="robots" content="noindex">
@endif

<x-ld-json />
