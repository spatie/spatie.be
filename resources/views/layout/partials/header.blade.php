<header class="flex-none header z-10 px-8 pt-8 links links-blue | sm:px-16 | md:py-8 md:bg-white md:shadow-light | print:bg-transparent print:shadow-none" role="navigation">
    <div class="leading-loose | md:leading-none md:flex md:items-center">
        <a class="flex-no-shrink logo h-8 w-20 mr-16 mb-8 block | md:mb-0" href="/" title="Home">
            @svg('logo')
        </a>

        @include('layout.partials.menu')

        <div class="hidden ml-16 w-20 | lg:block">
        </div>
    </div>
    <div class="lg:max-w-columns lg:px-16 lg:mx-auto md:hidden | print:hidden">
        <hr class="mt-8 h-2px opacity-25 rounded text-blue">
    </div>
</header>

