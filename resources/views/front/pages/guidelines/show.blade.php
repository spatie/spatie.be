<x-page title="{{ $page->title }}" background="/backgrounds/guidelines-blur.jpg">

    <x-slot name="description">
        {{ $page->description }}
    </x-slot>

    <section id="breadcrumb" class="hidden md:block py-4 md:py-6 lg:py-8">
        <div class="wrap">
            <p class="mt-4">
                <a href="{{ route('guidelines')}}" class="link-underline link-blue">Guidelines</a>
                <span class="icon mx-2 opacity-50 fill-current text-blue">{{ app_svg('icons/far-angle-right') }}</span>
                <span>{{ $page->title }}</span>
            </p>
        </div>
    </section>

    <section class="wrap md:grid pb-24 gap-8 md:grid-cols-3 items-stretch">
        <div class="z-10 | print:hidden">
            <nav class="h-full md:px-4 py-6 md:bg-white md:bg-opacity-50 shadow-light rounded-sm">
                <div class="flex items-center pb-4 border-b-2 border-gray-lighter">
                    <a class="ml-auto flex items-center"
                       href="https://github.com/spatie/spatie.be/edit/main/resources/views/front/pages/guidelines/pages/{{ $page->slug }}.md"
                       rel="nofollow noreferer">
                        <span class="text-xs link-gray link-underline">
                            Edit
                        </span>
                        <span class="ml-2 flex text-xs link-gray">
                            <span class="w-4 h-4">
                                {{ app_svg('github') }}
                            </span>
                        </span>
                    </a>
                </div>

                <div class="sticky top-0 pt-6">
                    {{ $page->toc }}
                </div>
            </nav>
        </div>
        <div class="md:col-span-2">
            <div class="mb-16">
                @include('front.pages.guidelines.partials.writing-readable-php-cta')

                <h1 class="banner-slogan">
                    {{ $page->title }}
                </h1>

                <div class="banner-intro flex items-center justify-start">
                    {{ $page->description }}
                </div>
            </div>

            <div class="markup markup-titles markup-lists markup-code links-blue links-underline">
                {{ $page->contents }}
            </div>
        </div>
    </section>

    @include('components.banners.writing-readable-php')
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add copy button to all code blocks
                document.querySelectorAll('.markup-code pre').forEach(function(pre) {
                    // Skip if already has a copy button
                    if (pre.querySelector('.copy-button')) return;
                    
                    // Create wrapper div
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative group';
                    wrapper.setAttribute('x-data', '{ copied: false }');
                    
                    // Wrap the pre element
                    pre.parentNode.insertBefore(wrapper, pre);
                    wrapper.appendChild(pre);
                    
                    // Create copy button
                    const button = document.createElement('button');
                    button.className = 'copy-button absolute top-3 right-3 p-2.5 rounded-lg bg-white bg-opacity-90 hover:bg-opacity-100 transition-all duration-200 opacity-0 group-hover:opacity-100 focus:opacity-100';
                    button.setAttribute(':class', "{ 'bg-green-50 bg-opacity-90 hover:bg-opacity-100': copied }");
                    button.setAttribute('title', 'Copy code');
                    button.setAttribute('x-on:click', `() => {
                        const code = $el.parentElement.querySelector('code')?.textContent || $el.parentElement.querySelector('pre').textContent;
                        navigator.clipboard.writeText(code);
                        copied = true;
                        setTimeout(() => copied = false, 2000);
                    }`);
                    
                    button.innerHTML = `
                        <svg x-show="!copied" class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <svg x-show="copied" x-cloak class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span x-show="copied" x-cloak class="absolute -left-14 top-1/2 -translate-y-1/2 text-sm font-medium text-green-600 pointer-events-none">Copied!</span>
                    `;
                    
                    wrapper.appendChild(button);
                });
            });
        </script>
    </x-slot>
</x-page>

