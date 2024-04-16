<section id="support" class="section">
    <div class="wrap wrap-8">
        <div class="sm:col-span-3 sm:col-start-2">
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
            </div>
        </div>
        <div class="sm:col-span-3 sm:col-start-6">
            <a class="illustration is-right is-rotated is-postcard-without-caption h-full" href="https://github.com/sponsors/spatie">
                {{ image('support.jpg') }}
            </a>
        </div>
    </div>
</section>
