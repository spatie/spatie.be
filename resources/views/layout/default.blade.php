<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">

<head>
    @include('layout.partials.meta')

    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6145752/css/fonts.css">
    @livewireStyles

    @include('layout.partials.favicons')
    @include('feed::links')

    @vite(['resources/js/front/app.js'])

    <script src="https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver,Promise,Array.from,Element.prototype.dataset" defer></script>

    @include('layout.partials.analytics')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    @stack('head')

    <x-comments::styles />
</head>

<body class="flex flex-col min-h-screen leading-normal {{ $bodyClass ?? '' }}">
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

    <div class="flex-grow" role="main">
        {{ $slot }}
    </div>

    @include('layout.partials.footer')

    <x-impersonate::banner/>

    @livewireScripts
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

            Alpine.data('compose', ({ text, defer = false } = {}) => {
                // Store the editor as a non-reactive instance property
                let editor;

                return {
                    text,

                    init() {
                        if (! defer) {
                            this.load();
                        }
                    },

                    load() {
                        if (editor) {
                            return;
                        }

                        const textarea = this.$el.querySelector('textarea');

                        if (! textarea) {
                            return;
                        }

                        editor = new SimpleMDE({
                            element: textarea,
                            hideIcons: ['heading', 'image', 'preview', 'side-by-side', 'fullscreen', 'guide'],
                            spellChecker: false,
                            status: false,
                        });

                        editor.codemirror.on("change", () => {
                            this.text = editor.value();
                        });
                    },

                    clear() {
                        editor.value('');
                    },
                };
            });
        });
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/focus@3.10.5/dist/cdn.min.js"></script>

    {!! schema()->localBusiness() !!}

    @stack('modals')
</body>
</html>
