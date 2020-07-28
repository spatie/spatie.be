<x-page
        title="Site under maintenance"
        background="/backgrounds/error.jpg"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Our site <br>is under maintenance
            </h1>
            <p class="banner-intro">
                Congratis, you've caught us! We're currently making this site better… <br>
                Please come back in a couple of minutes!
            </p>
        </div>
    </section>

    <div class="section section-group pt-0">
        <section class=section>
            <div class="wrap">
                <p class="text-2xl">
                    Even though our site is having a little break, <br>you can still reach us.
                </p>

                @include('front.pages.about.partials.banner-contact')
            </div>
        </section>
    </div>

</x-page>
