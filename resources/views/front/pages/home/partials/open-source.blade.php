<section id="open-source" class="section">
    <div class="wrap wrap-8">
        <div class="sm:col-span-3 sm:col-start-2">
            <div class="markup links-underline links-blue">
               <h2 class="title-2xl">From the <br>
                (open) source
                </h2>
                <p class="text-lg">
                    We are open source enthusiasts and active contributors to the Laravel ecosystem. Our packages have been downloaded worldwide {{ App\Models\Repository::humanReadableDownloadCount() }} times.<br>
                    Our <a href="http://git-awards.com/users?utf8=✓&type=world&language=php">top ranking</a> amongst PHP developers on GitHub makes us very proud.
                </p>
            </div>
            <div class="card gradient gradient-blue text-black mt-16">
                <h3 class="title-sm">
                    Learn more
                </h3>
                <ul class="mt-4 text-lg bullets bullets-blue links-underline links-black">
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> <a href="{{ route('open-source.packages') }}">Open source packages</a></li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> <a href="{{ route('products.index') }}">Our products</a> and  <a href="{{ route('videos.index') }}">videos</a></li>
                    <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> <a href="{{ route('web-development') }}">Laravel, React &amp; Vue development</a></li>
                </ul>
            </div>
        </div>
        <div class="hidden | sm:block sm:col-span-3 sm:col-start-6">
            <a class="illustration is-right is-rotated is-postcard-without-caption h-full" href="{{ route('open-source.postcards') }}" title="Postcards">
                {{ image('open-source.jpg') }}
            </a>
        </div>
        <div class="hidden | sm:block sm:col-span-5 sm:col-start-4 | text-right text-sm links-underline links-blue">
            <p class="mt-2 pr-16">Check out the <a href="{{ route('open-source.postcards') }}" >postcards</a><br> 
            we get from kind users all over the world.</p>
        </div>
    </div>
</section>
