<x-page
    title="{{ $page->title }}"
    body-class="bg-oss-gray font-pt antialiased font-medium text-oss-royal-blue leading-[1.4]">

    <x-og-image view="og-image.default" :data="[
        'title' => $page->title,
        'url' => 'spatie.be/guidelines',
        'image' => image('/backgrounds/guidelines-blur.jpg')
    ]" />

    <x-slot name="description">
        {{ $page->description }}
    </x-slot>

    <x-slot name="scripts">
        <style>
            /* Ensure pre elements inside relative wrappers maintain their styling */
            .relative.group pre {
                margin: 0;
            }

            /* Smooth transition for button opacity */
            .copy-button {
                backdrop-filter: blur(4px);
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            }

            /* Ensure button stays visible on focus for accessibility */
            .copy-button:focus {
                opacity: 1 !important;
                outline: 2px solid #3b82f6;
                outline-offset: 2px;
            }
        </style>
    </x-slot>
    <div class="px-3 py-2 sm:px-12">
        <div class="max-w-[1320px] mx-auto w-full">
            @include('front.pages.guidelines.partials.breadcrumbs')
        </div>

        <section class="max-w-[1320px] mx-auto w-full grid pb-24 gap-12 md:grid-cols-10 items-stretch md:mt-10">
            <div class="order-last md:order-none z-10 | md:col-span-3 | lg:col-span-2 | print:hidden">
                @include('front.pages.guidelines.partials.navigation')
                @include('components.banners.randomBanner')
            </div>

            <article class="order-first md:order-none min-w-0 md:col-span-7 lg:col-span-6">
                <h1
                    class="text-oss-spatie-blue uppercase text-[72px] md:text-[96px] font-black leading-90 tracking-normal font-druk mb-10 text-balance">
                    {{ $page->title }}</h1>

                @if (count($tableOfContents))
                    <div class="lg:hidden mb-8">
                        <h3 class="text-base font-bold mb-2">
                            On this page
                        </h3>
                        <ol class="grid gap-1">
                            @foreach ($tableOfContents as $fragment => $title)
                                <li class="text-sm">
                                    <a href="#{{ $fragment }}">
                                        {{ $title }}
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                <div class="markup markup-titles markup-lists markup-tables markup-embeds markup-code links-blue links-underline content-markup text-lg">
                    {{ $page->contents }}
                </div>

                @include('front.pages.guidelines.partials.previous-next-navigation')
            </article>

            <aside class="hidden lg:block w-full pb-16 col-span-2 print-hidden">
                <div class="sticky top-[1rem]">
                    @if (count($tableOfContents))
                        <h3 class="text-base font-bold mb-2">
                            On this page
                        </h3>
                        <ul class="grid gap-2 mb-10 max-h-screen overflow-y-auto">
                            @foreach ($tableOfContents as $fragment => $title)
                                <li class="text-[15px]">
                                    <a href="#{{ $fragment }}" class="docs-submenu-item">
                                        {{ $title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </aside>
        </section>
    </div>
</x-page>
