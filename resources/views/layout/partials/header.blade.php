<div class="px-3 sm:px-12 font-pt">
    <header x-data="{ open: window.innerWidth >= 720 }" x-on:resize.window="open = window.innerWidth >= 720" class="w-full max-w-screen-xl mx-auto p-5 sm:px-[40px] sm:py-[30px] flex-none z-10 my-5 rounded | bg-white shadow-light | print:bg-transparent print:shadow-none">
         <div class="flex justify-between leading-loose | sm:leading-none sm:flex sm:items-stretch">
             <a class="shrink-0 logo h-8 w-20 block | sm:mb-0 sm:w-48 sm:h-auto" href="/" title="Home">
                 <span class="absolute h-8 sm:h-14 ">
                 @app_svg('logo')
                 </span>
             </a>

             <button x-on:click="open = !open" class="flex items-center gap-x-2 text-black sm:hidden">
                 <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 12"><path fill="#172A3D" d="M0 0h14v2H0V0Zm0 5h14v2H0V5Zm14 5v2H0v-2h14Z"/></svg>
                 <span class="text-[14px]">Menu</span>
             </button>
        </div>
         <div x-show.important="open" x-transition class="mt-4 sm:mt-0 sm:h-14 grid grid-cols-2 items-start gap-x-8 | sm:grid-cols-1 sm:gap-y-4 sm:justify-end sm:justify-items-end sm:ml-auto">
             <nav class="flex | sm:row-start-2">
                 @include('layout.partials.menu')
             </nav>
             <nav class="grid | sm:opacity-75 sm:row-start-1 sm:grid-flow-col sm:items-center sm:gap-4 sm:text-sm | print:hidden">
                 @include('layout.partials.service')
             </nav>
         </div>
    </header>
</div>
