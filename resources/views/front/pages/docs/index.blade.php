<x-page title="Documentation" background="/backgrounds/docs.jpg">
    <div id="site-search-docs-content">
        <section id="banner" class="banner" role="banner">
            <div class="wrap">
                <h1 class="banner-slogan">
                    Docs
                </h1>
                <p class="banner-intro">
                    Documentation for our comprehensive packages
                </p>
            </div>
        </section>

        <section class="section section-group">
            @foreach($repositories->groupBy('category') as $category => $repositories)
                <div class="wrap">
                    <h2 class="title line-after mb-12">{{ $category }}</h2>
                </div>
                <div class="wrap mb-24">
                    <div class="grid col-gap-6 row-gap-16 | sm:grid-cols-2 items-stretch">
                        @each('front.pages.docs.partials.repository', $repositories, 'repository')
                    </div>
                </div>
            @endforeach
        </section>
    </div>
</x-page>
