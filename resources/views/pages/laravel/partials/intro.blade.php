<section id="intro" class="section">
    <div class="wrap-6">
        <div class="sm:spanx-3">
            <div class="markup links-underline links-blue">
                <div class="flex justify-center z-10 | sm:justify-end sm:-mr-8">
                    <div class="illustration-svg ">
                        <div class="rounded-full w-32 h-32 overflow-hidden mt-4 border-4 border-white shadow-lg bg-white flex items-center justify-center">
                            <div class="w-2/3">
                                @svg('laravel')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 sm:grid-text-right">
                    <h3 class="title-sm">Laravel framework</h3>
                    <p class="text-lg">
                        <a href="https://laravel.com">Laravel</a> is one of the fastest growing open source PHP frameworks at the moment, letting us set up both simple sites as well as complex applications.
                    </p>
                </div>
            </div>
        </div>
        <div class="sm:spanx-3">
            <div class="markup links-underline links-blue">
                <div class="flex justify-center  | sm:justify-start sm:-ml-8">
                    <div class="illustration-svg ">
                        <div class="rounded-full w-32 h-32 overflow-hidden mt-4 border-4 border-white shadow-lg bg-white flex items-center justify-center">
                            <div class="w-2/3">
                                @svg('vue')
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="title-sm mt-8">Vue.js</h3>
                <p class="text-lg">
                    <a href="https://vuejs.org">Vue.js</a> is our frontend framework of choice. We use it to render UIs &amp; dynamic data in your browser. It's comparable to React, but has a larger foot in the door in Laravel projects.
                </p>
            </div>
        </div>
    </div>
    <div class=wrap>
        <hr class=line>
    </div>
    <div class="wrap-6 mt-16">
        <div class="sm:spanx-6">
            <div class="markup links-underline links-blue">
                <h3 class="title">Our greenhouse</h3>
                <p class="text-lg">
                    We are truly a household name in the community, having contributed over <a href="{{ route('open-source.index') }}">
                    {{ App\Models\Repository::count() }} building blocks</a>. Our packages have been downloaded  {{ App\Models\Repository::humanReadableDownloadCount() }} times by peer developers.
                </p>
                <p class="text-lg">
                    The many contributions, conference talks and top ranking amongst PHP developers are proof of our dedication to the Laravel ecosystem, and even more: to web development in general.<br>
                </p>
            </div>
        </div>
    </div>
</section>
