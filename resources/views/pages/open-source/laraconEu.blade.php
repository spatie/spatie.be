@extends('layout.default', [
    'background' => '/backgrounds/laracon-eu.jpg',
    'title' => 'Laracon EU 2018',
    'description' => 'Visit our booth at Laracon EU 2018.',
    ])

    @section('content')

    <section id="banner" class="banner" role="banner">
        <div class="wrap-8">
            @include('pages.open-source.partials.menu')

            <div class="self-start sm:spanx-3 mt-8 | sm:grid-text-right sm:mt-0 | md:spanx-4 | print:spanx-7">
                <h1 class="banner-slogan">
                    Knock our socks off
                </h1>
                <p class="banner-intro">
                    Visit our booth at Laracon EU
                </p>
            </div>
        </div>
    </section>

    <div class="section-group pt-0">
        <section id="postcards" class="section">
            <div class="wrap-6 items-end">
                <div class="sm:spanx-4">
                    <div class="markup links-underline links-blue">
                        <h2 class="title">
                            Attending Laracon EU 2018?
                        </h2>
                        <p class="text-lg">
                            Show us how you implement our packages in your own code.
                            Visit our booth and talk to us about your plans or projects.
                        </p>
                        <p class="text-lg">
                            You can walk away with a fresh pair of SPATIE socks! <sup><a class="link-grey" style="text-decoration: none!important" href="#disclaimer">*</a></sup>
                            <br>
                            A new batch of stickers has arrived as well, so you can still win that <a href="https://laravelstickercontest.com" target="_blank">Laravel sticker contest</a>!
                        </p>
                        <p class="text-lg">
                            Just come say hi at our booth for a chat, our entire development team will be there.
                        </p>
                    </div>
                </div>
                <div class="sm:spanx-2">
                    <img src="/images/socks.svg" class="illustration-svg w-1/2 ml-auto -mt-8 -mb-32 z-10 | sm:w-full sm:-mb-48">
                </div>
            </div>
            <div class="wrap mt-16">
                <div class="inset-blue">
                    <div class="wrap-inset md:items-center" style="--cols: 1fr">
                        <h2 class="title-xl">
                            See you in <br>Amsterdam!</a>
                        </h2>
                    </div>
                </div>
                <p id="disclaimer" class="mt-8 text-sm text-grey">
                    <sup>*</sup> We have 50 pairs available; first come, first served!
                </p>
            </div>
        </section>
        <section id="impressions" class="section pt-0 overflow-visible">
            <div class="wrap -mt-8 mb-4">
                <div class="markup links-underline links-blue">
                    <h2 class="title">
                        Impressions from Instagram
                    </h2>
                </div>
            </div>
            <div class="wrap-gallery items-start mt-8">
                {{-- Start Instagram loop --}}
                <div class="illustration is-postcard" style="left: {{ rand(-20, +20) }}px; top: {{ rand(-20, +10) }}px">
                    <img srcset="…">

                    <div class="mt-4 text-xs links-underline links-black leading-tight">
                        <div class="flex items-baseline text-grey my-2">
                            Image comments
                        </div>

                    </div>
                </div>
                {{-- End Instagram loop --}}
            </div>
        </section>
    </div>

    @endsection
