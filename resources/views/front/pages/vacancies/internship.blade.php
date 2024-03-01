<x-page
        title="Stage"
        background="/backgrounds/jobs.jpg"

>
    <x-slot name="description">
        We are looking for interns in the field of digital design and development. Location: Antwerp.
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Webdevelopment <br>Stage <br>in Antwerpen
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ app_svg('icons/far-angle-left') }}</span>
                <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section section-group pt-0">
        <section id="interns" class="section">
            <div class="wrap wrap-6">
                <div class="sm:col-span-4">
                    <div class="markup links-underline links-blue">
                        <h2 class="title">Backend, frontend or full-stack student?</h2>
                        <p class="text-xl">
                            Wij willen je graag ontmoeten. Tijdens een stage werk je aan concrete klantprojecten, open
                            source componenten of zijprojecten.
                            Jij leert van onze dagelijkse routine en wij worden getriggerd door jouw frisse inzichten.
                        </p>
                        <p>
                            Spatie is een klein maar dapper webbedrijf uit Antwerpen. We hebben intussen een waaier aan
                            eigen producten met Flare en Mailcoach op kop.
                            Als agency ontwikkelen we vooral grote webapplicaties, en laten onze voetafdruk achter met
                            honderden open source packages.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="offer" class="section">
            <div class="wrap wrap-6 items-center">
                <div class="sm:col-span-3">
                    <div class="sm:col-span-4 markup links-underline links-blue">
                        <h2 class="title">Ons kantoor</h2>
                        <p>We geloven in een gezonde balans tussen thuis- en kantoorwerk. We starten maandag samen op
                            tijdens de weekplanning, de rest van de week heb je de mogelijkheid om deeltijds van thuis
                            werken.</p>
                        <p>Ons kantoor ligt in Zurenborg vlak tussen de stations Antwerpen-Berchem en
                            Antwerpen-Centraal, vlot te bereiken met het openbaar vervoer of de fiets. Je krijgt een
                            eigen bureau met tweede scherm en noise-cancelling koptelefoons om ongestoord door te kunnen
                            werken. Standing desks zijn beschikbaar, ook een dakterras om 's middags in de frisse lucht
                            te lunchen.</p>
                        <p>Daarnaast is er altijd heerlijke koffie en vers fruit te verkrijgen. We hebben een
                            maandelijkse afspraak bij ons favoriete Italiaans restaurant, en plannen zo nu en dan een
                            boardgame-avond of terrasje.</p>
                    </div>
                </div>
                <div class="hidden | sm:block sm:col-span-3 sm:col-start-4">
                    <div class="ml-24 w-full h-0" style="padding-bottom: 75%">
                        <div class="absolute inset-0 illustration h-full" title="Team">
                            {{ image('vacancies/about-3.jpg') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('front.pages.web-development.partials.stack')
        @include('front.pages.vacancies.partials.cta', ["github" => true])

    </div>

</x-page>
