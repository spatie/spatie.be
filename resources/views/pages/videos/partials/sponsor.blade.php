@guest
    <section id="proof" class="section">
        <div class="wrap">
            <div class="inset-green">
                <div class="wrap-inset md:items-center" style="--cols: 1fr auto">
                    @if(session()->has('not-a-sponsor'))
                        <h2 class="title-xl">
                            Become a sponsor
                        </h2>

                        <a href="https://github.com/sponsors/spatie"
                        class="font-sans-bold text-lg cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full text-white">
                            <span>Open GitHub sponsors</span>
                            <span class="ml-3 h-6 w-6 text-white">
                                {{ svg('github') }}
                            </span>
                        </a>
                    @else

                    <h2 class="title-xl">
                        Get full access
                    </h2>

                    <a href="/login/github"
                       class="font-sans-bold text-lg cursor-pointer bg-green hover:bg-green-dark justify-center flex items-center px-6 py-2 rounded-full text-white">
                        <span>Login as GitHub sponsor</span>
                        <span class="ml-3 h-6 w-6 text-white">
                            {{ svg('github') }}
                        </span>
                    </a>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endguest