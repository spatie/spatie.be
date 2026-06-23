<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">

<head>
    @include('layout.partials.meta')

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

    {{ $slot }}

    <x-impersonate::banner/>

    @stack('scripts')

    <script defer src="https://unpkg.com/@alpinejs/focus@3.10.5/dist/cdn.min.js"></script>

    {!! schema()->localBusiness() !!}
</body>
</html>
