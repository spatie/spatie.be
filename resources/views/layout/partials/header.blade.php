<header class="flex-none header z-10 px-8 pt-8 links links-blue | sm:px-16 | md:py-8 md:bg-white md:shadow-light" role="navigation">
    <div class="leading-loose | md:leading-none md:flex md:items-center">
        <a class="flex-no-shrink logo h-8 w-20 mr-16 mb-8 block | md:mb-0" href="/">
            @svg('logo')
        </a>

        @include('layout.partials.menu')

        <div class=" flex justify-end absolute pin-r pin-t ml-16 w-20 | sm:opacity-75 | md:relative md:opacity-25">
        {{-- Menu::language()
            ->addClass('leading-none grid-rows grid-flow-column gap-4')
            ->setActiveClass('font-sans-bold')
        --}}
        </div>
    </div>
    <div class="lg:max-w-columns lg:px-16 lg:mx-auto md:hidden">
        <hr class="mt-8 h-2px opacity-25 rounded text-blue">
    </div>
</header>

