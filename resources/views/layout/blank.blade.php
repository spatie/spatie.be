@props([
    'cssEntry' => 'resources/css/front/front.css',
    'gtmStrategy' => 'delayed',
    'livewire' => false,
    'usesAlpineFocus' => false,
])

<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">

<head>
    @include('layout.partials.meta')

    @if($livewire)
        @livewireStyles
    @endif

    @include('layout.partials.favicons')
    @include('feed::links')

    @if($usesAlpineFocus)
        <script>window.spatieUsesAlpineFocus = true;</script>
    @endif

    @vite([$cssEntry, 'resources/js/front/app.js'])

    @include('layout.partials.analytics', ['gtmStrategy' => $gtmStrategy])

    @stack('head')
</head>

<body class="{{ $bodyClass ?? '' }}">

    {{ $slot }}

    <x-impersonate::banner/>

    @if($livewire)
        @livewireScripts
    @endif

    @stack('scripts')

    {!! schema()->localBusiness() !!}
</body>
</html>
