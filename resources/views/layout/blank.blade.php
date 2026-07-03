<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">

<head>
    @include('layout.partials.meta')

    @livewireStyles

    @include('layout.partials.favicons')
    @include('feed::links')

    @vite(['resources/js/front/app.js'])

    @include('layout.partials.analytics')

    @stack('head')
</head>

<body class="{{ $bodyClass ?? '' }}">

    {{ $slot }}

    <x-impersonate::banner/>

    @livewireScripts

    @stack('scripts')

    <script defer src="https://unpkg.com/@alpinejs/focus@3.10.5/dist/cdn.min.js"></script>

    {!! schema()->localBusiness() !!}
</body>
</html>
