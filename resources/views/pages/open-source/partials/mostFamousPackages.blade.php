<section id="hitlist" class="section">
    <div class="wrap">
        <h3 class="title-sm text-grey mb-4">Our current favorites</h3>
        <div class="cells" style="--cols: 1fr 1fr auto">
            @foreach($repositories as $repository)
                @include('pages.open-source.partials.repository')
            @endforeach

            <div class="pt-8">
                <a href="{{ route('open-source.packages') }}" class="link-underline link-blue text-xl">Search all packages…</a>
            </div>
        </div>
    </div>
</section>
