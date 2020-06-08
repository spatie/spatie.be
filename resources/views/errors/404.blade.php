<x-page
        title="Page not found"
        background="/backgrounds/error.jpg"
>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                This page <br>seems missing
            </h1>
            <p class="banner-intro">
                Could be a typo in your URL or a deprecated hyperlink… <br>
                We're here to help!
            </p>
        </div>
    </section>

    <div class="section-group pt-0">
        @include('errors.partials.suggestions')

        <section class=section>
            <div class="wrap">
                <p class="text-2xl">
                    If you have a burning question at this point, <br>just contact us so we can help you out.
                </p>

                @include('front.pages.about.partials.banner-contact')
            </div>
        </section>
    </div>

</x-page>
