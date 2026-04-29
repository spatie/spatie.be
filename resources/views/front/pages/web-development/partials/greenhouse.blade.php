<section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
    <h2 class="font-druk uppercase text-[40px] sm:text-[72px] leading-[0.9] mb-10">Our greenhouse</h2>

    <div class="text-lg max-w-[640px] space-y-6">
        <p>
            We've contributed over <a class="underline hover:text-white" href="{{ route('open-source.packages') }}">
            {{ App\Models\Repository::count() }} packages</a> to the Laravel community, downloaded <strong>{{ App\Models\Repository::humanReadableDownloadCount() }} times</strong> by developers worldwide.
        </p>
        <p>
            Conference talks, open source leadership, and a consistent track record in the PHP ecosystem mean you're working with a team that knows Laravel inside out.
        </p>
    </div>
</section>
