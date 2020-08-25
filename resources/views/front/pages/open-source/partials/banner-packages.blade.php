<section id="banner" role="banner" class="banner">
    <div class="wrap">
        <h1 class="banner-slogan">
            Open source packages
        </h1>
        <p class="banner-intro">
            {{ ucfirst(App\Models\Repository::humanReadableDownloadCount()) }} downloads and <span class="icon">{{ svg('icons/far-chart-line') }}</span>
        </p>
    </div>
</section>