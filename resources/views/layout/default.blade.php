<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.partials.meta')

    <link rel="stylesheet" href="{{ mix('/css/front.css') }}">
    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6145752/css/fonts.css">

    @include('layout.partials.favicons')

    @yield('twitterMeta')

    <script src="https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver,Promise,Array.from,Element.prototype.dataset" defer></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>

    @include('layout.partials.analytics')
</head>

<body class="flex flex-col min-h-screen">
    @include('layout.partials.wallpaper')
    @include('layout.partials.header')

    <div class="flex-grow" role="main">
        @yield('content')
    </div>

    @include('layout.partials.footer')

    @yield('twitterTracking')

    {!! schema()->localBusiness() !!}
</body>
</html>
