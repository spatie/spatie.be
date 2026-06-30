@props([
    'comments' => false,
])

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

    @if($comments)
        @laravelCommentsLivewireStyles
    @endif
</head>

<body class="flex flex-col min-h-screen leading-normal antialiased {{ $bodyClass ?? '' }}">
    <script>/* Empty script tag because Firefox has a FOUC */</script>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WGCBMG"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>

    @stack('startBody')

    @include('layout.partials.wallpaper')

    {{-- @include('layout.partials.cta') --}}

    {{-- @include('layout.partials.header-alert') --}}
    @include('layout.partials.header')
    @include('layout.partials.flash')

    <main class="flex-grow {{ $mainClass ?? '' }}">
        {{ $slot }}
    </main>

    @include('layout.partials.footer', ['dark' => $dark ?? false, 'footerCta' => $footerCta ?? false])

    <x-impersonate::banner/>

    @livewireScripts

    @if($comments)
        @laravelCommentsLivewireScripts
    @endif

    @stack('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('modals', {
                openModals: [],
                onConfirm: null,
                init() {
                    if (window.location.hash) {
                        this.openModals.push(window.location.hash.replace('#', ''));
                    }
                },
                isOpen(id) {
                    return this.openModals.includes(id);
                },
                open(id) {
                    this.openModals.push(id);
                    window.location.hash = id;
                    Alpine.nextTick(() => {
                        const input = document.querySelector(`#modal-${id} input:not([type=hidden])`);
                        if (input) {
                            input.focus();
                            return;
                        }

                        const button = document.querySelector(`#modal-${id} [data-confirm]`);
                        if (button) button.focus();
                    });
                },
                close(id) {
                    this.openModals = this.openModals.filter(modal => modal !== id);
                    history.pushState('', document.title, window.location.pathname + window.location.search);
                },
            });
        });
    </script>
    <script defer src="https://unpkg.com/@alpinejs/focus@3.10.5/dist/cdn.min.js"></script>

    {!! schema()->localBusiness() !!}

    @stack('modals')

</body>
</html>
