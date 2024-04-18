<section id="header" class="md:flex w-full max-w-[1080px] mx-auto mt-8 sm:mt-32 mb-24 sm:mb-52 px-7 lg:px-0">
    <main class="w-full mb-10 md:mb-0">
        <h1 class="font-druk uppercase text-[72px] lg:text-[144px] leading-[0.8] font-bold mb-10">{!! $title !!}</h1>
        <h2 class="text-[18px] sm:text-2xl font-medium max-w-[600px]">{!! $subtitle !!}</h2>
    </main>
    <aside class="w-full max-w-[360px] flex-shrink-0 md:pl-32 flex flex-col md:justify-end md:items-end -mb-8 pt-10 md:pt-0 border-t md:border-t-0 md:border-l border-white/20">
        <ul class="text-xl w-full sm:max-w-[240px]">
            <li class="mb-3 {{ Route::is('open-source.index') ? 'font-bold' : 'text-white/50' }} hover:text-white transition-colors">
                <a wire:navigate.hover href="{{ route('open-source.index') }}" class="flex items-center justify-between">
                    <span>Open Source</span>
                    <svg class="fill-current w-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                </a>
            </li>
            <li class="mb-3 {{ Route::is('open-source.packages') ? 'font-bold' : 'text-white/50' }} hover:text-white transition-colors">
                <a wire:navigate.hover href="{{ route('open-source.packages') }}" class="flex items-center justify-between">
                    <span>Packages</span>
                    <svg class="fill-current w-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                </a>
            </li>
            <li class=" {{ Route::is('open-source.postcards') ? 'font-bold' : 'text-white/50' }} hover:text-white transition-colors">
                <a wire:navigate.hover href="{{ route('open-source.postcards') }}" class="flex items-center justify-between">
                    <span>Postcards</span>
                    <svg class="fill-current w-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                </a>
            </li>
        </ul>
    </aside>
</section>
<nav
    x-cloak
    x-data="{
        headerHeight: 0,
        scrollTop: 0,
    }"
    x-init="headerHeight = document.getElementById('header').getBoundingClientRect().height; scrollTop = window.scrollY;"
    x-on:scroll.window.lazy="scrollTop = window.scrollY;"
    x-bind:class="scrollTop > headerHeight ? 'translate-y-0' : 'translate-y-[200%]'"
    class="transition-transform fixed z-50 bottom-0 left-1/2 -translate-x-1/2 mb-10 max-w-[480px] w-full mx-auto link-card bg-link-card shadow-oss-card rounded-[38px] p-1.5 flex items-center backdrop-blur-lg"
>
    <span class="py-3 px-5 w-full text-center rounded-[100px] {{ Route::is('open-source.index') ? 'font-bold bg-oss-gray text-oss-black' : '' }}">
        <a wire:navigate.hover href="{{ route('open-source.index') }}" class="">
            Open Source
        </a>
    </span>
    <span class="py-3 px-5 w-full text-center rounded-[100px] {{ Route::is('open-source.packages') ? 'font-bold bg-oss-gray text-oss-black' : '' }}">
        <a wire:navigate.hover href="{{ route('open-source.packages') }}" class="">
            Packages
        </a>
    </span>
    <span class="py-3 px-5 w-full text-center rounded-[100px] {{ Route::is('open-source.postcards') ? 'font-bold bg-oss-gray text-oss-black' : '' }}">
        <a wire:navigate.hover href="{{ route('open-source.postcards') }}" class="">
            Postcards
        </a>
    </span>
</nav>
