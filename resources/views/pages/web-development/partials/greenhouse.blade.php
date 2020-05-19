<section id="greenhouse" class="section">
 <div class=wrap>
        <hr class=line>
    </div>
    <div class="wrap-6 mt-16">
        <div class="sm:spanx-6">
            <div class="markup links-underline links-blue">
                <h3 class="title">Our greenhouse</h3>
                <p class="text-lg">
                    We are truly a household name in the community, having contributed over <a href="{{ route('open-source.index') }}">
                    {{ App\Models\Repository::count() }} packages</a> that have been downloaded <strong>{{ App\Models\Repository::humanReadableDownloadCount() }} times</strong> by peer developers.
                </p>
                <p class="text-lg">
                    The many contributions, conference talks and top ranking amongst PHP developers are proof of our dedication to the Laravel ecosystem, and even more: to web development in general.<br>
                </p>
            </div>
        </div>
    </div>
</section>
