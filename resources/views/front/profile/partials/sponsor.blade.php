<section id="access">
    <div class="wrap">
        <div class="card gradient gradient-green text-white">
            @guest
                <div class="wrap-card grid md:grid-cols-2 md:items-center">
                    <h2 class="title-xl">
                        Get full access
                    </h2>

                    <div class="md:flex">
                        <a class="font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full md:rounded-r-none text-white"
                           href="/login/github">
                                    <span class="mr-3 h-6 w-6 text-white">
                                        {{ app_svg('github') }}
                                    </span>
                            <span>Log&nbsp;in</span>
                        </a>
                        <a class="mt-2 md:mt-0 font-sans-bold cursor-pointer md:border-l-2 md:border-green-light bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full md:rounded-l-none text-white"
                           href="https://github.com/sponsors/spatie" target="_blank">
                            <span>Become&nbsp;a&nbsp;GitHub&nbsp;Sponsor</span>
                        </a>
                    </div>
                </div>
            @else
                @if (auth()->user()->isSponsoring())
                    <div class="flex items-center text-xl">
                                <span class="text-xl mr-4 icon text-pink">
                                    {{ app_svg('icons/fas-heart') }}
                                </span>
                        <span>
                                    Thank you so much for being our sponsor!
                                </span>
                    </div>
                @else
                    <div class="wrap-card grid md:grid-cols-2 md:items-center">
                        <h2 class="title-xl">
                            Become a sponsor
                        </h2>

                        <a class="font-sans-bold cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full text-white"
                           href="https://github.com/sponsors/spatie" target="_blank">
                                    <span class="mr-3 h-6 w-6 text-white">
                                        {{ app_svg('github') }}
                                    </span>
                            <span>Become&nbsp;a&nbsp;GitHub&nbsp;Sponsor</span>
                        </a>
                    </div>
                @endif
            @endguest
        </div>
    </div>
</section>
