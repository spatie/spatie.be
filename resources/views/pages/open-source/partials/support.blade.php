<section id="support" class="section">
    <div class="wrap-8">
        <div class="sm:spanx-3 sm:startx-2">
            <div class="markup links-underline links-blue">
                <h2 class="title-2xl">Support us
                </h2>
                <p class="text-lg">
                    A lot of our packages are postcardware: free to use if you send us a postcard. All cards will be published on
                    <a href="{{ route('open-source.postcards') }}">our wall</a>.
                </p>
                <p class="text-lg">
                    With a growing portfolio of {{ App\Models\Repository::count() }} packages, maintaining and supporting all issues and updates has become a substantial portion of our workload.<br>
                </p>
                <p class="text-lg">
                    You can <a href="{{ route('open-source.support') }}">support us</a> with sponsorships or by buying one of our paid products.
                </p>
            </div>
        </div>
        <div class="sm:spanx-3 sm:startx-6">
            <a class="illustration is-right is-rotated is-postcard-without-caption h-full" href="https://patreon.com/spatie">
                {{ image('support.jpg') }}
            </a>
        </div>
    </div>
</section>
