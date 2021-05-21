<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.partials.meta')

    <link rel="stylesheet" href="{{ mix('/css/front.css') }}">
    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6145752/css/fonts.css">
    <livewire:styles>

    @include('layout.partials.favicons')
    @include('feed::links')

    <script src="https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver,Promise,Array.from,Element.prototype.dataset" defer></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>
        {{-- <script src="/scope.js?v=1" defer></script> --}}

        @include('layout.partials.analytics')
    @stack('head')
</head>

<body class="flex flex-col min-h-screen">
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WGCBMG"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>

    <script>/* Empty script tag because Firefox has a FOUC */</script>
    @include('layout.partials.wallpaper')

    {{--
    @include('layout.partials.cta')
    --}}

    @include('layout.partials.header')
    @include('layout.partials.flash')

    <div class="flex-grow" role="main">
        {{ $slot }}
    </div>

    @include('layout.partials.footer')

    <livewire:scripts>
    @stack('scripts')

    {!! schema()->localBusiness() !!}
</body>
</html>
