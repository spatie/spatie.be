<section id="greenhouse" class="section">
    <div class="wrap">
        <h3 class="title line-after mb-12">Our greenhouse</h3>
    </div>
    <div class="wrap wrap-6">
        <div class="sm:col-span-6">
            <div class="markup links-underline links-blue">
                <p class="text-lg">
                    We've contributed over <a href="{{ route('open-source.packages') }}">
                    {{ App\Models\Repository::count() }} packages</a> to the Laravel community, downloaded <strong>{{ App\Models\Repository::humanReadableDownloadCount() }} times</strong> by developers worldwide.
                </p>
                <p class="text-lg">
                    Conference talks, open source leadership, and a consistent track record in the PHP ecosystem mean you're working with a team that knows Laravel inside out.
                </p>
            </div>
        </div>
    </div>
</section>
