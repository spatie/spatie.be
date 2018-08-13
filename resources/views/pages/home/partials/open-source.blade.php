<section id="open-source" class="section">
    <div class="wrap-8">
        <div class="sm:spanx-3 sm:startx-2">
            <div class="markup links-underline links-blue">
               <h2 class="title-2xl">From the <br>
                (open) source
                </h2>
                <p class="text-lg">
                    We are open source enthusiasts and  active contributors to the Laravel ecosystem. Our packages have been downloaded worldwide  {{ App\Models\Repository::humanReadableDownloadCount() }} times.<br>
                    Our <a href="http://git-awards.com/users?utf8=✓&type=world&language=php">top ranking</a> amongst PHP developers on GitHub makes us very proud.
                </p>
            </div>
            <div class="inset-blue mt-16">
                <h3 class="title-sm">
                    Learn more
                </h3>
                <ul class="mt-4 text-lg bullets bullets-blue links-underline links-black">
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> <a href="{{ route('laravel') }}">Laravel &amp; Vue development</a></li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> <a href="{{ route('open-source.index') }}">Open source packages</a></li>
                </ul>
            </div>
        </div>
        <div class="sm:spanx-3 sm:startx-6">
            <a class="illustration is-right is-rotated is-postcard-without-caption h-full" href="{{ route('open-source.postcards') }}" title="Postcards">
                {{ image('open-source.jpg') }}
            </a>
        </div>
        <div class="sm:spanx-4 sm:startx-4 | text-right text-sm links-underline links-blue">
            <p>Check out the <a href="{{ route('open-source.postcards') }}" >postcards</a> <br>
            we get from kind users all over the world.</p>
        </div>
    </div>
</section>
