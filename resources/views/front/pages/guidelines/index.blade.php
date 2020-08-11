<x-page title="Guidelines" background="/backgrounds/docs.jpg">
    <x-slot name="description">
        A set of guidelines we use to bring our projects to a good end.
        Consistency is the key to writing maintainable software.
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Guidelines
            </h1>
            <p class="banner-intro">
                Consistency is key
            </p>
        </div>
    </section>

    <section class="section section-group">
        <div class="wrap mb-24">
            <div class="grid col-gap-6 row-gap-16 | sm:grid-cols-2 items-stretch">
                @each('front.pages.guidelines.partials.page', $pages, 'page')
            </div>
        </div>
    </section>
</x-page>
