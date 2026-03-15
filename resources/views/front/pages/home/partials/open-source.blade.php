<section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 pb-20">
    <h2 class="font-druk uppercase text-[40px] sm:text-[72px] leading-[0.9] mb-10">From the<br>(open) source</h2>
    <div class="text-lg max-w-[640px]">
        <p>
            We are open source enthusiasts and active contributors to the Laravel ecosystem. Our packages have
            been downloaded worldwide {{ App\Models\Repository::humanReadableDownloadCount() }} times.
            Our <a class="underline hover:text-white" href="http://git-awards.com/users?utf8=✓&type=world&language=php">top ranking</a> amongst PHP
            developers on GitHub makes us very proud.
        </p>
    </div>
    <ul class="mt-8 space-y-2 text-lg">
        <li>
            <a class="inline-flex items-center gap-x-2 underline hover:text-white" href="{{ route('open-source.packages') }}">
                <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                <span>Open source packages</span>
            </a>
        </li>
        <li>
            <a class="inline-flex items-center gap-x-2 underline hover:text-white" href="{{ route('products.index') }}">
                <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                <span>Our products and courses</span>
            </a>
        </li>
        <li>
            <a class="inline-flex items-center gap-x-2 underline hover:text-white" href="{{ route('web-development') }}">
                <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                <span>Laravel, React &amp; Vue development</span>
            </a>
        </li>
    </ul>
</section>
