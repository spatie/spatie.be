<section id="banner" class="banner" role="banner">
    <div class="wrap-8">
        @include('pages.open-source.partials.menu')

        <div class="self-start sm:spanx-3 mt-8 | sm:grid-text-right sm:mt-0 | md:spanx-4">
            <h1 class="banner-slogan">
            Open source packages
            </h1>
            <p class="banner-intro">
            {{ ucfirst(App\Models\Repository::humanReadableDownloadCount()) }} downloads and <span class="icon">{{ svg('icons/far-chart-line') }}</span>
            </p>
        </div>
    </div>
</section>
