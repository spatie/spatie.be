<section id="banner" role="banner" class="pb-8 | md:pb-12 | lg:pb-16">
    <div class="wrap-8 items-stretch">
        <div class="pt-8 sm:startx-2 sm:spanx-3 | md:pt-12 md:spanx-4 | lg:pt-16 lg:spanx-5 | print:spanx-7">
            <h1 class="banner-slogan">
                Open source packages
            </h1>
            <p class="banner-intro">
                {{ ucfirst(App\Models\Repository::humanReadableDownloadCount()) }} downloads and <span class="icon">{{ svg('icons/far-chart-line') }}</span>
            </p>
        </div>

        @include('pages.open-source.partials.menu')

    </div>
</section>