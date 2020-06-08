<x-page
        title="No access"
        background="/backgrounds/error.jpg"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Entering <br>private territory
            </h1>
            <p class="banner-intro">
                Seems like you don't have access to this page.
            </p>
        </div>
    </section>

    <div class="section-group pt-0">
        @include('errors.partials.suggestions')

        <section class=section>
            <div class="wrap">
                <p class="text-2xl">
                    If you need to get in asap, <br>just contact us so we can help you out.
                </p>

                @include('front.pages.about.partials.banner-contact')
            </div>
        </section>
    </div>
</x-page>
