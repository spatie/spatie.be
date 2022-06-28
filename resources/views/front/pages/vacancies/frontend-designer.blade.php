<x-page background="/backgrounds/jobs.jpg" title="Frontend designer vacancy" description="Vacancy for a frontend designer. Location: Antwerp.">
    <script type="application/ld+json">
        {
            "@context": "http://schema.org"
            , "@type": "JobPosting"
            , "datePosted": "2022-04-22T00:00:00"
            , "validThrough": "2023-04-22T00:00:00"
            , "description": "<p>
            You will be working at the front - of -the - front - end. <
            /p>  <
            ul >
            <li>You help defining personality for our own products.</li> <
            li > You can discuss and design UIs. < /li> <
            li > You design and implement concrete marketing actions. < /li> <
            li > You write fluent HTML
            , (Tailwind) CSS and pieces of JavaScript. < /li> <
            li > You can speak Dutch and you love Italian food. < /li> <
            /ul> <
            p >
            Learn and grow together with a team that has made its name in open source.You 'll have an enormous impact on users worldwide. <
            /p>",
            "title": "Frontend Designer"
            , "employmentType": "FULL_TIME"
            , "hiringOrganization": {
                "@type": "Organization"
                , "name": "Spatie"
                , "sameAs": "https://spatie.be"
                , "logo": "http://spatie.be/images/spatie.png"
            }
            , "jobLocation": {
                "@type": "Place"
                , "address": {
                    "@type": "PostalAddress"
                    , "streetAddress": "Kruikstraat 22"
                    , "addressLocality": "Antwerp"
                    , "addressRegion": "Antwerp"
                    , "postalCode": "2018"
                    , "addressCountry": "BE"
                }
            }
        }

    </script>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Frontend Designer
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a href="{{ route('vacancies.index')}}" class="link-underline link-blue text-xl">Vacancies overview</a>
            </p>
        </div>
    </section>

    <div class="section section-group pt-0 section-fade">
        <section id="intro" class="section">
            @include('front.pages.vacancies.partials.about')

            <div class="wrap wrap-6">
                <div class="mt-16 sm:col-span-4 markup links-underline links-blue">
                    <h3 class="title">The best is yet to come</h3>
                    <p>
                        We don't take on just any new project but only those where we all can learn something new.
                        We love to work with the latest and greatest.
                        To get an idea of what we've got in store for you, here are a few examples of projects and tasks you might be involved with:</p>
                    <ul class="bullets bullets-green">
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span>Spice up a promotional site with a clever animation in CSS or Three.JS, like the floating 3D letters on <a href="https://writing-readable-php.com">writing-readable-php.com</a>.</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span>Translate a Figma mockup to a SaaS UI in React. Write smaller UI components yourself, finetune them with the help of a JS developer, and leave instructions in a GitHub issue for a backend developer to load the correct data.</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span>Use Tailwind CSS to implement a maintainable light and dark theme for <a href="https://github.com/spatie/ignition">Ignition</a> –Laravel's default error page we created.</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span>Write plain and isolated CSS that doesn't interfere with the rest of a page for the UI of one of our commercial components like <a href="laravel-comments.com">laravel-comments.com</a> or <a href="medialibrary.pro">medialibrary.pro</a>.</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span>Come up with a suiting visual and branding to promote one of our video courses. Propose a few sketches to the team, design a one-pager, create social banners and even compose a short video intro in After Effects.</li>
                        <li><span class="icon">{{ svg('icons/far-angle-right') }}</span>Collaborate on our enormous collection of <a href="{{ route('open-source.packages') }}">open-source packages</a> and <a href="{{ route('open-source.projects') }}">projects</a>.</li>
                    </ul>

                    <p>
                        You'll have a say in what you'll be working on. No really, we áre listening.
                        If you're curious to see what we create, check out a selection of work on <a href="https://spatie.be">our homepage</a>.
                    </p>
                </div>
            </div>

            @include('front.pages.vacancies.partials.stagnation-decline', ['profile' => 'front'])

            <div class="wrap wrap-6">
                <div class="sm:col-span-4 mt-16 markup links-underline links-blue">
                    <h3 class="title">And you?</h3>
                    <ul class="bullets bullets-green">
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                            You will be working at the front-of-the-front-end (see this <a href="https://bradfrost.com/blog/post/front-of-the-front-end-and-back-of-the-front-end-web-development/">definition</a> by Brad Frost).
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                            You help defining personality for our own products — sketch logos, pick fonts, define color palettes, provide illustrations or create short animations.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                            You can discuss and design UIs — from idea, to prototype, to implementation. We use paper, Figma and Illustrator, but are open to any tool that gets the job done.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                            You design and implement concrete marketing actions: banners, newsletters or one-page promo sites.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                            You love to play with new technologies, try out new things that won't make production or tinker on your secret side project.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                            You write fluent HTML, (Tailwind) CSS and pieces of JavaScript. You know a bit of Git.
                        </li>
                        <li>
                            <span class="icon">{{ svg('icons/far-angle-right') }}</span>
                            You can speak Dutch and you love Italian food.
                        </li>
                    </ul>

                    <div class="mt-16 gradient gradient-blue p-8 rounded">
                        More of a <strong>React/JS</strong> type? Check our <a href="{{ route('vacancies.show', 'react-engineer') }}">React vacancy</a> as well.
                    </div>

                </div>
            </div>
        </section>
        <section id="offer" class="section">
            @include('front.pages.vacancies.partials.offer')
        </section>
    </div>

    <div class="section section-group">
        @include('front.pages.web-development.partials.stack')
        @include('front.pages.vacancies.partials.cta')
    </div>

</x-page>
