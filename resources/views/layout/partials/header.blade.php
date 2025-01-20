<div class="px-3 sm:px-12 font-pt antialiased font-medium">
    <header
        x-data="{ open: window.innerWidth >= 720 }"
        x-on:click.outside="() => {
            if (window.innerWidth >= 720) return;
            open = false
        }"
        x-on:resize.window="open = window.innerWidth >= 720"
        class="w-full max-w-screen-xl mx-auto p-5 sm:px-[40px] sm:py-[30px] sm:flex z-10 my-5 rounded | bg-white shadow-light | print:bg-transparent print:shadow-none"
    >
         <div class="flex justify-between leading-loose | sm:leading-none sm:block">
             <a class="shrink-0 logo h-8 w-20 block | sm:mb-0 sm:w-36" href="/" title="Home">
                 <span class="absolute h-8 sm:h-14 ">
                 @app_svg('logo')
                 </span>
             </a>

             <button x-on:click="open = !open" class="flex items-center gap-x-2 text-black sm:hidden">
                 <svg x-cloak x-show="!open" class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 12"><path fill="#172A3D" d="M0 0h14v2H0V0Zm0 5h14v2H0V5Zm14 5v2H0v-2h14Z"/></svg>
                 <svg x-cloak x-show="open" class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path fill="#172A3D" d="M2.148.718 1.433 0 0 1.433l.715.715L5.567 7 .718 11.852 0 12.567 1.433 14l.715-.715L7 8.433l4.852 4.849.715.718L14 12.567l-.715-.715L8.433 7l4.849-4.852.718-.715L12.567 0l-.715.718L7 5.568 2.148.717Z"/></svg>
                 <span class="text-[14px]">Menu</span>
             </button>
        </div>
         <div x-show.important="open" x-cloak x-transition class="mt-4 sm:mt-0 sm:h-14 grid items-start gap-x-8 | sm:gap-y-4 sm:justify-end sm:justify-items-end sm:ml-auto">
             <hr class="h-px bg-oss-gray sm:hidden -mx-5 mb-5" />
             <nav class="flex | sm:row-start-2 mb-5 sm:mb-0 text-oss-royal-blue">
                 {{ Menu::main()
                    ->addClass(
                        'grid sm:grid-flow-col gap-3 sm:gap-4 md:gap-6 sm:justify-between md:text-lg | print:hidden'
                    )
                    ->setActiveClass('text-blue font-bold')
                 }}
             </nav>
             <nav class="grid text-base | sm:opacity-75 sm:row-start-1 sm:grid-flow-col sm:items-center gap-4 sm:text-sm | print:hidden">
                 @include('layout.partials.service')
             </nav>
         </div>
    </header>
</div>
