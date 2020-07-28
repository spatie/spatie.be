{{-- <header class="flex-none bg-white">
    <div class="wrap | md:flex">

        <a class="flex-shrink-0 logo h-8 w-20 mr-16 mb-8 block | md:mb-0" href="/" title="Home">
            @svg('logo')
        </a>

        <div>
            @include('layout.partials.service')
        </div>

    </div>
</header>
--}}


<header class="pt-8 flex-none z-10 links links-blue | md:py-8 md:bg-white md:shadow-light | print:bg-transparent print:shadow-none" role="navigation">
    <div class="wrap leading-loose | md:leading-none md:flex md:items-center">
        <a class="flex-shrink-0 logo h-8 w-20 mr-16 mb-8 block | md:mb-0" href="/" title="Home">
            @svg('logo')
        </a>

        <div class="grid grid-cols-2 grid-flow-col items-start gap-8 | md:block md:ml-auto">
            <div class="col-start-2 links-blue grid | md:opacity-50 md:grid-flow-col md:items-center md:justify-end md:gap-6 md:mb-5 md:text-xs | print:hidden">
                @include('layout.partials.service')
            </div>
            <div class="col-start-1">
                @include('layout.partials.menu')
            </div>
        </div>
    </div>
    <div class="wrap | md:hidden | print:hidden">
        <hr class="mt-8 h-2px opacity-25 rounded text-blue">
    </div>
</header>

