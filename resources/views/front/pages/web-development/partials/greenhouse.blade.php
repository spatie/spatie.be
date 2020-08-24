<section id="greenhouse" class="section">
    <div class="wrap">
        <h3 class="title line-after mb-12">Our greenhouse</h3>
    </div>
    <div class="wrap wrap-6">
        <div class="sm:col-span-6">
            <div class="markup links-underline links-blue">
                <p class="text-lg">
                    We are truly a household name in the community, having contributed over <a href="{{ route('open-source.packages') }}">
                    {{ App\Models\Repository::count() }} packages</a> that have been downloaded <strong>{{ App\Models\Repository::humanReadableDownloadCount() }} times</strong> by peer developers.
                </p>
                <p class="text-lg">
                    The many contributions, conference talks and top ranking amongst PHP developers are proof of our dedication to the Laravel ecosystem, and even more: to web development in general.<br>
                </p>
            </div>
        </div>
    </div>
</section>
