<x-page
        title="Network unavailable"
        backgroundOffline="/images/offline.jpg"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Your connection <br>seems down
            </h1>
        </div>
    </section>

    <div class="section section-group pt-0">
        <section class=section>
            <div class="wrap">
                <p class="text-2xl">
                    You might want to call us from a phone booth or <br>
                    come visit us in person.
                </p>
                @include('front.pages.about.partials.banner-contact')
            </div>
        </section>
    </div>

</x-page>