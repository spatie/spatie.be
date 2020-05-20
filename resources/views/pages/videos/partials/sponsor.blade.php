@guest
    <section id="access" class="section">
        <div class="wrap">
            <div class="inset-green">
                <div class="wrap-inset md:items-center" style="--cols: 1fr auto">
                    @if(session()->has('not-a-sponsor'))
                        <h2 class="title-xl">
                            Become a sponsor
                        </h2>

                        <a class="mt-8 font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full text-white" href="https://github.com/sponsors/spatie" target="_blank">
                            <span class="mr-3 h-6 w-6 text-white">
                                {{ svg('github') }}
                            </span>                                                
                            <span>Become a GitHub Sponsor</span>
                        </a>
                    @else

                    <h2 class="title-xl">
                        Get full access
                    </h2>

                     <div class="mt-8 md:flex">
                        <a class="font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full md:rounded-r-none text-white" href="/login/github">
                            <span class="mr-3 h-6 w-6 text-white">
                                {{ svg('github') }}
                            </span>                                                
                            <span>Log in</span>
                        </a>
                        <a class="mt-2 md:mt-0 font-sans-bold cursor-pointer md:border-l-2 md:border-green-light bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full md:rounded-l-none text-white" href="https://github.com/sponsors/spatie" target="_blank">
                            <span>Become a GitHub Sponsor</span>                                             
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endguest