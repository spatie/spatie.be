<x-page
        title="Backend developer vacature"
        background="/backgrounds/vacancies.jpg"
>
    <x-slot name="description">
        Vacature voor een backend developer. Locatie: Antwerpen.
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Backend developer
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('vacancies.index')}}" class="link-underline link-blue">Vacature overzicht</a>
                <span class="ml-2 line-l"><a class="link-underline link-blue" href="/vacancies/backend-developer">English version</a></span>
            </p>
        </div>
    </section>

    <div class="section-group pt-0 section-fade">
        <section id="intro" class="section">
            <div class="wrap-6">
                <div class="sm:spanx-4">
                    <div class="markup links-underline links-blue">
                        <h2 class="font-serif text-3xl text-green line-l">
                            Zeg luidop:
                            <br>
                            Ik bouw moderne web applicaties met Laravel!
                        </h2>

                        <div class="mt-16">
                            <h3 class="title">Je werkt aan</h3>
                            <ul class="bullets bullets-green">
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Web apps voor
                                    internationale namen als Krauthammer, Mutsy of Martin Garrix
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Publieke sites voor
                                    de Waaslandhaven, Gemeente Hemiksem of Vrijwilligerswerk Vlaanderen
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Propere websites
                                    voor Wim Delvoye, META architecten of ArtAssistant
                                </li>
                            </ul>
                        </div>

                        <div class="mt-16">
                            <h3 class="title">Het beste eerst</h3>
                            <ul class="bullets bullets-green">
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Word pijlsnel een
                                    krak in Laravel en PHP — bekijk onze <a href="#stack">technology stack</a></li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Krijg elk jaar
                                    €1500,- persoonlijk budget voor opleiding &amp; conferenties als Laracon EU/US,
                                    DDD Europe, PHP Benelux, PHPUKConference, DPC, PHPDay
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Spendeer een halve
                                    dag per week aan experimenteren en open source werk
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Word deel van een
                                    team dat naam maakt binnen open source
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="offer" class="section">
            <section class=section>
                <div class="wrap-6 grid-flow-dense">
                    <div class="sm:spanx-4">
                        <div class="markup links-underline links-blue">
                            <h2 class="title-2xl">Basisbehoeften: <br>
                                voldaan
                            </h2>
                            <ul class="bullets bullets-green">
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Een competitief
                                    salarispakket
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span>
                                    Hospitalisatieverzekering
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Maaltijdcheques
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Ecocheques</li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Vélo kaart voor
                                    deelfietsen in Antwerpen
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Laptop +
                                    2<sup>de</sup> scherm, smartphone
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Internet thuis</li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Bose
                                    noise-cancelling hoofdtelefoons
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section class=section>
                <div class="wrap-8 grid-flow-dense">
                    <div class="sm:spanx-4 sm:startx-4">
                        <div class="markup links-underline links-blue">
                            <h3 class="title">Extra saus</h3>

                            <ul class="bullets bullets-green">
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> De oprechte zin om
                                    van elkaar te leren: code reviews, presentaties in huis en discussies op Slack
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Een vlakke
                                    bedrijfsstructuur waar je zelf het verschil maakt
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> <a
                                            href="https://www.kiva.org" target="_blank"
                                            rel="nofollow noreferrer noopener">Kiva</a> budget voor micro-leningen
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Lekkere espresso
                                    &amp; vers fruit op kantoor
                                </li>
                                <li><span class="icon">{{ svg('icons/far-angle-right') }}</span> Elke maand een
                                    italiaanse lunch met het team; wijn wordt geschonken uit een kippenkruik
                                </li>
                            </ul>

                            <p class="mt-16 text-sm text-grey">
                                We zijn niet op zoek naar remote work of relocatie; deeltijds thuiswerken is
                                bespreekbaar.
                                <br>
                                Kennis van Nederlands is een voorwaarde.
                                <br>
                                Je kan wat ons betreft onmiddellijk beginnen.
                            </p>
                        </div>
                    </div>
                    <div class="sm:spanx-3 sm:startx-1">
                        <div class="illustration is-left is-postcard is-rotated h-full | sm:mr-8">
                            {{ image('italian.jpg') }}
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </div>

    <div class="section-group">
        <section id="stack" class="section">
            <div class="wrap">
                <h3 class="title line-after mb-12">Technology stack</h3>
            </div>
            <div class="wrap-6 items-start">
                <div class="line-l | sm:spanx-3 | md:spanx-2">
                    <div class="markup text-sm">
                        <h3 class="title-sm">Frontend</h3>
                        <ul class="bullets-inline bullets-blue">
                            <li>Vue.js</li>
                            <li>React</li>
                            <li>Vanilla JS</li>
                            <li>Tailwind CSS</li>
                            <li>PostCSS</li>
                            <li>Laravel Mix</li>
                            <li>npm</li>
                            <li>Yarn</li>
                            <li>Webpack</li>
                        </ul>
                        <h3 class="title-sm">Services</h3>
                        <ul class="bullets-inline bullets-blue">
                            <li>MailChimp</li>
                            <li>Sendgrid</li>
                            <li>Google Analytics</li>
                            <li>Google Tag Manager</li>
                        </ul>
                    </div>
                </div>
                <div class="line-l | sm:spanx-3 | md:spanx-2">
                    <div class="markup text-sm">
                        <h3 class="title-sm">Backend</h3>
                        <ul class="bullets-inline bullets-blue">
                            <li>Laravel</li>
                            <li>Laravel Spark</li>
                            <li>Laravel Nova</li>
                            <li>PHP</li>
                            <li>MySQL</li>
                            <li>Algolia</li>
                            <li>Elasticsearch</li>
                        </ul>
                        <h3 class="title-sm">Integraties</h3>
                        <ul class="bullets-inline bullets-blue">
                            <li>Stripe</li>
                            <li>Ingenico</li>
                            <li>Mollie</li>
                            <li>Salesforce</li>
                            <li>Teamleader</li>
                            <li>Exact Online</li>
                            <li>Laravel Spark</li>
                        </ul>
                    </div>
                </div>
                <div class="line-l | sm:spanx-3 | md:spanx-2">
                    <div class="markup text-sm">
                        <h3 class="title-sm">Server</h3>
                        <ul class="bullets-inline bullets-blue">
                            <li>Digital Ocean</li>
                            <li>Laravel Forge</li>
                            <li>S3</li>
                            <li>Nginx</li>
                            <li>Docker</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section id="cta" class="section">
            <div class="wrap">
                <div class="inset-green">
                    <div class="wrap-inset md:items-end" style="--cols: 1fr 1fr">
                        <div class="links-underline links-white">
                            <p class="text-2xl">
                                Mail ons een korte motivatie, CV en GitHub details.
                            </p>
                        </div>
                        <h2 class="title-xl | grid-text-right">
                            <a class="link-white link-underline" href="{{ mailto(
        'Ik ben een goede match!',
        'Dit wordt iets! Stuur ons:
        - je CV
        - een korte motivatie
        - GitHub details of code voorbeelden'
        ) }}">Solliciteer vandaag</a>.
                        </h2>
                    </div>
                </div>
                <p class="mt-8 text-xs text-grey">
                    Elke sollicitatie wordt beantwoord <br>en confidentieel behandeld.
                </p>
            </div>
        </section>
    </div>

</x-page>
