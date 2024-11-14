<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">

<head>
    @include('layout.partials.meta')

    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6145752/css/fonts.css">
    @livewireStyles

    @include('layout.partials.favicons')
    @include('feed::links')

    @vite(['resources/js/front/app.js'])

    @include('layout.partials.analytics')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    @stack('head')

    <x-comments::styles />
</head>

<body class="{{ $bodyClass ?? '' }}">

    @include('layout.partials.wallpaper')

    <div class="flex-grow" role="main">
        {{ $slot }}
    </div>

    <x-impersonate::banner/>

    <script defer src="https://unpkg.com/@alpinejs/focus@3.10.5/dist/cdn.min.js"></script>

    {!! schema()->localBusiness() !!}
</body>
</html>