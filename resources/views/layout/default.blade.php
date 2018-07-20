<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.partials.meta')
    @include('layout.partials.fonts')

    <link rel="stylesheet" href="{{ mix('/css/front.css') }}">

    @include('layout.partials.favicons')

    @yield('twitterMeta')

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

</body>
</html>
