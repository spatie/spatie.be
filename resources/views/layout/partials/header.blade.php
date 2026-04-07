<div class="px-3 sm:px-12 font-pt antialiased font-medium">
    <header
        x-data="{
            mobileOpen: window.innerWidth >= 720,
            ossOpen: false,
        }"
        x-on:resize.window="mobileOpen = window.innerWidth >= 720"
        class="max-w-[1080px] mx-auto p-3 sm:flex sm:items-center sm:gap-x-6 z-10 my-3 sm:my-7 rounded-xl overflow-hidden sm:overflow-visible bg-white shadow-light font-pt antialiased font-medium print:bg-transparent print:shadow-none"
    >
        {{-- Logo --}}
        <div class="flex items-center justify-between">
            <a class="shrink-0 flex items-center h-8 w-20 sm:w-28" href="/" title="Home">
                <span class="h-8 overflow-hidden rounded-[4px] sm:h-10">
                    @app_svg('logo')
                </span>
            </a>

            <button
                x-on:click="mobileOpen = !mobileOpen"
                class="flex items-center gap-x-2 text-black sm:hidden"
            >
                <svg x-cloak x-show="!mobileOpen" class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 12"><path fill="#172A3D" d="M0 0h14v2H0V0Zm0 5h14v2H0V5Zm14 5v2H0v-2h14Z"/></svg>
                <svg x-cloak x-show="mobileOpen" class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path fill="#172A3D" d="M2.148.718 1.433 0 0 1.433l.715.715L5.567 7 .718 11.852 0 12.567 1.433 14l.715-.715L7 8.433l4.852 4.849.715.718L14 12.567l-.715-.715L8.433 7l4.849-4.852.718-.715L12.567 0l-.715.718L7 5.568 2.148.717Z"/></svg>
                <span class="text-[14px]">Menu</span>
            </button>
        </div>

        {{-- Navigation --}}
        <div
            x-show.important="mobileOpen"
            x-cloak
            x-transition
            class="mt-4 sm:mt-0 flex-1 sm:flex sm:items-center sm:justify-between"
        >
            <hr class="h-px bg-oss-gray sm:hidden -mx-4 mb-4" />

            {{-- Main nav --}}
            <nav class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-5 md:gap-6 text-oss-royal-blue md:text-base print:hidden">
                <a
                    href="{{ route('web-development') }}"
                    class="hover:text-oss-spatie-blue transition-colors {{ request()->routeIs('web-development') ? 'font-bold text-blue' : '' }}"
                >
                    Services
                </a>

                {{-- Open source dropdown --}}
                <div class="relative" x-on:mouseenter="ossOpen = true" x-on:mouseleave="ossOpen = false">
                    <button
                        x-on:click="if (window.innerWidth < 720) ossOpen = !ossOpen"
                        class="flex items-center gap-1 cursor-pointer hover:text-oss-spatie-blue transition-colors {{ request()->is('open-source*') || request()->routeIs('guidelines') || request()->routeIs('docs') ? 'font-bold text-blue' : '' }}"
                    >
                        Open source
                        <svg class="w-2.5 h-2.5 mt-0.5 transition-transform" :class="{ 'rotate-180': ossOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m1 1 4 4 4-4"/></svg>
                    </button>

                    {{-- Invisible bridge to cover gap between trigger and dropdown --}}
                    <div class="hidden sm:block absolute left-0 right-0 h-3"></div>

                    <div
                        x-show="ossOpen"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="sm:absolute sm:left-0 sm:mt-3 sm:w-52 sm:rounded-xl sm:bg-white sm:shadow-lg sm:ring-1 sm:ring-black/5 sm:py-1 pl-4 sm:pl-0 mt-2"
                    >
                        <div class="grid sm:px-1 gap-0.5">
                            <a href="{{ route('open-source.index') }}" class="sm:px-4 py-2 hover:bg-blue-lightest transition-colors rounded-lg {{ request()->routeIs('open-source.index') ? 'font-bold' : '' }}">
                                Our philosophy
                            </a>
                            <a href="{{ route('open-source.packages') }}" class="sm:px-4 py-2 hover:bg-blue-lightest transition-colors rounded-lg {{ request()->routeIs('open-source.packages') ? 'font-bold' : '' }}">
                                Packages
                            </a>
                            <a href="{{ route('open-source.postcards') }}" class="sm:px-4 py-2 hover:bg-blue-lightest transition-colors rounded-lg {{ request()->routeIs('open-source.postcards') ? 'font-bold' : '' }}">
                                Postcards
                            </a>
                            <a href="{{ route('guidelines') }}" class="sm:px-4 py-2 hover:bg-blue-lightest transition-colors rounded-lg {{ request()->routeIs('guidelines') ? 'font-bold' : '' }}">
                                Guidelines
                            </a>
                            <a href="{{ route('docs') }}" class="sm:px-4 py-2 hover:bg-blue-lightest transition-colors rounded-lg {{ request()->routeIs('docs') ? 'font-bold' : '' }}">
                                Documentation
                            </a>
                        </div>
                    </div>
                </div>

                <a
                    href="{{ route('products.index') }}"
                    class="hover:text-oss-spatie-blue transition-colors {{ request()->routeIs('products.*') ? 'font-bold text-blue' : '' }}"
                >
                    Products
                </a>

                <a
                    href="{{ route('blog') }}"
                    class="hover:text-oss-spatie-blue transition-colors {{ request()->routeIs('blog') ? 'font-bold text-blue' : '' }}"
                >
                    Blog
                </a>

                <a
                    href="{{ route('about') }}"
                    class="hover:text-oss-spatie-blue transition-colors {{ request()->routeIs('about') ? 'font-bold text-blue' : '' }}"
                >
                    About
                </a>
            </nav>

            {{-- Right side: Login + CTA --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 mt-4 sm:mt-0 print:hidden">
                @auth
                    @include('layout.partials.navigation.profileIcon', ['url' => route('profile'), 'active' => request()->is('profile*')])
                @else
                    <a
                        href="{{ route('login') }}"
                        class="flex items-center gap-1.5 text-oss-royal-blue hover:text-oss-spatie-blue transition-colors text-sm"
                    >
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                        Login
                    </a>
                @endauth

                <a
                    href="#match"
                    class="inline-flex items-center px-4 py-2 bg-oss-green hover:bg-oss-green-pale text-oss-royal-blue font-semibold rounded-lg transition-colors"
                >
                    Work with us
                </a>
            </div>
        </div>
    </header>
</div>
