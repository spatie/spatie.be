<header class="pt-8 flex-none z-10 | md:bg-white md:shadow-light md:py-8 | print:bg-transparent print:shadow-none">
     <div class="wrap leading-loose | md:leading-none md:flex md:items-stretch">
         <a class="flex-shrink-0 logo h-8 w-20 mr-16 mb-8 block | md:mb-0 md:w-48 md:h-auto" href="/" title="Home">
             <span class="absolute h-full w-auto">
             @svg('logo-xmas')
             </span>
         </a>
         <div class="grid grid-cols-2 items-start col-gap-8 | md:grid-cols-1 md:row-gap-6 md:justify-end md:justify-items-end md:ml-auto">
             <nav class="flex links links-black | md:row-start-2">
                 @include('layout.partials.menu')
             </nav>
             <nav class="grid links links-black | md:opacity-75 md:row-start-1 md:grid-flow-col md:items-center md:gap-6 md:text-xs | print:hidden">
                 @include('layout.partials.service')
             </nav>
         </div>
    </div>
    <div class="wrap | md:hidden | print:hidden">
        <hr class="mt-8 h-2px opacity-25 rounded text-gray">
    </div>
</header>
